<?php

class UpdatesController
{
    private static $db;
    private static $updates = [];

    private static function initialize()
    {
        self::$db = new SQLDB();
    }

    public static function getUpdates()
    {
        self::initialize();

        // Get Class names of sites
        $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'parser' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'Sites';
        $files = array_diff(scandir($path), array('.', '..'));

        // Get updates for each site
        foreach ($files as $file) {
            $class = str_replace('.php', '', $file);
            $site = strtolower($class);

            $$site = new $class();

            $flats = $$site->get_flats();
            self::$db->save($flats, $class);

            self::$updates = [
                $class => self::$db->get_all($class),
            ];
        }

        return self::$updates;
    }

    function var_dump_pre($mixed = null)
    {
        echo '<pre>';
        var_dump($mixed);
        echo '</pre>';
        return null;
    }
}
