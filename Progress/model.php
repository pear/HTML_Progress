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
 * The HTML_Progress_Model class provides an easy way to set look and feel 
 * of a progress bar with external config file.
 *
 * @version    1.2.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @package    HTML_Progress
 * @subpackage Progress_UI
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

require_once ('Config.php');

class HTML_Progress_Model extends HTML_Progress_UI
{
    /**
     * Package name used by PEAR_ErrorStack functions
     *
     * @var        string
     * @since      1.0
     * @access     private
     */
    var $_package;


    /**
     * The progress bar's UI extended model class constructor
     *
     * @param      string    $file          file name of model properties
     * @param      string    $type          type of external ressource (phpArray, iniFile, XML ...)
     *
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function HTML_Progress_Model($file, $type)
    {
        $this->_package = 'HTML_Progress_Model';
        $stack =& Error_Stack::singleton($this->_package);
        $messages = HTML_Progress::_getErrorMessage();
        $stack->setErrorMessageTemplate($messages);
        $stack->setDefaultLogger($this);

        if (!file_exists($file)) {
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$file',
                      'was' => $file,
                      'expected' => 'file exists',
                      'paramnum' => 1), $trace);
        }

        $conf = new Config();

        if (!$conf->isConfigTypeRegistered($type)) {
            $trace = debug_backtrace();
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$type',
                      'was' => $type,
                      'expected' => implode (" | ", array_keys($GLOBALS['CONFIG_TYPES'])),
                      'paramnum' => 2), $trace);
        }

        $data = $conf->parseConfig($file, $type);

        $structure = $data->toArray(false);
        $this->_progress =& $structure['root'];
        
        if (is_array($this->_progress['cell']['font-family'])) {
            $this->_progress['cell']['font-family'] = implode(",", $this->_progress['cell']['font-family']);
        }
        if (is_array($this->_progress['string']['font-family'])) {
            $this->_progress['string']['font-family'] = implode(",", $this->_progress['string']['font-family']);
        }
        $this->_orientation = $this->_progress['orientation']['shape'];
        $this->_fillWay = $this->_progress['orientation']['fillway'];
        
        if (isset($this->_progress['script']['file'])) {
            $this->_script = $this->_progress['script']['file'];
        } else {
            $this->_script = null;
        }

        if (isset($this->_progress['cell']['count'])) {
            $this->_cellCount = $this->_progress['cell']['count'];
        } else {
            $this->_cellCount = 10;
        }

        $this->_updateProgressSize();
    }
}

?>