<?php 
@include '../include_path.php';
/**
 * Easy set options of a progress meter with PEAR::Config package
 * and a configuration container style 'iniCommented'.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require 'HTML/Progress.php';

$bar = new HTML_Progress();
$bar->setModel('javadanse.ini', 'inicommented');

if (HTML_Progress::hasErrors()) {
    $err = HTML_Progress::getError();
    die('<h1>Your configuration file is erroneous</h1>'.$err['message']);
}
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Model Progress example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php 
$js = $bar->getScript(); 
if (is_file($js)) {
    echo file_get_contents($js);
} else {
    echo $js;
}   
?>
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