<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$bar->setValue(45);
printf('direct way: value = %d <br/>', $bar->getValue());

$dm =& $bar->getDM();
$dm->setValue(45);
printf('another way: value = %d <br/>', $dm->getValue());
?>