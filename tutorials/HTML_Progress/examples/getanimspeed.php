<?php 
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

print('delay progress bar execution = ' . $bar->getAnimSpeed());
?>