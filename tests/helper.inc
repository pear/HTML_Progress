<?php

if ($fp = @fopen('PHPUnit/Autoload.php', 'r', true)) {
    require_once 'PHPUnit/Autoload.php';
} elseif ($fp = @fopen('PHPUnit/Framework.php', 'r', true)) {
    require_once 'PHPUnit/Framework.php';
    require_once 'PHPUnit/TextUI/TestRunner.php';
} else {
    die('skip could not find PHPUnit');
}
fclose($fp);

if ('@php_dir@' == '@'.'php_dir'.'@') {
    // This package hasn't been installed.
    // Adjust path to ensure includes find files in working directory.
    set_include_path(dirname(dirname(__FILE__))
        . PATH_SEPARATOR . dirname(__FILE__)
        . PATH_SEPARATOR . get_include_path());
}

if (@!include_once 'HTML/Common.php') {
    die("These tests require HTML_Common.\n");
}

require_once 'HTML/Progress.php';

class HTML_Progress_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTML_Progress
     */
    protected $progress;
    /**
     * @var HTML_Progress_DM
     */
    protected $dm;
    /**
     * @var HTML_Progress_UI
     */
    protected $ui;

    function setUp()
    {
        $logger['push_callback'] = array(&$this, '_pushCallback'); // don't die when an exception is thrown
        $this->progress = new HTML_Progress($logger);
        $this->dm = $this->progress->getDM();
        $this->ui = $this->progress->getUI();
    }

    function tearDown()
    {
        unset($this->ui);
        unset($this->dm);
        unset($this->progress);
    }

    function _stripWhitespace($str)
    {
        return preg_replace('/\\s+/', '', $str);
    }

    function _methodExists($name)
    {
        return true;
        if (!in_array($name, get_class_methods($this->dm))) {
            $this->markTestSkipped('method '. $name . ' not implemented in ' . get_class($this->dm));
        }
    }

    function _pushCallback($err)
    {
        // don't die if the error is an exception (as default callback)
        return HTML_PROGRESS_ERRORSTACK_PUSH;
    }

    /**
     * Use this when expect the prior operation to NOT produce errors
     */
    protected function _getPass()
    {
        if ($this->progress->hasErrors()) {
            $err = $this->progress->getError();
            $this->fail($err['message']);
        } else {
            $this->assertTrue(true);
        }
    }

    /**
     * Use this when expect the prior operation TO produce errors
     */
    function _getResult($exp = 'UPDATE TEST WITH PROPER EXPECTATION')
    {
        if ($this->progress->hasErrors()) {
            $err = $this->progress->getError();
            $this->assertStringEndsWith('instead got "' . $exp . '"', $err['message']);
        } else {
            $this->fail('expected error but had none');
        }
    }
}
