<?php

/**
 * API setIndeterminate Unit tests for HTML_Progress class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_setIndeterminate extends PHPUnit_TestCase
{
    /**
     * HTML_Progress instance
     *
     * @var        object
     */
    var $progress;

    function HTML_Progress_TestCase_setIndeterminate($name)
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
     * TestCases for method setIndeterminate.
     *
     */
    function test_setIndeterminate_fail_no_boolean()
    {
        if (!$this->_methodExists('setIndeterminate')) {
            return;
        }
        $this->progress->setIndeterminate('');
    }

    function test_setIndeterminate()
    {
        if (!$this->_methodExists('setIndeterminate')) {
            return;
        }
        $this->progress->setIndeterminate(true);

        $this->assertFalse($this->errorThrown, 'error thrown');
    }
}

?>
