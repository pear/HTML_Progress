<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
print('maximum = ' . $bar->getMaximum());
echo '<br/>';

// another way
$dm =& $bar->getDM();
print('maximum = ' . $dm->getMaximum());
?>