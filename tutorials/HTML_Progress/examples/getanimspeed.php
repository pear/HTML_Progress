<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

printf('delay execution of progress meter = %d millisecond(s)', $bar->getAnimSpeed());
?>