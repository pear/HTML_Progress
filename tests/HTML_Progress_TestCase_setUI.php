<?php

/**
 * API setUI Unit tests for HTML_Progress class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_setUI extends PHPUnit_TestCase
{
    /**
     * HTML_Progress instance
     *
     * @var        object
     */
    var $progress;

    function HTML_Progress_TestCase_setUI($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorThrown = false;
        set_error_handler(array(&$this, 'errorHandler'));

        $this->progress = new HTML_Progress();
        Error_Raise::setContextGrabber($this->progress->_package, array('Error_Util', '_getFileLine'));
    }

    function tearDown()
    {
        unset($this->progress);
    }

    function _stripWhitespace($str)
    {
        return preg_replace('/\\s+/', '', $str);
    }

    function _methodExists($name) 
    {
        if (in_array(strtolower($name), get_class_methods($this->progress))) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name . ' not implemented in ' . get_class($this->progress));
        return false;
    }

    function errorHandler($errno, $errstr, $errfile, $errline) {
        //die("$errstr in $errfile at line $errline");
        $this->errorThrown = true;
        $this->assertTrue(false, $errstr);
    }
   
    /**
     * TestCases for method setUI.
     *
     */
    function test_setUI_fail_no_class()
    {
        if (!$this->_methodExists('setUI')) {
            return;
        }
        $this->progress->setUI('progress360');
    }

    function test_setUI()
    {
        if (!$this->_methodExists('setUI')) {
            return;
        }
        $this->progress->setUI('progress180');

        $this->assertFalse($this->errorThrown, 'error thrown');
    }
}

class progress360
{
    function progress360()
    {
    }
}

class progress180 extends HTML_Progress_UI
{
    function progress180()
    {
    }
}

?>
