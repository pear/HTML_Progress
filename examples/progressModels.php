<?php

require_once ('HTML/Progress/UI.php');

/**
 * Progress Bar layout.
 * These models are used with Progress Monitor examples v1.1
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class Progress_Default2 extends HTML_Progress_UI
{
    function Progress_Default2()
    {
        parent::HTML_Progress_UI();
        
        $this->setProgressAttributes(array('background-color' => '#e0e0e0'));        
        $this->setStringAttributes(array('color' => '#996', 'background-color' => '#CCCC99'));        
        $this->setCellAttributes(array('active-color' => '#996'));
    }
}

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

class Progress_ITDynamic2 extends HTML_Progress_UI
{
    function Progress_ITDynamic2()
    {
        parent::HTML_Progress_UI();
        
        $this->setCellCount(5);
        $this->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
        $this->setProgressAttributes('background-color=#e0e0e0');
        $this->setStringAttributes('background-color=lightblue color=red');
    }
}
?>