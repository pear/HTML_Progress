<?php 
require_once 'HTML/Progress.php';
require_once 'HTML/Progress/observer.php';


$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setBorderPainted(true);
$bar->setIncrement(10);

$observer = new HTML_Progress_Observer();

$ok = $bar->addListener($observer);
if (!$ok) {
    die ("Cannot add a valid listener to progress bar !");
}

$ui =& $bar->getUI();
//    border: 2px, solid, #000000
$ui->setBorderAttributes('width = 2'); 

$ui->setComment('Standard Observer ProgressBar example');

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Standard Observer </title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
    background-color: #FFFFFF;
    color: #000000;
    font-family: Verdana, Arial;
}
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
echo $bar->toHTML(); 
$bar->run();
?>

</body>
</html>