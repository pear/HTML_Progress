<?php
/**
 * Monitor example using ITDynamic QF renderer, and
 * a class-method as user callback.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress/monitor.php';
require_once 'HTML/QuickForm/Renderer/ITDynamic.php';
require_once 'HTML/Template/ITX.php';

class Progress_ITDynamic extends HTML_Progress_UI
{
    function Progress_ITDynamic()
    {
        parent::HTML_Progress_UI();

        $this->setCellCount(20);
        $this->setProgressAttributes('background-color=#EEE');
        $this->setStringAttributes('background-color=#EEE color=navy');
        $this->setCellAttributes('inactive-color=#FFF active-color=#444444');
    }
}

class my2ClassHandler
{
    function my1Method($progressValue, &$bar)
    {
        global $monitor;

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
            $monitor->setCaption('upload <b>%file%</b> in progress ... Start at %percent%%',
                                 array('file'=>$pic, 'percent'=>$progressValue)
                                );
        }
        $bar->sleep();  // slow animation because we do noting else
    }
}
$obs = new my2ClassHandler();

$monitor = new HTML_Progress_Monitor('frmMonitor5', array(
    'title'  => 'Upload your pictures',
    'start'  => 'Upload',
    'cancel' => 'Stop',
    'button' => array('style' => 'width:80px;')
));

$progress = new HTML_Progress();
$progress->setUI('Progress_ITDynamic');
$progress->setAnimSpeed(50);
$progress->setProgressHandler(array(&$obs, 'my1Method'));

$monitor->setProgressElement($progress);

$tpl =& new HTML_Template_ITX('../templates');

$tpl->loadTemplateFile('itdynamic_monitor.html');

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

?>