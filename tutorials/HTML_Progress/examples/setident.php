<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

printf('initial progress bar string identification = "%s" <br/>', $bar->getIdent());
$bar->setIdent('PB1');
printf('current progress bar string identification = "%s" <br/>', $bar->getIdent());
?>