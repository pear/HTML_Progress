<?php 
/**
 * Horizontal ProgressBar in indeterminate mode.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once ('HTML/Progress/monitor.php');

class Task extends HTML_Progress_Monitor
{
    var $_current;
    
    function Task()
    {
        $this->_current = 0;
        $this->_id = md5(microtime());

        $this->_form = new HTML_QuickForm('ProgressBarDialog');

        $renderer =& $this->_form->defaultRenderer();
        $renderer->setFormTemplate('
            <table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#CCCC99">
            <form{attributes}>{content}
            </form>
            </table>
            ');
        $renderer->setHeaderTemplate('
            <tr>
		<td style="white-space:nowrap;background:#996;color:#ffc;" align="left" colspan="2"><b>{header}</b></td>
	    </tr>
	    ');
        
        $this->_form->addElement('header', 'windowsname', 'Progress...');
        $this->_form->addElement('static', 'progress');
        $this->_form->addElement('static', 'status');

        $buttons[] = &HTML_QuickForm::createElement('submit', 'start',  'Start',  'style="width:80px;"');
        $buttons[] = &HTML_QuickForm::createElement('submit', 'cancel', 'Cancel', 'style="width:80px;"');
        $this->_form->addGroup($buttons);

        
        $this->_progress = new HTML_Progress();
        $this->_progress->setIncrement(10);
        $this->_progress->setStringPainted(true);     // get space for the string
        $this->_progress->setString("");              // but don't paint it

        $ui = & $this->_progress->getUI();
        $ui->setProgressAttributes(array(
	        'background-color' => '#e0e0e0'
                ));        
        $ui->setStringAttributes(array(
                'color'  => '#996',
	        'background-color' => '#CCCC99'
                ));        
        $ui->setCellAttributes(array(
                'active-color' => '#996'
                ));

        $bar =& $this->_form->getElement('progress');
        $bar->setText( $this->_progress->toHtml() );

        $str =& $this->_form->getElement('status');
        $str->setText('<div id="status" style="color:#000000; font-size:10px;">&nbsp;</div>');

        $this->_progress->addListener($this);
    }

    function notify($event)
    {
        if (is_array($event)) {
            $log = strtolower($event['log']);
            $val = $event['value'];
            
            switch (strtolower($log)) {
             case 'incvalue':
             case 'setvalue':
                 $this->_current = $this->getCurrent() + 16;
                 $s = $this->getMessage();
                 if (!is_null($s)) {
                     if ($this->_progress->isIndeterminate()) {
                         $this->_progress->setIndeterminate(false);
                         $this->_progress->setString(null);      // display % string
                         $this->_progress->setValue(0);
                     }
                     if ($this->isDone()) {
                         $this->_progress->removeListener($this);
                         $this->_progress->setString("");       // hide % string
                     }
                 }
                 $this->_progress->display();
                 
                 if ($this->_progress->getPercentComplete() == 1) {
                     if ($this->_progress->isIndeterminate()) {
                         $this->_progress->setValue(0);
                     }
                 } else {
                     $this->_progress->incValue();
                 }
                 break;
             default:
            }
        }
    }

    function getCurrent()
    {
        return $this->_current;
    }

    function getMessage()
    {
        $c = $this->getCurrent();
        $s = "completed $c out of 416";

        if (function_exists('ob_get_clean')) {
            $status  = ob_get_clean();      // use for PHP 4.3+
        } else {
            $status  = ob_get_contents();   // use for PHP 4.2+
            ob_end_clean();
        }
        $status = '<script type="text/javascript">self.setStatus("'.$s.'"); </script>';
        echo $status;
        ob_start();
        
        if ($c >= 240 ) {
            return $s;
        } else {
            return null;
        }
    }

    function isDone()
    {
        return ( ($this->_progress->getPercentComplete() == 1) &&
                 ($this->_progress->isIndeterminate() == false) );
    }


    function isStarted()
    {
        $action = $this->_form->getSubmitValues();

        if (isset($action['start'])) {
            return true;
        }

        return false;
    }

    function run()
    {
        if ($this->isStarted()) {
            $this->_progress->setIndeterminate(true);
            $this->_progress->incValue();
            
        } else {
            $abort = $this->isCanceled();
        }
    }

}

$task = new Task();

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Indeterminate Mode Progress example</title>
<style type="text/css">
<!--
<?php echo $task->getStyle(); ?>

body {
	background-color: #444444;
	color: #EEEEEE;
	font-family: Verdana, Arial;
}

a:visited, a:active, a:link {
	color: yellow;
}
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $task->getScript(); ?>

function setStatus(pString)
{
        if (isDom)
            prog = document.getElementById('status');
        if (isIE)
            prog = document.all['status'];
        if (isNS4)
            prog = document.layers['status'];
	if (prog != null) 
	    prog.innerHTML = pString;
}
//-->
</script>
</head>
<body>
<h1><?php echo basename(__FILE__); ?></h1>

<?php 
echo $task->toHtml(); 

$task->run();
?>

<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>

</body>
</html>