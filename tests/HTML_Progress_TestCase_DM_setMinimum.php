<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setMinimum Unit tests for HTML_Progress_DM class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_DM_setMinimum extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setMinimum.
     *
     */
    function test_setMinimum_fail_no_integer()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dm->setMinimum('');
        $this->_getResult('string');
    }

    function test_setMinimum_fail_no_positive()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dm->setMinimum(-1);
        $this->_getResult(-1);
    }

    function test_setMinimum_fail_greater_max()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dm->setMinimum(500);
        $this->_getResult(500);
    }

    function test_setMinimum()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dm->setMinimum(10);
        $this->_getPass();
    }
}
?>
