<?php
require_once 'HTML/Progress/monitor.php';
require_once 'HTML/QuickForm/Renderer/ITDynamic.php';
require_once 'HTML/Template/ITX.php';

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
        $bar =& $obj->getProgressElement();
        $bar->sleep();  // slow animation because we do noting else
    }
}

$monitor = new HTML_Progress_Monitor('frmMonitor5', array(
    'title'  => 'Upload your pictures',
    'start'  => 'Upload',
    'cancel' => 'Stop',
    'button' => array('style' => 'width:80px;')
    )
);
$monitor->setProgressHandler(array('my2ClassHandler','my1Method'));

$progress = new HTML_Progress();
$progress->setAnimSpeed(50);

$ui =& $progress->getUI();
$ui->setCellCount(20);
$ui->setProgressAttributes('background-color=#EEE');
$ui->setStringAttributes('background-color=#EEE color=navy');
$ui->setCellAttributes('inactive-color=#FFF active-color=#444444');

$monitor->setProgressElement($progress);

$tpl =& new HTML_Template_ITX('.');
$tpl->loadTemplateFile('monitor_itdynamic.html');
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
$tpl->show();

$monitor->run();   
?>