<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

$ui =& $bar->getUI();

print '<pre>';
var_dump($ui->getStringAttributes());         // see output 1.
var_dump($ui->getStringAttributes(true));     // see output 2.
print '</pre>';
?>