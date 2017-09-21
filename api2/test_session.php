<?php
//ini_set('session.save_handler', 'files');
//ini_set('session.save_path', '/var/lib/php/sessions');

//simple counter to test sessions. should increment on each page reload.
session_start();
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;

echo $count.PHP_EOL;

$_SESSION['count'] = ++$count;
?>