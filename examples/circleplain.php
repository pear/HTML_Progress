<?php 
@include '../../include_path.php';
/**
 * plain Circle Progress example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

$bar = new HTML_Progress(HTML_PROGRESS_CIRCLE);
$bar->setAnimSpeed(100);
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setStringAttributes('background-color=#eeeeee');
$ui->setCellAttributes('width=50 height=50 spacing=0 background-color=#eeeeee');
$ui->drawCircleSegments('temp', 'c%s.png');
?>
<html>
<head>
<title>Basic Circle ProgressBar example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #EEEEEE;
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