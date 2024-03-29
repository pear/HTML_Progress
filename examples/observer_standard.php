<?php 
/**
 * Observer ProgressBar example. Uses the default observer class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once ('HTML/Progress.php');
require_once ('HTML/Progress/observer.php');

// 1. Creates ProgressBar
$bar = new HTML_Progress();
$bar->setBorderPainted(true);
$bar->setIncrement(10);

// 2. Creates and attach a listener 
$observer = new HTML_Progress_Observer();

$ok = $bar->addListener($observer);
if (!$ok) {
    die ("Cannot add a valid listener to progress bar !");
}

// 3. Changes look-and-feel of ProgressBar
$ui =& $bar->getUI();
$ui->setBorderAttributes('width = 2');                     // border: 2px, solid, #000000
$ui->setComment('Standard Observer ProgressBar example');

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Standard Observer ProgressBar example</title>
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
<h1><?php echo basename(__FILE__); ?></h1>

<?php 
echo $bar->toHTML(); 

do {
    $bar->display();
    if ($bar->getPercentComplete() == 1) {
        break;   // the progress bar has reached 100%
    }
    $bar->incValue();
} while(1);
?>

<form>
Contents of file 'progress_observer.log' generated by HTML_Progress_Observer class
<textarea readOnly="true" rows="12" cols="80" wrap="virtual">
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:10;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:20;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:30;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:40;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:50;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:60;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:70;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:80;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:90;} 
a:2:{s:3:"log";s:8:"incValue";s:5:"value";i:100;} 
</textarea>
</form>

<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>

</body>
</html>