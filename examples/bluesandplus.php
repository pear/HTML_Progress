<?php 
/**
 * Natural Horizontal ProgressBar example with JavaScript customization.
 * See also ProgressMaker usage with pre-set UI model 'BlueSandPlus'.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes('active-color=#3874B4 inactive-color=#EEEECC width=10');
$ui->setBorderAttributes('width=1 color=navy');
$ui->setStringAttributes('width=60 font-size=14 background-color=#EEEEEE align=center');
$ui->setScript('progress_number.js');

foreach (range(0,2) as $index) {
    $ui->setCellAttributes('color=silver', $index);
}
foreach (range(3,6) as $index) {
    $ui->setCellAttributes('color=yellow', $index);
}
foreach (range(7,9) as $index) {
    $ui->setCellAttributes('color=orange', $index);
}

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>BlueSandPlus Progress example</title>
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
<script type="text/javascript" src="<?php echo $bar->getScript(); ?>"></script>
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