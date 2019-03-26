<?php
namespace BBDebugger;

use Phalcon\Mvc\View;

class ViewRender 
{

	private $viewPath = '';

    private $url;

	public function __construct($url)
	{
        
        $this->url      = $url;
        $this->viewPath = dirname(__FILE__) .'/';

	}

    public function afterRender($event , $view , $viewFile)
    {	

		$content = $view->getContent();
		$content = $this->addHead($content);
		$content = $this->addContent($content);

		$view->setContent($content);
    }

    private function addHead($content)
    {


        $style  = str_replace('//', '/', $this->url->get('/bb-debugger/css/style.min.css?v=' . BBDebugger::$version));
        $script = str_replace('//', '/', $this->url->get('/bb-debugger/js/bbscript.min.js?v=' . BBDebugger::$version));

    	$html  = "<link rel='stylesheet' type='text/css' href='" . $style . "' />";
        $html .= "<script type='text/javascript' src='" . $script . "'></script>";

    	if (preg_match('@<head>(.*?)</head>@si', $content)) {
    		return preg_replace('@<head>(.*?)</head>@si', '<head>' . $html . '$1</head>', $content);
    	}

    	if (preg_match('@<footer>(.*?)</footer>@si', $content)) {
    		return preg_replace('@<footer>(.*?)</footer>@si', '<footer>' . $html . '$1</footer>', $content);
    	}

    	if (preg_match('@<html>(.*?)</html>@si', $content)) {
    		return preg_replace('@<html>(.*?)</html>@si', '<html>' . $html . '$1</html>', $content);
    	}

    	return $content . $html;

    }

    private function addContent($content)
    {

		$view = new View();
		$view->setViewsDir($this->viewPath);

        $view = $this->viewSetParams($view);

		$render = $view->getRender('views' , 'toolbar');
    	if (preg_match('@<body>(.*?)</body>@si', $content)) {
    		return preg_replace('@<body>(.*?)</body>@si', '<body>' . $render . '$1</body>', $content);
    	}

    	return $content . $render;
    }

    private function viewSetParams($view)
    {

        $view->memory   = $this->getMemoryCalculate(memory_get_usage());
        $view->cookies  = $_COOKIE;
        $view->servers  = $_SERVER;
        $view->sessions = $_SESSION;
        $view->querys   = BBDebugger::$logList['db'];
        $view->time     = round(microtime(1) - BBDebugger::$startTime, 4);

        return $view;  
    }

    private function getMemoryCalculate($memory)
    {

        if ($memory < 1024 * 1024) {
            return round($memory / 1024 , 2) . ' KB';
        }else if($memory < 1024 * 1024 * 1024) {
            return round($memory / 1024 / 1024 , 2) . ' MB';
        }else {
            return round($memory / 1024 / 1024 / 1024 , 2) . ' GB';
        }

        return $memory;

    }

}