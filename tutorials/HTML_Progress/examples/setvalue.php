<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
$bar->setValue(45);
print('value = ' . $bar->getValue());
echo '<br/>';

// another way
$dm =& $bar->getDM();
$dm->setValue(45);
print('value = ' . $bar->getValue());
?>