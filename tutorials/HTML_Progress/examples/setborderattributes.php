<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes('active-color=#3874B4 inactive-color=#EEEECC width=10');
$ui->setBorderAttributes('width=1 color=navy');
$ui->setStringAttributes('width=60 font-size=14 background-color=#EEEEEE');
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>setBorderAttributes example </title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<body>

<?php echo $bar->toHtml(); ?>

</body>
</html>