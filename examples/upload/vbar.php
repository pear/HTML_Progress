<?php
@include '../include_path.php';
/**
 * Progress meter is running in indeterminate mode while a file upload operation.
 * This example may work with HTML_Progress 1.1 
 * but version 1.2.0 or better allows more easy facilities.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
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

$progress = new HTML_Progress(HTML_PROGRESS_BAR_VERTICAL);
$progress->setIncrement(5);
$progress->setAnimSpeed(100);
$progress->setIndeterminate(true);     // progress bar run in indeterminate mode
$progress->setStringPainted(true);     // get space for the string
$progress->setString("");              // but don't paint it
if ($version > 1.1) {
    // set a progress handler required at least version 1.2.0RC3
    $progress->setProgressHandler('myFunctionHandler');
}
$ui = & $progress->getUI();
$ui->setCellCount(20);
$ui->setBorderAttributes('width=1 color=#000000');
$ui->setCellAttributes(array(
        'active-color' => '#970038',
        'inactive-color' => '#FFDDAA',
        'width' => 20,
        'height' => 20
));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<style type="text/css">
<!--
body {
	background-color: White;
	color: red;
	font-family: Verdana, Arial;
	font-size: 10px;
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
    if ($stop == 'error') {
        echo '<b>File was not uploaded !</b>';
    } else {
        echo '<b>Upload Complete...</b>';
    }
}	
?>

</body>
</html>