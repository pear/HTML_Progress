<?php
/**
 * FTP file Upload
 * This example shows how to upload file on a ftp server,
 * that may be different than web server.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTML/QuickForm.php';
require_once 'Net/FTP.php';

function myProcess($values)
{
    global $form;
    $destination = './uploads/';

    // Account FTP on remote server, directory destination, and allows Y/N file overwriting
    $ftp = array(
        'user' => $values['ftpaccount']['U'],
        'pass' => $values['ftpaccount']['P'],
        'host' => $values['ftpaccount']['H'],
        'dest' => $values['ftpdir'],             // this directory must exists in your ftp server !
        'overwrite' => (bool)$values['overwrite']
    );

    $result = 'done';
    $file =& $form->getElement('tstUpload');

    if ($file->isUploadedFile()) {

        $_ftp = new Net_FTP($ftp['host']);

        $ret = $_ftp->connect();
        if (PEAR::isError($ret)) {
            $result = $ret->getMessage();                  // NET_FTP_ERR_CONNECT_FAILED
        } else {
            $ret = $_ftp->login($ftp['user'], $ftp['pass']);
            if (PEAR::isError($ret)) {
                $result = $ret->getMessage();              // NET_FTP_ERR_LOGIN_FAILED
            } else {
                $_ftp->setPassive();

                $ret = $_ftp->cd($ftp['dest']);
                if (PEAR::isError($ret)) {
                    $result = $ret->getMessage();          // NET_FTP_ERR_DIRCHANGE_FAILED
                } else {
                    $fval = $file->getValue();

                    $ret = $_ftp->put($fval['tmp_name'], $fval['name'], $ftp['overwrite']);
                    if (PEAR::isError($ret)) {
                        $result = $ret->getMessage();      // NET_FTP_ERR_UPLOADFILE_FAILED
                    }
                }
            }
            $ret = $_ftp->disconnect();
            if (PEAR::isError($ret)) {
                $result = $ret->getMessage();              // NET_FTP_ERR_DISCONNECT_FAILED
            }
        }
    }

    // write the semaphore to tell progress meter to stop
    // in script 'progressbar.php'

    $semaphore = $destination . $_GET['ID'];
    $fp = fopen($semaphore,'w',false);
    fwrite($fp, $result);
    fclose($fp);
}
?>
<html>
<head>
<script language="javascript">
<!--
function DoUpload() {
  theUniqueID = (new Date()).getTime() % 1000000000;
  parent.meter.window.location = "progressbar.php?ID=" + theUniqueID;
  parent.files.selfref.action = "ftpupload.php?ID=" + theUniqueID;
  parent.files.selfref.submit();
}
//-->
</script>
</head>
<body>

<?php

$form =& new HTML_QuickForm('selfref');

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

$account['host'] = &HTML_QuickForm::createElement('text', 'H', 'host');
$account['user'] = &HTML_QuickForm::createElement('text', 'U', 'user');
$account['pass'] = &HTML_QuickForm::createElement('password', 'P', 'password');
$form->addGroup($account, 'ftpaccount', 'FTP account:');
$form->addGroupRule('ftpaccount', 'The FTP account is required', 'required', null, 3, 'client');

$form->addElement('text', 'ftpdir', 'FTP directory:');

$radio[] = &HTML_QuickForm::createElement('radio', null, null, 'Yes', '1');
$radio[] = &HTML_QuickForm::createElement('radio', null, null, 'No',  '0');
$form->addGroup($radio,  'overwrite', 'Overwrite existing files:');
$form->addRule('overwrite', 'Check Yes or No', 'required', null, 'client');

$form->addElement('file', 'tstUpload', array('Upload file:', 'Rule types: \'uploadedfile\' \'upload_max_filesize\'='.ini_get('upload_max_filesize')));
$form->addRule('tstUpload', 'Upload is required', 'uploadedfile');

$form->addElement('header', null, 'Submit the form');
$submit[] =& $form->createElement('button', null, 'Upload', array('onClick'=>'DoUpload();'));
$form->addGroup($submit, null, null, '&nbsp;', false);

$form->applyFilter('__ALL__', 'trim');

if ($form->validate()) {
    // Form is validated, then processes the data
    $form->freeze();
    $form->process('myProcess', true);
    echo '<p>&lt;&lt; <a target="_top" href="../index.html">Back examples TOC</a></p>';
}
$form->display();
?>
</body>
</html>