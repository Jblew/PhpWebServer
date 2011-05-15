

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head profile="http://gmpg.org/xfn/11"> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
        <title>Index of <?php echo($uri); ?></title> 
        <style type="text/css"> 
            body {
                background-color: #dddddd;
                color: black;
                margin: 0;
                padding: 0;
            }

            #content_padding {
                margin: 25px;
            }

            #content {
                border: 0px solid gray;
                background: white;
                padding: 15px;
                text-align: center;
                position: relative;
            }

            #content .corner_ul {
                position: absolute;
                top: 0;
                left: 0;
                width: 10px;
                height: 10px;
                background: url(<?php echo(DATA_URI); ?>/corner_lu.png) no-repeat;
            }

            #content .corner_ur {
                position: absolute;
                top: 0;
                right: 0;
                width: 10px;
                height: 10px;
                background: url(<?php echo(DATA_URI); ?>/corner_ru.png) no-repeat;
            }

            #content .corner_dl {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 10px;
                height: 10px;
                background: url(<?php echo(DATA_URI); ?>/corner_ld.png) no-repeat;
            }

            #content .corner_dr {
                position: absolute;
                bottom: 0;
                right: 0;
                width: 10px;
                height: 10px;
                background: url(<?php echo(DATA_URI); ?>/corner_rd.png) no-repeat;
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
        </style> 
    </head> 
    <body> 
        <div id="content_padding">
            <div id="content"> 
                <div class="corner_dl"> </div>
                <div class="corner_dr"> </div>
                <div class="corner_ul"> </div>
                <div class="corner_ur"> </div>
                <h2>404. &quot;<?php echo($uri); ?>&quot; was not found on this server.</h2>  
                <p>We are really sory, but page you are looking for, is missing. You can try to the <a href="/">home page</a>.</p> 
            </div> 
            <div id="footer"> 
                <p> 
                    <?php include("footer.php"); ?>
                </p> 
            </div> 
        </div>
    </body> 
</html> 