<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setModel('./ancestor.ini', 'iniCommented');
$bar->setAnimSpeed(50); // override the delay execution model
?>
<html>
<head>
<title>setModel example</title>
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
$bar->run();
?>

</body>
</html>