<?php
/**
 * Default Monitor ProgressBar example with logging events.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress/monitor.php';

function logger($progressValue, &$bar)
{
    include_once 'Log.php';
    $logger = &Log::singleton('file', 'monitor.log', $_SERVER['REMOTE_ADDR']);
    $percent = $bar->getPercentComplete(false);

    if (fmod($progressValue,25) == 0) {
        $logger->info("$percent% has been reached");
    } else {
        $logger->debug("Progress ... $progressValue");
    }
}

$monitor = new HTML_Progress_Monitor();
$monitor->setProgressHandler('logger');

$pb = &$monitor->getProgressElement();
$dm = &$pb->getDM();
$dm->setMaximum(300);
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

<?php
echo $monitor->toHtml();
$monitor->run();
?>

</body>
</html>