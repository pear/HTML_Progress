<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$test = "\$res = \$bar->isIndeterminate() ? 'yes':'no';";

eval($test);
printf('try 1: progress bar in indeterminate mode ? %s <br/>', $res);

$bar->setIndeterminate(true);
eval($test);
printf('try 2: progress bar in indeterminate mode ? %s <br/>', $res);
?>