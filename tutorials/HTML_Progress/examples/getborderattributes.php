<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setBorderAttributes('width=1 color=navy');

print '<pre>';
var_dump($ui->getBorderAttributes());       // see output 1.
var_dump($ui->getBorderAttributes(true));   // see output 2.
print '</pre>';
?>