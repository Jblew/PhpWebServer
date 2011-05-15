<?php
$logFile = fopen(SERVER_DIR . DS . "backend/main.log", "a+");
class Logger {
    static function log($query) {
        global $logFile;
        fwrite($logFile, time()."|||".$query."\n");
    }
}
?>