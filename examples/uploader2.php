<?php
/**
 * A simple Web-ftp Progress Bar Uploader: files move
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/uploader.php';

session_start();

// Account FTP on remote server, directory destination, and allows Y/N file overwriting
$ftp = array(
    'user' => 'farell',
    'pass' => 'xxxxxx',
    'host' => 'ftpperso.free.fr',
    'dest' => 'tmp',                   // this directory must exists in your ftp server !
    'overwrite' => false
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
$progress->setAnimSpeed(100);               // (animation: 0 faster, 1000 slower)
$ui =& $progress->getUI();
$ui->setProgressAttributes(array('background-color' => '#e0e0e0'));        
$ui->setStringAttributes(array('color' => '#996', 'background-color' => '#CCCC99'));        
$ui->setCellAttributes(array('active-color' => '#996'));
$uploader->setProgressElement($progress);

// Allow only pictures upload
$uploader->setValidExtensions(array('gif','jpg','jpeg','png'));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Web-FTP Uploader with ProgressBar </title>
<style type="text/css">
<!--
.progressStatus {
	color:#000000; 
	font-size:10px;
}
<?php echo $uploader->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $uploader->getScript(); ?>
//-->
</script>
</head>
<body>

<?php 
include_once 'form_output.php';   // all customs colors and sizes are here
$uploader->accept($renderer);

// Display progress uploader dialog box
echo $renderer->toHtml();


if ($uploader->isStarted()) {
// Begin upload

    // add files to upload    
    $uploader->setFiles($_SESSION['file']);

    // connect to ftp server
    $logs = $uploader->logon($ftp['user'], $ftp['pass'], $ftp['host']);
    if (PEAR::isError($logs)) {
        die($logs->getMessage());
    }    
    
    // set timeout as a default ftp connection
    @set_time_limit(90);

    $ret = $uploader->moveTo($ftp['dest'], $ftp['overwrite']);
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

    $_SESSION = array();
    session_destroy();
}

if ($uploader->isCanceled()) {
    $uploader->logoff();     // disconnect from ftp server before a timeout has occured
}
?>

</body>
</html>