<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress(HTML_PROGRESS_BAR_VERTICAL);
$bar->setAnimSpeed(100);
$bar->setIdent('PB1');
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setComment('Reverse ProgressBar example');
$ui->setTabOffset(1);
$ui->setFillWay('reverse');
$ui->setCellCount(5);
$ui->setProgressAttributes(array(
	'background-color' => '#e0e0e0'
));        
$ui->setStringAttributes(array(
	'valign' => 'left',
	'color'  => 'red',
	'background-color' => 'lightblue'
	));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>setFillWay example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: lightblue;
	color: #000000;
	font-family: Verdana, Arial;
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

</body>
</html>