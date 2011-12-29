<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API getProgressAttributes Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_getProgressAttributes extends HTML_Progress_TestCase
{
    /**
     * TestCases for method getProgressAttributes.
     *
     */
    function test_getProgressAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getProgressAttributes')) {
            return;
        }
        $this->ui->getProgressAttributes('');
        $this->_getResult('string');
    }

    function test_getProgressAttributes()
    {
        if (!$this->_methodExists('getProgressAttributes')) {
            return;
        }
        $this->ui->getProgressAttributes(true);
        $this->_getPass();
    }
}
?>
