<?php
@include '../include_path.php';
/**
 * Generator usage example using HTMLPage renderer.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/generator.php';
require_once 'HTML/Progress/generator/HTMLPage.php';

session_start();

$tabbed = new HTML_Progress_Generator();
$tabbed->run();
?>