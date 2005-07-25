<?php
/**
 * Observer ProgressBar example. Uses a custom observer class
 * that handled progress of the second bar.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress.php';
require_once 'HTML/Progress/observer.php';

// 1. Defines ProgressBar observer
class Bar1Observer extends HTML_Progress_Observer
{
    function Bar1Observer()
    {
        $this->HTML_Progress_Observer();
    }

    function notify($event)
    {
        global $bar2;

        if (is_array($event)) {
            $log = isset($event['log']) ? $event['log'] : "undefined event id.";
            $val = isset($event['value']) ? $event['value'] : "unknown value";

            switch (strtolower($log)) {
             case 'incvalue':
                 // if you want to do special on each step of progress bar1; it's here !!!
                 break;
             case 'setvalue':
                 if ($val == 0) {
                     // updates $bar2 because $bar1 has completed a full loop
                     $bar2->incValue();
                     $bar2->display();
                 }
             default:
            }
        }
    }
}

// 2. Creates ProgressBar
$bar1 = new HTML_Progress(HTML_PROGRESS_BAR_VERTICAL);
$bar1->setAnimSpeed(50);
$bar1->setIncrement(10);
$bar1->setIdent('PB1');

$bar2 = new HTML_Progress(HTML_PROGRESS_BAR_VERTICAL);
$bar2->setAnimSpeed(50);
$bar2->setIncrement(25);
$bar2->setIdent('PB2');
$bar2->setBorderPainted(true);

// 3. Creates and attach a listener
$observer = new Bar1Observer();

$ok = $bar1->addListener($observer);
if (!$ok) {
    die ("Cannot add a valid listener to progress bar !");
}

// 4. Changes look-and-feel of ProgressBar
$ui1 =& $bar1->getUI();
$ui1->setComment('Complex Observer ProgressBar example');
$ui1->setTabOffset(1);
$ui1->setProgressAttributes(array(
    'background-color' => '#e0e0e0'
));
$ui1->setStringAttributes(array(
    'valign' => 'left',
    'color'  => 'red',
    'background-color' => 'lightblue'
));

$ui2 =& $bar2->getUI();
$ui2->setTabOffset(1);
$ui2->setBorderAttributes(array(
    'width' => 1,
    'style' => 'solid',
    'color' => 'navy'
));
$ui2->setCellAttributes(array(
    'active-color' => '#3874B4',
    'inactive-color' => '#EEEECC'
));
$ui2->setStringAttributes(array(
    'width'  => '100',
    'align'  => 'center',
    'valign' => 'right',
    'color'  => 'yellow',
    'background-color' => 'lightblue'
));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Complex Observer ProgressBar example</title>
<style type="text/css">
<!--
<?php
echo $bar1->getStyle();
echo $bar2->getStyle();
?>
table.container {
        background-color: lightblue;
        border: 2;
        border-color: navy;
        border-style: dashed;
        cell-spacing: 4;
        cell-padding: 8;
        width: 50%;
}
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $bar1->getScript(); ?>
//-->
</script>
</head>
<body>

<table class="container">
<tr>
    <td width="25%" align="center">
<?php echo $bar1->toHtml(); ?>
    </td>
    <td width="25%" align="center">
<?php echo $bar2->toHtml(); ?>
    </td>
</tr>
</table>

<?php
do {
    $bar1->display();
    $bar1->process();    // warning: don't forget it (even for a demo)
    if ($bar1->getPercentComplete() == 1) {
        $bar1->setValue(0);  // the 1st progress bar has reached 100%, do a new loop
    } else {
        $bar1->incValue();   // updates 1st progress bar
    }
} while($bar2->getPercentComplete() < 1);
?>

</body>
</html>