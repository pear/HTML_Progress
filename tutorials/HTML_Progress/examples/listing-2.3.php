<?php 
require_once 'HTML/Progress.php';

function myProgressHandler($progressValue, &$bar)
{
    static $c;
    
    if (!isset($c)) { 
        $c = 0;
    }

    $bar->sleep();  // wait 0.5 second

    if ($bar->isIndeterminate()) {

        if ($progressValue == 100) {
            $c++;
            echo "myProgressHandler -> loop #$c <br/>\n";
        }

        /* switch back from indeterminate to determinate mode 
           after 3 full loops */
         */
        if ($c == 3) {
            $bar->setIndeterminate(false);
            $bar->setValue(0);
            $bar->setString(null); // re-show percent info
        }
    }
}

$progress = new HTML_Progress();
$ui = & $progress->getUI();
$ui->setProgressAttributes(array(
    'background-color' => '#e0e0e0'
));        
$ui->setStringAttributes(array(
    'color'  => '#996',
    'background-color' => '#CCCC99'
));        
$ui->setCellAttributes(array(
    'active-color' => '#996'
));

$progress->setAnimSpeed(500);
$progress->setIncrement(10);
$progress->setStringPainted(true);     // get space for the string
$progress->setString("");              // but don't paint it
$progress->setIndeterminate(true);     // Progress start in indeterminate mode
$progress->setProgressHandler('myProgressHandler');
?>
<html>
<head>
<title>Listing 2.3 </title>
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