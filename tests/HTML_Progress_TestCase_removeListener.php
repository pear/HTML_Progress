<?php

require_once dirname(__FILE__) . '/helper.inc';

/**
 * API removeListener Unit tests for HTML_Progress class.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @ignore
 */

class HTML_Progress_TestCase_removeListener extends HTML_Progress_TestCase
{
    /**
     * TestCases for method removeListener.
     *
     */
    function test_removeListener_fail_no_class()
    {
        if (!$this->_methodExists('removeListener')) {
            return;
        }
        $observer = 'log_progress2';
        $monitor = $this->progress->removeListener(new $observer);
        $this->assertFalse($monitor);
    }

    function test_removeListener()
    {
        if (!$this->_methodExists('removeListener')) {
            return;
        }
        $observer = 'logit2';
        $monitor = $this->progress->addListener(new $observer);
        $monitor = $this->progress->removeListener(new $observer);

        $this->assertTrue($monitor, $observer .' is not a valid listener or is not yet attached ');
    }
}

require_once ('HTML/Progress/observer.php');
/**
 * @ignore
 */
class logit2 extends HTML_Progress_Observer
{
    function logit2()
    {
    }
}
/**
 * @ignore
 */
class log_progress2
{
}
?>
