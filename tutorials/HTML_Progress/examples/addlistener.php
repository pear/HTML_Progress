<?php 
require_once ('HTML/Progress/monitor.php');
	
$bar = new HTML_Progress();
$mon = new HTML_Progress_Monitor();

$li = $bar->getListeners();
print(count($li) .' listener(s)');
echo '<br/>';

$bar->addListener($mon);
$li = $bar->getListeners();
print(count($li) .' listener(s) now');
?>