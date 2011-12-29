<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setCellAttributes Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_setCellAttributes extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setCellAttributes.
     *
     */
    function test_setCellAttributes_fail_no_integer()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $this->ui->setCellAttributes('','');
        $this->_getResult('string');
    }

    function test_setCellAttributes_fail_no_positive()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $this->ui->setCellAttributes('',-1);
        $this->_getResult(-1);
    }

    function test_setCellAttributes_fail_invalid_cellindex()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $this->ui->setCellAttributes('',11);
        $this->_getResult(11);
    }

    function test_setCellAttributes()
    {
        if (!$this->_methodExists('setCellAttributes')) {
            return;
        }
        $this->ui->setCellAttributes('color = #FF0000');
        $this->_getPass();
    }
}
?>
