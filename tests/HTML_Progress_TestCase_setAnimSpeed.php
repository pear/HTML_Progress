<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setAnimSpeed Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setAnimSpeed extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setAnimSpeed.
     *
     */
    function test_setAnimSpeed_fail_no_integer()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $this->progress->setAnimSpeed('');
        $this->_getResult('string');
    }

    function test_setAnimSpeed_fail_no_positive()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $this->progress->setAnimSpeed(-1);
        $this->_getResult(-1);
    }

    function test_setAnimSpeed_fail_greater_max_allowed()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $this->progress->setAnimSpeed(1500);
        $this->_getResult(1500);
    }

    function test_setAnimSpeed()
    {
        if (!$this->_methodExists('setAnimSpeed')) {
            return;
        }
        $this->progress->setAnimSpeed(100);
        $this->_getPass();
    }
}
?>
