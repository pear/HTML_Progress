<?php

$docroot = $_SERVER['DOCUMENT_ROOT'];

$docroot = str_replace('pear', '', $docroot);
if (substr($docroot, - 1) != "/") { 
    $docroot = $docroot . '/';
}

// add my directory to the include path, and make it first, should fix any errors
$dirsep = (substr(PHP_OS, 0, 3) == 'WIN') ? ";" : ":" ;

ini_set('include_path', '.' . $dirsep. $docroot.'include' . $dirsep . ini_get('include_path'));

?>