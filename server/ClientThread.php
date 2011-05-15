<?php
include_once(LIB_DIR . DS . "TextUtils.php");
include_once(SERVER_DIR . DS . "RequestProcessor.php");

function processClient346543sdrgv24($thread, $socket, $rootDir, $serverName, $listeningPort) {
    socket_getpeername($socket, $address, $port);
    $lines = array();
    
    $line = "";
    while(true) {
        $line .= socket_read($socket, 3096, PHP_NORMAL_READ);
        if(endsWith($line, "\r")) continue;
        if(trim($line) === "") break;
        $lines[] = $line;
        $line = "";
    }
    //print_r($lines);
    $out = implode("\n", $lines);
    RequestProcessor::process($address, $port, $socket, $out, $rootDir, $serverName, $listeningPort);
    
    socket_shutdown($socket);
    socket_close($socket);
}

class ClientThread {

    private $thread;
    private $socket;
    private $started = false;
    private $rootDir;
    private $serverName;
    private $listeningPort;

    public function __construct($socket_, $rootDir_, $serverName_, $listeningPort_) {
        $this->socket = $socket_;
        $this->rootDir = $rootDir_;
        $this->serverName = $serverName_;
        $this->listeningPort = $listeningPort_;
    }

    public function start() {
        if ($this->started)
            throw new Exception("Thread already started!");
        $this->started = true;
        
        $this->thread = new Thread("processClient346543sdrgv24");
        $this->thread->start($this->thread, $this->socket, $this->rootDir, $this->serverName, $this->listeningPort);
    }

    public function isWorking() {
        return $this->thread->isAlive();
    }

}
?>
