[![Latest Stable Version](https://poser.pugx.org/ismail0234/phalcon-bb-debugger/v/stable)](https://packagist.org/packages/ismail0234/phalcon-bb-debugger)
[![Total Downloads](https://poser.pugx.org/ismail0234/phalcon-bb-debugger/downloads)](https://packagist.org/packages/ismail0234/phalcon-bb-debugger)
[![Monthly Downloads](https://poser.pugx.org/ismail0234/phalcon-bb-debugger/d/monthly)](https://packagist.org/packages/ismail0234/phalcon-bb-debugger)
[![License](https://poser.pugx.org/ismail0234/phalcon-bb-debugger/license)](https://packagist.org/packages/ismail0234/phalcon-bb-debugger)

# Phalcon BB Debugger

* Phalcon Version: **3.x**
* BB Debugger Version: **1.0.2**

### What is BB Debugger ?
The bb debugger, written for the phalcon framework, provides developers with lots of information, such as your sql queries, the amount of ram used on the page, and your page-opening speed.

### Composer Install Files
```php
composer require ismail0234/phalcon-bb-debugger
```

### How to Install BB Debugger ?

1. You should download the latest version from the [Releases](https://github.com/ismail0234/Phalcon-BB-Debugger/releases) section. (**or install composer files**)
2. **$config->application->libraryDir** discard the folder where your library files are located.
3. In the **config/config.php** file, define **'developerMode' => true** into the **application** array.
4. The following code into the **config/loader.php** file is **$loader = new\Phalcon\Loader();** add after.
```php
<?php

$loader = new \Phalcon\Loader();

/* BB DEBUGGER V1.0.2 */
if ($config->application->developerMode) {

    $namespaces = array_merge($loader->getNamespaces(), array('BBDebugger'=> $config->application->libraryDir . 'BBDebugger'));
    $loader->registerNamespaces($namespaces)->register();
    $bbdebugger = new \BBDebugger\BBDebugger($di);
    $bbdebugger->start();
    
}
```
5. Enjoy the fun!

### ScreenShot (v1.0.0)

#### Sql Querys
![BB Debugger Phalcon Querys](https://i.imgur.com/MxvT9tr.png)

#### Server Variables
![BB Debugger Phalcon Servers](https://i.imgur.com/EbhTlIw.png)

#### Cookies
![BB Debugger Phalcon Cookies](https://i.imgur.com/p0HQSB3.png)

