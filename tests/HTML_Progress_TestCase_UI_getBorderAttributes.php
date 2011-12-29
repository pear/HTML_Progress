<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API getBorderAttributes Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_getBorderAttributes extends HTML_Progress_TestCase
{
    /**
     * TestCases for method getBorderAttributes.
     *
     */
    function test_getBorderAttributes_fail_no_boolean()
    {
        if (!$this->_methodExists('getBorderAttributes')) {
            return;
        }
        $this->ui->getBorderAttributes('');
        $this->_getResult('string');
    }

    function test_getBorderAttributes()
    {
        if (!$this->_methodExists('getBorderAttributes')) {
            return;
        }
        $this->ui->getBorderAttributes(true);
        $this->_getPass();
    }
}
?>
