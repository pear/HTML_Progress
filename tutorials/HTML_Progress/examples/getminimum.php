<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
print('minimum = ' . $bar->getMinimum());
echo '<br/>';

// another way
$dm =& $bar->getDM();
print('minimum = ' . $dm->getMinimum());
?>