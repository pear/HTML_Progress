<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

// direct way
print('increment = ' . $bar->getIncrement());
echo '<br/>';

// another way
$dm =& $bar->getDM();
print('increment = ' . $dm->getIncrement());
?>