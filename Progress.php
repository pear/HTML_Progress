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
 * The HTML_Progress class allow you to add a loading bar
 * to any of your xhtml document.
 * You should have a browser that accept DHTML feature.
 *
 * @version    1.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @category   HTML
 * @package    HTML_Progress
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @tutorial   HTML_Progress.pkg
 * @todo       add new progress shapes such as square, rectangle, circle.
 */

require_once ('HTML/Progress/Error/Raise.php');
require_once ('HTML/Progress/DM.php');
require_once ('HTML/Progress/UI.php');

/**#@+
 * Progress Bar shape types
 *
 * @var        integer
 * @since      0.6
 */
define ('HTML_PROGRESS_BAR_HORIZONTAL', 1);
define ('HTML_PROGRESS_BAR_VERTICAL',   2);
/**#@-*/

/**
 * Basic error code that indicate a wrong input
 *
 * @var        integer
 * @since      1.0
 */
define ('HTML_PROGRESS_ERROR_INVALID_INPUT',   -100);


class HTML_Progress
{
    /**
     * Whether the progress bar is in determinate or indeterminate mode.
     * The default is false.
     * An indeterminate progress bar continuously displays animation indicating
     * that an operation of unknown length is occuring.
     *
     * @var        boolean
     * @since      1.0
     * @access     private
     * @see        setIndeterminate(), isIndeterminate()
     */
    var $_indeterminate;

    /**
     * Whether to display a border around the progress bar.
     * The default is false.
     *
     * @var        boolean
     * @since      1.0
     * @access     private
     * @see        setBorderPainted(), isBorderPainted()
     */
    var $_paintBorder;

    /**
     * Whether to textually display a string on the progress bar.
     * The default is false.
     * Setting this to true causes a textual display of the progress to be rendered 
     * on the progress bar. If the $_progressString is null, the percentage of completion
     * is displayed on the progress bar. Otherwise, the $_progressString is rendered
     * on the progress bar.
     *
     * @var        boolean
     * @since      1.0
     * @access     private
     * @see        setStringPainted(), isStringPainted()
     */
    var $_paintString;

    /**
     * An optional string that can be displayed on the progress bar.
     * The default is null.
     * Setting this to a non-null value does not imply that the string 
     * will be displayed.
     *
     * @var        string
     * @since      1.0
     * @access     private
     * @see        getString(), setString()
     */
    var $_progressString;

    /**
     * The data model (HTML_Progress_DM instance or extends) 
     * handles any mathematical issues arising from assigning faulty values.
     *
     * @var        object
     * @since      1.0
     * @access     private
     * @see        getDM(), setDM()
     */
    var $_DM;

    /**
     * The user interface (HTML_Progress_UI instance or extends)
     * handles look-and-feel of the progress bar.
     *
     * @var        object
     * @since      1.0
     * @access     private
     * @see        getUI(), setUI()
     */
    var $_UI;

    /**
     * The label that uniquely identifies this progress object.
     *
     * @var        string
     * @since      1.0
     * @access     private
     * @see        getIdent(), setIdent()
     */
    var $_ident;

    /**
     * Holds all HTML_Progress_Observer objects that wish to be notified of new messages.
     *
     * @var        array
     * @since      1.0
     * @access     private
     * @see        getListeners(), addListener(), removeListener()
     */
    var $_listeners;

    /**
     * Package name used by Error_Raise functions
     *
     * @var        string
     * @since      1.0
     * @access     private
     */
    var $_package;


