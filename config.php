<?php
define("LISTENING_ADDRESS", '0.0.0.0'); 
define("FRONTEND_PORT", 8083); //def 80
define("BACKEND_PORT", 8084);

define("SERVER_ID", "PhpWebServer 0.1");
define("PROTOCOL", "HTTP/1.1");

define("MAIN_DIR", "./");
define("DS", "/");

define("SERVER_DIR", MAIN_DIR . DS . "server");

define("DATA_URI", uniqid());

define("SERIALIZED_INDEXES", serialize(array("index.php", "index.html", "index.htm", "index")));
?>
