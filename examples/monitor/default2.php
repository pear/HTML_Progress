<?php
@include '../include_path.php';
/**
 * Default Monitor ProgressBar example with logging events.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/monitor.php';

function logger($progressValue, &$obj)
{
    include_once 'Log.php';
    $logger = &Log::singleton('file', 'monitor.log', $_SERVER['REMOTE_ADDR']);

    if (fmod($progressValue,25) == 0) {
        $logger->info("$progressValue % has been reached");
    } else {
        $logger->debug("Progress ... $progressValue %");
    }
}

$monitor = new HTML_Progress_Monitor();
$monitor->setProgressHandler('logger');
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
echo $monitor->toHtml();
$monitor->run();
?>

<p>&lt;&lt; <a href="../index.html">Back examples TOC</a></p>

</body>
</html>