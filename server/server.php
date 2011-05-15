<?php
define("LIB_DIR", SERVER_DIR . DS . "lib");
define("PAGES_DIR", SERVER_DIR . DS . "pages");
define("DATA_DIR", SERVER_DIR . DS . "data");

include_once(SERVER_DIR . DS . "Accepter.php");
include_once(LIB_DIR . DS . "Thread.php");
include_once(LIB_DIR . DS . "Logger.php");

if (!Thread::available()) {
    die('Threads not supported');
}

$serverData = array();
$serverData['listeningOn'] = array();

$frontendAccepter = new Accepter(LISTENING_ADDRESS, FRONTEND_PORT, MAIN_DIR . DS . "www", "frontend");
$frontendAccepter->start();

$backendAccepter = new Accepter(LISTENING_ADDRESS, BACKEND_PORT, SERVER_DIR . DS . "backend", "backend");
$backendAccepter->start();
echo("Running...\n");

while (true) {
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) == 'quit') {
        echo "Quit!\n";
        break;
    } else {
        echo("You must type 'quit' to stop server!");
    }
}
$backendAccepter->stopAndClose();
$frontendAccepter->stopAndClose();
?>
