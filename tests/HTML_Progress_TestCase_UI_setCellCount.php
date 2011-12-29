<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setCellCount Unit tests for HTML_Progress_UI class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_UI_setCellCount extends HTML_Progress_TestCase
{
    /**
     * TestCases for method setCellCount.
     *
     */
    function test_setCellCount_fail_no_integer()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->ui->setCellCount('');
        $this->_getResult('string');
    }

    function test_setCellCount_fail_less_1()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->ui->setCellCount(0);
        $this->_getResult(0);
    }

    function test_setCellCount_horizontal_valid_width()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->ui->setCellCount(1);

        $this->assertEquals(19, $this->ui->_progress['progress']['width'],
            'default-size HORIZONTAL-1-cell no-border : w=19 h=24.');
    }

    function test_setCellCount_vertical_valid_height()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
        $this->ui->setCellCount(2);

        $this->assertEquals(36, $this->ui->_progress['progress']['height'],
            'default-size VERTICAL-2-cells no-border : w=24 h=36.');
    }

    function test_setCellCount()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->ui->setCellCount(16);
        $this->_getPass();
    }
}
?>
