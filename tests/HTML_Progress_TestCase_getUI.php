<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API getUI Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_getUI extends HTML_Progress_TestCase
{
    /**
     * TestCases for method getUI.
     *
     */
    function test_getUI_fail()
    {
        if (!$this->_methodExists('getUI')) {
            return;
        }
        $ui = $this->progress->getUI();

        $this->assertNotEquals($this, $ui, 'Expected different objects');
    }

    function test_getUI()
    {
        if (!$this->_methodExists('getUI')) {
            return;
        }
        $ui = $this->progress->getUI();

        $this->assertEquals($this->progress->_UI, $ui);
    }
}
?>
