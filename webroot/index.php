<?php
use Greew\Sites\ErDetKaffetidDk\Object\Config;
use Greew\Sites\ErDetKaffetidDk\Object\Places;
use Greew\Sites\ErDetKaffetidDk\Object\Template;

/** Directory separator */
define('DS', '/');

/** Path to project root (with ending slash) */
define('ROOT', dirname(__DIR__) . DS);

// Load autoloader
require_once ROOT . 'vendor' . DS . 'autoload.php';

// Setup configuration
Config::load();

// Startup checks
if (Config::read('Keys.GoogleApi') == '') {
    Template::show('missing_api_key');
}

$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request);

/* Simple router system */
switch ($request['path']) {
    case '/places':
        Template::json(Places::find($_GET));
        break;

    case '/':
        Template::show('frontpage');
        break;

    default:
        header("HTTP/1.1 404 Not Found");
        Template::show('error');
        break;
}
