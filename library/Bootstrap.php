<?php

require_once(ROOT . DS . 'config' . DS . 'config.php');

require_once(ROOT . DS . 'library' . DS . 'Functions.php');

mb_internal_encoding('UTF-8');

function __autoload($className) {
    if (file_exists(ROOT . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'controllers' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'models' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.php');
    }else if(file_exists(ROOT . DS . 'entites' . DS . strtolower($className) . '.php')){
        require_once(ROOT . DS . 'entites' . DS . strtolower($className) . '.php');
    }else if(file_exists(ROOT . DS . 'library' . DS . 'tcpdf' . DS . strtolower($className) . '.php')){
        require_once(ROOT . DS . 'library' . DS . 'tcpdf' . DS . strtolower($className) . '.php');
    } else {
        //Une erreur grave
        die("Error: Class $className introuvable");
    }
    
}

Router::route();