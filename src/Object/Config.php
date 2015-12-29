<?php
namespace Greew\Sites\ErDetKaffetidDk\Object;

class Config
{

    static private $config = [];

    /**
     * Load the configuration for the site.
     *
     * @throws \Exception
     * @author Jesper Skytte Hansen <jesper@edulab.dk>
     */
    public static function load()
    {
        $file = ROOT . 'config' . DS .'config.php';
        if (!is_file($file)) {
            throw new \Exception(sprintf('No config file found in %s', $file));
        }
        $config = include $file;
        if (!is_array($config)) {
            throw new \Exception(sprintf('Config file "%s" did not return an array', $file));
        }
        self::$config = $config;
    }

    /**
     * Read a configuration setting.
     *
     * @param string $key Dot-separated key to the config array.
     * @return mixed
     * @throws \Exception
     * @author Jesper Skytte Hansen <jesper@edulab.dk>
     */
    public static function read($key) {
        $parts = explode('.', $key);
        $config = self::$config;
        while (!empty($parts)) {
            $current = array_shift($parts);
            if (!array_key_exists($current, $config)) {
                throw new \Exception(sprintf("Configuration key '%s' doesn't exist.", $key));
            }
            $config = $config[$current];
        }

        return $config;
    }
}