<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$css =& $ui->getStyle();

print '<pre>';
echo '<h1>object</h1>';
print_r($css);
echo '<h1>plain text</h1><br/>';
print_r($css->toString());
print '</pre>';
?>