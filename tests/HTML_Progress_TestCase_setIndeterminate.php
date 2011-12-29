<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setIndeterminate Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setIndeterminate extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setIndeterminate.
     *
     */
    function test_setIndeterminate_fail_no_boolean()
    {
        if (!$this->_methodExists('setIndeterminate')) {
            return;
        }
        $this->progress->setIndeterminate('');
        $this->_getResult('string');
    }

    function test_setIndeterminate()
    {
        if (!$this->_methodExists('setIndeterminate')) {
            return;
        }
        $this->progress->setIndeterminate(true);
        $this->_getPass();
    }
}
?>
