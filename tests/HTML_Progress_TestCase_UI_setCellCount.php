<?php

/**
 * API setCellCount Unit tests for HTML_Progress_UI class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_UI_setCellCount extends PHPUnit_TestCase
{
    /**
     * HTML_Progress_UI instance
     *
     * @var        object
     */
    var $ui;

    function HTML_Progress_TestCase_UI_setCellCount($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorThrown = false;
        set_error_handler(array(&$this, 'errorHandler'));

        $this->ui = new HTML_Progress_UI();
        Error_Raise::setContextGrabber($this->ui->_package, array('Error_Util', '_getFileLine'));
    }

    function tearDown()
    {
        unset($this->ui);
    }

    function _stripWhitespace($str)
    {
        return preg_replace('/\\s+/', '', $str);
    }

    function _methodExists($name) 
    {
        if (in_array(strtolower($name), get_class_methods($this->ui))) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name . ' not implemented in ' . get_class($this->ui));
        return false;
    }

    function errorHandler($errno, $errstr, $errfile, $errline) {
        //die("$errstr in $errfile at line $errline");
        $this->errorThrown = true;
        $this->assertTrue(false, $errstr);
    }
   
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
    }

    function test_setCellCount_fail_less_1()
    {
        if (!$this->_methodExists('setCellCount')) {
            return;
        }
        $this->ui->setCellCount(0);
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

        $this->assertFalse($this->errorThrown, 'error thrown');
    }
}

?>
