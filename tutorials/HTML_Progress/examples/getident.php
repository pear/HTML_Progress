<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

print('progress bar string identification = ' . $bar->getIdent());
?>