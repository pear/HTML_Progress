<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
?>
<head>
<title>apiVersion example</title>
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
$api = $bar->apiVersion();

if ($api < 1.2) {
    echo "API version = $api : use a basic do-while-loop";
    do {
        $bar->display();
        $bar->sleep();
        if ($bar->getPercentComplete() == 1) {
            break;
        }
        $bar->incValue();
    } while(1);
} else {
    echo "API version = $api : use the run() method";
    $bar->run();
}
?>

</body>
</html>