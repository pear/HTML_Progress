<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(50);
?>
<html>
<head>
<title>Code listing 2.1 </title>
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