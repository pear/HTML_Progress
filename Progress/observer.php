<?php
// +----------------------------------------------------------------------+
// | PEAR :: HTML :: Progress                                             |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Laurent Laville <pear@laurent-laville.org>                   |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * The HTML_Progress_Observer implements the observer pattern
 * for watching progress bar activity and taking actions
 * on exceptional events.
 *
 * @version    1.2.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @package    HTML_Progress
 * @subpackage Progress_Observer
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

class HTML_Progress_Observer
{
    /**
     * Instance-specific unique identification number.
     *
     * @var        integer
     * @since      1.0
     * @access     private
     */
    var $_id;

    /**
     * Creates a new basic HTML_Progress_Observer instance.
     *
     * @since      1.0
     * @access     public
     */
    function HTML_Progress_Observer()
    {
        $this->_id = md5(microtime());
    }

    /**
     * This is a stub method to make sure that HTML_Progress_Observer classes do
     * something when they are notified of a message.  The default behavior
     * is to just write into a file 'progress_observer.log' in current directory.
     * You should override this method.
     *
     * Default events :
     * - setMinimum
     * - setMaximum
     * - setValue
     *
     * @param      mixed     $event         A hash describing the progress event.
     * @since      1.0
     * @access     public
     */
    function notify($event)
    {
        $msg = (is_array($event)) ? serialize($event) : $event;
        error_log ("$msg \n", 3, 'progress_observer.log');
    }
}

?>
