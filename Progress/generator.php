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
 * The HTML_Progress_Generator class provides an easy way to 
 * dynamic build Progress bar, show a preview, 
 * and save php/css code for a later reuse.
 *
 * @version    1.2.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @package    HTML_Progress
 * @subpackage Progress_UI
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

require_once 'HTML/QuickForm/Controller.php';
require_once 'HTML/QuickForm/Action/Submit.php';
require_once 'HTML/QuickForm/Action/Jump.php';
require_once 'HTML/QuickForm/Action/Display.php';
require_once 'HTML/QuickForm/Action/Direct.php';
require_once 'HTML/Progress.php';
require_once 'HTML/Progress/generator/pages.php';
require_once 'HTML/CSS.php';

class HTML_Progress_Generator extends HTML_QuickForm_Controller 
{
    /**#@+
     * Attributes of wizard form.
     *
     * @var        mixed
     * @since      1.1
     * @access     private
     */
    var $_buttonBack   = '<< Back';
    var $_buttonNext   = 'Next >>';
    var $_buttonCancel = 'Cancel';
    var $_buttonReset  = 'Reset';
    var $_buttonApply  = 'Preview';
    var $_buttonSave   = 'Save';
    var $_buttonAttr   = array('style'=>'width:80px;');
    /**#@-*/

    /**
     * Tabs element of wizard form.
     *
     * @var        array
     * @since      1.1
     * @access     private
     */
    var $_tabs;

    /**
     * Package name used by PEAR_ErrorStack functions
     *
     * @var        string
     * @since      1.0
     * @access     private
     */
    var $_package;


