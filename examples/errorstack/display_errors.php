<?php 
@include '../include_path.php';
/**
 * Natural Horizontal ProgressBar example with blue skin.
 * Display errors only on browser screen with full context
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

function _pushCallback($err)
{
    // don't die if the error is an exception (as default callback)
}


$logger = array();

if ($_GET['push']) {
    $logger['pushCallback'] = '_pushCallback';  // don't die when an exception is thrown
    $logger['display_errors'] = 'off';          // turn off browser screen output
}
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
$bar->setAnimSpeed('100');   // < - - - will generate an API error

if ($bar->hasErrors()) {
    $err = $bar->getError();
    echo '<pre>';
    print_r($err);
    echo '</pre>';
    die('<h1>Catch PEAR_ErrorStack Exception error </h1>');
}
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
$bar->run();
?>

<p>&lt;&lt; <a href="../index.html">Back examples TOC</a></p>

</body>
</html>