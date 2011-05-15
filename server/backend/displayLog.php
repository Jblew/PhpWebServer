<?php
//$file = fopen("main.log", "r");
echo(str_replace("\n", "<br />", file_get_contents("./main.log")));
//fclose($file);
?>
