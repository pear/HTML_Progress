<?php
/**
 * ProgressBar model example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress.php';

/**
 * @ignore
 */
class TimerProgress extends HTML_Progress_DM
{
    function TimerProgress()
    {
        $this->HTML_Progress_DM(0,60,5);
    }
}

function myFunctionHandler($progressValue, &$obj)
{
    if ($obj->getPercentComplete() == 0.25) {
        $obj->setString('Fourth part way done!');
    }
    if ($obj->getPercentComplete() == 0.5) {
        $obj->setString('Half way done!');
    }
    if ($obj->getPercentComplete() == 0.75) {
        $obj->setString('Three quarters way done!');
    }
    if ($obj->getPercentComplete() == 1) {
        $obj->setString('All done!');
        $obj->display();
    } else {
        $obj->sleep();
    }
}

$timer = new TimerProgress();
$bar = new HTML_Progress($timer);
$bar->setAnimSpeed(100);
$bar->setStringPainted(true);          // get space for the string
$bar->setString('');                   // but don't paint it
$bar->setProgressHandler('myFunctionHandler');

$ui =& $bar->getUI();
$ui->setTab('    ');
$ui->setStringAttributes('width=170 height=20 valign=bottom align=center');
?>
<html>
<head>
<title>ProgressBar model example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
    background-color: #FFFFFF;
    color: #000000;
    font-family: Verdana, Arial;
}

a:visited, a:active, a:link {
    color: navy;
}
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