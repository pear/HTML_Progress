<?php 
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(5);
$bar->setStringPainted(true);     // get space for the string
$bar->setString('');              // but don't paint it

$ui =& $bar->getUI();
$ui->setStringAttributes('width=350 align=left');
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>setString example</title>
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

$pkg = array('PEAR', 'Archive_Tar', 'Config', 
    'HTML_QuickForm', 'HTML_CSS', 'HTML_Page', 'HTML_Template_Sigma', 
    'Log', 'MDB', 'PHPUnit');

do {
    $val = $bar->getValue();
    $i = floor($val / 10);
    $msg = ($val == 100) ? '' : "&nbsp; installing package ($val %) ... : ".$pkg[$i];
    $bar->setString($msg);

    $bar->display();
    if ($bar->getPercentComplete() == 1) {
        break;   // the progress bar has reached 100%
    }
    $bar->incValue();
} while(1);
?>

</body>
</html>