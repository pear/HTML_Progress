<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setBorderPainted Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setBorderPainted extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setBorderPainted.
     *
     */
    function test_setBorderPainted_fail_no_boolean()
    {
        if (!$this->_methodExists('setBorderPainted')) {
            return;
        }
        $this->progress->setBorderPainted('');
        $this->_getResult('string');
    }

    function test_setBorderPainted()
    {
        if (!$this->_methodExists('setBorderPainted')) {
            return;
        }
        $this->progress->setBorderPainted(true);
        $this->_getPass();
    }
}
?>
