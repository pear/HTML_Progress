<?php 
@include '../../include_path.php';
/**
 * Custom Ellipse Progress example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
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
if (isset($_GET['cacheIMG'])) {
    foreach (range(0,10) as $index) {
        $ui->setCellAttributes(array('background-image' => 'temp/e'.$index.'.png'),$index);
    }
} else {
    $ui->drawCircleSegments('temp', 'e%s.png');
}
?>
<html>
<head>
<title>Custom Ellipse ProgressBar example</title>
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
<h1><?php echo basename(__FILE__); ?></h1>

<?php 
echo $bar->toHtml(); 

do {
    $bar->display();
    if ($bar->getPercentComplete() == 1) {
        break;   // the progress bar has reached 100%
    }
    $bar->incValue();
} while(1);

?>

<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>

</body>
</html>