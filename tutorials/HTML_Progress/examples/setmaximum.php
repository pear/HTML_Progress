<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
$bar->setMaximum(80);
print('maximum = ' . $bar->getMaximum());
echo '<br/>';

// another way
$dm =& $bar->getDM();
$dm->setMaximum(80);
print('maximum = ' . $bar->getMaximum());
?>