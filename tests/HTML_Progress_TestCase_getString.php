<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API getString Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_getString extends HTML_Progress_TestCase
{
    /**
     * TestCases for method getString.
     *
     */
    function test_getString_from_string()
    {
        if (!$this->_methodExists('getString')) {
            return;
        }
        $this->progress->setStringPainted(true);
        $str = '"Receiving 1 out of 5"';
        $this->progress->setString($str);
        $percent = $this->progress->getString();

        $this->assertEquals($str, $percent);
    }

    function test_getString()
    {
        if (!$this->_methodExists('getString')) {
            return;
        }
        $percent = $this->progress->getString();

        $this->assertEquals("0 %", $percent);
    }
}
?>
