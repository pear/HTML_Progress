<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$bar->setMaximum(80);
printf('direct way: maximum = %d <br/>', $bar->getMaximum());

$dm =& $bar->getDM();
$dm->setMaximum(80);
printf('another way: maximum = %d <br/>', $dm->getMaximum());
?>