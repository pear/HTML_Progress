<?php 
/**
 * Simple Monitor ProgressBar example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once ('HTML/Progress/monitor.php');
require_once ('HTML/Page.php');

$p = new HTML_Page(array(
        'charset'  => 'utf-8',
        'lineend'  => OS_WINDOWS ? 'win' : 'unix',
        'doctype'  => "XHTML 1.0 Strict",
        'language' => 'en',
        'cache'    => 'false'
     ));        

$p->setTitle("PEAR::HTML_Progress - Simple Monitor demo");
$p->setMetaData("author", "Laurent Laville");

$progressMonitor = new HTML_Progress_Monitor();

$p->addStyleDeclaration(
    $progressMonitor->getStyle()
    );
$p->addScriptDeclaration(
    $progressMonitor->getScript()
    );
$p->addBodyContent(
    "<h1>".basename(__FILE__)."</h1>"
    );
$p->addBodyContent(
    $progressMonitor->toHtml()
    );
$p->addBodyContent(
    '<p>&lt;&lt; <a href="index.html">Back examples TOC</a></p>'
    );

$p->display();

$progressMonitor->run();

?>
