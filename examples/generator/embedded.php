<?php
@include '../include_path.php';
/**
 * How to embedded HTML_Progress_Generator into existing html page
 * and allows php/css source-code download.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/generator.php';

/* 1. Choose between standard renderers (default, HTMLPage, ITDynamic).
      If none is selected, then 'default' will be used.
      It can be automatically loaded and added by the controller
 */
require_once 'HTML/Progress/generator/ITDynamic.php';

/* 2. 'ActionDisplay' is default classname that should exists 
      to manage wizard/tabbed display. But you can also create
      your own class under a new name. Then you've to give 
      the new name to HTML_Progress_Generator.
      For example:
      
      class MyDisplayHandler extends HTML_QuickForm_Action_Display
      {
           ...
      }
      If your 'MyDisplayHandler' class is not defined, then default
      'ActionDisplay' ('HTML/Progress/generator/default.php')
      will be used.
 */
class MyDisplayHandler extends HTML_QuickForm_Action_Display
{
    function _renderForm(&$page) 
    {
        $pageName = $page->getAttribute('name');
        $tabPreview = array_slice ($page->controller->_tabs, -2, 1);

        $tpl =& new HTML_Template_ITX('../templates');

        $tpl->loadTemplateFile('itdynamic_generator.html');

        // on preview tab, add progress bar javascript and stylesheet
        if ($pageName == $tabPreview[0][0]) {
            $bar = $page->controller->createProgressBar();

            $tpl->setVariable(array(
                'qf_style'  => $bar->getStyle(),
                'qf_script' => $bar->getScript()
                )
            );

            $barElement =& $page->getElement('progressBar');
            $barElement->setText( $bar->toHtml() );
        }

        $renderer =& new HTML_QuickForm_Renderer_ITDynamic($tpl);
        $renderer->setElementBlock(array(
            'buttons'     => 'qf_buttons'
        ));

        $page->accept($renderer);

        $tpl->show();
    }
}

/* 3. 'ActionProcess' is default classname that should exists 
      to save your progress bar php/css source-code. But you can also create
      your own class under a new name. Then you've to give 
      the new name to HTML_Progress_Generator.
      For example:
      
      class MyProcessHandler extends HTML_QuickForm_Action
      {
           ...
      }
      If your 'MyProcessHandler' class is not defined, then default
      'ActionProcess' ('HTML/Progress/generator/process.php') 
      will be used.
 */
