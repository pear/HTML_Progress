<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$ui =& $bar->getUI();

print_r($ui);
?>