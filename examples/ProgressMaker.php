<?php
/**
 * ProgressMaker allows to dynamic build Progress bar,
 * give a shot on display.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

require_once 'HTML/Page.php';
require_once 'HTML/CSS.php';

require_once 'HTML/QuickForm/Controller.php';

// Load some default action handlers
require_once 'HTML/QuickForm/Action/Submit.php';
require_once 'HTML/QuickForm/Action/Jump.php';
require_once 'HTML/QuickForm/Action/Display.php';
require_once 'HTML/QuickForm/Action/Direct.php';

/**
 *  Progress main properties
 */
class Property1 extends HTML_QuickForm_Page
{
    function buildForm()
    {
        $this->_formBuilt = true;

        $tabs[] =& $this->createElement('submit', $this->getButtonName('page1'), 'Progress', array('class' => 'flat', 'disabled' => 'disabled'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page2'), 'Cell', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page3'), 'Border', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page4'), 'String', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page5'), 'Ready', array('class' => 'flat'));
        $this->addGroup($tabs, 'tabs', null, '&nbsp;', false);

        $this->addElement('header', null, '&nbsp;');

        $models = array(
            ''  => '',
            'ancestor.ini'  => 'Ancestor',
            'bluesand.ini'  => 'BlueSand',
            'redsandback.ini'  => 'RedSandBack',
            'bullit.ini'  => 'Bullit',
            'smallest.ini'  => 'Smallest',
            'bgimages.ini'  => 'BgImages'
        );
        $this->addElement('select', 'model', 'pre-set UI models:', $models);

        $this->addElement('text', 'progressclass', 'CSS class:', array('size' => 32));

        $shape[] =& $this->createElement('radio', null, null, 'Horizontal', '1');
        $shape[] =& $this->createElement('radio', null, null, 'Vertical', '2');
        $this->addGroup($shape, 'shape', 'Progress shape:');

        $way[] =& $this->createElement('radio', null, null, 'Natural', 'natural');
        $way[] =& $this->createElement('radio', null, null, 'Reverse', 'reverse');
        $this->addGroup($way, 'way', 'Progress way:');

        $autosize[] =& $this->createElement('radio', null, null, 'Yes', true);
        $autosize[] =& $this->createElement('radio', null, null, 'No', false);
        $this->addGroup($autosize, 'autosize', 'Progress best size:');

        $progresssize['width']   =& $this->createElement('text', 'width', null, array('size' => 4));
        $progresssize['height']  =& $this->createElement('text', 'height', null, array('size' => 4));
        $progresssize['bgcolor'] =& $this->createElement('text', 'bgcolor', null, array('size' => 7));
        $this->addGroup($progresssize, 'progresssize', 'Size and color (width, height, bgcolor):', ',&nbsp;');


        $this->addElement('submit', $this->getButtonName('next'), 'Next >>');
    }
}

/**
 *  Cell properties
 */
