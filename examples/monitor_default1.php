<?php
/**
 * Simple Default Monitor ProgressBar example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/monitor.php';


$monitor = new HTML_Progress_Monitor();

// As there is no action (callback) defined, animation will be so fast
// that we must make it slower to see something. 1000 === sleep(1) 
$monitor->setAnimSpeed(100);
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

<h1>Standard Monitor</h1>
<p>Used default QuickForm renderer without any form template customizations. 
No user callback defined.</p>

<?php 
// Display progress monitor dialog box
echo $monitor->toHtml();


$monitor->run();   
?>

<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>
<p><b><i>href: examples/<?php echo basename(__FILE__); ?></i></b></p>

</body>
</html>