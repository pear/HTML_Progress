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
        error_reporting(E_ALL & ~E_NOTICE);

        $logger['display_errors'] = 'off';                      // don't use PEAR::Log display driver
        $logger['msgCallback'] = array(&$this, '_msgCallback'); // remove file&line context in error message
        $this->progress = new HTML_Progress($logger);
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
        $this->_getResult();
    }

    function test_setUI()
    {
        if (!$this->_methodExists('setUI')) {
            return;
        }
        $this->progress->setUI('progress180');
        $this->_getResult();
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
