<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

$ui =& $bar->getUI();

// orientation: 1 = horizontal, 2 = vertical, 3 = polygonal
print('1st orientation = ' . $ui->getOrientation());
$ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
echo '<br/>';
print('2nd orientation = ' . $ui->getOrientation());
?>