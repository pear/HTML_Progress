<?php 
@include '../../include_path.php';
/**
 * Basic Square Progress example.
 *
 * <b>start</b> parameter could be equal to:
 * - 'topleft'     = beginning at top left corner (default)
 * - 'topright'    = beginning at top right corner
 * - 'bottomright' = beginning at bottom right corner
 * - 'bottomleft'  = beginning at bottom left corner
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

$s = isset($_GET['start']) ? $_GET['start'] : 'topleft';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setStringAttributes('valign=top align=center height=30');
$ui->setOrientation(HTML_PROGRESS_POLYGONAL);
$ui->setCellAttributes('width=20 height=20');
$w = 3;
$h = 3;
$ui->setCellCoordinates($w,$h);          // square 3x3
$coord = $ui->getCellCoordinates();

switch (strtolower($s)) {
 case 'topright':
     for ($i=1; $i<$w; $i++) {
         $shift = array_shift($coord);
         array_push($coord, $shift);
     }
     break;
 case 'bottomright':
     for ($i=1; $i<($w+$h-1); $i++) {
         $shift = array_shift($coord);
         array_push($coord, $shift);
     }
     break;
 case 'bottomleft':
     for ($i=1; $i<$w; $i++) {
         $pop = array_pop($coord);
         array_unshift($coord, $pop);
     }
     break;
 case 'topleft':
 default:     
     break;
}
$ui->setCellCoordinates($w, $h, $coord);
?>
<html>
<head>
<title>Basic Square ProgressBar example</title>
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