<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$ui =& $bar->getUI();

print '<pre>';
var_dump($ui->getProgressAttributes());
var_dump($ui->getProgressAttributes(true));
print '</pre>';
?>