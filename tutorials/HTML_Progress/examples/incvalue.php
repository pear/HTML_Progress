<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setIncrement(5);

$bar->incValue();
printf('value after 1st update = %d <br/>', $bar->getValue());

$dm =& $bar->getDM();
$dm->incValue();
printf('value after 2nd update = %d <br/>', $dm->getValue());
?>