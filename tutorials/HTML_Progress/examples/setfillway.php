<?php
require_once 'HTML/Progress.php';

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
<html>
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
$bar->run();
?>

</body>
</html>