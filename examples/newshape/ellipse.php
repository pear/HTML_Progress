<?php
/**
 * Ellipse Progress meter example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setOrientation(HTML_PROGRESS_CIRCLE);
$ui->setStringAttributes('font-size=20 width=100');
$ui->setCellAttributes(array(
    'width' => 200,
    'height' => 100,
    'spacing' => 0,
    'inactive-color' => 'red',
    'active-color' => 'navy'
    )
);

if (file_exists('../temp/e0.png')) {
    // uses cached files rather than create it again and again
    foreach (range(0,10) as $index) {
        $ui->setCellAttributes(array('background-image' => '../temp/e'.$index.'.png'),$index);
    }
} else {
    // creates circle segments pictures only once
    $ui->drawCircleSegments('../temp', 'e%s.png');
}
?>
<html>
<head>
<title>Ellipse ProgressBar example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
    background-color: #FFFFFF;
    color: #000000;
    font-family: Verdana, Arial;
}

a:visited, a:active, a:link {
    color: navy;
}
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $ui->getScript(); ?>
//-->
</script>
</head>
<body>

<?php
echo $bar->toHtml();
$bar->run();
?>

</body>
</html>