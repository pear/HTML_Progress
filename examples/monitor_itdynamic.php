<?php
/**
 * Monitor example using ITDynamic QF renderer, and 
 * a class-method as user callback.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/monitor.php';
require_once 'progressModels.php';
require_once 'progressHandler.php';
require_once 'HTML/QuickForm/Renderer/ITDynamic.php';
// can use either HTML_Template_Sigma or HTML_Template_ITX
require_once 'HTML/Template/ITX.php';
//require_once 'HTML/Template/Sigma.php';


$monitor = new HTML_Progress_Monitor('frmMonitor5', array(
    'title'  => 'Upload your pictures',
    'start'  => 'Upload',
    'cancel' => 'Stop',
    'button' => array('style' => 'width:80px;')
    )
);
$monitor->setAnimSpeed(100);
$monitor->setProgressHandler(array('my2ClassHandler','my1Method'));

// Attach a progress ui-model (see file progressModels.php for attributes definition)
$progress = new HTML_Progress();
$progress->setUI('Progress_ITDynamic');
$monitor->setProgressElement($progress);

// can use either HTML_Template_Sigma or HTML_Template_ITX
$tpl =& new HTML_Template_ITX('./templates');
// $tpl =& new HTML_Template_Sigma('./templates');


$tpl->loadTemplateFile('itdynamic.html');

$tpl->setVariable(array(
    'qf_style'  => "body {font-family: Verdana, Arial; } \n" . $monitor->getStyle(),
    'qf_script' => $monitor->getScript()
    )
);

$renderer =& new HTML_QuickForm_Renderer_ITDynamic($tpl);
$renderer->setElementBlock(array(
    'buttons'     => 'qf_buttons'
));

$monitor->accept($renderer);

// Display progress uploader dialog box
$tpl->show();


$monitor->run();   

echo '<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>';
echo '<p><b><i>href: examples/'.basename(__FILE__).'</i></b></p>';
?>