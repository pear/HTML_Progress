<?php

/**
 * API Unit tests for HTML_Progress_DM class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_DM extends PHPUnit_TestCase
{
    /**
     * HTML_Progress_DM instance
     *
     * @var        object
     */
    var $dataModel;

    function HTML_Progress_TestCase_DM($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);
        $this->errorThrown = false;
        set_error_handler(array(&$this, 'errorHandler'));

        $this->dataModel = new HTML_Progress_DM(25,200,10);
        Error_Raise::setContextGrabber($this->dataModel->_package, array('Error_Util', '_getFileLine'));
    }

    function tearDown()
    {
        unset($this->dataModel);
    }

    function _stripWhitespace($str)
    {
        return preg_replace('/\\s+/', '', $str);
    }

    function _methodExists($name) 
    {
        if (in_array(strtolower($name), get_class_methods($this->dataModel))) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name . ' not implemented in ' . get_class($this->dataModel));
        return false;
    }

    function errorHandler($errno, $errstr, $errfile, $errline) {
        //die("$errstr in $errfile at line $errline");
        $this->errorThrown = true;
        $this->assertTrue(false, $errstr);
    }
   
    /**
     * TestCases for method setMinimum.
     *
     */
    function test_setMinimum_fail_no_integer()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dataModel->setMinimum('');
    }

    function test_setMinimum_fail_no_positive()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dataModel->setMinimum(-1);
    }

    function test_setMinimum_fail_greater_max()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dataModel->setMinimum(500);
    }

    function test_setMinimum()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dataModel->setMinimum(10);

        $this->assertFalse($this->errorThrown, 'error thrown');
    }

    /**
     * TestCases for method setMaximum.
     *
     */
    function test_setMaximum_fail_no_integer()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dataModel->setMaximum('');
    }

    function test_setMaximum_fail_no_positive()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dataModel->setMaximum(-1);
    }

    function test_setMaximum_fail_less_min()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dataModel->setMaximum(10);
    }

    function test_setMaximum()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dataModel->setMaximum(60);

        $this->assertFalse($this->errorThrown, 'error thrown');
    }

    /**
     * TestCases for method setIncrement.
     *
     */
    function test_setIncrement_fail_no_integer()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dataModel->setIncrement('');
    }

    function test_setIncrement_fail_no_zero()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dataModel->setIncrement(0);
    }

    function test_setIncrement()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dataModel->setIncrement(-10);

        $this->assertFalse($this->errorThrown, 'error thrown');
    }

    /**
     * TestCases for method setValue.
     *
     */
    function test_setValue_fail_no_integer()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dataModel->setValue('');
    }

    function test_setValue_fail_less_min()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dataModel->setValue(5);
    }

    function test_setValue_fail_greater_max()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dataModel->setValue(1500);
    }

    function test_setValue()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dataModel->setValue(30);

        $this->assertFalse($this->errorThrown, 'error thrown');
    }
}

?>
