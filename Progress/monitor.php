<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
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

require_once ('HTML/Progress/Error/Raise.php');
require_once ('HTML/Progress.php');
require_once ('HTML/QuickForm.php');

/**
 * The HTML_Progress_Monitor class allow an easy way to display progress
 * in a dialog. The user can cancel the task.
 *
 * @version    1.1
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @category   HTML
 * @package    HTML_Progress
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

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

    /**#@+
     * Attributes of monitor form.
     *
     * @var        string
     * @since      1.1
     * @access     public
     */
    var $windowname;
    var $buttonStart;
    var $buttonCancel;
    /**#@-*/
    
    /**
     * Delay in milisecond before each progress cells display.
     * 1000 ms === sleep(1)
     * <strong>usleep()</strong> function does not run on Windows platform.
     *
     * @var        integer
     * @since      1.1
     * @access     private
     * @see        setAnimSpeed()
     */
    var $_anim_speed = 0;

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
     * User callback, is in the format:
     * * $_callback = array('classname', 'functionname');
     * If the callback is not a method, then its just
     * * $_callback = 'functionname';
     *
     * @var        mixed
     * @since      1.1
     * @access     private
     */
    var $_callback = null;

    
    /**
     * Constructor Summary
     *
     * o Creates a standard progress bar into a dialog box (QuickForm).
     *   Form name, buttons 'start', 'cancel' labels and style, and 
     *   title of dialog box may also be changed.
     *   <code>
     *   $monitor = new HTML_Progress_Monitor();
     *   </code>
     *
     * o Creates a progress bar into a dialog box, with only a new 
     *   form name.
     *   <code>
     *   $monitor = new HTML_Progress_Monitor($formName);
     *   </code>
     *
     * o Creates a progress bar into a dialog box, with a new form name,
     *   new buttons name and style, and also a different title box.
     *   <code>
     *   $monitor = new HTML_Progress_Monitor($formName, $attributes);
     *   </code>
     *
     * @param      string    $formName      (optional) Name of monitor dialog box (QuickForm)
     * @param      array     $attributes    (optional) List of renderer options
     *
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function HTML_Progress_Monitor($formName = 'ProgressMonitor', $attributes = array())
    {
        $this->_package = 'HTML_Progress_Monitor';
        Error_Raise::initialize($this->_package, array('HTML_Progress', '_getErrorMessage'));

        if (!is_string($formName)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$formName',
                      'was' => gettype($formName),
                      'expected' => 'string',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif (!is_array($attributes)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$attributes',
                      'was' => gettype($attributes),
                      'expected' => 'array',
                      'paramnum' => 2), PEAR_ERROR_TRIGGER);
        }

        $this->_id = md5(microtime());

        $this->_form = new HTML_QuickForm($formName);

        $this->windowname   = isset($attributes['title'])  ? $attributes['title']  : 'In progress ...';
        $this->buttonStart  = isset($attributes['start'])  ? $attributes['start']  : 'Start';
        $this->buttonCancel = isset($attributes['cancel']) ? $attributes['cancel'] : 'Cancel';
        $buttonAttr         = isset($attributes['button']) ? $attributes['button'] : '';
        
        $this->_form->addElement('header', 'windowname', $this->windowname);
        $this->_form->addElement('static', 'progressBar');
        $this->_form->addElement('static', 'progressStatus');

        $style = $this->isStarted() ? array('disabled'=>'true') : null;
        
        $buttons[] =& $this->_form->createElement('submit', 'start',  $this->buttonStart, $style);
        $buttons[] =& $this->_form->createElement('submit', 'cancel', $this->buttonCancel);

        $buttons[0]->updateAttributes($buttonAttr);
        $buttons[1]->updateAttributes($buttonAttr);
        
        $this->_form->addGroup($buttons, 'buttons', '', '&nbsp;', false);
      
        // default embedded progress element with look-and-feel
        $bar = new HTML_Progress();
        $this->setProgressElement($bar);

        $str =& $this->_form->getElement('progressStatus');
        $str->setText('<div id="status" class="progressStatus">&nbsp;</div>');
    }

    /**
     * Set the sleep delay in milisecond before each progress cells display.
     *
     * @param      integer   $delay         Delay in milisecond.
     *
     * @return     void
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function setAnimSpeed($delay)
    {
        if (!is_int($delay)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$delay',
                      'was' => gettype($delay),
                      'expected' => 'integer',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($delay < 0) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$delay',
                      'was' => $delay,
                      'expected' => 'greater than zero',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($delay > 1000) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$delay',
                      'was' => $delay,
                      'expected' => 'less or equal 1000',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_anim_speed = $delay;
        
        // reflect changes on the observer copy
        $this->_progress->addListener($this);
    }

    /**
     * Listens all progress events from this monitor.
     *
     * @param      mixed     $event         A hash describing the progress event.
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        callProgressHandler()
     */
    function notify($event)
    {
        if (!is_array($event)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$event',
                      'was' => gettype($event),
                      'expected' => 'array',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $log = strtolower($event['log']);
        if ($log == 'incvalue') {

            if (!is_null($this->_callback)) {
                $this->callProgressHandler($event['value'], $this);
            }
            $this->_progress->display();
            // sleep a bit ...
            for ($i=0; $i<($this->_anim_speed*1000); $i++) { }
                 
            if ($this->_progress->getPercentComplete() == 1) {
                if ($this->_progress->isIndeterminate()) {
                    $this->_progress->setValue(0);
                } else {
                    // the progress bar has reached 100%
                    $this->_progress->removeListener($this);
                }
            } else {
                $this->_progress->incValue();
            }
        }
    }

    /**
     * Sets a user-defined progress handler function.
     *
     * @param      callback  $handler       Name of function or a class-method.
     *
     * @return     void
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @throws     HTML_PROGRESS_ERROR_INVALID_CALLBACK
     * @see        callProgressHandler()
     */
    function setProgressHandler($handler)
    {
        if (is_array($handler) && count($handler) == 2) {
            list($className, $methodName) = $handler;
            if (class_exists($className)) {
                $obj = new $className();
                if (!method_exists($obj, $methodName)) {
                    return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_CALLBACK, 'error',
                        array('var' => '$handler[1]',
                              'element' => 'Class-Method',
                              'was' => $methodName,
                              'paramnum' => 1), PEAR_ERROR_TRIGGER);
                }
            } else {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_CALLBACK, 'error',
                    array('var' => '$handler[0]',
                          'element' => 'Class',
                          'was' => $className,
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);
            }
        } elseif (is_string($handler)) {
            if (!function_exists($handler)) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_CALLBACK, 'error',
                    array('var' => '$handler',
                          'element' => 'Function',
                          'was' => $handler,
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);
            }
        } else {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$handler',
                      'was' => gettype($handler),
                      'expected' => 'array(class,method) | string(function)',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_callback = $handler;

        // reflect changes on the observer copy
        $this->_progress->addListener($this);
    }

    /**
     * Calls a user-defined progress handler function.
     *
     * @param      integer   $arg           Current value of the progress bar.
     * @param      object    $monitor       Reference to this monitor.
     *
     * @return     mixed
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        setProgressHandler(), notify()
     */
    function callProgressHandler($arg, &$monitor)
    {
        if (!is_int($arg)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$arg',
                      'was' => gettype($arg),
                      'expected' => 'integer',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif (!is_object($monitor)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$monitor',
                      'was' => gettype($monitor),
                      'expected' => 'HTML_Progress_Monitor object',
                      'paramnum' => 2), PEAR_ERROR_TRIGGER);
        }
        
        if (is_null($this->_callback)) {
            return true;                         // no callback yet defined
        } elseif (is_array($this->_callback)) {
            list($className, $methodName) = $this->_callback;
            $obj = new $className();
            return call_user_func(array(&$obj, $methodName), $arg, $monitor);
        } else {
            return call_user_func($this->_callback, $arg, $monitor);
        }
    }

    /**
     * Returns TRUE if progress was started by user, FALSE otherwise.
     *
     * @return     bool
     * @since      1.1
     * @access     public
     */
    function isStarted()
    {
        $action = $this->_form->getSubmitValues();
        return isset($action['start']);
    }

    /**
     * Returns TRUE if progress was canceled by user, FALSE otherwise.
     *
     * @return     bool
     * @since      1.0
     * @access     public
     */
    function isCanceled()
    {
        $action = $this->_form->getSubmitValues();
        return isset($action['cancel']);
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
        if ($this->isStarted()) {
            $this->_progress->incValue();
        }
    }

    /**
     * Attach a progress bar to this monitor.
     *
     * @param      object    $bar           a html_progress instance
     *
     * @return     void
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        getProgressElement()
     */
    function setProgressElement($bar)
    {
        if (!is_a($bar, 'HTML_Progress')) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$bar',
                      'was' => gettype($bar),
                      'expected' => 'HTML_Progress object',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_progress = $bar;
        $this->_progress->addListener($this);

        $bar =& $this->_form->getElement('progressBar');
        $bar->setText( $this->_progress->toHtml() );
    }

    /**
     * Returns a reference to the progress bar object 
     * used with the monitor.
     *
     * @return     object
     * @since      1.1
     * @access     public
     * @see        setProgressElement()
     */
    function &getProgressElement()
    {
        return $this->_progress;
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
        $js = "
function setStatus(pString)
{
        if (isDom)
            prog = document.getElementById('status');
        if (isIE)
            prog = document.all['status'];
        if (isNS4)
            prog = document.layers['status'];
	if (prog != null) 
	    prog.innerHTML = pString;
}";
        return $this->_progress->getScript() . $js;
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
     * Accepts a renderer
     *
     * @param      object    $renderer      An HTML_QuickForm_Renderer object
     *
     * @return     void
     * @since      1.1
     * @access     public
     */
    function accept(&$renderer)
    {
        if (!is_a($renderer, 'HTML_QuickForm_Renderer')) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$renderer',
                      'was' => gettype($renderer),
                      'expected' => 'HTML_QuickForm_Renderer object',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_form->accept($renderer);
    }

    /**
     * Display a caption on action in progress.
     *
     * The idea of a simple utility function for replacing variables 
     * with values in an message template, come from sprintfErrorMessage
     * function of Error_Raise package by Greg Beaver.
     *
     * This simple str_replace-based function can be used to have an
     * order-independent sprintf, so messages can be passed in
     * with different grammar ordering, or other possibilities without
     * changing the source code.
     *
     * Variables should simply be surrounded by % as in %varname%
     *
     * @param      string    $caption       (optional) message template
     * @param      array     $args          (optional) associative array of 
     *                                      template var -> message text
     * @since      1.1
     * @access     public
     */
    function setCaption($caption = '&nbsp;', $args = array() )
    {
        if (!is_string($caption)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$caption',
                      'was' => gettype($caption),
                      'expected' => 'string',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif (!is_array($args)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$args',
                      'was' => gettype($args),
                      'expected' => 'array',
                      'paramnum' => 2), PEAR_ERROR_TRIGGER);
        }

        foreach($args as $name => $value) {
            $caption = str_replace("%$name%", $value, $caption);
        }
        if (function_exists('ob_get_clean')) {
            $status  = ob_get_clean();      // use for PHP 4.3+
        } else {
            $status  = ob_get_contents();   // use for PHP 4.2+
            ob_end_clean();
        }
        $status = '<script type="text/javascript">self.setStatus(\''.$caption.'\'); </script>';
        echo $status;
        ob_start();
    }
}
?>