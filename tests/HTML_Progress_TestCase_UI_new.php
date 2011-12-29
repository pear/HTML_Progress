<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setValue Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_new extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setValue.
     *
     */
    function test_new_fail_no_cell()
    {
        $this->ui = new HTML_Progress_UI('nocell');
        $this->_getResult('nocell');
    }

    function test_new()
    {
        $this->ui = new HTML_Progress_UI(20);
        $this->_getPass();
    }
}
?>
