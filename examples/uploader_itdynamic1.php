<?php
/**
 * A ITDynamic renderer example for ProgressBar Uploader
 * that used template engine IT[x] family.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/uploader.php';
require_once 'progressModels.php';
require_once 'HTML/QuickForm/Renderer/ITDynamic.php';
// can use either HTML_Template_Sigma or HTML_Template_ITX
require_once 'HTML/Template/ITX.php';
//require_once 'HTML/Template/Sigma.php';

// Account FTP on remote server
$ftp = array(
    'user' => 'farell',
    'pass' => 'xxxxxx',
    'host' => 'ftpperso.free.fr'
);

// A custom progress uploader dialog box 
$uploader = new HTML_Progress_Uploader('MyUploader3', array(
    'title'  => 'Upload your pictures',
    'mask'   => 'upload <b>%s</b> in progress ...',
    'start'  => 'Upload',
    'cancel' => 'Stop',
    'button' => array('style' => 'width:80px;')
    )
);

// Attach a progress ui-model (see file progressModels.php for attributes definition)
$progress = new HTML_Progress();
$progress->setUI('Progress_ITDynamic');
$progress->setAnimSpeed(100);               // (animation: 0 faster, 1000 slower)
$uploader->setProgressElement($progress);

// Allow only pictures upload
$uploader->setValidExtensions(array('gif','jpg','jpeg','png'));

// can use either HTML_Template_Sigma or HTML_Template_ITX
$tpl =& new HTML_Template_ITX('./templates');
// $tpl =& new HTML_Template_Sigma('./templates');


$tpl->loadTemplateFile('itdynamic_uploader.html');

$tpl->setVariable(array(
    'qf_style'  => $progress->getStyle(),
    'qf_script' => $uploader->getScript()
    )
);

$renderer =& new HTML_QuickForm_Renderer_ITDynamic($tpl);
$renderer->setElementBlock(array(
    'buttons'     => 'qf_buttons'
));

$uploader->accept($renderer);

// Display progress uploader dialog box
$tpl->show();


if ($uploader->isStarted()) {
// Begin upload

    // declare files to upload    
    $uploader->setFiles(array(
        'splintercell.jpg',
        'd:/Mes Documents/Mes images/black hawk down/00015962.jpg'
        )
    );

    // connect to ftp server
    $logs = $uploader->logon($ftp['user'], $ftp['pass'], $ftp['host']);
    if (PEAR::isError($logs)) {
        die($logs->getMessage());
    }    

    // set timeout as a default ftp connection
    set_time_limit(90);
    
    $ret = $uploader->moveTo('tmp', true);  // replace existing files 
    if (PEAR::isError($ret)) {
        die($ret->getMessage());
    }    

    // summary of uploads operation
    if (count($ret) == 0) {
        echo '<i>All files were move on to ' . $ftp['host'] . "</i><br/>\n";
    } else {
        echo '<b>Some files were not move on to ' . $ftp['host'] . "</b><br/>\n";
        print "<pre>";
        var_dump($ret);
        print "</pre>";
    }

    // disconnect from ftp server
    $uploader->logoff();
}

if ($uploader->isCanceled()) {
    $uploader->logoff();     // disconnect from ftp server before a timeout has occured
}
?>

</body>
</html>