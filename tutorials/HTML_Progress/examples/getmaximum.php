<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

printf('direct way: maximum = %d <br/>', $bar->getMaximum());

$dm =& $bar->getDM();
printf('another way: maximum = %d <br/>', $dm->getMaximum());
?>