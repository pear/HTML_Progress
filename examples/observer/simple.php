<?php
/**
 * Observer ProgressBar example. Uses a custom observer class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress.php';
require_once 'HTML/Progress/observer.php';

// 1. Defines ProgressBar observer
class MyObserver extends HTML_Progress_Observer
{
    var $_console;
    var $_out;

    function MyObserver($out)
    {
        $this->_console = '.' . DIRECTORY_SEPARATOR . 'observer_complex.log';
        $this->HTML_Progress_Observer();
        $this->_out = strtolower($out);
    }

    function notify($event)
    {
        if (is_array($event)) {
            $log = isset($event['log']) ? $event['log'] : "undefined event id.";
            $val = isset($event['value']) ? $event['value'] : "unknown value";
            $msg = "$log = $val";
        } else {
            $msg = $event;
        }
        if ($this->_out == 'file') {
            error_log("$msg \n", 3, $this->_console);
        } else {
            print ("$msg <br />\n");
    }
    }
}

// 2. Creates ProgressBar
$bar = new HTML_Progress();
$bar->setAnimSpeed(50);
$bar->setIncrement(5);

// 3. Creates and attach a listener
$observer = new MyObserver($_GET['out']);

$ok = $bar->addListener($observer);
if (!$ok) {
    die ("Cannot add a valid listener to progress bar !");
}

// 4. Changes look-and-feel of ProgressBar
$ui = $bar->getUI();
$ui->setComment('Simple Observer ProgressBar example');
?>
<html>
<head>
<title>Simple Observer ProgressBar example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $bar->getScript(); ?>
//-->
</script>
</head>
<body>

<?php
echo $bar->toHtml();
$bar->run();
?>

</body>
</html>