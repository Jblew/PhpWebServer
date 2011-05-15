<?php

$statusMap = array(200 => "OK", 404 => "Not Found");
$indexes = unserialize(SERIALIZED_INDEXES);

function setStatus($code) {
    global $status;
    if (!in_array($code, array(200, 404)))
        throw new Exception("No such http code: " . $code);
    $status = $code;
}

$lines = explode("\n", $request);

$methodLine = array_shift($lines);
$methodLineParts = explode(" ", $methodLine);
$method = $methodLineParts[0];
$urlData = parse_url($methodLineParts[1]);
$uri = $urlData['path'];

$queryString = "";
if (isset($urlData['query'])) {
    $queryString = $urlData['query'];
}
$protocol = $methodLineParts[2];

$getVars = array();
parse_str($queryString, $getVars);

$accept = "";
$inputHeaders = array();
foreach ($lines as $line) {
    $line = trim($line);
    $keyvalue = explode(":", $line);
    $key = strtolower(trim($keyvalue[0]));
    $value = "";
    if (isset($keyvalue[1])) {
        $value = trim($keyvalue[1]);
    }
    if ($key == "accept") {
        $accept = $value;
    }
    $inputHeaders[$key] = $value;
}

$response = "";
$headers = array("Server" => "PhpWebServer 0.5", "Connection" => "close", "Content-Type" => "text/html");
$status = 200;

echo($address . ":" . $port . " " . $method . " " . $uri . "\n");
Logger::log($address . ":" . $port . " " . $method . " " . $uri);

if (!ob_start())
    $response .= "<html><h1>Server error</h1><p>Cannot handle script output!</p>";
else {
    $path = "";
    $localPath = "";
    if (startsWith($uri, DS . DATA_URI)) {
        $path = DATA_DIR . DS . str_replace(DS . DATA_URI, "", $uri);
        $localPath = $path;
    } elseif (($uri == "/favicon.ico" || $uri == "favicon.ico") && !file_exists($rootDir . DS . "favicon.ico")) {
        $path = DATA_DIR . DS . "favicon.ico";
        $localPath = $path;
    } else {
        $path = $rootDir . DS . $uri;
        $localPath = $uri;
    }
    $path = str_replace("//", "/", $path);
    $localPath = str_replace("//", "/", $localPath);
    //echo("Path: " . $path);
    if (is_dir($path)) {
        foreach (scandir($path) as $filename) {
            if (in_array($filename, $indexes) && !is_dir($path . DS . $filename) && !is_dir($path . DS . $filename)) {
                $path = $path . DS . $filename;
                $localPath = $localPath . DS . $filename;
                break;
            }
        }
    }

    while (startsWith($localPath, "/")) {
        $localPath = substr($localPath, 1);
    }

    if (!file_exists($path)) {
        setStatus(404);
        include(PAGES_DIR . DS . "404.php");
        $response .= ob_get_clean();
    } else {
        if (is_dir($path)) {
            include(PAGES_DIR . DS . "directory.php");
            $response .= ob_get_clean();
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
            $mimetype = finfo_file($finfo, $path);
            $headers["Content-Type"] = $mimetype;
            finfo_close($finfo);
            if (in_array($mimetype, array("text/php", "text/html"))) {
                $scriptOutput = array();
                $data = base64_encode(serialize(array(
                            "path" => $localPath,
                            "method" => $method,
                            "rootDir" => $rootDir,
                            "queryString" => $queryString,
                            "accept" => $accept,
                            "headers" => $inputHeaders,
                            "address" => $address,
                            "port" => $port,
                            "serverName" => $serverName,
                            "listeningPort" => $listeningPort,
                            "serverData" => $serverData,
                            "uri" => $uri,
                            "get" => $getVars,
                            "post" => array(),
                            "files" => array(),
                            "session" => array(),
                            "cookie" => array(),
                        )));

                $cmd = "php " . SERVER_DIR . DS . "run-script.php " . $data;

                $descriptorspec = array(
                    0 => array("pipe", "r"), // stdin is a pipe that the child will read from
                    1 => array("pipe", "w"), // stdout is a pipe that the child will write to
                    2 => array("pipe", "w") // stderr is a file to write to
                );

                $cwd = MAIN_DIR;
                $env = array();

                $process = proc_open($cmd, $descriptorspec, $pipes, $cwd, $env);

                if (is_resource($process)) {
                    fclose($pipes[0]);
                    $response .= stream_get_contents($pipes[1]);
                    //echo($response);
                    fclose($pipes[1]);
                    $err = stream_get_contents($pipes[2]);
                    $response .= $err;
                    fclose($pipes[2]);
                    $return_code = proc_close($process);
                    if ($return_code != 0)
                        echo("ERROR running script '" . $path . "'. Returned code: " . $return_code . ". Stderr: " . $err . "\n");
                }
                else
                    $response .= "Error: Process is not resource!";
                //$response .= shell_exec($cmd);
            } else {
                //echo("Mime-type: " . $mimetype . "\n");
                $response = file_get_contents($path);
            }
        }
    }
//ob_end_clean();
}

//echo($response);

$out = "";
$out .= PROTOCOL . " " . $status . " " . $statusMap[$status] . "\n";

foreach ($headers as $key => $value) {
    $out .= $key . ": " . $value . "\n";
}
$out .= "\n";
$out .= $response;
socket_write($socket, $out . "\n");
?>
