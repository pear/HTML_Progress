<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

printf('progress bar string identification = "%s"', $bar->getIdent());
?>