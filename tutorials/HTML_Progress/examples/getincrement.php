<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

printf('direct way: increment = %d <br/>', $bar->getIncrement());

$dm =& $bar->getDM();
printf('another way: increment = %d <br/>', $dm->getIncrement());
?>