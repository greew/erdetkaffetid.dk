<?php
namespace Greew\Sites\ErDetKaffetidDk\Object;

class Template {

    public static function json($data) {
        header('Content-Type: application/json');
        print json_encode($data);
        exit();
    }
    public static function show($page) {

        $page = ROOT . 'src' . DS . 'Template' . DS . $page . '.php';
        if (!is_file($page)) {
            throw new \Exception(sprintf("Template '%s' not found", $page));
        }
        header('Content-Language: da');
        include($page);
        exit();
    }

    public static function read($key) {
        return Config::read($key);
    }
}
