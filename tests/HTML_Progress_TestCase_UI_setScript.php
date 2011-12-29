<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setScript Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_setScript extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setScript.
     *
     */
    function test_setScript_fail_no_string()
    {
        if (!$this->_methodExists('setScript')) {
            return;
        }
        $this->ui->setScript(100);
        $this->_getResult('integer');
    }

    function test_setScript_fail_no_file()
    {
        if (!$this->_methodExists('setScript')) {
            return;
        }
        $this->ui->setScript('progress1.js');
        $this->_getResult('progress1.js file does not exists');
    }

    function test_setScript()
    {
        if (!$this->_methodExists('setScript')) {
            return;
        }
        $this->ui->setScript(dirname(__FILE__) . '/progress3.js');
        $this->_getPass();
    }
}
?>
