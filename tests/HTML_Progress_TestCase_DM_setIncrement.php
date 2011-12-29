<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setIncrement Unit tests for HTML_Progress_DM class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_DM_setIncrement extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setIncrement.
     *
     */
    function test_setIncrement_fail_no_integer()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dm->setIncrement('');
        $this->_getResult('string');
    }

    function test_setIncrement_fail_zero()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dm->setIncrement(0);
        $this->_getResult(0);
    }

    function test_setIncrement()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dm->setIncrement(5);
        $this->_getPass();
    }
}
?>
