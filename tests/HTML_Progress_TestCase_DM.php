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

        $logger['display_errors'] = 'off';                      // don't use PEAR::Log display driver
        $logger['msgCallback'] = array(&$this, '_msgCallback'); // remove file&line context in error message
        $this->progress  = new HTML_Progress(25,200,$logger);
        $this->progress->setIncrement(10);
        $this->dataModel =& $this->progress->getDM();
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
        if (in_array(strtolower($name), get_class_methods($this->dataModel))) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name . ' not implemented in ' . get_class($this->dataModel));
        return false;
    }

    function _msgCallback(&$stack, $err)
    {
        $message = call_user_func_array(array(&$stack, 'getErrorMessage'), array(&$stack, $err));
        return $message;
    }

    function _getResult()
    {
        $s = &PEAR_ErrorStack::singleton('HTML_Progress');
        if ($s->hasErrors()) {
            $err = $s->pop();
            $this->assertTrue(false, $err['message']);
        } else {
            $this->assertTrue(true);
	}
    }

    function errorHandler($errno, $errstr, $errfile, $errline) {
        $this->errorOccured = true;
        $this->assertTrue(false, "$errstr at line $errline");
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
        $this->_getResult();
    }

    function test_setMinimum_fail_no_positive()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dataModel->setMinimum(-1);
        $this->_getResult();
    }

    function test_setMinimum_fail_greater_max()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dataModel->setMinimum(500);
        $this->_getResult();
    }

    function test_setMinimum()
    {
        if (!$this->_methodExists('setMinimum')) {
            return;
        }
        $this->dataModel->setMinimum(10);
        $this->_getResult();
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
        $this->_getResult();
    }

    function test_setMaximum_fail_no_positive()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dataModel->setMaximum(-1);
        $this->_getResult();
    }

    function test_setMaximum_fail_less_min()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dataModel->setMaximum(10);
        $this->_getResult();
    }

    function test_setMaximum()
    {
        if (!$this->_methodExists('setMaximum')) {
            return;
        }
        $this->dataModel->setMaximum(60);
        $this->_getResult();
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
        $this->_getResult();
    }

    function test_setIncrement_fail_no_zero()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dataModel->setIncrement(0);
        $this->_getResult();
    }

    function test_setIncrement()
    {
        if (!$this->_methodExists('setIncrement')) {
            return;
        }
        $this->dataModel->setIncrement(-10);
        $this->_getResult();
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
        $this->_getResult();
    }

    function test_setValue_fail_less_min()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dataModel->setValue(5);
        $this->_getResult();
    }

    function test_setValue_fail_greater_max()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dataModel->setValue(1500);
        $this->_getResult();
    }

    function test_setValue()
    {
        if (!$this->_methodExists('setValue')) {
            return;
        }
        $this->dataModel->setValue(30);
        $this->_getResult();
    }
}

?>
