<refentry id="{@id}">
 <refnamediv>
  <refname>setProgressAttributes Manual</refname>
  <refpurpose>defines look and feel of the core of progress bar</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setProgressAttributes</important>( $attributes )</para>
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
      <entry><emphasis>attributes</emphasis>&nbsp;</entry>
      <entry>array                 &nbsp;</entry>
      <entry>
       <itemizedlist>
        <listitem>class => progressBar   &nbsp;&nbsp;</listitem>
        <listitem>background-color => #FFFFFF            &nbsp;&nbsp;</listitem>
        <listitem>auto-size => true | [ false ]          &nbsp;&nbsp;</listitem>
        <listitem>width           &nbsp;&nbsp;</listitem>
        <listitem>height          &nbsp;&nbsp;</listitem>
       </itemizedlist>
      </entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
  <para>
   <emphasis>$attributes</emphasis> is an associative array or string of HTML tag attributes.
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>setProgressAttributes()</emphasis> method is used to give a look and feel,
   such as size and color, to the core of progress bar.
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a plain progress bar. It's a dynamic example, the progress bar
   will run.
   <para><graphic fileref="../media/screenshots/bullit.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes(array(
	'active-color' => '#000084',
	'inactive-color' => '#3A6EA5',
	'width' => 20,
	'spacing' => 0
));
$ui->setBorderAttributes('width=1 style=inset color=white');
$ui->setStringAttributes(array(
	'width' => 200,
	'height' => 20,
	'font-size' => 14,
	'background-color' => '#C3C6C3',
	'valign' => 'top'
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
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $ui->getScript(); ?>
//-->
</script>
</head>
<body bgcolor="#C3C6C3">

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
   To build a plain bar the cell spacing should be set to zero. To do it,
   see {@tutorial ui.setcellattributes.cls} 
  </para>
 </refsect1>
</refentry>
