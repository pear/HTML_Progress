<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes(array(
	'active-color' => '#000084',
	'inactive-color' => '#3A6EA5',
	'width' => 20,
	'spacing' => 0
));
$ui->setBorderAttributes('width=1 style=inset color=white');
$ui->setStringAttributes(array(
	'width' => 200,
	'height' => 20,
	'font-size' => 14,
	'background-color' => '#C3C6C3',
	'valign' => 'top'
));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>setProgressAttributes example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $bar->getScript(); ?>
//-->
</script>
</head>
<body bgcolor="#C3C6C3">

<?php 
echo $bar->toHtml(); 
$bar->run();
?>

</body>
</html>