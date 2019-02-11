<?php
require __DIR__ . '/vendor/autoload.php';
class PHPSimpleTracker {
    var $installationDir = '';
    var $dbName = 'analytics-db';
    function setInstallationDir($dirname){
        $this->installationDir = $dirname;
    }
    function setDBName($dbName){
        $this->dbName = $dbName;
    }
    function getTimestamp(){
        return time();
    }
    function trackPage(){
        $track = $_SERVER['PHP_SELF'];
        $track = str_replace($this->installationDir, '', $track);
        $timestamp = $this->getTimestamp();
        $this->saveToDB($track, $timestamp);
    }
    function connectDB(){
        return new \Filebase\Database(['dir' => __DIR__.'/'.$this->dbName.'/']);
    }
    function saveToDB($trackPage, $timestamp){
        $database = $this->connectDB();
        $randomID = uniqid('123456789');
        $item = $database->get($randomID);
        $item->trackPage = $trackPage;
        $item->timestamp  = $timestamp;
        $item->save();
    }
}
$tracker = new PHPSimpleTracker();
?>