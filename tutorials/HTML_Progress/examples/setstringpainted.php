<?php 
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setStringPainted(true);
$bar->setValue(25);

$ui =& $bar->getUI();
$ui->setStringAttributes('width=350 align=left');
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>setStringPainted example</title>
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
<body>

<?php 
echo $bar->toHtml(); 

$msg = "&nbsp; installing package (25 %) ... : Config";
$bar->setString($msg);

$bar->display();
?>

</body>
</html>