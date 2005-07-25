<?php
/**
 * Display a horizontal progress meter
 * embedded into a ITX template system file.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/Renderer/ITStatic.php';
require_once 'HTML/Template/ITX.php';
require_once 'HTML/Progress.php';

function myFunctionHandler($progressValue, &$bar)
{
    $bar->sleep();
    $str = ' ';

    if ($progressValue > 25) {
        $str = ' - DB schema generated';
    }
    if ($progressValue > 50) {
        $str = ' - Config file created';
    }
    if ($progressValue == 100) {
        $str = ' - All done !';
    }
    $bar->setString( sprintf("Installation in progress ... %01s%s %s", $progressValue, '%', $str) );
}

$tpl = new HTML_Template_ITX('.');
$tpl->loadTemplateFile('installing.html');

$vars = array (
    "L_SETUP_APP_TITLE"    => "SW4P",
    "L_APPNAME"            => basename(__FILE__),
    "L_APPCOPYRIGHT"       => "&copy 2003 SW4P Team ",
);
$tpl->setVariable($vars);

$form = new HTML_QuickForm('form');
$form->addElement('submit', 'launch', 'Launch', 'style="width:100px;"');

$styles = array('none' => 'none',
    'solid'  => 'solid',
    'dashed' => 'dashed',
    'dotted' => 'dotted',
    'inset'  => 'inset',
    'outset' => 'outset'
);
$form->addElement('select','border','border style:',$styles);

$colors = array('#FFFFFF' => 'white', '#0000FF'=> 'blue', '#7B7B88' => '#7B7B88');
$form->addElement('select','color','border color:',$colors);

$defaultValues['border'] = 'solid';
$defaultValues['color']  = '#7B7B88';
$form->setDefaults($defaultValues);

if ($form->validate()) {
    $arr = $form->getElementValue('border');
    $border = $arr[0];
    $arr = $form->getElementValue('color');
    $color = $arr[0];
} else {
    $border = $defaultValues['border'];
    $color  = $defaultValues['color'];
}


$bar = new HTML_Progress();
$bar->setAnimSpeed(200);
$bar->setIncrement(10);
$bar->setBorderPainted(true);
$bar->setStringPainted(true);          // get space for the string
$bar->setString('');                   // but don't paint it
$bar->setProgressHandler('myFunctionHandler');

$ui =& $bar->getUI();
$ui->setCellAttributes('active-color=#7B7B88 inactive-color=#D0D0D0 width=10');
$ui->setBorderAttributes(array(
    'width' => 2,
    'color' => $color,
    'style' => $border
));
$ui->setStringAttributes(array(
    'width' => 320,
    'font-size' => 10,
    'align' => 'left',
    'valign' => 'bottom',
    'background-color' => '#D0D0D0'  // make it transparent, see style #MainWindow
));
$ui->setProgressAttributes('width=320');

$tpl->setVariable("L_STYLESHEET", $bar->getStyle() );
$tpl->setVariable("L_JAVASCRIPT", $ui->getScript() );
$tpl->setVariable("L_PROGRESS_BAR", $bar->toHtml() );

$renderer = new HTML_QuickForm_Renderer_ITStatic($tpl);
$form->accept($renderer);

$tpl->show();

$bar->run();
$bar->display();  // to display the last custom string
?>