<refentry id="{@id}">
 <refnamediv>
  <refname>setString Manual</refname>
  <refpurpose>sets the current value of the progress string</refpurpose>
 </refnamediv>
 <refsynopsisdiv>
  <refsynopsisdivinfo>
   <author>
    by Laurent Laville
    <authorblurb>{@link mailto:pear@laurent-laville.org}</authorblurb>
   </author>
   <copyright>November 2003, Laurent Laville</copyright>
   <releaseinfo>HTML_Progress 1.0+</releaseinfo>
  </refsynopsisdivinfo>
 </refsynopsisdiv>
 <refsect1 id="{@id synopsis}">
  <title>Synopsis</title>
  <para><emphasis>void</emphasis> <important>setString</important>( $str )</para>
 </refsect1>
 <refsect1 id="{@id attributes}">
  <title>Attributes</title>
  <para>
   <table frame="all">
    <tgroup cols="3">
    <thead align="center">
      <row>
       <entry><important>Name</important></entry>
       <entry><important>Type</important></entry>
       <entry><important>Default</important></entry>
      </row>
    </thead>
    <tbody>
     <row>
      <entry><emphasis>str</emphasis>&nbsp;</entry>
      <entry>string                  &nbsp;</entry>
      <entry>Null                    &nbsp;</entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>setString()</emphasis> method is used to print a custom string.
   The default value is null, that means the progress bar displays the value returned by 
   {@link HTML_Progress::getPercentComplete()} method formatted as a percent such as 33%.
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a progress bar with a custom string. It's a dynamic example, 
   the progress bar will run.
   <para><graphic fileref="../media/screenshots/string.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php 
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIncrement(5);
$bar->setStringPainted(true);          // get space for the string
$bar->setString('');                   // but don't paint it

$ui =& $bar->getUI();
$ui->setStringAttributes('width=350 align=left');

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Horizontal String ProgressBar example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $ui->getScript(); ?>
//-->
</script>
</head>
<body>

<?php 
echo $bar->toHtml(); 

$pkg = array('PEAR', 'Archive_Tar', 'Config', 
    'HTML_QuickForm', 'HTML_CSS', 'HTML_Page', 'HTML_Template_Sigma', 
    'Log', 'MDB', 'PHPUnit');

do {
    $val = $bar->getValue();
    $i = floor($val / 10);
    $msg = ($val == 100) ? '' : "&nbsp; installing package ($val %) ... : ".$pkg[$i];
    $bar->setString($msg);

    $bar->display();
    if ($bar->getPercentComplete() == 1) {
        break;   // the progress bar has reached 100%
    }
    $bar->incValue();
} while(1);
?>

</body>
</html>
   ]]>
   </programlisting>
  </para>
 </refsect1>
 <refsect1 id="{@id seealso}">
  <title>See Also</title>
  <para>
   Take care that <emphasis>setString()</emphasis> method is not enough to display
   a custom string. You should also decide to paint the custom string. To do it, see 
   {@tutorial progress.setstringpainted.cls}.
  </para>
 </refsect1>
</refentry>
