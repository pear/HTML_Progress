<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$css =& $ui->getStyle();

print '<pre>';
echo '<b>object</b><br/>';
print_r($css);
echo '<b>plain text</b><br/>';
print_r($css->toString());
print '</pre>';
?>