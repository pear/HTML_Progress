<?php
require_once 'HTML/Progress/monitor.php';

$monitor = new HTML_Progress_Monitor();

$bar =& $monitor->getProgressElement();
$bar->setAnimSpeed(50);
$bar->setIncrement(10);
?>
<html>
<head>
<title>Progress Monitor - default renderer </title>
<style type="text/css">
<!--
.progressStatus {
    color:#000000; 
    font-size:10px;
}
<?php echo $monitor->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $monitor->getScript(); ?>
//-->
</script>
</head>
<body>

<?php 
echo $monitor->toHtml();
$monitor->run();   
?>

</body>
</html>