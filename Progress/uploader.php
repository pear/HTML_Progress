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

/**
 * The HTML_Progress_Uploader class provides a GUI interface
 * (with progress bar) to manage files to upload to a 
 * ftp server via your web browser.
 *
 * @version    1.2.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @package    HTML_Progress
 * @subpackage Progress_Observer
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

require_once 'HTML/Progress.php';
require_once 'Net/FTP.php';
require_once 'Net/FTP/Observer.php';
require_once 'HTML/QuickForm.php';

class HTML_Progress_Uploader
{
    /**#@+
     * Attributes of upload form.
     *
     * @var        string
     * @since      1.1
     * @access     public
     */
    var $windowname;
    var $captionMask;
    var $buttonStart;
    var $buttonCancel;
    /**#@-*/
    
    /**
     * The progress object renders into this uploader.
     *
     * @var        object
     * @since      1.1
     * @access     private
     */
    var $_progress;

    /**
     * The quickform object that allows the presentation.
     *
     * @var        object
     * @since      1.1
     * @access     private
     */
    var $_form;

    /**
     * It's a common security risk in pages who has the upload dir
     * facility. You should restrict file kind to upload.
     *
     * @var        array
     * @since      1.1
     * @access     private
     * @see        setValidExtensions()
     */
    var $_extensions_check = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'tar', 'zip', 'gz');

    /**
     * A list of files ready to upload on a ftp server.
     *
     * @var        array
     * @since      1.1
     * @access     private
     * @see        setFiles()
     */
    var $_files = array();

    /**
     * Net_FTP instance used for communications with ftp server
     *
     * @var        object
     * @since      1.2.0
     * @access     private
     */
    var $_ftp;
    
    /**
     * Package name used by PEAR_ErrorStack functions
     *
     * @var        string
     * @since      1.0
     * @access     private
     */
    var $_package;


    /**
     * The progress uploader class constructor
     *
     * @param      string    $formName      (optional) Name of monitor dialog box (QuickForm)
     * @param      array     $attributes    (optional) List of renderer options
     *
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function HTML_Progress_Uploader($formName = 'ProgressUploader', $attributes = array())
    {
        $args = func_get_args();
        $num_args = func_num_args();

        if ($num_args > 2) {
            $errorPrefs = func_get_arg($num_args - 1);
            if (!is_array($errorPrefs)) {
                $errorPrefs = array();
            }
            HTML_Progress::_initErrorStack($errorPrefs);
        } else {        	
            HTML_Progress::_initErrorStack();
        }

        if (!is_string($formName)) {
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$formName',
                      'was' => gettype($formName),
                      'expected' => 'string',
                      'paramnum' => 1), $trace);

        } elseif (!is_array($attributes)) {
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$attributes',
                      'was' => gettype($attributes),
                      'expected' => 'array',
                      'paramnum' => 2), $trace);
        }
        
        $this->_form = new HTML_QuickForm($formName);

        $this->windowname   = isset($attributes['title'])  ? $attributes['title']  : 'Upload ...';
        $this->captionMask  = isset($attributes['mask'])   ? $attributes['mask']   : '%s';
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
        $this->_progress = new HTML_Progress();
        $this->setProgressElement($this->_progress);

        $str =& $this->_form->getElement('progressStatus');
        $str->setText('<div id="status" class="progressStatus">&nbsp;</div>');
    }

    /**
     * Attach a progress bar to this uploader.
     *
     * @param      object    $bar           a html_progress instance
     *
     * @return     void
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function setProgressElement(&$bar)
    {
        if (!is_a($bar, 'HTML_Progress')) {
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$bar',
                      'was' => gettype($bar),
                      'expected' => 'HTML_Progress object',
                      'paramnum' => 1), $trace);
        }
        $this->_progress =& $bar;

        $this->_progress->setStringPainted(true);     // get space for the string
        $this->_progress->setString("");              // but don't paint it
        $this->_progress->setIndeterminate(true);

        $bar =& $this->_form->getElement('progressBar');
        $bar->setText( $this->_progress->toHtml() );
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
     * @since      1.1
     * @access     public
     */
    function isCanceled()
    {
        $action = $this->_form->getSubmitValues();
        return isset($action['cancel']);
    }

    /**
     * Returns progress styles (StyleSheet).
     *
     * @return     string
     * @since      1.1
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
     * @since      1.1
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
     * Returns Uploader forms as a Html string.
     *
     * @return     string
     * @since      1.1
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
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$renderer',
                      'was' => gettype($renderer),
                      'expected' => 'HTML_QuickForm_Renderer object',
                      'paramnum' => 1), $trace);
        }
        $this->_form->accept($renderer);
    }

    /**
     * Uploads the files asynchronously, so the class can perform other operations 
     * while files are being uploaded, such :
     * display a progress bar in indeterminate mode. 
     *
     * @param      string    $dest          Changes from current to the specified directory.
     * @param      boolean   $overwrite     (optional) overwrite existing files.
     *
     * @return     mixed                    a null array if all files transfered
     * @since      1.1
     * @access     public
     * @see        FTP_Upload::setFiles()
     */
    function moveTo($dest, $overwrite = false)
    {
        if (!is_string($dest)) {
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$dest',
                      'was' => gettype($dest),
                      'expected' => 'string',
                      'paramnum' => 1), $trace);

        } elseif (!is_bool($overwrite)) {
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$overwrite',
                      'was' => gettype($overwrite),
                      'expected' => 'boolean',
                      'paramnum' => 2), $trace);
        }

        if (!isset($this->_ftp)) {
            return PEAR::raiseError('You should logs in first'); 
        }
        $dir = $this->_ftp->cd($dest);
        if (PEAR::isError($dir)) {
            return $dir;
        }
        $remoteFiles = $this->_ftp->ls(null, NET_FTP_FILES_ONLY);
        if (PEAR::isError($remoteFiles)) {
            return $remoteFiles;
        }

        $observer = new Observer_progressUpload($this->_progress);
        $this->_ftp->attach($observer);
        
        $nomove = array();   // files not transfered on remote host
        
        foreach ($this->_files as $file) {
            if (!$overwrite) {
                foreach ($remoteFiles as $remoteFile) {
                    if (basename($file) == $remoteFile['name']) {
                        // file already exists, skip to next one
                        continue 2;
                    }
                }
            }

            // writes file caption
            $status  = ob_get_clean();
            $status  = '<script type="text/javascript">self.setStatus(\'';
            $status .= sprintf($this->captionMask, basename($file));
            $status .= '\'); </script>';
            echo $status;
            ob_start();

            $ret = $this->_ftp->put($file, basename($file), $overwrite);
            if (PEAR::isError($ret)) {
                $nomove[] = $file;
            }
        }
        $this->_ftp->detach($observer);

        return $nomove;
    }

    /**
     * Restricts the valid extensions on file uploads.
     *
     * @param      mixed     $exts          File extensions to validate
     *
     * @return     void
     * @since      1.1
     * @access     public
     */
    function setValidExtensions($exts)
    {
        if (is_array($exts)) {
            $this->_extensions_check = $exts;
        } else {
            $this->_extensions_check = array();
            array_push($this->_extensions_check, $exts);
        }
    }

    /**
     * Set a list of files to upload on the ftp server.
     *
     * @param      mixed     $files         List of files to transfer to FTP server.
     * @param      boolean   $check         (optional) Restrict files to valid extensions only.
     *
     * @return     void
     * @since      1.1
     * @access     public
     */
    function setFiles($files, $check = true)
    {
        $this->_files = $inputs = array();
        if (is_array($files)) {
            $inputs = $files;
        } else {
            array_push($inputs, $files);
        }

        foreach ($inputs as $file) {
            if ($check) {
                $info = pathinfo($file);
                if (in_array($info['extension'], $this->_extensions_check) && file_exists($file)) {
                    $this->_files[] = $file;
                }
            } else {
                $this->_files[] = $file;
	    }
        }
    }

    /**
     * Connect on a remote FTP server and login as $user.
     *
     * @param      string    $host          FTP server to connect to.
     * @param      string    $user          Username.
     * @param      string    $pass          Password.
     * @param      integer   $port          (optional) an alternate port to connect to.
     * @param      integer   $timeout       (optional) the timeout for all subsequent network operations.
     *
     * @return     mixed                    TRUE on success, and PEAR_Error on failure
     * @since      1.1
     * @access     public
     */
    function logon($user, $pass, $host, $port = 21, $timeout = 90)
    {
        $this->_ftp = new Net_FTP($host, $port);

        $ret = $this->_ftp->connect();
        if (PEAR::isError($ret)) {
            return $ret;
        }

        $ret = $this->_ftp->login($user, $pass);
        if (PEAR::isError($ret)) {
            $this->logoff();            
            return $ret;
        }
    }

    /**
     * Disconnect from a remote FTP server.
     * (Timeout is default set to 90 sec.)
     *
     * @return     void
     * @since      1.1
     * @access     public
     */
    function logoff()
    {
        $this->_ftp->disconnect();
        unset($this->_ftp);
    }
}

/**
 * The class is a listener for HTML_Progress pending 
 * file uploads operation.
 *
 * @version    1.2.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     private
 * @package    HTML_Progress
 * @subpackage Progress_Observer
 */

class Observer_progressUpload extends Net_FTP_Observer
{
    var $_progress;

    function Observer_progressUpload(&$progress)
    {
        /* Call the base class constructor. */
        parent::Net_FTP_Observer();

        /* Configure the observer. */
        $this->_progress =& $progress;
    }

    function notify($event)
    {
        $this->_progress->display();
        // sleep a bit ...
        for ($i=0; $i<($this->_progress->getAnimSpeed()*1000); $i++) { }
                 
        if ($this->_progress->getPercentComplete() == 1) {
            $this->_progress->setValue(0);
        } else {
            $this->_progress->incValue();
        }
    }
}
?>