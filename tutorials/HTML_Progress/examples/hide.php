<?php
require_once 'HTML/Progress.php';

$progress = new HTML_Progress();
$progress->setAnimSpeed(250);
$progress->setIncrement(10);
?>
<html>
<head>
<style type="text/css">
<!--
body {
    background-color: #CCCC99;
    color: #996;
    font-family: Verdana, Arial;
}

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
$progress->hide();
?>

<h1>Your job is finished ! </h1>
<p>The progress meter is now hidden.</p>

</body>
</html>