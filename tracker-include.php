<?php
class PHPSimpleTracker {
    var $installationDir = '';
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
    }
}
$tracker = new PHPSimpleTracker();
?>