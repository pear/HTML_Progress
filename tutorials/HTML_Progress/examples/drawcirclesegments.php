<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress(HTML_PROGRESS_CIRCLE);

$ui =& $bar->getUI();
$ui->setStringAttributes('background-color=#eeeeee');
$ui->setCellAttributes(array(
    'width' => 50,
    'height' => 50,
    'spacing' => 0,
    'background-color' => '#EEEEEE'
    ));

$dir = '../temp';
$fmask = 'c%s.png';

if (file_exists("$dir/c0.png")) {
    // uses cached files rather than create it again and again
    foreach (range(0,10) as $index) {
        $ui->setCellAttributes(
            array('background-image' => sprintf($dir.$fmask, $index)),
            $index
            );
    }
} else {
    // creates circle segments pictures only once
    $ui->drawCircleSegments($dir, $fmask);
}
?>