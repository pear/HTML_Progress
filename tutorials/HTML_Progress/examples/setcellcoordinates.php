<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setAnimSpeed(500);
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
$ui->setCellCoordinates(6,4);          // Rectangle 6x4
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
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