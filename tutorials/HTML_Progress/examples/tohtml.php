<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
?>
<head>
<title>toHtml example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
</head>
<body>

<h1>Basic Progress bar </h1>
<?php echo $bar->toHtml(); ?>

</body>
</html>