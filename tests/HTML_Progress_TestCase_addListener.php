<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API addListener Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_addListener extends HTML_Progress_TestCase
{
    /**
     * TestCases for method addListener.
     *
     */
    function test_addListener_fail_no_class()
    {
        if (!$this->_methodExists('addListener')) {
            return;
        }
        $observer = 'logit';
        $monitor = $this->progress->addListener($observer);

        $this->assertFalse($monitor, 'Expected invalid listener ');
    }

    function test_addListener()
    {
        if (!$this->_methodExists('addListener')) {
            return;
        }
        $observer = 'log_progress';
        $monitor = $this->progress->addListener(new $observer);

        $this->assertTrue($monitor, $observer .' is not a valid listener ');
    }
}

require_once ('HTML/Progress/observer.php');
/**
 * @ignore
 */
class logit
{
}
/**
 * @ignore
 */
class log_progress extends HTML_Progress_Observer
{
    function log_progress()
    {
    }
}
?>
