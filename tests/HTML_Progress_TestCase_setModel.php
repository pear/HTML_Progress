<?php
/**
 * API setModel Unit tests for HTML_Progress class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_setModel extends PHPUnit_TestCase
{
    /**
     * HTML_Progress instance
     *
     * @var        object
     */
    var $progress;

    function HTML_Progress_TestCase_setModel($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL & ~E_NOTICE);

        $logger['display_errors'] = 'off';                        // don't use PEAR::Log display driver
        $logger['msgCallback'] = array(&$this, '_msgCallback');   // remove file&line context in error message
        $logger['pushCallback'] = array(&$this, '_pushCallback'); // don't die when an exception is thrown
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
        if (substr(PHP_VERSION,0,1) < '5') {
            $n = strtolower($name);
        } else {
            $n = $name;
        }
        if (in_array($n, get_class_methods($this->progress))) {
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

    function _pushCallback($err)
    {
        // don't die if the error is an exception (as default callback)
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
     * TestCases for method setModel.
     *
     */
    function test_setModel_fail_no_file()
    {
        if (!$this->_methodExists('setModel')) {
            return;
        }
        $this->progress->setModel('progress360.php', 'phpArray');
        $this->_getResult();
    }

    function test_setModel_fail_invalid_filetype()
    {
        if (!$this->_methodExists('setModel')) {
            return;
        }
        $this->progress->setModel('ancestor.ini', 'simpleXML');
        $this->_getResult();
    }

    function test_setModel()
    {
        if (!$this->_methodExists('setModel')) {
            return;
        }
        $this->progress->setModel('ancestor.ini', 'iniCommented');
        $this->_getResult();
    }
}
?>
