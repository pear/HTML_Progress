<?php
@include '../include_path.php';
/**
 * Monitor example with a new form template and progress bar
 * color scheme. Used a class-method as user callback.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/monitor.php';

class Progress_Default2 extends HTML_Progress_UI
{
    function Progress_Default2()
    {
        parent::HTML_Progress_UI();
        
        $this->setProgressAttributes(array('background-color' => '#e0e0e0'));        
        $this->setStringAttributes(array('color' => '#996', 'background-color' => '#CCCC99'));        
        $this->setCellAttributes(array('active-color' => '#996'));
    }
}

class myClassHandler
{
    function myMethodHandler($progressValue, &$obj)
    {
        if (fmod($progressValue,10) == 0) {
            echo "myMethodHandler -> progress value is = $progressValue <br/>\n";
        }
        $bar =& $obj->getProgressElement();
        $bar->sleep();
    }
}


$monitor = new HTML_Progress_Monitor('frmMonitor3', array(
    'button' => array('style' => 'width:80px;')
    )
);
$monitor->setProgressHandler(array('myClassHandler','myMethodHandler'));


$progress = new HTML_Progress();
$progress->setUI('Progress_Default2');   // Attach a progress ui-model 
$progress->setAnimSpeed(20);
$monitor->setProgressElement($progress);
?>
<html>
<head>
<title>ProgressBar Monitor - Default renderer </title>
<style type="text/css">
<!--
.progressStatus {
	color:#000000; 
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
<h1><?php echo basename(__FILE__); ?></h1>

<?php 
$renderer =& HTML_QuickForm::defaultRenderer();
$renderer->setFormTemplate('
	<table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#CCCC99">
	<form{attributes}>{content}
	</form>
	</table>
	');
$renderer->setHeaderTemplate('
	<tr>
	    <td style="white-space:nowrap;background:#996;color:#ffc;" align="left" colspan="2"><b>{header}</b></td>
	</tr>
	');
$monitor->accept($renderer);

echo $renderer->toHtml();
$monitor->run();   
?>

<p>&lt;&lt; <a href="../index.html">Back examples TOC</a></p>

</body>
</html>