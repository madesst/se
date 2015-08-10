<?php
if (php_sapi_name() == "cli-server") {
    // running under built-in server so
    // route static assets and return false
    $extensions = array("php", "jpg", "jpeg", "gif", "css", "js");
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (in_array($ext, $extensions)) {
        return false;
    }
}

define('ENVIRONMENT', 'dev');
include_once __DIR__.'/../app/bootstrap.php';