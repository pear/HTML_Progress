<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$ui->setFillWay('reverse');

print('this progress bar will be filled in ' . $ui->getFillWay() . ' way');
?>