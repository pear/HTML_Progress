<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();

// orientation: 1 = horizontal, 2 = vertical, 3 = polygonal
printf('1st orientation = %d <br/>', $ui->getOrientation());

$ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
printf('2nd orientation = %d <br/>', $ui->getOrientation());
?>