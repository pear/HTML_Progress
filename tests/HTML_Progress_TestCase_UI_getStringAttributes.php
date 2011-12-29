<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API getStringAttributes Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_getStringAttributes extends HTML_Progress_TestCase
{
    /**
     * TestCases for method getStringAttributes.
     *
     */
    function test_getStringAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getStringAttributes')) {
            return;
        }
        $this->ui->getStringAttributes('');
        $this->_getResult('string');
    }

    function test_getStringAttributes()
    {
        if (!$this->_methodExists('getStringAttributes')) {
            return;
        }
        $this->ui->getStringAttributes(true);
        $this->_getPass();
    }
}
?>
