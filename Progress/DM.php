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
 * The HTML_Progress_DM class handles any mathematical issues
 * arising from assigning faulty values.
 *
 * @version    1.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @category   HTML
 * @package    HTML_Progress
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

class HTML_Progress_DM
{
    /**
     * The progress bar's minimum value.
     * The default is 0.
     *
     * @var        integer
     * @since      1.0
     * @access     private
     * @see        getMinimum(), setMinimum()
     */
    var $_minimum;

    /**
     * The progress bar's maximum value.
     * The default is 100.
     *
     * @var        integer
     * @since      1.0
     * @access     private
     * @see        getMaximum(), setMaximum()
     */
    var $_maximum;

    /**
     * The progress bar's increment value.
     * The default is +1.
     *
     * @var        integer
     * @since      1.0
     * @access     private
     * @see        getIncrement(), setIncrement()
     */
    var $_increment;

    /**
     * The progress bar's current value.
     *
     * @var        integer
     * @since      1.0
     * @access     private
     * @see        getValue(), setvalue(), incValue()
     */
    var $_value;

    /**
     * Package name used by Error_Raise functions
     *
     * @var        string
     * @since      1.0
     * @access     private
     */
    var $_package;


    /**
     * The data model class constructor
     *
     * Constructor Summary
     *
     * o Creates a progress mathematical model with a minimum value set to 0, 
     *   a maximum value set to 100, and a increment value set to +1.
     *   By default, the value is initialized to be equal to the minimum value.
     *   <code>
     *   $html = new HTML_Progress_DM();
     *   </code>
     *
     * o Creates a progress mathematical model with minimum and maximum set to
     *   specified values, and a increment value set to +1.
     *   By default, the value is initialized to be equal to the minimum value.
     *   <code>
     *   $html = new HTML_Progress_DM($min, $max);
     *   </code>
     *
     * o Creates a progress mathematical model with minimum, maximum and increment
     *   set to specified values.
     *   By default, the value is initialized to be equal to the minimum value.
     *   <code>
     *   $html = new HTML_Progress_DM($min, $max, $inc);
     *   </code>
     *
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function HTML_Progress_DM()
    {
        $this->_package = 'HTML_Progress_DM';
        Error_Raise::initialize($this->_package, array('HTML_Progress', '_getErrorMessage'));

        $this->_minimum = 0;
        $this->_maximum = 100;
        $this->_increment = +1;

        $args = func_get_args();
        
        switch (count($args)) {
         case 2:
            /*   int min, int max   */