class Property2 extends HTML_QuickForm_Page
{
    function buildForm()
    {
        $this->_formBuilt = true;

        $tabs[] =& $this->createElement('submit', $this->getButtonName('page1'), 'Progress', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page2'), 'Cell', array('class' => 'flat', 'disabled' => 'disabled'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page3'), 'Border', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page4'), 'String', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page5'), 'Ready', array('class' => 'flat'));
        $this->addGroup($tabs, 'tabs', null, '&nbsp;', false);

        $this->addElement('header', null, '&nbsp;');

        $this->addElement('text', 'cellid', 'Id mask:', array('size' => 32));
        $this->addElement('text', 'cellclass', 'CSS class:', array('size' => 32));

        $cellvalue['min'] =& $this->createElement('text', 'min', null, array('size' => 4));
        $cellvalue['max'] =& $this->createElement('text', 'max', null, array('size' => 4));
        $cellvalue['inc'] =& $this->createElement('text', 'inc', null, array('size' => 4));
        $this->addGroup($cellvalue, 'cellvalue', 'Value (minimum, maximum, increment):', ',&nbsp;');

        $cellsize['width']   =& $this->createElement('text', 'width', null, array('size' => 4));
        $cellsize['height']  =& $this->createElement('text', 'height', null, array('size' => 4));
        $cellsize['spacing'] =& $this->createElement('text', 'spacing', null, array('size' => 2));
        $cellsize['count']   =& $this->createElement('text', 'count', null, array('size' => 2));
        $this->addGroup($cellsize, 'cellsize', 'Size (width, height, spacing, count):', ',&nbsp;');

        $cellcolor['active']   =& $this->createElement('text', 'active', null, array('size' => 7));
        $cellcolor['inactive'] =& $this->createElement('text', 'inactive', null, array('size' => 7));
        $this->addGroup($cellcolor, 'cellcolor', 'Color (active, inactive):', ',&nbsp;');

        $cellfont['family'] =& $this->createElement('text', 'family', null, array('size' => 32));
        $cellfont['size']   =& $this->createElement('text', 'size', null, array('size' => 2));
        $cellfont['color']  =& $this->createElement('text', 'color', null, array('size' => 7));
        $this->addGroup($cellfont, 'cellfont', 'Font (family, size, color):', ',&nbsp;');


        $prevnext[] =& $this->createElement('submit', $this->getButtonName('back'), '<< Back');
        $prevnext[] =& $this->createElement('submit', $this->getButtonName('next'), 'Next >>');
        $this->addGroup($prevnext, null, '', '&nbsp;', false);       
    }
}

/**
 *  Progress border properties
 */
class Property3 extends HTML_QuickForm_Page
{
    function buildForm()
    {
        $this->_formBuilt = true;

        $tabs[] =& $this->createElement('submit', $this->getButtonName('page1'), 'Progress', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page2'), 'Cell', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page3'), 'Border', array('class' => 'flat', 'disabled' => 'disabled'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page4'), 'String', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page5'), 'Ready', array('class' => 'flat'));
        $this->addGroup($tabs, 'tabs', null, '&nbsp;', false);

        $this->addElement('header', null, '&nbsp;');

        $borderpainted[] =& $this->createElement('radio', null, null, 'Yes', true);
        $borderpainted[] =& $this->createElement('radio', null, null, 'No', false);
        $this->addGroup($borderpainted, 'borderpainted', 'Display a border around the progress bar:');

        $this->addElement('text', 'borderclass', 'CSS class:', array('size' => 32));

        $borderstyle['style'] =& $this->createElement('select', 'style', null, array('solid'=>'Solid', 'dashed'=>'Dashed', 'dotted'=>'Dotted', 'inset'=>'Inset', 'outset'=>'Outset'));
        $borderstyle['width'] =& $this->createElement('text', 'width', null, array('size' => 2));
        $borderstyle['color'] =& $this->createElement('text', 'color', null, array('size' => 7));
        $this->addGroup($borderstyle, 'borderstyle', '(style, width, color):', ',&nbsp;');


        $prevnext[] =& $this->createElement('submit', $this->getButtonName('back'), '<< Back');
        $prevnext[] =& $this->createElement('submit', $this->getButtonName('next'), 'Next >>');
        $this->addGroup($prevnext, null, '', '&nbsp;', false);       
    }
}

/**
 *  String properties
 */
