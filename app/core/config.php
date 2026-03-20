<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DBNAME', 'sch'); // localhost host database name
    define('DBHOST', 'localhost'); // localhost host host name
    define('DBUSER', 'root'); // localhost host user name
    define('DBPASS', ''); // localhost host password name
    define('DBDRIVER', '');
    define('SCH_DOMAIN', 'edupulse.co.ke');
    define("SCH_CHECK_DOMAIN", 'edupulse.co.ke');
    define("DEBUG", true);
} else {
    define('DBNAME', 'frajosan_SSMS'); // real server host database name
    define('DBHOST', 'localhost'); // real server host host name
    define('DBUSER', 'frajosan_francis'); // real server host user name
    define('DBPASS', 'Frajosan97@001'); // real server host password name
    define('DBDRIVER', '');
    if (in_array("frajosantech", explode(".", $_SERVER['SERVER_NAME']))) {
        define('SCH_DOMAIN', 'edupulse.co.ke');
        define("SCH_CHECK_DOMAIN", 'edupulse.co.ke');
    } else {
        define('SCH_DOMAIN', $_SERVER['SERVER_NAME']);
        define("SCH_CHECK_DOMAIN", $_SERVER['SERVER_NAME']);
    }
    define("DEBUG", false);
}

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
$THIS_FILE = str_replace('\\', '/', __File__);
$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
$ROOT =  str_replace(array($DOC_ROOT, "app/core/config.php"), '', $THIS_FILE);
defined('SITE_ROOT') ? null : define('SITE_ROOT', $DOC_ROOT . DS . $ROOT);
define('TOKEN', schoolKey(SCH_DOMAIN));
