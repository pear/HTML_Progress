<?php
/**
 * Few examples of user-callback
 * to use with Progress Monitor.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

function myFunctionHandler($progressValue, &$obj)
{
    $bar =& $obj->getProgressElement();
    if (!$bar->isIndeterminate()) {
        if (fmod($progressValue,10) == 0) {
            $obj->setCaption("myFunctionHandler -> progress value is = $progressValue");
        }
    } else {
        /* in case we have attached an indeterminate progress bar to the monitor ($obj)
           after a first pass that reached 60%, 
           we swap from indeterminate mode to determinate mode
           and run a standard progress bar from 0 to 100%
        */   
        if ($progressValue == 60) {
            $bar->setIndeterminate(false);
            $bar->setString(null);           // show percent-info
            $bar->setValue(0);
        }
    }
}

class myClassHandler
{
    function myMethodHandler($progressValue, &$obj)
    {
        if (fmod($progressValue,10) == 0) {
            echo "myMethodHandler -> progress value is = $progressValue <br/>\n";
        }
    }
}

class my2ClassHandler
{
    function my1Method($progressValue, &$obj)
    {
        switch ($progressValue) {
         case 10:
            $pic = 'picture1.jpg';
            break;
         case 45:
            $pic = 'picture2.jpg';
            break;
         case 70:
            $pic = 'picture3.jpg';
            break;
         default:
            $pic = null;
        }
        if (!is_null($pic)) {
            $obj->setCaption('upload <b>%file%</b> in progress ... Start at %percent%%',
                              array('file'=>$pic, 'percent'=>$progressValue)
                             );
        }
    }
}

function logger($progressValue, &$obj)
{
    include_once 'Log.php';
    $logger = &Log::singleton('file', 'monitor.log', $_SERVER['REMOTE_ADDR']);

    if (fmod($progressValue,25) == 0) {
        $logger->info("$progressValue % has been reached");
    } else {
        $logger->debug("Progress ... $progressValue %");
    }
}
?>