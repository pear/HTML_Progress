<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setCellCoordinates Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_setCellCoordinates extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setCellCoordinates.
     *
     */
    function test_setCellCoordinates_fail_no_integer()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $this->ui->setCellCoordinates('',2);
        $this->_getResult('string');
    }

    function test_setCellCoordinates_fail_no_positive()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $this->ui->setCellCoordinates(-1,4);
        $this->_getResult(-1);
    }

    function test_setCellCoordinates_fail_too_small()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $this->ui->setCellCoordinates(1,2);
        $this->_getResult(1);
    }

    function test_setCellCoordinates()
    {
        if (!$this->_methodExists('setCellCoordinates')) {
            return;
        }
        $this->ui->setCellCoordinates(5,5);
        $this->_getPass();
    }
}
?>
