<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$ui->setScript('progress.js');

print '<pre>';
echo '<b>Progress bar managed by javascript </b><br/>';
print_r($ui->getScript());
echo '<br/>';

$ui->setScript(null);   // retrieve the default behavior (internal js code)

echo '<b>Progress bar managed by javascript </b><br/>';
print_r($ui->getScript());
print '</pre>';
?>