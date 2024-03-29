<refentry id="{@id}">
 <refnamediv>
  <refname>setFillWay Manual</refname>
  <refpurpose>decides how the progress bar will be filled</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setFillWay</important>( $way )</para>
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
      <entry><emphasis>way</emphasis>&nbsp;</entry>
      <entry>string                  &nbsp;</entry>
      <entry>natural | [ reverse ]   &nbsp;</entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>setFillWay()</emphasis> method is used to change the fill way
   of the progress bar.
   It could be <emphasis>natural</emphasis> (left to right for horizontal progress bar),
   (down to up for vertical progress bar) or <emphasis>reverse</emphasis> 
   (right to left for horizontal progress bar), (up to down for vertical progress bar).
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a vertical progress bar with only 5 cells filled in reverse order.
   It's a dynamic example, the progress bar will run.
   <para><graphic fileref="../media/screenshots/vertical2.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress(HTML_PROGRESS_BAR_VERTICAL);
$bar->setIdent('PB1');
$bar->setIncrement(10);

$ui =& $bar->getUI();
$ui->setComment('Reverse ProgressBar example');
$ui->setTabOffset(1);
$ui->setFillWay('reverse');
$ui->setCellCount(5);
$ui->setProgressAttributes(array(
	'background-color' => '#e0e0e0'
));        
$ui->setStringAttributes(array(
	'valign' => 'left',
	'color'  => 'red',
	'background-color' => 'lightblue'
	));

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Progress example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: lightblue;
	color: #000000;
	font-family: Verdana, Arial;
}
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

do {
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
   To display a vertical progress bar, see {@tutorial ui.setorientation.cls} 
  </para>
 </refsect1>
</refentry>
