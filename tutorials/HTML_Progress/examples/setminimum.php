<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$bar->setMinimum(20);
printf('direct way: minimum = %d <br/>', $bar->getMinimum());

$dm =& $bar->getDM();
$dm->setMinimum(20);
printf('another way: minimum = %d <br/>', $dm->getMinimum());
?>