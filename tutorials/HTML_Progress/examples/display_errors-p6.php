<?php 
require_once 'HTML/Progress.php';

function _pushCallback($err)
{
    // now don't die if the error is an exception, it will be ignored
    if ($err['level'] == 'exception') {
        return HTML_PROGRESS_ERRORSTACK_IGNORE;
    }
}
function _errorHandler($err)
{
    global $options;

    $display_errors = ini_get('display_errors');

    if ($display_errors) {
        $lineFormat = $options['lineFormat'];
        $contextFormat = $options['contextFormat'];

        $file  = $err['context']['file'];
        $line  = $err['context']['line'];
        $func  = $err['context']['class'];
        $func .= $err['context']['type'];
        $func .= $err['context']['function'];

        $context = sprintf($contextFormat, $file, $line, $func);

        printf($lineFormat."<br />\n", ucfirst($err['level']), $err['message'], $context);
    }
}
$logger['push_callback'] = '_pushCallback';
$logger['error_handler'] = '_errorHandler';

$options = array(
    'lineFormat' => '<b>%1$s</b>: %2$s <hr>%3$s',
    'contextFormat' => '<b>Function</b>: %3$s<br/><b>File</b>: %1$s<br/><b>Line</b>: %2$s'
);
$logger['handler']['display'] = array('conf' => $options);   

$bar = new HTML_Progress($logger);
$e = $bar->setAnimSpeed('100');   // < - - - will generate an API exception

if (is_object($e)) {
    if (is_a($e,'PEAR_Error')) {
        die('<h1>Catch PEAR_Error API exception</h1>'. $e->toString());
    }
}
if (HTML_Progress::hasErrors()) {
    $err = HTML_Progress::getError();
    echo '<pre>';
    print_r($err);
    echo '</pre>';
    die('<h1>Catch HTML_Progress exception</h1>');
}

$e = $bar->setAnimSpeed(10000);   // < - - - will generate an API error

if (is_object($e)) {
    if (is_a($e,'PEAR_Error')) {
        die('<h1>Catch PEAR_Error API error</h1>'. $e->toString());
    }
}
if (HTML_Progress::hasErrors()) {
    $err = HTML_Progress::getError();
    die('<h1>Catch HTML_Progress error</h1>'.$err['message']);
}
?>