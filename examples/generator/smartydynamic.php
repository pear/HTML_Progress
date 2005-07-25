<?php
/**
 * Generator usage example using Array QF renderer
 * for Smarty template engine.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress/generator.php';
require_once 'HTML/Progress/generator/SmartyDynamic.php';

session_start();

$tabbed = new HTML_Progress_Generator();
$tabbed->run();
?>