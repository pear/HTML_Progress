<?php 
require_once ('HTML/Progress/monitor.php');
	
$bar = new HTML_Progress();
$mon = new HTML_Progress_Monitor();

$bar->addListener($mon);
$li = $bar->getListeners();
print(count($li) .' listener(s)');
echo '<br/>';

$bar->removeListener($mon);
$li = $bar->getListeners();
print(count($li) .' listener(s) now');
?>