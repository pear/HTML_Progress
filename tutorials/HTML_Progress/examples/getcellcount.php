<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$ui->setCellCount(5);

print('this progress bar has ' . $ui->getCellCount() . ' cell(s)');
?>