<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setStringPainted Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setStringPainted extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setStringPainted.
     *
     */
    function test_setStringPainted_fail_no_boolean()
    {
        if (!$this->_methodExists('setStringPainted')) {
            return;
        }
        $this->progress->setStringPainted('');
        $this->_getResult('string');
    }

    function test_setStringPainted()
    {
        if (!$this->_methodExists('setStringPainted')) {
            return;
        }
        $this->progress->setStringPainted(true);
        $this->_getPass();
    }
}
?>
