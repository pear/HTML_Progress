<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress(HTML_PROGRESS_BAR_VERTICAL);
$bar->setAnimSpeed(80);
$bar->setIdent('PB1');
$bar->setIncrement(10);
$bar->setBorderPainted(true);
$bar->setStringPainted(true);    // get space for the string
$bar->setString("");             // but don't paint it
$bar->setIndeterminate(true);    // progress start in indeterminate mode

$ui =& $bar->getUI();
$ui->setCellAttributes('active-color=#970038 inactive-color=#FFDDAA width=50 height=13');
$ui->setBorderAttributes('width=1 color=#000000');
$ui->setStringAttributes(array(
	'font-size' => 8,
	'color' => '#FF0000',
	'background-color' => '#C3C6C3',
	'align' => 'center', 
	'valign' => 'bottom'
));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>setIndeterminate example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #C3C6C3;
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
echo $bar->toHtml();

$loop = 0;

do {
    $bar->display();
    $bar->sleep();      // for purpose of demo only
    
    if ($bar->getPercentComplete() == 1) {
        $loop++;
        if ($bar->isIndeterminate()) {
            $bar->setValue(0);
        } else {
            break;      // progress bar reached 100% in determinate mode
        }
    } else {
        $bar->incValue();
    }

    /** rule to decide when to switch back to determinate mode
     *  - after two full loops and half one
     */       
    if ($bar->isIndeterminate()) {
        if ($loop == 2 && $bar->getValue() == 50) {
            $bar->setIndeterminate(false);  
            $bar->setString(null);         // display % string
            $bar->setValue(0);
        }
    }

} while(1);
?>

</body>
</html>