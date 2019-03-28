<?php
namespace BBDebugger;

use Phalcon\DiInterface;
use Phalcon\Mvc\Url;
use Phalcon\Di\InjectionAwareInterface;

class BBDebugger implements InjectionAwareInterface
{


	private $serviceList;

    protected $di;

    public static $version = "v1.0.3";

    public static $startTime;

    public static $logList;

    public function setDi(DiInterface $di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }


    public function __construct($di)
    {

    	self::$startTime = microtime(1);
    	$this->di = $di;

    }


    public function start()
    {

        $this->copyAssetsFiles();

		$this->serviceList  = $this->di->getServices();

		$eventsManager = $this->di->get('eventsManager');
    	if (count($this->serviceList) > 0) {
    		$this->dbLoggerStart($eventsManager);
    		$this->ViewRenderStart($eventsManager);
    	}

    }

    private function dbLoggerStart($eventsManager)
    {

    	if (isset($this->serviceList['db'])) {

            self::$logList['db'] = array();

    		$this->serviceList['db']->setShared(true);
    		$this->di->get('db')->setEventsManager($eventsManager);
    		$eventsManager->attach('db', new DBDebugger());

    	}

    }

    private function ViewRenderStart($eventsManager)
    {

    	if (isset($this->serviceList['view'])) {

            self::$logList['view'] = array();

    		$this->serviceList['view']->setShared(true);
    		$this->di->get('view')->setEventsManager($eventsManager);
    		$eventsManager->attach('view', new ViewRender($this->di->get('url')));

    	}

    }

    private function copyAssetsFiles()
    {

        $url = new Url();

        $config = $this->di->get('config');
        $public = $config->application->appDir . '..' . $url->getBaseUri();
        $assets = $config->application->libraryDir . 'BBDebugger/assets/';
        $forceUpdateAssets = false;

        /***** DEBUG ASSETS FOLDERS *****/
        if (!file_exists($public . 'bb-debugger/')) {
            mkdir($public . 'bb-debugger/' , 0777);
        }

        if (!file_exists($public . 'bb-debugger/css')) {
            mkdir($public . 'bb-debugger/css' , 0777);
        }

        if (!file_exists($public . 'bb-debugger/js')) {
            mkdir($public . 'bb-debugger/js' , 0777);
        }

        if (!file_exists($public . 'bb-debugger/version.txt')) {
            touch($public . 'bb-debugger/version.txt');
        }



        $content = file_get_contents($public . 'bb-debugger/version.txt');
        if ($content != self::$version) {
            $handle = fopen($public . 'bb-debugger/version.txt', 'w+');
            fwrite($handle, self::$version);
            fclose($handle);
            $forceUpdateAssets = true;
        }

        /***** DEBUG ASSETS FILES *****/
        if (!file_exists($public . 'bb-debugger/css/style.min.css') || $forceUpdateAssets) {
            copy($assets . 'css/style.min.css', $public . 'bb-debugger/css/style.min.css');
        }

        if (!file_exists($public . 'bb-debugger/js/bbscript.min.js') || $forceUpdateAssets) {
            copy($assets . 'js/bbscript.min.js', $public . 'bb-debugger/js/bbscript.min.js');
        }

    }
}