<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setValue(25);
$bar->setStringPainted(true);

$ui =& $bar->getUI();
$ui->setStringAttributes('width=350 align=left');
?>
<html>
<head>
<title>getString example</title>
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

$val = $bar->getValue();
$msg = "&nbsp; installing package ($val %) ... : Config";
$bar->setString($msg);

$bar->display();

echo '<h1>Progress Meter Custom String</h1>';
print($bar->getString());
?>

</body>
</html>