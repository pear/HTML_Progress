<?php 
require_once 'HTML/Progress.php';

$bar = new HTML_Progress();
$e = $bar->setAnimSpeed(10000);   // < - - - will generate an API error

if ($bar->hasErrors()) {
    $err = $bar->getError();
    echo '<h1>Catch HTML_Progress Error</h1>';
    echo '<pre>';
    print_r($err);
    echo '</pre>';
}
?>