<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes('active-color=#3874B4 inactive-color=#EEEECC width=10');

print '<pre>';
var_dump($ui->getCellAttributes());
var_dump($ui->getCellAttributes(true));
print '</pre>';
?>