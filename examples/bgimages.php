<?php 
@include '../../include_path.php';
/**
 * Natural Horizontal with background images ProgressBar example.
 * See also ProgressMaker usage with pre-set UI model 'BgImages'.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes(array(
    'active-color' => '#000084',
    'inactive-color' => '#3A6EA5',
    'width' => 25,
    'spacing' => 0,
    'background-image' => 'download.gif'
));
$ui->setBorderAttributes('width=1 style=inset color=white');
$ui->setStringAttributes(array(
    'width' => 60,
    'font-size' => 10,
    'background-color' => '#C3C6C3',
    'align' => 'center',
    'valign' => 'left'
));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>BgImages Progress example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #C3C6C3;
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
<?php echo $bar->getScript(); ?>
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