<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIncrement(5);

// direct way
$bar->incValue();
print('value after 1st update = ' . $bar->getValue());
echo '<br/>';

// another way
$dm =& $bar->getDM();
$dm->incValue();
print('value after 2nd update = ' . $bar->getValue());
?>