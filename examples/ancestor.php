<?php 
/**
 * Basic Horizontal ProgressBar v0.5 style example.
 * See also ProgressMaker usage with pre-set UI model 'Ancestor'.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setStringAttributes('width=60 font-size=14 align=center');

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Ancestor Progress example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #444444;
	color: #EEEEEE;
	font-family: Verdana, Arial;
}

a:visited, a:active, a:link {
	color: yellow;
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
<h1><?php echo basename(__FILE__); ?></h1>

<?php 
echo $bar->toHtml(); 

do {
    $bar->display();
    if ($bar->getPercentComplete() == 1) {
        break;   // the progress bar has reached 100%
    }
    $bar->incValue();
} while(1);
?>

<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>

</body>
</html>