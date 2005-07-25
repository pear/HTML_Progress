<?php
/**
 * Progress meter is running in indeterminate mode while a file upload operation.
 * This example may work with HTML_Progress 1.1
 * but version 1.2.0 or better allows more easy facilities.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress.php';

function _methodExists($name)
{
    if (substr(PHP_VERSION,0,1) < '5') {
        $n = strtolower($name);
    } else {
        $n = $name;
    }
    if (in_array($n, get_class_methods('HTML_Progress'))) {
        return true;
    }
    return false;
}

/*
    User callback called pending progress meter is running, comes with version 1.2.0RC3
 */
function myFunctionHandler($progressValue, &$obj)
{
    global $version;
    global $stop;
    $semaphore = './uploads/'.$_GET['ID'];

    if (file_exists($semaphore)) {
        $stop = file_get_contents($semaphore);
        $obj->setValue(100);
        $obj->setIndeterminate(false);
        $obj->display();
        unlink($semaphore);
    }

    // sleep a bit ...
    if ($version > 1.1) {
        $obj->sleep();
    } else {
        for ($i=0; $i<($obj->_anim_speed*1000); $i++) { }
    }
}

/*
    Which version of html_progress: (stable)1.1 or (beta)1.2.0 RC1, RC2 or RC3
 */
$version = _methodExists('run') ? 1.2 : 1.1;

$progress = new HTML_Progress();
$progress->setIncrement(10);
$progress->setAnimSpeed(100);
$progress->setIndeterminate(true);     // progress bar run in indeterminate mode
$progress->setStringPainted(true);     // get space for the string
$progress->setString("");              // but don't paint it
if ($version > 1.1) {
    // set a progress handler required at least version 1.2.0RC3
    $progress->setProgressHandler('myFunctionHandler');
}
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
?>
<html>
<head>
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

if (isset($_GET['ID'])) {

    if ($version > 1.1) {
        $progress->run();    // run method is born on version 1.2.0RC3
    } else {
        // do the same as run() method
        do {
            $progress->display();
            myFunctionHandler($progress->getValue(), $progress);
            if ($progress->getPercentComplete() == 1) {
                if ($progress->isIndeterminate()) {
                    $progress->setValue(0);
                } else {
                    break;
                }
            }
            $progress->incValue();
        } while(1);
    }
    if ($stop == 'done') {
        echo '<b>Upload Complete...</b>';
    } else {
        echo '<b>File was not uploaded !</b>';
        echo '<br/><font size="1">'.$stop.'</font>';
    }
}
?>

</body>
</html>