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

require_once 'HTML/QuickForm/Renderer/Array.php';
// fix this if your Smarty is somewhere else
require_once 'Smarty.class.php';

/**
 * The ActionDisplay class provides a dynamic form rendering
 * with Smarty template engine.
 *
 * @version    1.1
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @category   HTML
 * @package    HTML_Progress
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

class ActionDisplay extends HTML_QuickForm_Action_Display
{
    function _renderForm(&$page) 
    {
        $pageName = $page->getAttribute('name');
        $tabPreview = array_slice ($page->controller->_tabs, -2, 1);

        // setup a template object
        $tpl =& new Smarty();
        $tpl->template_dir = './templates';
        $tpl->compile_dir  = './templates_c';

        // on preview tab, add progress bar javascript and stylesheet
        if ($pageName == $tabPreview[0][0]) {
            $bar = $page->controller->createProgressBar();

            $tpl->assign(array(
                'qf_style'  => $bar->getStyle(),
                'qf_script' => $bar->getScript()
                )
            );

            $barElement =& $page->getElement('progressBar');
            $barElement->setText( $bar->toHtml() );
        }

        $renderer =& new HTML_QuickForm_Renderer_Array(true);

        $page->accept($renderer);
        $tpl->assign('form', $renderer->toArray());

        // capture the array stucture 
        // (only for showing in sample template)
        ob_start();
        print_r($renderer->toArray());
        $tpl->assign('dynamic_array', ob_get_contents());
        ob_end_clean();

        $tpl->display('smarty-dynamic.tpl');
    }
}
?>