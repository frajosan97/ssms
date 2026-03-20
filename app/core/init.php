<?php

spl_autoload_register(function ($classname) {
    $pagesFilename = "../app/models/" . ucfirst($classname) . ".php";
    $portalsFilename = "../app/models/portals/" . ucfirst($classname) . ".php";
    if (file_exists($pagesFilename)) {
        $filename = $pagesFilename;
    } else {
        if (file_exists($portalsFilename)) {
            $filename = $portalsFilename;
        }
    }
    if (isset($filename))
        require $filename;
});

require 'functions.php';
require 'config.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require SITE_ROOT . DS . 'public/assets/plugins/fpdi/vendor/autoload.php';
require SITE_ROOT . DS . 'public/assets/plugins/tcpdf/vendor/autoload.php';
require SITE_ROOT . DS . 'public/assets/plugins/fpdf/vendor/autoload.php';
require SITE_ROOT . DS . 'public/assets/plugins/phpSpreadsheet/vendor/autoload.php';
// require SITE_ROOT . DS . 'public/assets/plugins/who-is/autoload.php';
require 'App.php';
require 'Main.php';