class MyProcessHandler extends HTML_QuickForm_Action
{
    function perform(&$page, $actionName)
    {
        if ($actionName == 'cancel') {
            echo '<h1>Progress Generator Demonstration is Over</h1>';
            echo '<p>Hope you\'ve enjoyed. See you later!</p>';
        } else {
            // Checks whether the pages of the controller are valid
            $page->isFormBuilt() or $page->buildForm();
            $page->controller->isValid();

            // what kind of source code is requested  
            $code = $page->exportValue('phpcss');
            $bar = $page->controller->createProgressBar();
            
            if (isset($code['C'])) {
                $this->exportOutput($bar->getStyle(), 'text/css');
            }

            if (isset($code['P'])) {
                $structure = $bar->toArray();

                $lineEnd = OS_WINDOWS ? "\r\n" : "\n";
                
                $strPHP  = '<?php'.$lineEnd;
                $strPHP .= 'require_once \'HTML/Progress.php\';'.$lineEnd.$lineEnd;
                $strPHP .= '$progress = new HTML_Progress();'.$lineEnd;
                $strPHP .= '$progress->setIdent(\'PB1\');'.$lineEnd;
                    
                if ($bar->isIndeterminate()) {
                    $strPHP .= '$progress->setIndeterminate(true);'.$lineEnd;
                }
                if ($bar->isBorderPainted()) {
                    $strPHP .= '$progress->setBorderPainted(true);'.$lineEnd;
                }
                if ($bar->isStringPainted()) {
                    $strPHP .= '$progress->setStringPainted(true);'.$lineEnd;
                }
                if (is_null($structure['string'])) {
                    $strPHP .= '$progress->setString(null);';
                } else {
                    $strPHP .= '$progress->setString('.$structure['string'].');';
                }
                $strPHP .= $lineEnd;
                if ($structure['animspeed'] > 0) {
                    $strPHP .= '$progress->setAnimSpeed('.$structure['animspeed'].');'.$lineEnd;
                }
                if ($structure['dm']['minimum'] != 0) {
                    $strPHP .= '$progress->setMinimum('.$structure['dm']['minimum'].');'.$lineEnd;
                }
                if ($structure['dm']['maximum'] != 100) {
                    $strPHP .= '$progress->setMaximum('.$structure['dm']['maximum'].');'.$lineEnd;
                }
                if ($structure['dm']['increment'] != 1) {
                    $strPHP .= '$progress->setIncrement('.$structure['dm']['increment'].');'.$lineEnd;
                }
                $strPHP .= $lineEnd;
                $strPHP .= '$ui =& $progress->getUI();'.$lineEnd;

                $orient = ($structure['ui']['orientation'] == '1') ? 'HTML_PROGRESS_BAR_HORIZONTAL' : 'HTML_PROGRESS_BAR_VERTICAL';
                $strPHP .= '$ui->setOrientation('.$orient.');'.$lineEnd;
                $strPHP .= '$ui->setFillWay(\''.$structure['ui']['fillway'].'\');'.$lineEnd;

            /* Page 1: Progress attributes **************************************************/
                $strPHP .= $this->_attributesArray('$ui->setProgressAttributes(', $structure['ui']['progress']);
                $strPHP .= $lineEnd;

            /* Page 2: Cell attributes ******************************************************/
                $strPHP .= '$ui->setCellCount('.$structure['ui']['cell']['count'].');'.$lineEnd;
                unset($structure['ui']['cell']['count']);  // to avoid dupplicate entry in attributes
                $strPHP .= $this->_attributesArray('$ui->setCellAttributes(', $structure['ui']['cell']);
                $strPHP .= $lineEnd;

            /* Page 3: Border attributes ****************************************************/
                $strPHP .= $this->_attributesArray('$ui->setBorderAttributes(', $structure['ui']['border']);
                $strPHP .= $lineEnd;

            /* Page 4: String attributes ****************************************************/
                $strPHP .= $this->_attributesArray('$ui->setStringAttributes(', $structure['ui']['string']);
                $strPHP .= $lineEnd.$lineEnd;

                $strPHP .= '// code below is only for run demo; its not ncecessary to create progress bar'.$lineEnd;
                $strPHP .= 'echo \'<style type="text/css">\'.$progress->getStyle().\'</style>\';'.$lineEnd;
                $strPHP .= 'echo \'<script type="text/javascript">\'.$progress->getScript().\'</script>\';'.$lineEnd;
                $strPHP .= 'echo $progress->toHtml();'.$lineEnd;
                $strPHP .= '$progress->run();'.$lineEnd;
                $strPHP .= '?>';
                $this->exportOutput($strPHP, 'text/php');
            }

            // reset session data
            $page->controller->container(true);
        }
    }

    function exportOutput($str, $mime = 'text/plain', $charset = 'iso-8859-1')
    {
        if (!headers_sent()) {
            header("Expires: Tue, 1 Jan 1980 12:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
            header("Content-Type: $mime; charset=$charset");
        }
        print $str;
    }

    function _attributesArray($str, $attributes)
    {
        $strPHP = $str . 'array(';
        foreach ($attributes as $attr => $val) {
            if (is_integer($val)) {
                $strPHP .= "'$attr'=>$val, ";
            } elseif (is_bool($val)) {
                $strPHP .= "'$attr'=>".($val?'true':'false').', ';
            } else {
                $strPHP .= "'$attr'=>'$val', ";
            }   
        }
        $strPHP = ereg_replace(', $', '', $strPHP);
        $strPHP .= '));';
        return $strPHP;
    }
}


session_start();

$tabbed = new HTML_Progress_Generator('PBwizard', array(
                                      'display' => 'MyDisplayHandler',
                                      'process' => 'MyProcessHandler'
                                      ));

$tabbed->run();
?>