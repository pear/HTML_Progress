<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();

$ui =& $bar->getUI();
$ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
$ui->setCellAttributes('active-color=#3874B4 inactive-color=#EEEECC width=65');
?>
<head>
<title>display example</title>
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

<h1>Screenshot </h1>
<?php 
$bar->setValue(65);
echo $bar->toHtml();
$bar->display();
?>

</body>
</html>