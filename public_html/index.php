<?php

require_once '../vendor/autoload.php';

// use App\Controllers\MailController;
use App\Controllers\UpdatesController;
use App\Factories\SiteFactory;
use App\Utils\DbUtil;

$env_path = dirname(__FILE__, 2);
$dotenv = \Dotenv\Dotenv::create($env_path);
$dotenv->load();

try {
    $conf = new \App\Models\DB\DatabaseConfiguration();
    $db = new App\Models\DB\SQLDB($conf);
//
    $site = SiteFactory::build('NeagentSite');
    $updates = UpdatesController::getSiteUpdate($site, $db);
    // var_dump($updates);
//    DbUtil::createTablesForAllSites();
} catch (\Error $ex) {
    echo $ex->getMessage() . "<br>";
    echo $ex->getTraceAsString();
} catch (\Exception $ex) {
    echo $ex->getMessage() . "<br>";
    echo $ex->getTraceAsString();
}
