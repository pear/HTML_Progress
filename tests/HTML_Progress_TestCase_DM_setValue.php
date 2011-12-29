<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setValue Unit tests for HTML_Progress_DM class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_DM_setValue extends HTML_Progress_TestCase
{
    function setUp()
    {
        parent::setUp();
        $this->dm->setMinimum(10);
        $this->dm->setMaximum(100);
    }

    /**
     * TestCases for method setValue.
     *
     */
    function test_setValue_fail_no_integer()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dm->setValue('');
        $this->_getResult('string');
    }

    function test_setValue_fail_less_than_min()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dm->setValue(1);
        $this->_getResult(1);
    }

    function test_setValue_fail_greater_than_max()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dm->setValue(200);
        $this->_getResult(200);
    }

    function test_setValue()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dm->setValue(15);
        $this->_getPass();
    }
}
?>
