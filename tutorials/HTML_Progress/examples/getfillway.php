<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$ui->setFillWay('reverse');

printf('this progress bar will be filled in "%s" way', $ui->getFillWay());
?>