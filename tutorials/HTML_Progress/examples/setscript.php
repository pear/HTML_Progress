<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes(array(
    'active-color' => '#3874B4',
    'inactive-color' => '#EEEECC',
    'width' => 10,
    'font-size' => 10
    ));
$ui->setBorderAttributes('width=1 color=navy');
$ui->setStringAttributes(array(
    'width' => 60,
    'font-size' => 14,
    'background-color' => '#EEEEEE',
    'align' => 'center'
    ));
$ui->setScript('progress.js');

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
<title>setScript example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #EEEEEE;
	color: #000000;
	font-family: Verdana, Arial;
}
// -->
</style>
<script type="text/javascript" src="<?php echo $bar->getScript(); ?>"></script>
</head>
<body>

<?php 
echo $bar->toHtml(); 
$bar->run();
?>

</body>
</html>