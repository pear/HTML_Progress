<?php 
@include '../include_path.php';
/**
 * Horizontal String ProgressBar example.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

$pkg = array('PEAR', 'Archive_Tar', 'Config', 
    'HTML_QuickForm', 'HTML_CSS', 'HTML_Page', 'HTML_Template_Sigma', 
    'Log', 'MDB', 'PHPUnit');

function myFunctionHandler($progressValue, &$obj)
{
    global $pkg;
    
    $obj->sleep();
    $i = floor($progressValue / 10);
    if ($progressValue == 100) {
    	$msg = '';
    } else {
    	$msg = "&nbsp; installing package ($progressValue %) ... : ".$pkg[$i];
    }
    $obj->setString($msg);
}

$bar = new HTML_Progress();
$bar->setAnimSpeed(100);
$bar->setIncrement(5);
$bar->setStringPainted(true);          // get space for the string
$bar->setString('');                   // but don't paint it
$bar->setProgressHandler('myFunctionHandler');

$ui =& $bar->getUI();
$ui->setStringAttributes('width=350 align=left');
?>
<html>
<head>
<title>Horizontal String ProgressBar example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #FFFFFF;
	color: #000000;
	font-family: Verdana, Arial;
}

a:visited, a:active, a:link {
	color: navy;
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
<h1><?php echo basename(__FILE__); ?></h1>

<?php 
echo $bar->toHtml(); 
$bar->run();
$bar->display();  // to display the last custom string (blank)
?>

<p>&lt;&lt; <a href="../index.html">Back examples TOC</a></p>

</body>
</html>