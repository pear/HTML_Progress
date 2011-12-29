<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API getCellAttributes Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_getCellAttributes extends HTML_Progress_TestCase
{
    /**
     * TestCases for method getCellAttributes.
     *
     */
    function test_getCellAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getCellAttributes')) {
            return;
        }
        $this->ui->getCellAttributes('');
        $this->_getResult('string');
    }

    function test_getCellAttributes()
    {
        if (!$this->_methodExists('getCellAttributes')) {
            return;
        }
        $this->ui->getCellAttributes(true);
        $this->_getPass();
    }
}
?>
