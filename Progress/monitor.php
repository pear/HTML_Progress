<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
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
 * The HTML_Progress_Monitor class allow an easy way to display progress
 * in a dialog. The user can cancel the task.
 *
 * @version    1.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @category   HTML
 * @package    HTML_Progress
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @todo       add more easy-to-build methods, such as setNote(), setTitle() ...
 */

require_once ('HTML/Progress.php');
require_once ('HTML/QuickForm.php');

class HTML_Progress_Monitor
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
     * The progress object renders into this monitor.
     *
     * @var        object
     * @since      1.0
     * @access     private
     */
    var $_progress;

    /**
     * The quickform object that allows the presentation.
     *
     * @var        object
     * @since      1.0
     * @access     private
     */
    var $_form;


    /**
     * The progress monitor class constructor
     *
     * @since      1.0
     * @access     public
     */
    function HTML_Progress_Monitor()
    {
        $this->_id = md5(microtime());

        $this->_form = new HTML_QuickForm('ProgressBarDialog');

        $renderer =& $this->_form->defaultRenderer();
        $renderer->setFormTemplate('
            <table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#CCCC99">
            <form{attributes}>{content}
            </form>
            </table>
            ');
        $renderer->setHeaderTemplate('
            <tr>
		<td style="white-space:nowrap;background:#996;color:#ffc;" align="left" colspan="2"><b>{header}</b></td>
	    </tr>
	    ');
        
        $this->_form->addElement('header', 'windowsname', 'Progress...');
        $this->_form->addElement('static', 'progress');
        $this->_form->addElement('submit', 'cancel', 'Cancel');
        
        $this->attachProgress();
    }

    /**
     * Attach a progress bar to this monitor.
     *
     * @param      object                   (optional) a progress instance
     *
     * @return     void
     * @since      1.0
     * @access     public
     */
    function attachProgress()
    {
        $args = func_get_args();

        if (count($args) == 1) {
            $this->_progress =& $args[0];
        } else {
            // default embedded progress element with look-and-feel
            $this->_progress = new HTML_Progress();
            $this->_progress->setIncrement(10);

            $ui = & $this->_progress->getUI();
            $ui->setProgressAttributes(array(
	        'background-color' => '#e0e0e0'
                ));        
            $ui->setStringAttributes(array(
                'color'  => '#996',
	        'background-color' => '#e0e0e0'
                ));        
            $ui->setCellAttributes(array(
                'active-color' => '#996'
                ));
        }        	
        $this->_progress->addListener($this);
        
        $bar =& $this->_form->getElement('progress');
        $bar->setText( $this->_progress->toHtml() );
    }

    /**
     * Listens all progress events from this monitor.
     *
     * @param      mixed     $event         A hash describing the progress event.
     *
     * @return     void
     * @since      1.0
     * @access     public
     */
    function notify($event)
    {
        if (is_array($event)) {
            $log = strtolower($event['log']);
            if ($log == 'incvalue') {
                if ($this->_progress->getPercentComplete() == 1) {
                    // the progress bar has reached 100%
                    $this->_progress->removeListener($this);
                }
                $this->_progress->display();
                $this->_progress->incValue();
            }
        }
    }

    /**
     * Returns TRUE if progress was canceled by user, FALSE otherwise.
     * If the progress was canceled, stop also listening of events.
     *
     * @return     bool
     * @since      1.0
     * @access     public
     */
    function isCanceled()
    {
        $action = $this->_form->getSubmitValues();

        if (isset($action['cancel'])) {
            $this->_progress->removeListener($this);
            return true;
        }

        return false;
    }

    /**
     * Returns progress styles (StyleSheet).
     *
     * @return     string
     * @since      1.0
     * @access     public
     */
    function getStyle()
    {
        return $this->_progress->getStyle();
    }

    /**
     * Returns progress javascript.
     *
     * @return     string
     * @since      1.0
     * @access     public
     */
    function getScript()
    {
        return $this->_progress->getScript();
    }

    /**
     * Returns Monitor forms as a Html string.
     *
     * @return     string
     * @since      1.0
     * @access     public
     */
    function toHtml()
    {
        return $this->_form->toHtml();
    }

    /**
     * Display Monitor and catch user action (cancel button).
     *
     * @return     void
     * @since      1.0
     * @access     public
     */
    function run()
    {
        if (!$this->isCanceled()) {
            $this->_progress->incValue();
        }
    }
}

?>