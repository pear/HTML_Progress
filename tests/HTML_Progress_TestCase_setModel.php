<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API setModel Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_setModel extends HTML_Progress_TestCase
{
    static $skip = false;
    static $config;

    public static function setUpBeforeClass()
    {
        if (! $fp = @fopen('Config.php', 'r', true)) {
            self::$skip = true;
        }
        fclose($fp);
        include_once 'Config.php';
        self::$config = $GLOBALS['CONFIG_TYPES'];
    }

    public function setUp()
    {
        if (self::$skip) {
            $this->markTestSkipped("PEAR's Config package needs to be installed.");
        }
        parent::setUp();
        $GLOBALS['CONFIG_TYPES'] = self::$config;
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
        $this->_getResult('progress360.php');
    }

    function test_setModel_fail_invalid_filetype()
    {
        if (!$this->_methodExists('setModel')) {
            return;
        }
        $this->progress->setModel(dirname(__FILE__) . '/ancestor.ini', 'simpleXML');
        $this->_getResult('simpleXML');
    }

    function test_setModel()
    {
        if (!$this->_methodExists('setModel')) {
            return;
        }
        $this->progress->setModel(dirname(__FILE__) . '/ancestor.ini', 'iniCommented');
        $this->_getPass();
    }
}
?>
