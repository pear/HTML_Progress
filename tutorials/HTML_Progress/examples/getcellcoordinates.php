<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$ui->setCellCoordinates(3,3);     // square 3x3

print '<pre>';
var_dump($ui->getCellCoordinates());
print '</pre>';
?>