<?php 
require_once 'HTML/Progress.php';

function myProgressHandler($progressValue, &$bar)
{
    static $c;
    static $t;
    
    if (!isset($c)) { 
        $c = time();
        $t = 0;
    }

    // wait a bit ... 
    $bar->sleep();

    if ($bar->isIndeterminate()) {
        $elapse = time() - $c;

        if ($elapse > $t) {
            echo "myProgressHandler -> elapse time = $elapse s.<br/>\n";
            $t++;
        }
        /* rules to determine when switch back 
           from indeterminate to determinate mode 
         */
        if ($elapse >= 12) {
            $bar->setIndeterminate(false);
            $bar->setValue(0);
            $bar->setString(null);
            $bar->setIncrement(1);
        }
    }
}

$progress = new HTML_Progress();
$progress->setAnimSpeed(200);
$progress->setIncrement(10);
$progress->setStringPainted(true);  // get space for the string
$progress->setString("");           // but don't paint it
$progress->setIndeterminate(true);  // Progress start in indeterminate mode
$progress->setProgressHandler('myProgressHandler');

$ui = & $progress->getUI();
$ui->setProgressAttributes('background-color = #e0e0e0');
$ui->setStringAttributes(array(
	'color'  => '#996',
	'background-color' => '#CCCC99'
));        
$ui->setCellAttributes('active-color = #996');
?>
<html>
<head>
<title>Basic Indeterminate Mode </title>
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
?>

</body>
</html>