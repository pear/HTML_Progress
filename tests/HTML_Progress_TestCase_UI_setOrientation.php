<?php

/**
 * API setOrientation Unit tests for HTML_Progress_UI class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_UI_setOrientation extends PHPUnit_TestCase
{
    /**
     * HTML_Progress_UI instance
     *
     * @var        object
     */
    var $ui;

    function HTML_Progress_TestCase_UI_setOrientation($name)
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
     * TestCases for method setOrientation.
     *
     */
    function test_setOrientation_fail_no_integer()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation('');
    }

    function test_setOrientation_fail_invalid_value()
    {
        if (!$this->_methodExists('setOrientation')) {
            return;
        }
        $this->ui->setOrientation(0);
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

        $this->assertFalse($this->errorThrown, 'error thrown');
    }
}

?>
