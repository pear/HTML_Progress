<?php
require_once 'HTML/Progress.php';

/*
    user callback: job to do while the progress meter is running

    $obj is an instance of the progress meter object (see line 13)
    $progressValue contains the current value of the progress meter
 */
function myFunctionHandler($progressValue, &$obj)
{
    $obj->sleep();  // nothing to do here, except sleep a bit ...
}

$progress = new HTML_Progress();
$progress->setAnimSpeed(1000);    // defines delay of one second
$progress->setIncrement(10);
$progress->setProgressHandler('myFunctionHandler');
?>
<html>
<head>
<style type="text/css">
<!--
<?php echo $progress->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $progress->getScript(); ?>
//-->
</script>
</head>
<body>

<?php 
echo $progress->toHtml();  
$progress->run();
?>

</body>
</html>