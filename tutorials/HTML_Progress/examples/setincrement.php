<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$bar->setIncrement(10);
printf('direct way: increment = %d <br/>', $bar->getIncrement());

$dm =& $bar->getDM();
$dm->setIncrement(10);
printf('another way: increment = %d <br/>', $dm->getIncrement());
?>