<?php
require_once 'HTML/Progress.php';

class Progress_Plus extends HTML_Progress_DM
{
    var $_plus;
    
    function Progress_Plus()
    {
        $this->setMinimum(0);
        $this->setMaximum(60);
        $this->setIncrement(1);
        $this->setValue(0);
        $this->myNewFeature('a new feature');
    }

    function myNewFeature($plus)
    {
        $this->_plus = $plus;
    }
}

$bar = new HTML_Progress();
$bar->setDM('Progress_Plus');
$dm =& $bar->getDM();

print_r($dm);
?>