            if (!is_int($args[0])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[0],
                          'expected' => 'integer',
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);

            } elseif ($args[0] < 0) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[0],
                          'expected' => 'positive',
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);

            } elseif ($args[0] > $args[1]) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[0],
                          'expected' => 'less than $max = '.$args[1],
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);
            }
            $this->_minimum = $args[0];


            if (!is_int($args[1])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$max',
                          'was' => $args[1],
                          'expected' => 'integer',
                          'paramnum' => 2), PEAR_ERROR_TRIGGER);

            } elseif ($args[1] < 0) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$max',
                          'was' => $args[1],
                          'expected' => 'positive',
                          'paramnum' => 2), PEAR_ERROR_TRIGGER);
            }
            $this->_maximum = $args[1];
            break;
         case 3:
            /*   int min, int max, int inc   */

            if (!is_int($args[0])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[0],
                          'expected' => 'integer',
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);

            } elseif ($args[0] < 0) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[0],
                          'expected' => 'positive',
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);

            } elseif ($args[0] > $args[1]) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$min',
                          'was' => $args[0],
                          'expected' => 'less than $max = '.$args[1],
                          'paramnum' => 1), PEAR_ERROR_TRIGGER);
            }
            $this->_minimum = $args[0];

            if (!is_int($args[1])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$max',
                          'was' => $args[1],
                          'expected' => 'integer',
                          'paramnum' => 2), PEAR_ERROR_TRIGGER);

            } elseif ($args[1] < 0) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$max',
                          'was' => $args[1],
                          'expected' => 'positive',
                          'paramnum' => 2), PEAR_ERROR_TRIGGER);
            }
            $this->_maximum = $args[1];

            if (!is_int($args[2])) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$inc',
                          'was' => $args[2],
                          'expected' => 'integer',
                          'paramnum' => 3), PEAR_ERROR_TRIGGER);

            } elseif ($args[2] < 1) {
                return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$inc',
                          'was' => $args[2],
                          'expected' => 'greater than zero',
                          'paramnum' => 3), PEAR_ERROR_TRIGGER);
            }
            $this->_increment = $args[2];
            break;
         default:
        }
        $this->_value = $this->_minimum;
    }

    /**
     * Returns the progress bar's minimum value. The default value is 0.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setMinimum()
     */
    function getMinimum()
    {
        return $this->_minimum;
    }

    /**
     * Sets the progress bar's minimum value.
     *
     * @param      integer   $min           progress bar's minimal value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        getMinimum()
     */
    function setMinimum($min)
    {
        if (!is_int($min)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$min',
                      'was' => gettype($min),
                      'expected' => 'integer',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($min < 0) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$min',
                      'was' => $min,
                      'expected' => 'positive',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($min > $this->getMaximum()) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$min',
                      'was' => $min,
                      'expected' => 'less than $max = '.$this->getMaximum(),
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_minimum = $min;

        /* set current value to minimum if less than minimum */
        if ($this->getValue() < $min) {
            $this->setValue($min);
        }
    }

    /**
     * Returns the progress bar's maximum value. The default value is 100.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setMaximum()
     */
    function getMaximum()
    {
        return $this->_maximum;
    }

    /**
     * Sets the progress bar's maximum value.
     *
     * @param      integer   $max           progress bar's maximal value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        getMaximum()
     */
    function setMaximum($max)
    {
        if (!is_int($max)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$max',
                      'was' => gettype($max),
                      'expected' => 'integer',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($max < 0) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$max',
                      'was' => $max,
                      'expected' => 'positive',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($max < $this->getMinimum()) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$max',
                      'was' => $max,
                      'expected' => 'greater than $min = '.$this->getMinimum(),
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_maximum = $max;

        /* set current value to maximum if greater to maximum */
        if ($this->getValue() > $max) {
            $this->setValue($max);
        }
    }

    /**
     * Returns the progress bar's increment value. The default value is +1.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setIncrement()
     */
    function getIncrement()
    {
        return $this->_increment;
    }

    /**
     * Sets the progress bar's increment value.
     *
     * @param      integer   $inc           progress bar's increment value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        getIncrement()
     */
    function setIncrement($inc)
    {
        if (!is_int($inc)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$inc',
                      'was' => gettype($inc),
                      'expected' => 'integer',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($inc == 0) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$inc',
                      'was' => $inc,
                      'expected' => 'not equal zero',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_increment = $inc;
    }

    /**
     * Returns the progress bar's current value. The value is always between 
     * the minimum and maximum values, inclusive.
     * By default, the value is initialized to be equal to the minimum value.
     *
     * @return     integer
     * @since      1.0
     * @access     public
     * @see        setValue()
     */
    function getValue()
    {
        return $this->_value;
    }

    /**
     * Sets the progress bar's current value.
     * If the new value is different from previous value, all change listeners
     * are notified.
     *
     * @param      integer   $val           progress bar's current value
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        getValue()
     */
    function setValue($val)
    {
        if (!is_int($val)) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$val',
                      'was' => gettype($val),
                      'expected' => 'integer',
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($val < $this->getMinimum()) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$val',
                      'was' => $val,
                      'expected' => 'greater than $min = '.$this->getMinimum(),
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);

        } elseif ($val > $this->getMaximum()) {
            return Error_Raise::raise($this->_package, HTML_PROGRESS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$val',
                      'was' => $val,
                      'expected' => 'less than $max = '.$this->getMaximum(),
                      'paramnum' => 1), PEAR_ERROR_TRIGGER);
        }
        $this->_value = $val;
    }

    /**
     * Updates the progress bar's current value by adding increment value.
     *
     * @return     void
     * @since      1.0
     * @access     public
     * @see        getValue(), setValue()
     */
    function incValue()
    {
        $newVal = $this->getValue() + $this->getIncrement();
        $newVal = min($this->getMaximum(), $newVal);
        $this->setValue( $newVal );
    }

    /**
     * Returns the percent complete for the progress bar. Note that this number is
     * between 0.00 and 1.00.
     *
     * @return     float
     * @since      1.0
     * @access     public
     * @see        getValue(), getMaximum()
     */
    function getPercentComplete()
    {
        $percent = sprintf("%01.2f",
                      ( ($this->getValue() - $this->getMinimum()) / $this->getMaximum() )
                   );

        if (function_exists('floatval')) {
            return floatval($percent);  // use for PHP 4.2+
        } else {
            return (float)$percent;     // use for PHP 4.1.x
        }
    }
}

?>