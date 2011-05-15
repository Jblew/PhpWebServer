<?php

include_once("ClientThread.php");

//in order to not collide with any run function
function runSrv84014elgnerj23($thread, $sock, $rootDir, $name, $port) {
    while (true) {
        $client = new ClientThread(socket_accept($sock), $rootDir, $name, $port);
        $client->start();
    }
}

class Accepter {

    private $thread;
    private $port;
    private $address;
    private $started = false;
    private $sock;
    private $rootDir;
    private $name;

    public function __construct($address_, $port_, $rootDir_, $name_) {
        global $serverData;
        
        $this->address = $address_;
        $this->port = $port_;
        $this->rootDir = $rootDir_;
        $this->name = $name_;
        
        $serverData['listeningOn'][] = array("address" => $this->address, "port" =>$this->port, "name" => $this->name, "rootDir" => $this->rootDir);
    }

    public function start() {
        if ($this->started)
            throw new Exception("Thread already started!");
        $this->started = true;

        $this->sock = socket_create(AF_INET, SOCK_STREAM, 0);

        if (!socket_set_option($this->sock, SOL_SOCKET, SO_REUSEADDR, 1)) {//must be before bind!
            echo socket_strerror(socket_last_error($this->sock));
            exit;
        }
        
        if(!socket_bind($this->sock, $this->address, $this->port)) {
            die("Cannot listen on ".$this->address.":".$this->port."!\n");
            exit;
        }

        socket_listen($this->sock);
        echo("Listening on ".$this->address.":".$this->port."...\n");

        $this->thread = new Thread("runSrv84014elgnerj23");
        $this->thread->start($this->thread, $this->sock, $this->rootDir, $this->name, $this->port);
    }

    public function isWorking() {
        return $this->thread->isAlive();
    }

    public function stopAndClose() {
        $this->thread->stop();
        socket_close($this->sock);
    }

}

?>
