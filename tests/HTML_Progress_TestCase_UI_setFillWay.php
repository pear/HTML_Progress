<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setFillWay Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_setFillWay extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setFillWay.
     *
     */
    function test_setFillWay_fail_no_string()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $this->ui->setFillWay(0);
        $this->_getResult('integer');
    }

    function test_setFillWay_fail_invalid_value()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $this->ui->setFillWay('right');
        $this->_getResult('right');
    }

    function test_setFillWay_natural()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $this->ui->setFillWay('natural');
        $this->_getPass();
    }
}
?>
