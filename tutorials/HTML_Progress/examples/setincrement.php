<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
$bar->setIncrement(10);
print('increment = ' . $bar->getIncrement());
echo '<br/>';

// another way
$dm =& $bar->getDM();
$dm->setIncrement(10);
print('increment = ' . $bar->getIncrement());
?>