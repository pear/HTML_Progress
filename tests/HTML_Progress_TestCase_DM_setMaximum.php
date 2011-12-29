<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setMaximum Unit tests for HTML_Progress_DM class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_DM_setMaximum extends HTML_Progress_TestCase
{
    function setUp()
    {
        parent::setUp();
        $this->dm->setMinimum(10);
        $this->dm->setMaximum(100);
    }

    /**
     * TestCases for method setMaximum.
     *
     */
    function test_setMaximum_fail_no_integer()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dm->setMaximum('');
        $this->_getResult('string');
    }

    function test_setMaximum_fail_no_positive()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dm->setMaximum(-1);
        $this->_getResult(-1);
    }

    function test_setMaximum_fail_less_min()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dm->setMaximum(1);
        $this->_getResult(1);
    }

    function test_setMaximum()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dm->setMaximum(10);
        $this->_getPass();
    }
}
?>
