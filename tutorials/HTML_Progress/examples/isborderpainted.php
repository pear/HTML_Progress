<?php
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setBorderAttributes(array(
        'width' => 2,
        'style' => 'solid',
        'color' => 'red'
        ));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>isBorderPainted example </title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<body>

<?php 

echo $bar->toHtml(); 
$test = "\$res = \$bar->isBorderPainted() ? 'yes':'no';";

eval($test);
print('border is painted ? ' . $res);
?>

</body>
</html>