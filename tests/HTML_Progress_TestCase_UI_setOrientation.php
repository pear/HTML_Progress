<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setOrientation Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_setOrientation extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setOrientation.
     *
     */
    function test_setOrientation_fail_no_integer()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation('');
        $this->_getResult('string');
    }

    function test_setOrientation_fail_invalid_value()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation(0);
        $this->_getResult(0);
    }

    function test_setOrientation_vertical_valid_width()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);

        $this->assertEquals(24, $this->ui->_progress['progress']['width'],
            'default-size VERTICAL no-border : w=24 h=172.');
    }

    function test_setOrientation_vertical_valid_height()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);

        $this->assertEquals(172, $this->ui->_progress['progress']['height'],
            'default-size VERTICAL no-border : w=24 h=172.');
    }

    function test_setOrientation_vertical_valid_cell_width()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);

        $this->assertEquals(20, $this->ui->_progress['cell']['width'],
            'default-cell-size VERTICAL : w=20 h=15.');
    }

    function test_setOrientation_vertical_valid_cell_height()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);

        $this->assertEquals(15, $this->ui->_progress['cell']['height'],
            'default-cell-size VERTICAL : w=20 h=15.');
    }

    function test_setOrientation_vertical()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
        $this->_getPass();
    }
}
?>
