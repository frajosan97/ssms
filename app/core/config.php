<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DBNAME', 'ssms');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBDRIVER', '');
    define('SCH_DOMAIN', 'kathekaboys.sc.ke');
    define("SCH_CHECK_DOMAIN", 'kathekaboys.sc.ke');
    define("DEBUG", true);
} else {
    define('DBNAME', 'hencangr_ssms');
    define('DBHOST', 'localhost');
    define('DBUSER', 'hencangr_francis');
    define('DBPASS', 'Frajosan97@001');
    define('DBDRIVER', '');
    define('SCH_DOMAIN', $_SERVER['SERVER_NAME']);
    define("SCH_CHECK_DOMAIN", $_SERVER['SERVER_NAME']);
    define("DEBUG", false);
}

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
$THIS_FILE = str_replace('\\', '/', __FILE__);
$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
$ROOT = str_replace(array($DOC_ROOT, "app/core/config.php"), '', $THIS_FILE);
defined('SITE_ROOT') ? null : define('SITE_ROOT', $DOC_ROOT . DS . $ROOT);
define('TOKEN', schoolKey(SCH_DOMAIN));
