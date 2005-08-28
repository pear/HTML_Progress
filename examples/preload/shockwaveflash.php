<?php
/**
 * An example of Listener usage with HTTP_Request and HTML_Progress.
 *
 * Credit: Alexey Borzov <avb@php.net>
 *         for his download-progress.php pattern in HTTP_Request package
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 * @subpackage Examples
 */

require_once 'HTTP/Request.php';
require_once 'HTTP/Request/Listener.php';
require_once 'HTML/Progress.php';

/**
 * @ignore
 */
class HTTP_Request_DownloadListener extends HTTP_Request_Listener
{
   /**
    * Handle for the target file
    * @var int
    */
    var $_fp;

   /**
    * ProgressBar intance used to display the indicator
    * @var object
    */
    var $_bar;

   /**
    * Name of the target file
    * @var string
    */
    var $_target;

   /**
    * Number of bytes received so far
    * @var int
    */
    var $_size = 0;

    function HTTP_Request_DownloadListener()
    {
        $this->HTTP_Request_Listener();
    }

   /**
    * Opens the target file
    * @param string Target file name
    * @throws PEAR_Error
    */
    function setTarget($target)
    {
        $this->_target = $target;
        $this->_fp = @fopen($target, 'wb');
        if (!$this->_fp) {
            PEAR::raiseError("Cannot open '{$target}'");
        }
    }

    function update(&$subject, $event, $data = null)
    {
        switch ($event) {
            case 'sentRequest':
                $this->_target = basename($subject->_url->path);
                break;

            case 'gotHeaders':
                if (isset($data['content-disposition']) &&
                    preg_match('/filename="([^"]+)"/', $data['content-disposition'], $matches)) {

                    $this->setTarget(basename($matches[1]));
                } else {
                    $this->setTarget($this->_target);
                }
                $this->_bar =& new HTML_Progress();
                $this->_bar->setAnimSpeed(10);
                $inc = isset($data['content-length'])? round($data['content-length'] / 100) : 1;
                $this->_bar->setIncrement(intval($inc));
                echo '<style type="text/css">'.$this->_bar->getStyle().'</style>';
                echo '<script type="text/javascript">'.$this->_bar->getScript().'</script>';
                echo $this->_bar->toHtml();
                $this->_size = 0;
                break;

            case 'tick':
                $this->_size += strlen($data);
                $this->_bar->display();
                $val = round($this->_size / $this->_bar->getIncrement());
                $this->_bar->setValue(intval($val));
                fwrite($this->_fp, $data);
                break;

            case 'gotBody':
                fclose($this->_fp);
                break;

            default:
                PEAR::raiseError("Unhandled event '{$event}'");
        } // switch
    }
}

$url = 'http://pear.laurent-laville.org/HTML_Progress/examples/viewlet/sw4p.swf';

$req =& new HTTP_Request($url);

$download =& new HTTP_Request_DownloadListener();
$req->attach($download);
$req->sendRequest(false);


$href = 'http://'.$_SERVER['SERVER_NAME']. dirname($_SERVER['PHP_SELF']) . '/sw4p.html';
$go = '<script type="text/javascript">window.location.href="'.$href.'";</script>';
echo $go;
?>