class Property4 extends HTML_QuickForm_Page
{
    function buildForm()
    {
        $this->_formBuilt = true;

        $tabs[] =& $this->createElement('submit', $this->getButtonName('page1'), 'Progress', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page2'), 'Cell', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page3'), 'Border', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page4'), 'String', array('class' => 'flat', 'disabled' => 'disabled'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page5'), 'Ready', array('class' => 'flat'));
        $this->addGroup($tabs, 'tabs', null, '&nbsp;', false);

        $this->addElement('header', null, '&nbsp;');

        $stringpainted[] =& $this->createElement('radio', null, null, 'Yes', true);
        $stringpainted[] =& $this->createElement('radio', null, null, 'No', false);
        $this->addGroup($stringpainted, 'stringpainted', 'Render a custom string:');

        $this->addElement('text', 'stringid', 'Id:', array('size' => 32));

        $stringsize['width']   =& $this->createElement('text', 'width', null, array('size' => 4));
        $stringsize['height']  =& $this->createElement('text', 'height', null, array('size' => 4));
        $stringsize['bgcolor'] =& $this->createElement('text', 'bgcolor', null, array('size' => 7));
        $this->addGroup($stringsize, 'stringsize', 'Size and color (width, height, bgcolor):', ',&nbsp;');

        $stringvalign[] =& $this->createElement('radio', null, null, 'Left', 'left');
        $stringvalign[] =& $this->createElement('radio', null, null, 'Right', 'right');
        $stringvalign[] =& $this->createElement('radio', null, null, 'Top', 'top');
        $stringvalign[] =& $this->createElement('radio', null, null, 'Bottom', 'bottom');
        $this->addGroup($stringvalign, 'stringvalign', 'Vertical alignment:');

        $stringalign[] =& $this->createElement('radio', null, null, 'Left', 'left');
        $stringalign[] =& $this->createElement('radio', null, null, 'Right', 'right');
        $stringalign[] =& $this->createElement('radio', null, null, 'Center', 'center');
        $this->addGroup($stringalign, 'stringalign', 'Horizontal alignment:');

        $stringfont['family'] =& $this->createElement('text', 'family', null, array('size' => 40));
        $stringfont['size']   =& $this->createElement('text', 'size', null, array('size' => 2));
        $stringfont['color']  =& $this->createElement('text', 'color', null, array('size' => 7));
        $this->addGroup($stringfont, 'stringfont', 'Font (family, size, color):', ',&nbsp;');

        $this->addElement('textarea', 'strings', 'percent, string thrown:', array('rows' => 10, 'cols' => 50));


        $prevnext[] =& $this->createElement('submit', $this->getButtonName('back'), '<< Back');
        $prevnext[] =& $this->createElement('submit', $this->getButtonName('next'), 'Next >>');
        $this->addGroup($prevnext, null, '', '&nbsp;', false);       
    }
}

/**
 *  Output page options
 */
class Ready extends HTML_QuickForm_Page
{
    function buildForm()
    {
        $this->_formBuilt = true;

        $tabs[] =& $this->createElement('submit', $this->getButtonName('page1'), 'Progress', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page2'), 'Cell', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page3'), 'Border', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page4'), 'String', array('class' => 'flat'));
        $tabs[] =& $this->createElement('submit', $this->getButtonName('page5'), 'Ready', array('class' => 'flat', 'disabled' => 'disabled'));
        $this->addGroup($tabs, 'tabs', null, '&nbsp;', false);

        $this->addElement('header', null, 'Output page styles');

        $outputcolor['bg']   =& $this->createElement('text', 'bg', null, array('size' => 7));
        $outputcolor['fg']   =& $this->createElement('text', 'fg', null, array('size' => 7));
        $outputcolor['link'] =& $this->createElement('text', 'link', null, array('size' => 7));
        $this->addGroup($outputcolor, 'outputcolor', 'Color (background, foreground, link):', ',&nbsp;');

        $this->addElement('text', 'outputcss', 'StyleSheet:', array('size' => 32));

        $render[] =& $this->createElement('radio', null, null, 'dump', 'dump');
        $render[] =& $this->createElement('radio', null, null, 'live', 'demo');
        $this->addGroup($render, 'render', 'Render:');


        $prevnext[] =& $this->createElement('submit', $this->getButtonName('back'), '<< Back');
        $prevnext[] =& $this->createElement('submit', $this->getButtonName('submit'), 'Apply');
        $this->addGroup($prevnext, null, '', '&nbsp;', false);       
    }
}


/**
 *  Class for form rendering
 */
