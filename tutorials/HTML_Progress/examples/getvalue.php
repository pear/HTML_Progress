<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
print('value = ' . $bar->getValue());
echo '<br/>';

// another way
$dm =& $bar->getDM();
print('value = ' . $dm->getValue());
?>