<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setStringPainted(true);
$bar->setValue(25);

$ui =& $bar->getUI();
$ui->setStringAttributes('width=350 align=left');
?>
<html>
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