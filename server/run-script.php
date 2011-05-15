<?php
echo("\n");
if (file_exists("../config.php"))
    include("../config.php");
else if (file_exists("config.php"))
    include("config.php");
else if (file_exists("../../config.php"))
    include("../../config.php");
else
    die("Cannot find config file!");

if (count($argv) < 2) {
    die("Server internal error: You must specify data!");
}

if (empty($argv[1]))
    die("Error 404: There is no such script: null!");
$data = unserialize(base64_decode($argv[1]));
chdir($data['rootDir']);

if (!file_exists($data['path']))
    die("Error 404: There is no such script: " . $data['path'] . "!");

$oldserver = $_SERVER;
$_SERVER = array();
$HTTP_RAW_POST_DATA = "";
$_COOKIE = array();
$_ENV = array();
$_FILES = array();
$_GET = array();
$_POST = array();
$_REQUEST = array();
$_SESSION = array();

$_SERVER['PHP_SELF'] = $data['path'];
$_SERVER['argv'] = array();
$_SERVER['argc'] = 0;
$_SERVER['GATEWAY_INTERFACE'] = "Unsupported";

$_SERVER['SERVER_ADDR'] = LISTENING_ADDRESS;
$_SERVER['SERVER_NAME'] = LISTENING_ADDRESS;
$_SERVER['SERVER_SOFTWARE'] = SERVER_ID;
$_SERVER['SERVER_PROTOCOL'] = PROTOCOL;
$_SERVER['REQUEST_TIME'] = time();
$_SERVER['REQUEST_METHOD'] = $data['method'];
$_SERVER['QUERY_STRING'] = $data['queryString'];
$_SERVER['DOCUMENT_ROOT'] = $data['rootDir'];

if (isset($data['accept']))
    $_SERVER['HTTP_ACCEPT'] = $data['accept'];
else
    $_SERVER['HTTP_ACCEPT'] = "";

if (isset($data['headers']['accept-charset']))
    $_SERVER['HTTP_ACCEPT_CHARSET'] = $data['headers']['accept-charset'];
else
    $_SERVER['HTTP_ACCEPT_CHARSET'] = "";

if (isset($data['headers']['accept-encoding']))
    $_SERVER['HTTP_ACCEPT_ENCODING'] = $data['headers']['accept-encoding'];
else
    $_SERVER['HTTP_ACCEPT_ENCODING'] = "";

if (isset($data['headers']['accept-language']))
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $data['headers']['accept-language'];
else
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";

$_SERVER['HTTP_HOST'] = $data['headers']['host'];

if (isset($data['headers']['user-agent']))
    $_SERVER['HTTP_USER_AGENT'] = $data['headers']['user-agent'];
else
    $_SERVER['HTTP_USER_AGENT'] = "";

$_SERVER['HTTPS'] = "";

$_SERVER['GATEWAY_INTERFACE'] = "Unsupported";
$_SERVER['HTTP_REFERER'] = "Unsupported";
$_SERVER['REMOTE_ADDR'] = $data['address'];
$_SERVER['REMOTE_HOST'] = gethostbyaddr($data['address']);
$_SERVER['REMOTE_PORT'] = $data['port'];
$_SERVER['SCRIPT_FILENAME'] = $data['path'];
$_SERVER['SERVER_PORT'] = $data['listeningPort'];
$_SERVER['SERVER_SIGNATURE'] = $data['serverName'];
$_SERVER['SERVER_ADMIN'] = "Unsupported";
$_SERVER['PATH_TRANSLATED'] = realpath($data['path']);
$_SERVER['SCRIPT_NAME'] = $oldserver['SCRIPT_NAME'];
$_SERVER['REQUEST_URI'] = $data['uri'];
$_SERVER['ORIG_PATH_INFO'] = pathinfo($data['uri']);
$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];

$_SERVER['PHP_AUTH_DIGEST'] = "Unsupported";
$_SERVER['PHP_AUTH_USER'] = "Unsupported";
$_SERVER['PHP_AUTH_PW'] = "Unsupported";
$_SERVER['AUTH_TYPE'] = "Unsupported";

$_GET = $data['get'];
$_POST = $data['post'];
$_FILES = $data['files'];
$_SESSION = $data['session'];
$_COOKIE = $data['cookie'];

$_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
$_PHP_SERVER_DATA = $data['serverData'];
unset($data);
unset($oldserver);

include($_SERVER['PHP_SELF']);

?>
