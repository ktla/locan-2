<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('TIME_OUT', 3600);
# Nombre d'horaire pour les appels, 9 pour les 1ere et Terminale
define("MAX_HORAIRE", 7);

if(!defined("CAL_GREGORIAN")){
    define("CAL_GREGORIAN", 0);
}

define('FIRST_TITLE', 47);
$url = isset($_GET['url']) ? $_GET['url'] : null;
$css = "";
$_JS = "";
require_once(ROOT . DS . 'library' . DS . 'Bootstrap.php');
