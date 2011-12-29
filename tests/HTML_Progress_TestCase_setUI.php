<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setUI Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setUI extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setUI.
     *
     */
    function test_setUI_fail()
    {
        $this->progress->setUI('');
        $this->_getResult('class does not exists');
    }
}
?>
