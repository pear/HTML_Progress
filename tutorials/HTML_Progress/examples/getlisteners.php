<?php 
require_once 'HTML/Progress/monitor.php';
	
$bar = new HTML_Progress();
$mon = new HTML_Progress_Monitor();

$bar->addListener($mon);
$li = $bar->getListeners();
printf("%d listener(s) <br/>", count($li));
?>