    /**
     * Constructor Summary
     *
     * o Creates a standard progress bar generator wizard.
     *   <code>
     *   $generator = new HTML_Progress_Generator();
     *   </code>
     *
     * o Creates a progress bar generator wizard with 
     *   customized actions: progress bar preview, form rendering, buttons manager
     *   <code>
     *   $attributes = array(
     *        'preview' => name of a HTML_QuickForm_Action instance 
     *                     (default 'ActionPreview', see 'HTML/Progress/generator/preview.php')
     *        'display' => name of a HTML_QuickForm_Action_Display instance
     *                     (default 'ActionDisplay', see 'HTML/Progress/generator/default.php')
     *        'process' => name of a HTML_QuickForm_Action instance 
     *                     (default 'ActionProcess', see 'HTML/Progress/generator/process.php')
     *   );
     *   $generator = new HTML_Progress_Generator($attributes);
     *   </code>
     *
     * @param      string    $controllerName(optional) Name of generator wizard (QuickForm)
     * @param      array     $attributes    (optional) List of renderer options
     *
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function HTML_Progress_Generator($controllerName = 'ProgressGenerator', $attributes = array())
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

        if (!is_string($controllerName)) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$controllerName',
                      'was' => gettype($controllerName),
                      'expected' => 'string',
                      'paramnum' => 1));

        } elseif (!is_array($attributes)) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$attributes',
                      'was' => gettype($attributes),
                      'expected' => 'array',
                      'paramnum' => 2));
        }
        parent::HTML_QuickForm_Controller($controllerName,false);

        // Check if Action(s) are customized
        $ActionPreview = isset($attributes['preview'])? $attributes['preview']: 'ActionPreview';
        $ActionDisplay = isset($attributes['display'])? $attributes['display']: 'ActionDisplay';
        $ActionProcess = isset($attributes['process'])? $attributes['process']: 'ActionProcess';

        $this->_tabs = array(
            0 => array('page1', 'Property1', 'Progress'),
            1 => array('page2', 'Property2', 'Cell'),
            2 => array('page3', 'Property3', 'Border'),
            3 => array('page4', 'Property4', 'String'),
            4 => array('page5', 'Preview',   'Preview'),
            5 => array('page6', 'Save',      'Save')
        );

        foreach ($this->_tabs as $tab) {
            list($pageName, $className, $tabName) = $tab;
            // Add each tab of the wizard
            $this->addPage(new $className($pageName));

            // These actions manage going directly to the pages with the same name
            $this->addAction($pageName, new HTML_QuickForm_Action_Direct());
        }
        $preview =& $this->getPage('page5');

        // The customized actions
        if (!class_exists($ActionPreview)) {
            include_once 'HTML/Progress/generator/preview.php';
            $ActionPreview = 'ActionPreview';
        }
        if (!class_exists($ActionDisplay)) {
            include_once 'HTML/Progress/generator/default.php';
            $ActionDisplay = 'ActionDisplay';
        }
        if (!class_exists($ActionProcess)) {
            include_once 'HTML/Progress/generator/process.php';
            $ActionProcess = 'ActionProcess';
        }
        $preview->addAction('apply', new $ActionPreview());
        $this->addAction('display', new $ActionDisplay());
        $this->addAction('process', new $ActionProcess());
        $this->addAction('cancel',  new $ActionProcess());

        // set ProgressBar default values on first run
        $sess = $this->container();
        $defaults = $sess['defaults'];

        if (count($sess['defaults']) == 0) {
            $this->setDefaults(array(
                'progressclass' => 'progressBar',
                'shape'         => HTML_PROGRESS_BAR_HORIZONTAL,
                'way'           => 'natural',
                'autosize'      => true,
                'progresssize'  => array('bgcolor' => '#FFFFFF'),
                'rAnimSpeed'    => 100,
    
                'borderpainted' => false,
                'borderclass'   => 'progressBarBorder',
                'borderstyle'   => array('style' => 'solid', 'width' => 0, 'color' => '#000000'),

                'cellid'        => 'progressCell%01s',
                'cellclass'     => 'cell',
                'cellvalue'     => array('min' => 0, 'max' => 100, 'inc' => 1),
                'cellsize'      => array('width' => 15, 'height' => 20, 'spacing' => 2, 'count' => 10),
                'cellcolor'     => array('active' => '#006600', 'inactive' => '#CCCCCC'),
                'cellfont'      => array('family' => 'Courier, Verdana', 'size' => 8, 'color' => '#000000'),

                'stringpainted' => false,
                'stringid'      => 'installationProgress',
                'stringsize'    => array('width' => 50, 'height' => '', 'bgcolor' => '#FFFFFF'),
                'stringvalign'  => 'right',
                'stringalign'   => 'right',
                'stringfont'    => array('family' => 'Verdana, Arial, Helvetica, sans-serif', 'size' => 12, 'color' => '#000000'),
                'strings'       => implode(";\n", array(
                                       0 => '10,Hello world',
                                       1 => '20,Welcome',
                                       2 => '30,to',
                                       3 => '40,HTML_Progress v1',
                                       4 => '60,by',
                                       5 => '70,Laurent Laville',
                                       6 => '100,Have a nice day !'
                                    )),

                'phpcss'        => array('P'=>true)
            ));
        }
    }

    /**
     * Adds all necessary tabs to the given page object.
     *
     * @param      object    $page          Page where to put the button
     * @param      mixed     $attributes    (optional) Either a typical HTML attribute string 
     *                                      or an associative array.
     * @return     void
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function createTabs(&$page, $attributes = null)
    {
        if (!is_a($page, 'HTML_QuickForm_Page')) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$page',
                      'was' => gettype($page),
                      'expected' => 'HTML_QuickForm_Page object',
                      'paramnum' => 1));

        } elseif (!is_array($attributes) && !is_string($attributes) && !is_null($attributes)) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$attributes',
                      'was' => gettype($attributes),
                      'expected' => 'array | string',
                      'paramnum' => 2));
        }

        $here = $attributes = HTML_Common::_parseAttributes($attributes);
        $here['disabled'] = 'disabled';
        $pageName = $page->getAttribute('name');
        $jump = array();

        foreach ($this->_tabs as $tab) {
            list($event, $cls, $label) = $tab;
            $attrs = ($pageName == $event) ? $here : $attributes;
            $jump[] =& $page->createElement('submit', $page->getButtonName($event), $label, HTML_Common::_getAttrString($attrs));
        }
        $page->addGroup($jump, 'tabs', '', '&nbsp;', false);
    }

    /**
     * Adds all necessary buttons to the given page object.
     *
     * @param      object    $page          Page where to put the button
     * @param      array     $buttons       Key/label of each button/event to handle
     * @param      mixed     $attributes    (optional) Either a typical HTML attribute string 
     *                                      or an associative array.
     * @return     void
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     */
    function createButtons(&$page, $buttons, $attributes = null)
    {
        if (!is_a($page, 'HTML_QuickForm_Page')) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$page',
                      'was' => gettype($page),
                      'expected' => 'HTML_QuickForm_Page object',
                      'paramnum' => 1));

        } elseif (!is_array($buttons)) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$buttons',
                      'was' => gettype($buttons),
                      'expected' => 'array',
                      'paramnum' => 2));

        } elseif (!is_array($attributes) && !is_string($attributes) && !is_null($attributes)) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$attributes',
                      'was' => gettype($attributes),
                      'expected' => 'array | string',
                      'paramnum' => 3));
        }

        $confirm = $attributes = HTML_Common::_parseAttributes($attributes);
        $confirm['onClick'] = "return(confirm('Are you sure ?'));";

        $prevnext = array();

        foreach ($buttons as $event => $label) {
            if ($event == 'cancel') {
                $type = 'submit';
                $attrs = $confirm;
            } elseif ($event == 'reset') {
            	$type = 'reset';
            	$attrs = $confirm;
            } else {
                $type = 'submit';
                $attrs = $attributes;
            }
            $prevnext[] =& $page->createElement($type, $page->getButtonName($event), $label, HTML_Common::_getAttrString($attrs));
        }
        $page->addGroup($prevnext, 'buttons', '', '&nbsp;', false);
    }

    /**
     * Enables certain buttons for a page.
     * 
     * Buttons [ = events] : back, next, cancel, reset, apply, help
     * 
     * @param      object    $page          Page where you want to activate buttons
     * @param      array     $events        (optional) List of buttons
     *
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        disableButton()
     */  
    function enableButton(&$page, $events = array()) 
    {
        if (!is_a($page, 'HTML_QuickForm_Page')) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$page',
                      'was' => gettype($page),
                      'expected' => 'HTML_QuickForm_Page object',
                      'paramnum' => 1));

        } elseif (!is_array($events)) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$events',
                      'was' => gettype($events),
                      'expected' => 'array',
                      'paramnum' => 2));
        }
        static $all;
        if (!isset($all)) {
            $all = array('back','next','cancel','reset','apply','help');
        }
        $buttons = (count($events) == 0) ? $all : $events;

        foreach ($buttons as $event) {
            $group    =& $page->getElement('buttons');
            $elements =& $group->getElements();
            foreach (array_keys($elements) as $key) {
                if ($group->getElementName($key) == $page->getButtonName($event)) {
                    $elements[$key]->updateAttributes(array('disabled'=>'false'));
                }
            }
        }
    }

    /**
     * Disables certain buttons for a page.
     * 
     * Buttons [ = events] : back, next, cancel, reset, apply, help
     * 
     * @param      object    $page          Page where you want to activate buttons
     * @param      array     $events        (optional) List of buttons
     *
     * @since      1.1
     * @access     public
     * @throws     HTML_PROGRESS_ERROR_INVALID_INPUT
     * @see        enableButton()
     */  
    function disableButton(&$page, $events = array()) 
    {
        if (!is_a($page, 'HTML_QuickForm_Page')) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$page',
                      'was' => gettype($page),
                      'expected' => 'HTML_QuickForm_Page object',
                      'paramnum' => 1));

        } elseif (!is_array($events)) {
            HTML_Progress::raiseError(HTML_PROGRESS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$events',
                      'was' => gettype($events),
                      'expected' => 'array',
                      'paramnum' => 2));
        }
        static $all;
        if (!isset($all)) {
            $all = array('back','next','cancel','reset','apply','help');
        }
        $buttons = (count($events) == 0) ? $all : $events;

        foreach ($buttons as $event) {
            $group    =& $page->getElement('buttons');
            $elements =& $group->getElements();
            foreach (array_keys($elements) as $key) {
                if ($group->getElementName($key) == $page->getButtonName($event)) {
                    $elements[$key]->updateAttributes(array('disabled'=>'true'));
                }
            }
        }
    }

    /**
     * Creates a progress bar with options choosen on all wizard tabs.
     *
     * @since      1.1
     * @access     public
     */
    function createProgressBar()
    {
        $progress = $this->exportValues();
        
        $bar = new HTML_Progress();
        $bar->setIdent('PB1');
        $bar->setAnimSpeed(intval($progress['rAnimSpeed']));

        if ($progress['model'] != '') {
            $bar->setModel($progress['model'], 'iniCommented');
            $bar->setIncrement(10);
            $ui =& $bar->getUI();
        } else {
            $bar->setBorderPainted(($progress['borderpainted'] == '1'));
            $bar->setStringPainted(($progress['stringpainted'] == '1'));
            $ui =& $bar->getUI();      
        
            $structure = array();

            /* Page 1: Progress attributes **************************************************/
            if (strlen(trim($progress['progressclass'])) > 0) {
                $structure['progress']['class'] = $progress['progressclass'];
            }
            if (strlen(trim($progress['progresssize']['bgcolor'])) > 0) {
                $structure['progress']['background-color'] = $progress['progresssize']['bgcolor'];
            }
            if (strlen(trim($progress['progresssize']['width'])) > 0) {
                $structure['progress']['width'] = $progress['progresssize']['width'];
            }
            if (strlen(trim($progress['progresssize']['height'])) > 0) {
                $structure['progress']['height'] = $progress['progresssize']['height'];
            }
            $structure['progress']['auto-size'] = ($progress['autosize'] == '1');

            $ui->setProgressAttributes($structure['progress']);
            $orient = ($progress['shape'] == '1') ? HTML_PROGRESS_BAR_HORIZONTAL : HTML_PROGRESS_BAR_VERTICAL;
            $ui->setOrientation($orient);
            $ui->setFillWay($progress['way']);

            /* Page 2: Cell attributes ******************************************************/
            if (strlen(trim($progress['cellid'])) > 0) {
                $structure['cell']['id'] = $progress['cellid'];
            }
            if (strlen(trim($progress['cellclass'])) > 0) {
                $structure['cell']['class'] = $progress['cellclass'];
            }
            if (strlen(trim($progress['cellvalue']['min'])) > 0) {
                $bar->setMinimum(intval($progress['cellvalue']['min']));
            }
            if (strlen(trim($progress['cellvalue']['max'])) > 0) {
                $bar->setMaximum(intval($progress['cellvalue']['max']));
            }
            if (strlen(trim($progress['cellvalue']['inc'])) > 0) {
                $bar->setIncrement(intval($progress['cellvalue']['inc']));
            }
            if (strlen(trim($progress['cellsize']['width'])) > 0) {
                $structure['cell']['width'] = $progress['cellsize']['width'];
            }
            if (strlen(trim($progress['cellsize']['height'])) > 0) {
                $structure['cell']['height'] = $progress['cellsize']['height'];
            }
            if (strlen(trim($progress['cellsize']['spacing'])) > 0) {
                $structure['cell']['spacing'] = $progress['cellsize']['spacing'];
            }
            if (strlen(trim($progress['cellsize']['count'])) > 0) {
                $ui->setCellCount(intval($progress['cellsize']['count']));
            }
            if (strlen(trim($progress['cellcolor']['active'])) > 0) {
                $structure['cell']['active-color'] = $progress['cellcolor']['active'];
            }
            if (strlen(trim($progress['cellcolor']['inactive'])) > 0) {
                $structure['cell']['inactive-color'] = $progress['cellcolor']['inactive'];
            }
            if (strlen(trim($progress['cellfont']['family'])) > 0) {
                $structure['cell']['font-family'] = $progress['cellfont']['family'];
            }
            if (strlen(trim($progress['cellfont']['size'])) > 0) {
                $structure['cell']['font-size'] = $progress['cellfont']['size'];
            }
            if (strlen(trim($progress['cellfont']['color'])) > 0) {
                $structure['cell']['color'] = $progress['cellfont']['color'];
            }
            $ui->setCellAttributes($structure['cell']);

            /* Page 3: Border attributes ****************************************************/
            if (strlen(trim($progress['borderclass'])) > 0) {
                $structure['border']['class'] = $progress['borderclass'];
            }
            if (strlen(trim($progress['borderstyle']['width'])) > 0) {
                $structure['border']['width'] = $progress['borderstyle']['width'];
            }
            if (strlen(trim($progress['borderstyle']['style'])) > 0) {
                $structure['border']['style'] = $progress['borderstyle']['style'];
            }
            if (strlen(trim($progress['borderstyle']['color'])) > 0) {
                $structure['border']['color'] = $progress['borderstyle']['color'];
            }
            $ui->setBorderAttributes($structure['border']);

            /* Page 4: String attributes ****************************************************/
            if (strlen(trim($progress['stringid'])) > 0) {
                $structure['string']['id'] = $progress['stringid'];
            }
            if (strlen(trim($progress['stringsize']['width'])) > 0) {
                $structure['string']['width'] = $progress['stringsize']['width'];
            }
            if (strlen(trim($progress['stringsize']['height'])) > 0) {
                $structure['string']['height'] = $progress['stringsize']['height'];
            }
            if (strlen(trim($progress['stringsize']['bgcolor'])) > 0) {
                $structure['string']['background-color'] = $progress['stringsize']['bgcolor'];
            }
            if (strlen(trim($progress['stringalign'])) > 0) {
                $structure['string']['align'] = $progress['stringalign'];
            }
            if (strlen(trim($progress['stringvalign'])) > 0) {
                $structure['string']['valign'] = $progress['stringvalign'];
            }
            if (strlen(trim($progress['stringfont']['family'])) > 0) {
                $structure['string']['font-family'] = $progress['stringfont']['family'];
            }
            if (strlen(trim($progress['stringfont']['size'])) > 0) {
                $structure['string']['font-size'] = $progress['stringfont']['size'];
            }
            if (strlen(trim($progress['stringfont']['color'])) > 0) {
                $structure['string']['color'] = $progress['stringfont']['color'];
            }
            $ui->setStringAttributes($structure['string']);

	} // end-if-no-model

        return $bar;
    }
}
?>