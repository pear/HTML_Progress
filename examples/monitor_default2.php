<?php
/**
 * Default Monitor ProgressBar example with logging events.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/monitor.php';
require_once 'progressHandler.php';


$monitor = new HTML_Progress_Monitor();

// As action (callback) defined, is not a huge task (and take few time)
// then we must make animation slower to see something.
$monitor->setAnimSpeed(100);
$monitor->setProgressHandler('logger');
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

<h1>Simple Monitor and user callback</h1>
<p>Used default QuickForm renderer without any form template customizations. 
User callback 'logger' will write into a file through PEAR::Log.</p>

<?php 
// Display progress monitor dialog box
echo $monitor->toHtml();


$monitor->run();
?>

<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>
<p><b><i>href: examples/<?php echo basename(__FILE__); ?></i></b></p>

</body>
</html>