<?php

/**
 * API setString Unit tests for HTML_Progress class.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_setString extends PHPUnit_TestCase
{
    /**
     * HTML_Progress instance
     *
     * @var        object
     */
    var $progress;

    function HTML_Progress_TestCase_setString($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);

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
     * TestCases for method setString.
     *
     */
    function test_setString_fail()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $this->progress->setStringPainted(false);
        $str = '"Receiving 1 out of 5"';
        $this->progress->setString($str);
        $percent = $this->progress->getString();

        $this->assertEquals($str, '"'.$percent.'"');
    }

    function test_setString()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $this->progress->setStringPainted(true);
        $str = '"Receiving 1 out of 5"';
        $this->progress->setString($str);
        $percent = $this->progress->getString();

        $this->assertEquals($str, $percent);
    }
}

?>
