<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$ui->setCellCount(5);

printf('this progress bar has %d cell(s)', $ui->getCellCount());
?>