<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$test = "\$res = \$bar->isIndeterminate() ? 'yes':'no';";

eval($test);
print('try 1: progress bar in indeterminate mode ? ' . $res);
echo '<br/>';

$bar->setIndeterminate(true);
eval($test);
print('try 2: progress bar in indeterminate mode ? ' . $res);
?>