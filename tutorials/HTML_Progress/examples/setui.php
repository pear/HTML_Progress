<?php
require_once 'HTML/Progress.php';

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

$bar = new HTML_Progress();
$bar->setUI('Progress_ITDynamic');
$ui =& $bar->getUI();

print_r($ui);
?>