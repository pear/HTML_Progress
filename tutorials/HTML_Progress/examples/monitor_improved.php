<?php
require_once 'HTML/Progress/monitor.php';

function myFunctionHandler($progressValue, &$obj)
{
    $bar =& $obj->getProgressElement();
    $bar->sleep();
    if (!$bar->isIndeterminate()) {
        if (fmod($progressValue,10) == 0) {
            $obj->setCaption("myFunctionHandler -> progress value is = $progressValue");
        }
    } else {
        /* in case we have attached an indeterminate progress bar to the monitor ($obj)
           after a first pass that reached 60%, 
           we swap from indeterminate mode to determinate mode
           and run a standard progress bar from 0 to 100%
        */   
        if ($progressValue == 60) {
            $bar->setIndeterminate(false);
            $bar->setString(null);  // show percent-info
            $bar->setValue(0);
        }
    }
}

$monitor = new HTML_Progress_Monitor('frmMonitor4', array(
    'button' => array('style' => 'width:80px;')
    )
);
$monitor->setProgressHandler('myFunctionHandler');

$progress = new HTML_Progress();
$progress->setAnimSpeed(20);
$progress->setStringPainted(true);  // get space for the string
$progress->setString("");           // but don't paint it
$progress->setIndeterminate(true);  // Progress start in indeterminate mode

$ui =& $progress->getUI();
$ui->setCellCount(20);
$ui->setProgressAttributes('background-color=#EEE');
$ui->setStringAttributes('background-color=#EEE color=navy');
$ui->setCellAttributes('inactive-color=#FFF active-color=#444444');

$monitor->setProgressElement($progress);
?>
<html>
<head>
<title>Progress Monitor - default improved renderer </title>
<style type="text/css">
<!--
body {
    background-color: lightgrey;
    font-family: Verdana, Arial;
}
.progressStatus {
    color: navy; 
    font-size:10px;
}
<?php echo $monitor->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $monitor->getScript(); ?>
//-->
</script>
</head>
<body>

<?php 
$renderer =& HTML_QuickForm::defaultRenderer();
$renderer->setFormTemplate('
  <table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#EEEEEE">
  <form{attributes}>{content}
  </form>
  </table>
');
$renderer->setHeaderTemplate('
  <tr>
    <td style="white-space:nowrap;background:#7B7B88;color:#ffc;" align="left" colspan="2">
        <b>{header}</b>
    </td>
  </tr>
');
$monitor->accept($renderer);

echo $renderer->toHtml();
$monitor->run();   
?>

</body>
</html>