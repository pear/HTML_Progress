<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$dm =& $bar->getDM();

print_r($dm);
?>