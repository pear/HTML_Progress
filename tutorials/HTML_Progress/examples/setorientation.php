<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIdent('PB1');
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
$ui->setFillWay('natural');
$ui->setCellCount(6);
$ui->setCellAttributes(array(
	'active-color' => '#970038',
	'inactive-color' => '#FFDDAA',
	'width' => 50,
	'height' => 13
));
$ui->setBorderAttributes('width=1');
$ui->setStringAttributes(array(
	'font-size' => 8,
	'color' => '#FF0000',
	'background-color' => '#C3C6C3',
	'align' => 'center', 
	'valign' => 'bottom'
));

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>setOrientation example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #C3C6C3;
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