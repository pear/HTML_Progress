<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setValue(18);

// direct way
print('completed at ' . $bar->getPercentComplete());
echo '<br/>';

// another way
$dm =& $bar->getDM();
print('completed at ' . $dm->getPercentComplete());
?>