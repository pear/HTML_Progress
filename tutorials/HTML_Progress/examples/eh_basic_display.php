<?php 
require_once 'HTML/Progress.php';
	
$bar = new HTML_Progress();

$e = $bar->setDM('dm_class_model');

if (is_object($e)) {
    if (is_a($e,'PEAR_Error')) {
        die('<h1>Catch PEAR_Error</h1>'. $e->toString());
    }
}
?>