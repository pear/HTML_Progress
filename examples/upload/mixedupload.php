<?php
/**
 * Mixed Field Upload
 * This example shows how to upload a form containing a mix of standard form
 * and file input fields.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
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
  theUniqueID = (new Date()).getTime() % 1000000000;
  parent.meter.window.location = "vbar.php?ID=" + theUniqueID;
  parent.files.mixed.action = "mixedupload.php?ID=" + theUniqueID;
  parent.files.mixed.submit();
}
//-->
</script>
</head>
<body>
<?php

$form =& new HTML_QuickForm('mixed');

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

$form->setDefaults(array(
    'color'     => 'orange'
));

$form->addElement('header', null, 'Uploaded file rules');
$form->addElement('file', 'tstUpload', array('What is your favorite picture ?', 'Rule types: \'uploadedfile\', \'maxfilesize\' with $format = 512000, <br />filename with $format = \'/\.(jpe?g|gif|png)$/\'<br />Validation for files is obviuosly <b>server-side only</b>'));
$form->addRule('tstUpload', 'Upload is required', 'uploadedfile');
$form->addRule('tstUpload', 'File size should be less than 500kb', 'maxfilesize', 512000);
$form->addRule('tstUpload', 'File name should be *.jpg, *.gif or *.png', 'filename', '/\.(jpe?g|gif|png)$/i');

$form->addElement('header', null, 'Assortment of other fields');
$form->addElement('text', 'color', 'What is your favorite color ?');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'chocolate', null, 'Chocolate');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'butterscotch', null, 'Butterscotch');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'vanilla', null, 'Vanilla');
$form->addGroup($checkbox, 'flavor', 'What types of ice cream do you like?', array('&nbsp;', '<br />'));


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
</body>
</html>