<?php
require __DIR__ . '/vendor/autoload.php';
class PHPSimpleTracker {
    var $installationDir = '';
    var $basedir = '';
    var $pathArray = array();
    function setInstallationDir($dirname){
        $this->installationDir = $dirname;
    }
    function getTimestamp(){
        return time();
    }
    function trackPage(){
        $track = $_SERVER['PHP_SELF'];
        $track = str_replace($this->installationDir, '', $track);
        $timestamp = $this->getTimestamp();
        
        $this->pathArray = explode('/', $track);
        $this->basedir = $this->pathArray[0];
        
        echo $this->basedir;
        
        $this->saveToDB($track, $timestamp);
    }
    function saveToDB($trackPage, $timestamp){
        if($this->basedir){
            
        }
        $database = new \Filebase\Database([
            'dir' => 'db/',
            'cache' => true,
            ]);
            
            $item = $database->get('phpanalytics');
            $item->id = uniqid('123456789');
            $item->trackPage = $trackPage;
            $item->timestamp  = $timestamp;
            $item->save();            
            // if ($database->has('phpanalytics')){
                // }
            }
        }
        $tracker = new PHPSimpleTracker();
        ?>