<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
$bar->setMinimum(20);
print('minimum = ' . $bar->getMinimum());
echo '<br/>';

// another way
$dm =& $bar->getDM();
$dm->setMinimum(20);
print('minimum = ' . $bar->getMinimum());
?>