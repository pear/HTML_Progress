<?php 
include '../../include_path.php';
/**
 * Complex Monitor ProgressBar example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once ('HTML/Progress/monitor.php');
require_once ('HTML/QuickForm/Renderer/ITStatic.php');
require_once ('HTML/Template/ITX.php');

class ProgressMonitor extends HTML_Progress_Monitor
{
    
    function ProgressMonitor()
    {
        $this->_id = md5(microtime());

        $this->_form = new HTML_QuickForm('form');
        
        $this->_form->addElement('header', 'windowsname', 'Progress...');
        $this->_form->addElement('static', 'progress');
        $this->_form->addElement('submit', 'cancel', 'Cancel');
        
        $this->attachProgress();
    }

    function attachProgress()
    {
        $this->_progress = new HTML_Progress();
        $this->_progress->setIncrement(10);

        $ui =& $this->_progress->getUI();
        $ui->setProgressAttributes('background-color=#EEE');
        $ui->setCellAttributes('inactive-color=#FFF active-color=#444444');
        $ui->setStringAttributes('background-color=#EEE color=navy');

        $this->_progress->addListener($this);
        
        $bar =& $this->_form->getElement('progress');
        $bar->setText( $this->_progress->toHtml() );
    }

    function toHtml()
    {
        $tpl =& new HTML_Template_ITX('.');
        $tpl->loadTemplateFile('monitor.html');

        $js  = $this->getScript();
        $css = $this->getStyle();
        $tpl->setVariable("monitor_script", $js);
        $tpl->setVariable("monitor_style", $css);

        $renderer =& new HTML_QuickForm_Renderer_ITStatic($tpl);       
        $this->_form->accept($renderer);
        return $tpl->get();
    }

    function display()
    {
        print $this->toHtml();
    }
}

$progressMonitor = new ProgressMonitor();
$progressMonitor->display();
$progressMonitor->run();

?>
