<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setDM Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setDM extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setDM.
     *
     */
    function test_setDM_fail()
    {
        if (!$this->_methodExists('setDM')) {
            return;
        }
        $this->progress->setDM('');
        $this->_getResult('class does not exists');
    }
}
?>
