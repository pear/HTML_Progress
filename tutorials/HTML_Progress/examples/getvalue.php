<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

printf('direct way: value = %d <br/>', $bar->getValue());

$dm =& $bar->getDM();
printf('another way: value = %d <br/>', $dm->getValue());
?>