class ActionDisplay extends HTML_QuickForm_Action_Display
{
    function _renderForm(&$page) 
    {
        $renderer =& $page->defaultRenderer();

        $p = new HTML_Page(array(
                 'lineend'  => OS_WINDOWS ? 'win' : 'unix',
                 'doctype'  => "XHTML 1.0 Strict",
                 'language' => 'en',
                 'cache'    => 'false'
             ));        
        $p->disableXmlProlog();
        $p->setTitle("PEAR::HTML_Progress - ProgressMaker");
        $p->setMetaData("author", "Laurent Laville");

        $renderer->setFormTemplate('<table class="maintable"><form{attributes}>{content}</form></table>');
        $renderer->setHeaderTemplate('<tr><th colspan="2">{header}</th></tr>');
        $renderer->setGroupTemplate('<table><tr>{content}</tr></table>', 'name');
        $renderer->setGroupElementTemplate('<td>{element}<br /><span style="font-size:10px;"><span class="label">{label}</span></span></td>', 'name');

        $page->accept($renderer);

        $css = new HTML_CSS();
        $css->setStyle('body', 'background-color', '#7B7B88');
        $css->setStyle('body', 'font-family', 'Verdana, Arial, helvetica');
        $css->setStyle('body', 'font-size', '10pt');
        $css->setStyle('h1', 'color', '#FFC');
        $css->setStyle('h1', 'text-align', 'center');
        $css->setStyle('.maintable', 'width', '100%');
        $css->setStyle('.maintable', 'border-width', '0');
        $css->setStyle('.maintable', 'border-style', 'thin dashed');
        $css->setStyle('.maintable', 'border-color', '#D0D0D0');
        $css->setStyle('.maintable', 'background-color', '#EEE');
        $css->setStyle('.maintable', 'cellspacing', '2');
        $css->setStyle('.maintable', 'cellspadding', '3');
        $css->setStyle('th', 'text-align', 'center');
        $css->setStyle('th', 'color', '#FFC');
        $css->setStyle('th', 'background-color', '#AAA');
        $css->setStyle('th', 'white-space', 'nowrap');
        $css->setStyle('input', 'font-family', 'Verdana, Arial, helvetica');
        $css->setStyle('input.flat', 'border-style', 'solid');
        $css->setStyle('input.flat', 'border-width', '2px 2px 0px 2px');
        $css->setStyle('input.flat', 'border-color', '#996');

        $p->addStyleDeclaration($css);
        $p->addBodyContent( '<h1>ProgressMaker - Control Panel</h1>'. $renderer->toHtml() );
	$p->display();
    }
}

