<?php   // listing-2.2.2.php
require_once 'HTML/Progress.php';

$progress = new HTML_Progress();

$ui = & $progress->getUI();
$ui->setCellCount(20);
$ui->setBorderAttributes('width=1 color=#000000');
$ui->setCellAttributes(array(
        'active-color' => '#970038',
        'inactive-color' => '#FFDDAA',
        'width' => 20,
        'height' => 20
));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<style type="text/css">
<!--
<?php echo $progress->getStyle(); ?>

body {
	background-color: #FFFFFF;
	color: #000000;
	font-family: Verdana, Arial;
}
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $progress->getScript(); ?>
//-->
</script>
</head>
<body>

<?php echo $progress->toHtml(); ?>

</body>
</html>