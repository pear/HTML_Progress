<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIdent('PB1');

print('progress bar string identification = ' . $bar->getIdent());
?>