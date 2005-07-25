<?php
/**
 * Horizontal ProgressBar in indeterminate mode
 * without using the Progress_Monitor V2 solution.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress.php';

/**
 *  This user callback process simulate a reply given after 12 seconds
 *  Parameters
 *  1. current value of the progress bar
 *  2. the progress bar (object) itself
 */
function myProgressHandler($progressValue, &$bar)
{
    static $c;

    if (!isset($c)) {
        $c = time();
    }

    // wait a bit ...
    $bar->sleep();

    /* rules to determine when switch back from indeterminate to determinate mode */
    $elapse = time() - $c;

    echo "myProgressHandler -> elapse time = $elapse s.<br/>\n";
    if ($elapse >= 12) {
        if ($bar->isIndeterminate()) {
            $bar->setIndeterminate(false);
            $bar->setValue(100);
        }
    }
}

$progress = new HTML_Progress();
$ui = & $progress->getUI();
$ui->setProgressAttributes(array(
    'background-color' => '#e0e0e0'
));
$ui->setStringAttributes(array(
    'color'  => '#996',
    'background-color' => '#CCCC99'
));
$ui->setCellAttributes(array(
    'active-color' => '#996'
));

$progress->setAnimSpeed(200);
$progress->setIncrement(10);
$progress->setStringPainted(true);     // get space for the string
$progress->setString("");              // but don't paint it
$progress->setIndeterminate(true);     // Progress start in indeterminate mode
$progress->setProgressHandler('myProgressHandler');
?>
<html>
<head>
<title>Basic Indeterminate Mode Progress example</title>
<style type="text/css">
<!--
body {
    background-color: #CCCC99;
    color: #996;
    font-family: Verdana, Arial;
}

a:visited, a:active, a:link {
    color: yellow;
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
$progress->run();
?>

</body>
</html>