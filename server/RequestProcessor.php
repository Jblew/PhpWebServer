<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class RequestProcessor {
    public static function process($address, $port, $socket, $request, $rootDir, $serverName, $listeningPort) {
        global $serverData;
        include(SERVER_DIR . DS . "processQuery.php");
    }
}
?>
