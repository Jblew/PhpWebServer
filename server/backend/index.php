<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head profile="http://gmpg.org/xfn/11"> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
        <title>Server Backend</title> 
        <style type="text/css"> 
            body {
                background-color: #dddddd;
                color: black;
                margin: 0;
                padding: 0;
            }

            #header {
                width: 100%;
                background-color: #1e6e6e;
                padding: 20px;
                font-family: sans-serif;
                border: 0;
                border-bottom: 4px solid #a9c134;
            }
            #header h1 {
                padding: 0;
                margin: 0;
                font-size: 25px;
                color: #333;
            }
            #header p {
                margin: 0;
                padding: 0;
                padding-top: 5px;
                font-size: 12px;
                letter-spacing: 2px;
            }

            #content_padding {
                margin: 25px;
            }

            #content {
                border: 0px solid gray;
                background: white;
                padding: 15px;
                position: relative;
            }

            #content .corner_ul {
                position: absolute;
                top: 0;
                left: 0;
                width: 10px;
                height: 10px;
                background: url(/corner_lu.png) no-repeat;
            }

            #content .corner_ur {
                position: absolute;
                top: 0;
                right: 0;
                width: 10px;
                height: 10px;
                background: url(/corner_ru.png) no-repeat;
            }

            #content .corner_dl {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 10px;
                height: 10px;
                background: url(/corner_ld.png) no-repeat;
            }

            #content .corner_dr {
                position: absolute;
                bottom: 0;
                right: 0;
                width: 10px;
                height: 10px;
                background: url(/corner_rd.png) no-repeat;
            }

            #content h2 {
                color: #a9c134;
                font-family: sans-serif;
                font-size: 25px;
                width: 100%;
                border-bottom: 1px solid #a9c134;
                padding: 0;
                margin: 0;
                padding-left: 6px;
                text-align: left;
            }
            #footer {
                padding: 0;
                padding-top: 15px;
                font-size: 10px;
                color: #444;
                width: 800px;
                margin: 0 auto;
                text-align: center;
            }
            .headera {
                color: #a9c134;
                font-family: sans-serif;
                font-size: 27px;
                text-decoration: none;
            }
            table {
            }
            table tr {

            }
            table tr th {
                border-bottom: 2px solid #a9c134;
                color: #000;
                font-size: 1.3em;
                text-align: center;
            }
            table tr td {
                color: #444;
                padding: 5px;
                padding-right: 12px;
                text-align: left;
            }
            table tr td.icontd {
                padding-right: 5px;
            }
            .ok {
                color: green;
            }
        </style> 
    </head> 
    <body> 
        <div id="header"> 
            <h1><a class="headera" href="#">Server backend  </a></h1> 
        </div>  

        <div id="content_padding">
            <div id="content"> 
                <div class="corner_dl"> </div>
                <div class="corner_dr"> </div>
                <div class="corner_ul"> </div>
                <div class="corner_ur"> </div>
                <h2>Server backend</h2> 
                <p class="ok">Serwer is ok.</p>
                <h3>Listening on:</h3>
                <ul>
                    <?php
                    foreach ($_PHP_SERVER_DATA['listeningOn'] as $entry) {
                        echo("<li><strong>" . ucfirst($entry['name']) . "</strong>: [Address: <strong>" . $entry['address'] . "</strong>; Port: <strong>" . $entry['port'] . "</strong>; Root dir: <strong>" . $entry['rootDir'] . "</strong>]</li>");
                    }
                    ?>
                </ul>
                <h3>Log</h3>
                <?php
                include("displayLog.php");
                ?>
            </div> 
            <div id="footer"> 
                <p> 
                    <?php include("footer.php"); ?>
                </p> 
            </div> 
        </div>
    </body> 
</html> 
