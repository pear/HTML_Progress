<?php
/**
 * Simple Default Monitor ProgressBar example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress/monitor.php';


$monitor = new HTML_Progress_Monitor();

$bar =& $monitor->getProgressElement();
$bar->setAnimSpeed(50);
$bar->setIncrement(10);
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