class ActionProcess extends HTML_QuickForm_Action
{
    function perform(&$page, $actionName)
    {
        $progress = $page->controller->exportValues();

        $p = new HTML_Page(array(
                 'lineend'  => OS_WINDOWS ? 'win' : 'unix',
                 'doctype'  => "XHTML 1.0 Strict",
                 'language' => 'en',
                 'cache'    => 'false'
             ));        
        $p->disableXmlProlog();
        $p->setTitle("PEAR::HTML_Progress - ProgressMaker");
        $p->setMetaData("author", "Laurent Laville");

        $bar = new HTML_Progress();

        if ($progress['model'] != '') {
            switch ($progress['model']) {
             case 'ancestor.ini':
                 $progress['outputcolor']['bg'] = "#444444";
                 $progress['outputcolor']['fg'] = "#EEEEEE";
                 $progress['outputcolor']['link'] = "yellow";
                 break;
             case 'bluesand.ini':
                 $progress['outputcolor']['bg'] = "#EEEEEE";
                 $progress['outputcolor']['fg'] = "#000000";
                 $progress['outputcolor']['link'] = "navy";
                 break;
             case 'bullit.ini':
             case 'bgimages.ini':
             case 'smallest.ini':
                 $progress['outputcolor']['bg'] = "#C3C6C3";
                 $progress['outputcolor']['fg'] = "#000000";
                 $progress['outputcolor']['link'] = "navy";
                 break;
            }
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


        $css = new HTML_CSS();
        $css->setStyle('body', 'background-color', $progress['outputcolor']['bg']);
        $css->setStyle('body', 'color', $progress['outputcolor']['fg']);
        $css->setStyle('body', 'font-family', 'Verdana, Arial');
        $css->setStyle('a:link', 'color', $progress['outputcolor']['link']);
        $css->setSameStyle('a:visited, a:active', 'a:link');
        $css->setStyle('div.frame', 'margin-left', '10%');
        $css->setStyle('div.frame', 'margin-right', '10%');
        $css->setStyle('div.frame', 'border', '1px solid '.$progress['outputcolor']['link']);
        $css->setStyle('div.frame', 'padding', '1em');

        if ($progress['render'] == 'dump') {
            $p->addBodyContent('<pre>');
            ob_start();
            print_r($bar->toArray());
            if (function_exists('ob_get_clean')) {
                $structure  = ob_get_clean();      // use for PHP 4.3+
            } else {
                $structure  = ob_get_contents();   // use for PHP 4.2+
                ob_end_clean();
            }
            $p->addBodyContent($structure);
            ob_get_contents();
            
            $p->addBodyContent('</pre>');
        } else {
            $p->addStyleSheet($progress['outputcss']);
            $p->addStyleDeclaration( $bar->getStyle() . $css->toString() );
            $p->addScriptDeclaration( $ui->getScript() );
            $p->addBodyContent('<div class="frame">');
            $p->addBodyContent('<h1>ProgressMaker</h1>');
            $p->addBodyContent('<i>powered by HTML_Progress 1.0</i>');
            $p->addBodyContent('<p><i><b>Laurent Laville, November 2003</b></i></p>');
            $p->addBodyContent('<p>&lt;&lt; <a href="'.getenv('SCRIPT_NAME').'">Replay</a></p>');
            $p->addBodyContent( $bar->toHtml() );
            $p->addBodyContent('</div>');
	}
        $p->display();

        if ($progress['render'] == 'demo') {
            do {
                $percent = $bar->getPercentComplete();
                if ($bar->isStringPainted()) {
                    if (substr($progress['strings'], -1) == ";") {
                        $strings = explode(";", $progress['strings']);
                    } else {
                        $strings = explode(";", $progress['strings'].";");
                    }
                    for ($i=0; $i<count($strings)-1; $i++) {
                        list ($p, $s) = explode(",", $strings[$i]);
                        if ($percent == floatval($p)/100) {
                            $bar->setString(trim($s));
                        }
                    }
                }
                $bar->display();
                if ($percent == 1) {
                    break;   // the progress bar has reached 100%
                }
                $bar->incValue();
            } while(1);
        }
    }
}

session_start();

$tabbed = new HTML_QuickForm_Controller('Tabbed', false);

$tabbed->addPage(new Property1('page1'));
$tabbed->addPage(new Property2('page2'));
$tabbed->addPage(new Property3('page3'));
$tabbed->addPage(new Property4('page4'));
$tabbed->addPage(new Ready('page5'));

// These actions manage going directly to the pages with the same name
$tabbed->addAction('page1', new HTML_QuickForm_Action_Direct());
$tabbed->addAction('page2', new HTML_QuickForm_Action_Direct());
$tabbed->addAction('page3', new HTML_QuickForm_Action_Direct());
$tabbed->addAction('page4', new HTML_QuickForm_Action_Direct());
$tabbed->addAction('page5', new HTML_QuickForm_Action_Direct());

// We actually add these handlers here for the sake of example
// They can be automatically loaded and added by the controller
$tabbed->addAction('jump', new HTML_QuickForm_Action_Jump());
$tabbed->addAction('submit', new HTML_QuickForm_Action_Submit());

// The customized actions
$tabbed->addAction('display', new ActionDisplay());
$tabbed->addAction('process', new ActionProcess());

$sess = $tabbed->container();
$defaults = $sess['defaults'];

if (count($sess['defaults']) == 0) {
  // ProgressBar default values
  $tabbed->setDefaults(array(
    'progressclass' => 'progressBar',
    'shape'         => HTML_PROGRESS_BAR_HORIZONTAL,
    'way'           => 'natural',
    'autosize'      => true,
    'progresssize'  => array('bgcolor' => '#FFFFFF'),

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
                           3 => '40,HTML_Progress 1.0',
                           4 => '60,by',
                           5 => '70,Laurent Laville',
                           6 => '100,Have a nice day !'
                       )),
    'outputcolor'   => array('bg' => '#FFFFFF', 'fg' => '#000000', 'link' => 'navy'),
    'outputcss'     => '',
    'render'        => 'demo'
  ));
}

$tabbed->run();

?>
