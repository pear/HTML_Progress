<?php 
@include '../../include_path.php';
/**
 * Natural Horizontal ProgressBar example with blue skin.
 * Display errors only on browser screen with full context
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

$logger = array();
$logger['handler']['display'] = array(
    'conf' => array(
                 'printf' => '<b>%s</b>: %s <br/>'
                             . '<font color="blue">'
                             . '[class="%s" method="%s" file="%s" line="%s"]'
                             . '</font>',
                 'ereg' => 'in (.*)::(.*) \(file (.*) at line (.*)\)'
                   )
);

$bar = new HTML_Progress($logger);
$bar->setAnimSpeed('100');
?>
<html>
<head>
<title>FileLogger Progress example</title>
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