<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$test = "\$res = \$bar->isStringPainted() ? 'yes':'no';";

eval($test);
print ('is custom string painted ? '. $res);
echo '<br/>';

$bar->setStringPainted(true);
eval($test);
print ('decide to paint custom string : '. $res);
?>