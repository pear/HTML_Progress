<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

printf('direct way: minimum = %d <br/>', $bar->getMinimum());

$dm =& $bar->getDM();
printf('another way: minimum = %d <br/>', $dm->getMinimum());
?>