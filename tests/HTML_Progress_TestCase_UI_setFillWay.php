<?php

/**
 * API setFillWay Unit tests for HTML_Progress_UI class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_UI_setFillWay extends PHPUnit_TestCase
{
    /**
     * HTML_Progress_UI instance
     *
     * @var        object
     */
    var $ui;

    function HTML_Progress_TestCase_UI_setFillWay($name)
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
     * TestCases for method setFillWay.
     *
     */
    function test_setFillWay_fail_no_string()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $this->ui->setFillWay(0);
    }

    function test_setFillWay_fail_invalid_value()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $this->ui->setFillWay('right');
    }

    function test_setFillWay_natural()
    {
        if (!$this->_methodExists('setFillWay')) {
            return;
        }
        $this->ui->setFillWay('natural');

        $this->assertFalse($this->errorThrown, 'error thrown');
    }
}

?>
