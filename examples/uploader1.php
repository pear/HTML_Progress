<?php
/**
 * A simple Web-ftp Progress Bar Uploader: files selection
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/QuickForm.php';
require_once 'form_output.php';

$form = new HTML_QuickForm('frmUpload');

$form->addElement('header', null, 'Web-FTP PEAR::Progress Uploader');

// changes the limit, to have more or less file choice
for ($f = 0; $f < 10; $f++) {
    $files[] = &HTML_QuickForm::createElement('file', 'file[]');
}
$form->addGroup($files, null, null, '<br/>', false);

$buttons[] = &HTML_QuickForm::createElement('submit', null, 'Submit');
$buttons[] = &HTML_QuickForm::createElement('reset',  null, 'Reset');
$form->addGroup($buttons, null, null, '&nbsp;', false);

// i just want to have filename(s) when form is submit, not file contents
$form->updateAttributes(array('enctype' => 'application/x-www-form-urlencoded'));

include_once 'form_output.php';   // all customs colors and sizes are here
$form->accept($renderer);

if ($form->validate()) {
    // Form is validated, then processes the data
    $form->process('myProcess');
}

echo $renderer->toHtml();


// Process callback
function myProcess($values)
{
    session_start();
    
    $_files = array();
    foreach ($values['file'] as $file) {
        if (!empty($file)) {
            $_SESSION['file'][] = $file;
        } 
    }
    header ('Location: uploader2.php');
    exit;
}
?>