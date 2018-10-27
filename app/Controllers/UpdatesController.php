<?php

namespace App\Controllers;

use App\Models\DB\DBInterface;
use App\Models\DB\DatabaseConfiguration;
use App\Models\DB\SQLDB;
use App\Factories\SiteFactory;
use App\Models\AbstractSite;

class UpdatesController
{

    /**
     *
     * @var DBInterface
     */
    private static $db;

    /**
     *
     * @var array
     */
    private static $updates;

    private static function initialize()
    {
        $db_config = new DatabaseConfiguration();
        self::$db = new SQLDB($db_config);
    }

    /**
     *
     * @param AbstractSite $site_class
     * @return Flat[]
     */
    public static function getSiteUpdate(AbstractSite $site)
    {
        self::initialize();

        $parsed_flats = $site->getFlats();
        $new_flats = self::$db->getNewFlats($parsed_flats, $site->getSiteName());
//        self::$updates[$site->getSiteName()] = $new_flats;

        return $new_flats;
    }

    /**
     *
     * @return array
     */
    public static function getUpdates(): array
    {
        self::initialize();
        $sites = SiteFactory::getSitesArray();

        // Get updates for each site
        foreach ($sites as $site) {
            try {
                $flats = $site->getFlats();
                $new_flats = self::$db->getNewFlats($flats, $site->getSiteName());
                self::$updates[$site->getSiteName()] = $new_flats;
            } catch (\Exception $e) {
                // TODO: Log errors
                var_dump($e);
            }
        }

        return self::$updates;
    }

}
