<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$test = "\$res = \$bar->isStringPainted() ? 'yes':'no';";

eval($test);
printf('is custom string painted ? %s <br/>', $res);

$bar->setStringPainted(true);
eval($test);
printf('and now, is custom string painted ? %s', $res);
?>