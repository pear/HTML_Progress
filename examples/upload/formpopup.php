<?php
@include '../include_path.php';
/**
 * Single Page Upload
 * A form is used to select and submit any kind of file to webserver
 * while a progress meter is running in indeterminate mode inside a popup.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/QuickForm.php';

function myProcess($values)
{
    global $form;
    $destination = './uploads/';
    
    $file =& $form->getElement('tstUpload');
    if ($file->isUploadedFile()) {
        $ok = $file->moveUploadedFile($destination);

        if ($ok) {
            // write the semaphore to tell progress meter to stop
            // in script 'progressbar.php'

            $fp = fopen($destination . $_GET['ID'],'w',false);
            fwrite($fp, 'done');
            fclose($fp);
        }
    }
}
?>
<html>
<head>
<script language="javascript">
<!--
function DoUpload() {
  theFeats    = "height=100,width=250,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no";
  theUniqueID = (new Date()).getTime() % 1000000000;
  window.open("progressbar.php?ID=" + theUniqueID, theUniqueID, theFeats);
  document.formpopup.action = "formpopup.php?ID=" + theUniqueID;
  document.formpopup.submit();
}
//-->
</script> 
</head>
<body>
<?php

$form =& new HTML_QuickForm('formpopup');

// We need an additional label below the element
$renderer =& $form->defaultRenderer();
$renderer->setElementTemplate(<<<EOT
<tr>
    <td align="right" valign="top" nowrap="nowrap"><!-- BEGIN required --><span style="color: #ff0000">*</span><!-- END required --><b>{label}</b></td>
    <td valign="top" align="left">
        <!-- BEGIN error --><span style="color: #ff0000">{error}</span><br /><!-- END error -->{element}
        <!-- BEGIN label_2 --><br/><span style="font-size: 80%">{label_2}</span><!-- END label_2 -->
    </td>
</tr>

EOT
);

$form->addElement('header', null, 'Uploaded file rules');
$form->addElement('file', 'tstUpload', array('Upload file:', 'Rule types: \'uploadedfile\', \'maxfilesize\' with $format = 10240, \'mimetype\' with $format = \'text/xml\', filename with $format = \'/\\.xml$/\'<br />Validation for files is obviuosly <b>server-side only</b>'));
$form->addRule('tstUpload', 'Upload is required', 'uploadedfile');
$form->addRule('tstUpload', 'File size should be less than 10kb', 'maxfilesize', 10240);
$form->addRule('tstUpload', 'File type should be text/xml', 'mimetype', 'text/xml');
$form->addRule('tstUpload', 'File name should be *.xml', 'filename', '/\\.xml$/');

$form->addElement('header', null, 'Submit the form');
$submit[] =& $form->createElement('button', null, 'Upload', array('onClick'=>'DoUpload();'));
$form->addGroup($submit, null, null, '&nbsp;', false);

$form->applyFilter('__ALL__', 'trim');

if ($form->validate()) {
    // Form is validated, then processes the data
    $form->freeze();
    $form->process('myProcess', true);
    echo '<p>&lt;&lt; <a target="_top" href="../index.html">Back examples TOC</a></p>';

} elseif (isset($_GET['ID'])) {
    $destination = './uploads/';
    $fp = fopen($destination . $_GET['ID'],'w',false);
    fwrite($fp, 'error');
    fclose($fp);  
}
$form->display();
?>