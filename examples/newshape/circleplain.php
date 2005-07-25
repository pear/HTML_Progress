<?php
/**
 * plain Circle Progress example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress.php';

$bar = new HTML_Progress(HTML_PROGRESS_CIRCLE);
$bar->setAnimSpeed(100);
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setStringAttributes('background-color=#eeeeee');
$ui->setCellAttributes('width=50 height=50 spacing=0 background-color=#eeeeee');

if (file_exists('../temp/c0.png')) {
    // uses cached files rather than create it again and again
    foreach (range(0,10) as $index) {
        $ui->setCellAttributes(array('background-image' => '../temp/c'.$index.'.png'),$index);
    }
} else {
    // creates circle segments pictures only once
    $ui->drawCircleSegments('../temp', 'c%s.png');
}
?>
<html>
<head>
<title>Basic Circle ProgressBar example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
    background-color: #EEEEEE;
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
<?php echo $ui->getScript(); ?>
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