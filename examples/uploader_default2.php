<?php
/**
 * Another simple Default Upload ProgressBar example.
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/uploader.php';

require_once 'progressModels.php';

// Account FTP on remote server
$ftp = array(
    'user' => 'farell',
    'pass' => 'xxxxxx',
    'host' => 'ftpperso.free.fr'
);


// A progress uploader dialog box with buttons 80 pixels width
$uploader = new HTML_Progress_Uploader('MyUploader2', array(
    'button' => array('style' => 'width:80px;')
    )
);

// Attach a progress ui-model (see file progressModels.php for attributes definition)
$progress = new HTML_Progress();
$progress->setUI('Progress_Default2');
$progress->setAnimSpeed(100);               // (animation: 0 faster, 1000 slower)
$uploader->setProgressElement($progress);

// Allow only pictures upload
$uploader->setValidExtensions(array('gif','jpg','jpeg','png'));
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Web-FTP Uploader with ProgressBar - Default renderer </title>
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
$renderer =& HTML_QuickForm::defaultRenderer();
$renderer->setFormTemplate('
	<table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#CCCC99">
	<form{attributes}>{content}
	</form>
	</table>
	');
$renderer->setHeaderTemplate('
	<tr>
	    <td style="white-space:nowrap;background:#996;color:#ffc;" align="left" colspan="2"><b>{header}</b></td>
	</tr>
	');
$uploader->accept($renderer);

// Display progress uploader dialog box
echo $renderer->toHtml();


if ($uploader->isStarted()) {
// Begin upload

    // declare files to upload    
    $uploader->setFiles(array(
        'splintercell.jpg',
        'd:/Mes Documents/Mes images/black hawk down/00010484.jpg',
        'monitor.html'       // NOTE: invalid file extension, won't be uploaded
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