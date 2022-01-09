<?php

namespace Greew\Sites\ErDetKaffetidDk\Object;

use Exception;

class Template
{

    /**
     * @throws \JsonException
     */
    public static function json($data): void
    {
        header('Content-Type: application/json');
        print json_encode($data, JSON_THROW_ON_ERROR);
        exit();
    }

    /**
     * @throws Exception
     */
    public static function show($page): void
    {
        $page = ROOT . 'src' . DS . 'Template' . DS . $page . '.php';
        if (!is_file($page)) {
            throw new Exception(sprintf("Template '%s' not found", $page));
        }
        header('Content-Language: da');
        include($page);
        exit();
    }

    /**
     * @throws Exception
     */
    public static function read($key)
    {
        return Config::read($key);
    }
}
