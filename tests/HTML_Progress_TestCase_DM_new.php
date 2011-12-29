<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setValue Unit tests for HTML_Progress_DM class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_DM_new extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setValue.
     *
     */
    function test_new_fail_no_minimum()
    {
        $this->dm = new HTML_Progress_DM('nomin',1000);
        $this->_getResult('nomin');
    }

    function test_new_fail_no_maximum()
    {
        $this->dm = new HTML_Progress_DM(0,'nomax');
        $this->_getResult('nomax');
    }

    function test_new_fail_no_increment()
    {
        $this->dm = new HTML_Progress_DM(0,50,'noinc');
        $this->_getResult('noinc');
    }

    function test_new()
    {
        $this->dm = new HTML_Progress_DM(0,200,10);
        $this->_getPass();
    }
}
?>
