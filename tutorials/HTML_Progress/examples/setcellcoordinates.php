<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(250);
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setStringAttributes('valign=bottom align=center width=90 height=30');
$ui->setOrientation(HTML_PROGRESS_POLYGONAL);
$ui->setCellAttributes(array(
        'width'  => 15,
        'height' => 15,
        'active-color'   => 'red',
        'inactive-color' => 'orange',
        )
);
$ui->setCellCoordinates(6,4);     // Rectangle 6x4
?>
<html>
<head>
<title>setCellCoordinates example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $ui->getScript(); ?>
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