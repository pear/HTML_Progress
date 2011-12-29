<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API getDM Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_getDM extends HTML_Progress_TestCase
{
    /**
     * TestCases for method getDM.
     *
     */
    function test_getDM_fail()
    {
        if (!$this->_methodExists('getDM')) {
            return;
        }
        $dm = $this->progress->getDM();

        $this->assertNotEquals($this, $dm, 'Expected different objects');
    }

    function test_getDM()
    {
        if (!$this->_methodExists('getDM')) {
            return;
        }
        $dm = $this->progress->getDM();

        $this->assertEquals($this->progress->_DM, $dm);
    }
}
?>
