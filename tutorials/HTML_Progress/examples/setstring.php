<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(5);
$bar->setStringPainted(true);     // get space for the string
$bar->setString('');              // but don't paint it

$ui =& $bar->getUI();
$ui->setStringAttributes('width=350 align=left');
?>
<html>
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
    if ($val == 100) {
        $msg = '';
    } else {
        $msg  = "&nbsp; installing package ($val %) ... : ";
        $msg .= $pkg[$i];
    }
    $bar->setString($msg);

    $bar->display();
    if ($bar->getPercentComplete() == 1) {
        break;   // the progress bar has reached 100%
    }
    $bar->sleep();  // for purpose of demo only
    $bar->incValue();
} while(1);
?>

</body>
</html>