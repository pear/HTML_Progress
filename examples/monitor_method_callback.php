<?php
/**
 * Monitor example with a new form template and progress bar
 * color scheme. Used a class-method as user callback.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/monitor.php';
require_once 'progressModels.php';
require_once 'progressHandler.php';


$monitor = new HTML_Progress_Monitor('frmMonitor3', array(
    'button' => array('style' => 'width:80px;')
    )
);
$monitor->setAnimSpeed(100);
$monitor->setProgressHandler(array('myClassHandler','myMethodHandler'));


// Attach a progress ui-model (see file progressModels.php for attributes definition)
$progress = new HTML_Progress();
$progress->setUI('Progress_Default2');
$monitor->setProgressElement($progress);
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
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

<h1>Monitor handled by class-method user callback</h1>
<p>Used default QuickForm renderer with a non-standard color scheme
for form template and progress bar.</p>

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

// Display progress monitor dialog box
echo $renderer->toHtml();


$monitor->run();   
?>

<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>
<p><b><i>href: examples/<?php echo basename(__FILE__); ?></i></b></p>

</body>
</html>