    /**
     * Constructor Summary
     *
     * o Creates a natural horizontal progress bar that displays ten cells/units
     *   with no border and no progress string.
     *   The initial and minimum values are 0, and the maximum is 100.
     *   <code>
     *   $bar = new HTML_Progress();
     *   </code>
     *
     * o Creates a natural progress bar with the specified orientation, which can be
     *   either HTML_PROGRESS_BAR_HORIZONTAL or HTML_PROGRESS_BAR_VERTICAL
     *   By default, no border and no progress string are painted.
     *   The initial and minimum values are 0, and the maximum is 100.
     *   <code>
     *   $bar = new HTML_Progress($orient);
     *   </code>
     *
     * o Creates a natural horizontal progress bar with the specified minimum and
     *   maximum. Sets the initial value of the progress bar to the specified
     *   minimum, and the maximum that the progress bar can reach.
     *   By default, no border and no progress string are painted.
     *   <code>
     *   $bar = new HTML_Progress($min, $max);
     *   </code>
     *
     * o Creates a natural horizontal progress bar with the specified orientation, 
     *   minimum and maximum. Sets the initial value of the progress bar to the 
     *   specified minimum, and the maximum that the progress bar can reach.
     *   By default, no border and no progress string are painted.
     *   <code>
     *   $bar = new HTML_Progress($orient, $min, $max);
     *   </code>
     *
     * o Creates a natural horizontal progress that uses the specified model
     *   to hold the progress bar's data.
     *   By default, no border and no progress string are painted.
     *   <code>
     *   $bar = new HTML_Progress($model);
     *   </code>
     *
     *
     * @param      object    $model         Model that hold the progress bar's data
     * @param      int       $orient        Orientation of progress bar
     * @param      int       $min           Minimum value of progress bar
     * @param      int       $max           Maximum value of progress bar
     *
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        setIndeterminate(), 
     *             setBorderPainted(), setStringPainted(), setString(),
     *             setDM(), setUI(), setIdent()
     */
    function HTML_Progress()
    {
        $this->_package = 'HTML_Progress';
        Error_Raise::initialize($this->_package, array(get_class($this), '_getErrorMessage'));

        $this->_listeners = array();          // none listeners by default

        $this->_DM = new HTML_Progress_DM();  // new instance of a progress DataModel
        $this->_UI = new HTML_Progress_UI();  // new instance of a progress UserInterface

        $args = func_get_args();

        switch (count($args)) {
         case 1:
            if (is_object($args[0]) && (is_a($args[0], 'html_progress_dm'))) {
                /*   object html_progress_dm extends   */
                $this->_DM = &$args[0];
                
            } elseif (is_int($args[0])) {
                /*   int orient   */
                $this->_UI->setOrientation($args[0]);

            } else {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$model | $orient',
                          'was' => (gettype($args[0]) == 'object') ? 
                                    get_class($args[0]).' object' : gettype($args[0]),
                          'expected' => 'html_progress_dm object | integer',
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);
            }
            break;
         case 2:
            /*   int min, int max   */
            if (!is_int($args[0])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[0],
                          'expected' => 'integer',
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);

            } elseif (!is_int($args[1])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$max',
                          'was' => $args[1],
                          'expected' => 'integer',
                          'paramnum' => 2), PEAR_ERROR_TRIGGER);
            } else {
                $this->_DM->setMinimum($args[0]);
                $this->_DM->setMaximum($args[1]);
            } 
            break;
         case 3:
            /*   int orient, int min, int max   */
            if (!is_int($args[0])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$orient',
                          'was' => $args[0],
                          'expected' => 'integer',
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);

            } elseif (!is_int($args[1])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[1],
                          'expected' => 'integer',
                          'paramnum' => 2), PEAR_ERROR_TRIGGER);

            } elseif (!is_int($args[2])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$max',
                          'was' => $args[2],
                          'expected' => 'integer',
                          'paramnum' => 3), PEAR_ERROR_TRIGGER);
            } else {
                $this->_UI->setOrientation($args[0]);
                $this->_DM->setMinimum($args[1]);
                $this->_DM->setMaximum($args[2]);
            }
            break;
         default:
        }
        $this->setString(null);
        $this->setStringPainted(false);
        $this->setBorderPainted(false);
        $this->setIndeterminate(false);
        $this->setIdent();

        // to fix a potential php config problem with PHP 4.2.0 : turn 'implicit_flush' ON
        ob_implicit_flush(1);
    }

    /**
     * Returns the current API version
     *
     * @return     float
     * @since      0.1
     * @access     public
     */
    function apiVersion()
    {
        return 1.0;
    }

    /**
     * Returns mode of the progress bar (determinate or not).
     *
     * @return     boolean
     * @since      1.0
     * @access     public
     * @see        setIndeterminate()
     * @tutorial   indeterminate.pkg
     */
    function isIndeterminate()
    {
        return $this->_indeterminate;
    }

    /**
     * Sets the $_indeterminate property of the progress bar, which determines
     * whether the progress bar is in determinate or indeterminate mode.
     * An indeterminate progress bar continuously displays animation indicating
     * that an operation of unknown length is occuring.
     * By default, this property is false.
     *
     * @param      boolean   $continuous    whether countinuously displays animation
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        isIndeterminate()
     * @tutorial   indeterminate.pkg
     * @example    indeterminate.php        Horizontal ProgressBar in indeterminate mode
     */
    function setIndeterminate($continuous)
    {
        if (!is_bool($continuous)) {
            Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$continuous',
                      'was' => gettype($continuous),
                      'expected' => 'boolean',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_indeterminate = $continuous;
    }

    /**
     * Does the progress bar should paint its border. The default is false.
     *
     * @return     boolean
     * @since      1.0
     * @access     public
     * @see        setBorderPainted()
     */
    function isBorderPainted()
    {
        return $this->_paintBorder;
    }

    /**
     * Sets the value of $_paintBorder property, which determines whether the
     * progress bar should paint its border. The default is false. 
     *
     * @param      boolean   $paint         whether the progress bar should paint its border
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        isBorderPainted()
     * @tutorial   beginner.pkg#look-and-feel.border-style
     * @example    bluesand.php             A thin solid border to a horizontal progress bar
     */
    function setBorderPainted($paint)
    {
        if (!is_bool($paint)) {
            Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$paint',
                      'was' => gettype($paint),
                      'expected' => 'boolean',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }

        $this->_paintBorder = $paint;
    }

    /**
     * Does the progress bar should render a progress string. The default is false.
     * The progress bar displays the value returned by getPercentComplete() method
     * formatted as a percent such as 33%.
     *
     * @return     boolean
     * @since      1.0
     * @access     public
     * @see        setStringPainted(), setString()
     */
    function isStringPainted()
    {
        return $this->_paintString;
    }

    /**
     * Sets the value of $_paintString property, which determines whether the
     * progress bar should render a progress string. The default is false.
     *
     * @param      boolean   $paint         whether the progress bar should render a string
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        isStringPainted(), setString()
     * @tutorial   beginner.pkg#look-and-feel.string-style
     */
    function setStringPainted($paint)
    {
        if (!is_bool($paint)) {
            Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$paint',
                      'was' => gettype($paint),
                      'expected' => 'boolean',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_paintString = $paint;
    }

    /**
     * Returns the current value of the progress string.
     * By default, the progress bar displays the value returned by 
     * getPercentComplete() method formatted as a percent such as 33%.
     *
     * @return     string
     * @since      1.0
     * @access     public
     * @see        setString()
     */
    function getString()
    {
        if ($this->isStringPainted() && !is_null($this->_progressString)) {
            return $this->_progressString;
        } else {
            return sprintf("%s", $this->getPercentComplete()*100).' %';
	}
    }

    /**
     * Sets the current value of the progress string. By default, this string
     * is null. If you have provided a custom progress string and want to revert
     * to the built-in-behavior, set the string back to null.
     * The progress string is painted only if the isStringPainted() method
     * returns true.
     *
     * @param      string    $str           progress string
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        getString(), isStringPainted(), setStringPainted()
     * @tutorial   beginner.pkg#look-and-feel.string-style
     * @example    horizontal_string.php    A custom string with percent progress info
     */
    function setString($str)
    {
        $this->_progressString = $str;
    }

    /**
     * Returns the data model used by this progress bar.
     *
     * @return     object
     * @since      1.0
     * @access     public
     * @see        setDM()
     */
    function &getDM()
    {
        return $this->_DM;
    }

    /**
     * Sets the data model used by this progress bar.
     *
     * @param      string    $model         class name of a html_progress_dm extends object
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        getDM()
     */
    function setDM($model)
    {
        if (!class_exists($model)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$model',
                      'was' => 'class does not exists',
                      'expected' => $model.' class defined',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }

        $_dm = new $model();

        if (!is_a($_dm, 'html_progress_dm')) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$model',
                      'was' => $model,
                      'expected' => 'HTML_Progress_DM extends',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_DM =& $_dm;
    }

    /**
     * Returns the progress bar's minimum value stored in the progress bar's data model.
     * The default value is 0.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setMinimum(),
     *             HTML_Progress_DM::getMinimum()
     */
    function getMinimum()
    {
        return $this->_DM->getMinimum();
    }

    /**
     * Sets the progress bar's minimum value stored in the progress bar's data model.
     * If the minimum value is different from previous minimum, all change listeners
     * are notified.
     *
     * @param      integer   $min           progress bar's minimal value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        getMinimum(),
     *             HTML_Progress_DM::setMinimum()
     */
    function setMinimum($min)
    {
        $oldVal = $this->getMinimum();

        $this->_DM->setMinimum($min);

        if ($oldVal != $min) {
            $this->_announce(array('log' => 'setMinimum', 'value' => $min));
        }
    }

    /**
     * Returns the progress bar's maximum value stored in the progress bar's data model.
     * The default value is 100.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setMaximum(),
     *             HTML_Progress_DM::getMaximum()
     */
    function getMaximum()
    {
        return $this->_DM->getMaximum();
    }

    /**
     * Sets the progress bar's maximum value stored in the progress bar's data model.
     * If the maximum value is different from previous maximum, all change listeners
     * are notified.
     *
     * @param      integer   $max           progress bar's maximal value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        getMaximum(),
     *             HTML_Progress_DM::setMaximum()
     */
    function setMaximum($max)
    {
        $oldVal = $this->getMaximum();

        $this->_DM->setMaximum($max);

        if ($oldVal != $max) {
            $this->_announce(array('log' => 'setMaximum', 'value' => $max));
        }
    }

    /**
     * Returns the progress bar's increment value stored in the progress bar's data model.
     * The default value is +1.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setIncrement(),
     *             HTML_Progress_DM::getIncrement()
     */
    function getIncrement()
    {
        return $this->_DM->getIncrement();
    }

    /**
     * Sets the progress bar's increment value stored in the progress bar's data model.
     *
     * @param      integer   $inc           progress bar's increment value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        getIncrement(),
     *             HTML_Progress_DM::setIncrement()
     */
    function setIncrement($inc)
    {
        $this->_DM->setIncrement($inc);
    }

    /**
     * Returns the progress bar's current value, which is stored in the 
     * progress bar's data model. The value is always between the minimum
     * and maximum values, inclusive.
     * By default, the value is initialized to be equal to the minimum value.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setValue(), incValue(),
     *             HTML_Progress_DM::getValue()
     */
    function getValue()
    {
        return $this->_DM->getValue();
    }

    /**
     * Sets the progress bar's current value stored in the progress bar's data model.
     * If the new value is different from previous value, all change listeners
     * are notified.
     *
     * @param      integer   $val           progress bar's current value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        getValue(), incValue(),
     *             HTML_Progress_DM::setValue()
     */
    function setValue($val)
    {
        $oldVal = $this->getValue();

        $this->_DM->setValue($val);

        if ($oldVal != $val) {
            $this->_announce(array('log' => 'setValue', 'value' => $val));
        }
    }

    /**
     * Updates the progress bar's current value by adding increment value.
     * All change listeners are notified.
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        getValue(), setValue(),
     *             HTML_Progress_DM::incValue()
     */
    function incValue()
    {
        $this->_DM->incValue();
        $this->_announce(array('log' => 'incValue', 'value' => $this->_DM->getValue() ));
    }

    /**
     * Returns the percent complete for the progress bar. Note that this number is
     * between 0.00 and 1.00.
     *
     * @return     float
     * @since      1.0
     * @access     public
     * @see        getValue(), getMaximum(),
     *             HTML_Progress_DM::getPercentComplete()
     */
    function getPercentComplete()
    {
        return $this->_DM->getPercentComplete();
    }

    /**
     * Returns the look-and-feel object that renders the progress bar.
     *
     * @return     object
     * @since      1.0
     * @access     public
     * @see        setUI()
     */
    function &getUI()
    {
        return $this->_UI;
    }

    /**
     * Sets the look-and-feel object that renders the progress bar.
     *
     * @param      string    $ui            class name of a html_progress_ui extends object
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        getUI()
     */
    function setUI($ui)
    {
        if (!class_exists($ui)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$ui',
                      'was' => 'class does not exists',
                      'expected' => $ui.' class defined',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        
        $_ui = new $ui();

        if (!is_a($_ui, 'html_progress_ui')) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$ui',
                      'was' => $ui,
                      'expected' => 'HTML_Progress_UI extends',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_UI =& $_ui;
    }

    /**
     * Sets the look-and-feel model that renders the progress bar.
     *
     * @param      string    $file          file name of model properties
     * @param      string    $type          type of external ressource (phpArray, iniFile, XML ...)
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        setUI()
     */
    function setModel($file, $type)
    {
        include_once ('HTML/Progress/model.php');

        $this->_UI = new HTML_Progress_Model($file, $type);
    }

    /**
     * Get the cascading style sheet to put inline on HTML document
     *
     * @return     string
     * @since      1.0
     * @access     public
     * @see        HTML_Progress_UI::getStyle()
     */
    function getStyle()
    {
        $ui = $this->getUI();
        $lnEnd = $ui->_getLineEnd();
        
        $css =& $ui->getStyle();
        $style = $css->toString();
        $style = preg_replace("/".$lnEnd."\./", ".".$this->getIdent()." .", $style);

        return $style;
    }

    /**
     * Get the javascript code to manage progress bar.
     *
     * @return     string                   JavaScript URL or inline code to manage progress bar
     * @since      1.0
     * @access     public
     * @see        HTML_Progress_UI::getScript()
     */
    function getScript()
    {
        $ui = $this->getUI();
        $js =& $ui->getScript();
        return $js;
    }

    /**
     * Returns the progress bar structure in an array.
     *
     * @return     array of progress bar properties
     * @since      1.0
     * @access     public
     */
    function toArray()
    {
        $ui =& $this->getUI();
        $dm =& $this->getDM(); 

        $_structure = array();       
        $_structure['id'] = $this->getIdent();
        $_structure['indeterminate'] = $this->isIndeterminate();
        $_structure['borderpainted'] = $this->isBorderPainted();
        $_structure['stringpainted'] = $this->isStringPainted();
        $_structure['string'] = $this->_progressString;
        $_structure['ui']['classID'] = get_class($ui);
        $_structure['ui']['orientation'] = $ui->getOrientation();
        $_structure['ui']['fillway'] = $ui->getFillWay();
        $_structure['ui']['cell'] = $ui->getCellAttributes();
        $_structure['ui']['cell']['count'] = $ui->getCellCount();
        $_structure['ui']['border'] = $ui->getBorderAttributes();
        $_structure['ui']['string'] = $ui->getStringAttributes();
        $_structure['ui']['progress'] = $ui->getProgressAttributes();
        $_structure['ui']['script'] = $ui->getScript();
        $_structure['dm']['classID'] = get_class($dm);
        $_structure['dm']['minimum'] = $dm->getMinimum();
        $_structure['dm']['maximum'] = $dm->getMaximum();
        $_structure['dm']['increment'] = $dm->getIncrement();
        $_structure['dm']['value'] = $dm->getValue();
        $_structure['dm']['percent'] = $dm->getPercentComplete();

        return $_structure;
    }

    /**
     * Returns the progress structure as HTML.
     *
     * @return     string                   HTML Progress bar
     * @since      0.2
     * @access     public
     */
    function toHtml()
    {
        $strHtml = '';
        $ui =& $this->_UI;
        $tabs = $ui->_getTabs();
        $tab = $ui->_getTab();
        $lnEnd = $ui->_getLineEnd();
        $comment = $ui->getComment();
        $orient = $ui->getOrientation();
        $progressAttr = $ui->getProgressAttributes();
        $borderAttr = $ui->getBorderAttributes();
        $stringAttr = $ui->getStringAttributes();
        $valign = strtolower($stringAttr['valign']);
        
        /**
         *  Adds a progress bar legend in html code is possible.
         *  See HTML_Common::setComment() method.
         */
        if (strlen($comment) > 0) {
            $strHtml .= $tabs . "<!-- $comment -->" . $lnEnd;
        }

        $strHtml .= $tabs . "<div class=\"".$this->getIdent()."\">" . $lnEnd;
        $strHtml .= $tabs . "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" . $lnEnd;
        $progressId = $this->getIdent().'_';

        /**
         *  Creates all cells of progress bar in order
         *  depending of the FillWay and Orientation. 
         */
        if ($orient == HTML_PROGRESS_BAR_HORIZONTAL) {
            $progressHtml = $this->_getProgressHbar_toHtml();
        }

        if ($orient == HTML_PROGRESS_BAR_VERTICAL) {
            $progressHtml = $this->_getProgressVbar_toHtml();
        }

        /**
         *  Progress Bar (2) alignment rules:
         *  - percent / messsage area (1)
         *
         *  +---------------------------------------+
         *  |         +t1---+                       |
         *  |         | (1) |                       |
         *  |         +-----+                       |
         *  | +t2---+ +-------------------+ +t3---+ |
         *  | | (1) | | | | | (2) | | | | | | (1) | |
         *  | +-----+ +-------------------+ +-----+ |
         *  |         +t4---+                       |
         *  |         | (1) |                       |
         *  |         +-----+                       |
         *  +---------------------------------------+
         */
        if (($valign == 'left') || ($valign == 'right')) {
            $tRows = 1;
            $tCols = 2;
            $ps = ($valign == 'left') ? 0 : 1;
        } else {
            $tRows = 2;
            $tCols = 1;
            $ps = ($valign == 'top')  ? 0 : 1;
        }

        for ($r = 0 ; $r < $tRows ; $r++) {
            $strHtml .= $tabs . "<tr>" . $lnEnd;
            for ($c = 0 ; $c < $tCols ; $c++) {
                if (($c == $ps) || ($r == $ps)) {
                    $id = $stringAttr['id'];
                    $strHtml .= $tabs . $tab . "<td class=\"$id\" id=\"$progressId$id\">" . $lnEnd;
                    $strHtml .= $tabs . $tab . $tab . $this->getString() . $lnEnd;
                    $ps = -1;
                } else {
                    $class = $progressAttr['class'];
                    $strHtml .= $tabs . $tab ."<td class=\"$class\">" . $lnEnd;
                    $strHtml .= $tabs . $tab . $tab . "<div class=\"".$borderAttr['class']."\">" . $lnEnd;
                    $strHtml .= $progressHtml;
                    $strHtml .= $tabs . $tab . $tab . "</div>" . $lnEnd;
                }
                $strHtml .= $tabs . $tab ."</td>" . $lnEnd;
            }
            $strHtml .= $tabs . "</tr>" . $lnEnd;
        }

        $strHtml .= $tabs . "</table>" . $lnEnd;
        $strHtml .= $tabs . "</div>" . $lnEnd;

        return $strHtml;
    }

    /**
     * Renders the new value of progress bar.
     *
     * @return     void
     * @since      0.2
     * @access     public
     */
    function display()
    {
        static $lnEnd;
        static $cellAmount;
        static $determinate;

        if(!isset($lnEnd)) {
            $ui =& $this->_UI;
            $lnEnd = $ui->_getLineEnd();
            $cellAmount = ($this->getMaximum() - $this->getMinimum()) / $ui->getCellCount();
        }

        if (function_exists('ob_get_clean')) {
            $bar  = ob_get_clean();      // use for PHP 4.3+
        } else {
            $bar  = ob_get_contents();   // use for PHP 4.2+
            ob_end_clean();
        }
        $bar .= $lnEnd;

        $progressId = $this->getIdent().'_';

        if ($this->isIndeterminate()) {
            if (isset($determinate)) {
                $determinate++;
                $progress = $determinate;
            } else {
                $progress = $determinate = 1;
            }
        } else {
            $progress = ($this->getValue() - $this->getMinimum()) / $cellAmount;
            $determinate = 0;
	}
        $bar .= '<script type="text/javascript">self.setprogress("'.$progressId.'",'.((int) $progress).',"'.$this->getString().'",'.$determinate.'); </script>';

        sleep(1);
        echo $bar;
        ob_start();
    }

    /**
     * Returns the current identification string.
     *
     * @return     string                   current Progress instance's identification string
     * @since      1.0
     * @access     public
     * @see        setIdent()
     */
    function getIdent()
    {
        return $this->_ident;
    }

    /**
     * Sets this Progress instance's identification string.
     *
     * @param      mixed     $ident         (optional) the new identification string.
     *
     * @since      1.0
     * @access     public
     * @see        getIdent()
     */
    function setIdent($ident = null)
    {
        if (is_null($ident)) {
            $this->_ident = 'p_' . substr(md5(microtime()), 0, 6);
        } else {
            $this->_ident = $ident;
	}
    }

    /**
     * Returns an array of all the listeners added to this progress bar.
     *
     * @return     array
     * @since      1.0
     * @access     public
     * @see        addListener(), removeListener()
     */
    function getListeners()
    {
        return $this->_listeners;
    }

    /**
     * Adds a HTML_Progress_Observer instance to the list of observers 
     * that are listening for messages emitted by this HTML_Progress instance.
     *
     * @param      object    $observer      The HTML_Progress_Observer instance 
     *                                      to attach as a listener.
     *
     * @return     boolean                  True if the observer is successfully attached.
     * @since      1.0
     * @access     public
     * @see        getListeners(), removeListener()
     */
    function addListener($observer)
    {
        if (!is_a($observer, 'HTML_Progress_Observer') &&
            !is_a($observer, 'HTML_Progress_Monitor')) {
            return false;
        }
        $this->_listeners[$observer->_id] = &$observer;
        return true;
    }

    /**
     * Removes a HTML_Progress_Observer instance from the list of observers.
     *
     * @param      object    $observer      The HTML_Progress_Observer instance 
     *                                      to detach from the list of listeners.
     *
     * @return     boolean                  True if the observer is successfully detached.
     * @since      1.0
     * @access     public
     * @see        getListeners(), addListener()
     */
    function removeListener($observer)
    {
        if ((!is_a($observer, 'HTML_Progress_Observer') && 
             !is_a($observer, 'HTML_Progress_Monitor')
             ) || 
            (!isset($this->_listeners[$observer->_id]))  ) {

            return false;
        }
        unset($this->_listeners[$observer->_id]);
        return true;
    }

    /**
     * Notifies all listeners that have registered interest in $event message.
     *
     * @param      mixed     $event         A hash describing the progress event.
     *
     * @since      1.0
     * @access     private
     * @see        setMinimum(), setMaximum(), setValue(), incValue()
     */
    function _announce($event)
    {
        foreach ($this->_listeners as $id => $listener) {
            $this->_listeners[$id]->notify($event);
        }
    }

    /**
     * Returns a horizontal progress bar structure as HTML.
     *
     * @return     string                   Horizontal HTML Progress bar
     * @since      1.0
     * @access     private
     */
    function _getProgressHbar_toHtml()
    {
        $ui =& $this->_UI;
        $tabs = $ui->_getTabs();
        $tab = $ui->_getTab();
        $lnEnd = $ui->_getLineEnd();
        $way_natural = ($ui->getFillWay() == 'natural');
        $cellAttr = $ui->getCellAttributes();
        $cellCount = $ui->getCellCount();

        $progressId = $this->getIdent().'_';
        $progressHtml = "";

        if ($way_natural) {
            // inactive cells first
            $pos = $cellAttr['spacing'];
            for ($i=0; $i<$cellCount; $i++) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."I\""; 
                $progressHtml .= " class=\"".$cellAttr['class']."I\"";
                $progressHtml .= " style=\"position:absolute;top:".$cellAttr['spacing']."px;left:".$pos."px;\"";
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['width'] + $cellAttr['spacing']);
            }
            // then active cells
            $pos = $cellAttr['spacing'];
            for ($i=0; $i<$cellCount; $i++) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."A\""; 
                $progressHtml .= " class=\"".$cellAttr['class']."A\"";
                $progressHtml .= " style=\"position:absolute;top:".$cellAttr['spacing']."px;left:".$pos."px;";
                if (isset($cellAttr[$i])) {
                    $progressHtml .= "color:".$cellAttr[$i]['color'].";\"";
                } else {
                    $progressHtml .= "\"";
                }
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['width'] + $cellAttr['spacing']);
            }
        } else {
            // inactive cells first
            $pos = $cellAttr['spacing'];
            for ($i=$cellCount-1; $i>=0; $i--) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."I\"";
                $progressHtml .= " class=\"".$cellAttr['class']."I\"";
                $progressHtml .= " style=\"position:absolute;top:".$cellAttr['spacing']."px;left:".$pos."px;\"";
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['width'] + $cellAttr['spacing']);
            }
            // then active cells
            $pos = $cellAttr['spacing'];
            for ($i=$cellCount-1; $i>=0; $i--) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."A\"";
                $progressHtml .= " class=\"".$cellAttr['class']."A\"";
                $progressHtml .= " style=\"position:absolute;top:".$cellAttr['spacing']."px;left:".$pos."px;";
                if (isset($cellAttr[$i])) {
                    $progressHtml .= "color:".$cellAttr[$i]['color'].";\"";
                } else {
                    $progressHtml .= "\"";
                }
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['width'] + $cellAttr['spacing']);
            }
        }
        return $progressHtml;
    }

    /**
     * Returns a vertical progress bar structure as HTML.
     *
     * @return     string                   Vertical HTML Progress bar
     * @since      1.0
     * @access     private
     */
    function _getProgressVbar_toHtml()
    {
        $ui =& $this->_UI;
        $tabs = $ui->_getTabs();
        $tab = $ui->_getTab();
        $lnEnd = $ui->_getLineEnd();
        $way_natural = ($ui->getFillWay() == 'natural');
        $cellAttr = $ui->getCellAttributes();
        $cellCount = $ui->getCellCount();

        $progressId = $this->getIdent().'_';
        $progressHtml = "";

        if ($way_natural) {
            // inactive cells first
            $pos = $cellAttr['spacing'];
            for ($i=$cellCount-1; $i>=0; $i--) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."I\"";
                $progressHtml .= " class=\"".$cellAttr['class']."I\"";
                $progressHtml .= " style=\"position:absolute;left:".$cellAttr['spacing']."px;top:".$pos."px;\"";
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['height'] + $cellAttr['spacing']);
            }
            // then active cells
            $pos = $cellAttr['spacing'];
            for ($i=$cellCount-1; $i>=0; $i--) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."A\"";
                $progressHtml .= " class=\"".$cellAttr['class']."A\"";
                $progressHtml .= " style=\"position:absolute;left:".$cellAttr['spacing']."px;top:".$pos."px;";
                if (isset($cellAttr[$i])) {
                    $progressHtml .= "color:".$cellAttr[$i]['color'].";\"";
                } else {
                    $progressHtml .= "\"";
                }
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['height'] + $cellAttr['spacing']);
            }
        } else {
            // inactive cells first
            $pos = $cellAttr['spacing'];
            for ($i=0; $i<$cellCount; $i++) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."I\"";
                $progressHtml .= " class=\"".$cellAttr['class']."I\"";
                $progressHtml .= " style=\"position:absolute;left:".$cellAttr['spacing']."px;top:".$pos."px;\"";
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['height'] + $cellAttr['spacing']);
            }
            // then active cells
            $pos = $cellAttr['spacing'];
            for ($i=0; $i<$cellCount; $i++) {
                $progressHtml .= $tabs . $tab . $tab;
                $progressHtml .= "<div id=\"". $progressId . sprintf($cellAttr['id'],$i) ."A\"";
                $progressHtml .= " class=\"".$cellAttr['class']."A\"";
                $progressHtml .= " style=\"position:absolute;left:".$cellAttr['spacing']."px;top:".$pos."px;";
                if (isset($cellAttr[$i])) {
                    $progressHtml .= "color:".$cellAttr[$i]['color'].";\"";
                } else {
                    $progressHtml .= "\"";
                }
                $progressHtml .= ">&nbsp;</div>" . $lnEnd;
                $pos += ($cellAttr['height'] + $cellAttr['spacing']);
            }
        }
        return $progressHtml;
    }

    /**
     * Error message generator for package HTML_Progress
     *
     * @param      integer   $code
     * @param      array     $args
     * @param      integer   $state
     *
     * @return     string
     * @since      1.0
     * @access     private
     */
    function _getErrorMessage($code, $args, $state)
    {
        $messages = array(
            HTML_PROGRESS_ERROR_INVALID_INPUT =>
                'invalid input, parameter #%paramnum% '
                    . '"%var%" was expecting '
                    . '"%expected%", instead got "%was%"',
        );
        if (isset($messages[$code])) {
            $message = $messages[$code];
        } else {
            $message = 'Code ' . $code . ' is not a valid error code';
        }
        return Error_Raise::sprintfErrorMessageWithState($message, $args, $state);
    }
}

?>