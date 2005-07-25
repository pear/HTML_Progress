<?php
/**
 * How to customize HTML_Progress_Generator usage.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/Progress/generator.php';

/* 1. Choose between standard renderers (default, HTMLPage, ITDynamic).
      If none is selected, then 'default' will be used.
      It can be automatically loaded and added by the controller
 */
//require_once 'HTML/Progress/generator/default.php';
//require_once 'HTML/Progress/generator/HTMLPage.php';
//require_once 'HTML/Progress/generator/ITDynamic.php';
/*    Or creates your own renderer ...
 */

session_start();

$tabbed = new HTML_Progress_Generator();

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
//$tabbed = new HTML_Progress_Generator('PBwizard2',array('display'=>'MyDisplayHandler'));

/* 3. 'ActionPreview' is default classname that should exists
      to run live progress bar demo. But you can also create
      your own class under a new name. Then you've to give
      the new name to HTML_Progress_Generator.
      For example:

      class MyPreviewHandler extends HTML_QuickForm_Action
      {
           ...
      }
      If your 'MyPreviewHandler' class is not defined, then default
      'ActionPreview' ('HTML/Progress/generator/preview.php')
      will be used.

      YES, but why allow to cutomize preview function ?
      PERHARPS, because you want to do something else than just
      run your progress bar new look and feel !
 */
//$tabbed = new HTML_Progress_Generator('PBwizard3',array('preview'=>'MyPreviewHandler'));

/* 4. 'ActionProcess' is default classname that should exists
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
//$tabbed = new HTML_Progress_Generator('PBwizard4',array('process'=>'MyProcessHandler'));


$tabbed->run();
?>