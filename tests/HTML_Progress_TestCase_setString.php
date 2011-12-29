<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setString Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setString extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setString.
     *
     */
    function test_setString_fail()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $this->progress->setStringPainted(false);
        $str = '"Receiving 1 out of 5"';
        $this->progress->setString($str);
        $percent = $this->progress->getString();

        $this->assertEquals('"0 %"', '"'.$percent.'"');
    }

    function test_setString()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $this->progress->setStringPainted(true);
        $str = '"Receiving 1 out of 5"';
        $this->progress->setString($str);
        $percent = $this->progress->getString();

        $this->assertEquals($str, $percent);
    }
}

?>
