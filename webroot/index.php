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
if (empty(Config::read('Keys.GoogleApi'))) {
    Template::show('missing_api_key');
}

$request = parse_url($_SERVER['REQUEST_URI']);

/* Simple router system */
switch ($request['path']) {
    case '/places':
        Template::json(Places::find($_GET));
        break;

    case '/':
    default:
        Template::show('frontpage');
        break;
}
