<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();

print '<pre>';
var_dump($ui->getStringAttributes());
var_dump($ui->getStringAttributes(true));
print '</pre>';
?>