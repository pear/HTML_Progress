<?php
// +----------------------------------------------------------------------+
// | PEAR :: HTML :: Progress                                             |
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
 * The ActionDisplay class provides a HTML_Page form rendering.
 *
 * @version    1.2.0
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @access     public
 * @package    HTML_Progress
 * @subpackage Progress_UI
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

require_once 'HTML/Page.php';

class ActionDisplay extends HTML_QuickForm_Action_Display
{
    function _renderForm(&$page) 
    {
        $pageName = $page->getAttribute('name');
        $tabPreview = array_slice ($page->controller->_tabs, -2, 1);

        $p = new HTML_Page(array(
                 'lineend'  => OS_WINDOWS ? 'win' : 'unix',
                 'doctype'  => "XHTML 1.0 Strict",
                 'language' => 'en',
                 'cache'    => 'false'
             ));        
        $p->disableXmlProlog();
        $p->setTitle("PEAR::HTML_Progress - Generator");
        $p->setMetaData("author", "Laurent Laville");

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

        // on preview tab, add progress bar javascript and stylesheet
        if ($pageName == $tabPreview[0][0]) {
            $bar = $page->controller->createProgressBar();

            $p->addStyleDeclaration( $css->toString() . $bar->getStyle() );
            $p->addScriptDeclaration( $bar->getScript() );

            $barElement =& $page->getElement('progressBar');
            $barElement->setText( $bar->toHtml() );
        } else {
            $p->addStyleDeclaration( $css->toString() );
        }

        $renderer =& $page->defaultRenderer();

        $renderer->setFormTemplate('<table class="maintable"><form{attributes}>{content}</form></table>');
        $renderer->setHeaderTemplate('<tr><th colspan="2">{header}</th></tr>');
        $renderer->setGroupTemplate('<table><tr>{content}</tr></table>', 'name');
        $renderer->setGroupElementTemplate('<td>{element}<br /><span style="font-size:10px;"><span class="label">{label}</span></span></td>', 'name');

        $page->accept($renderer);

        $p->addBodyContent( $renderer->toHtml() );
	$p->display();
    }
}
?>