<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setValue(18);

printf('direct way: progress completed at %f <br/>', $bar->getPercentComplete());

$dm =& $bar->getDM();
printf('another way: progress completed at %f <br/>', $dm->getPercentComplete());
?>