<refentry id="{@id}">
 <refnamediv>
  <refname>setCellAttributes Manual</refname>
  <refpurpose>defines look and feel of the progress bar cells</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setCellAttributes</important>( $attributes, $cell )</para>
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
        <listitem>id => progressCell%01s &nbsp;&nbsp;</listitem>
        <listitem>class => cell          &nbsp;&nbsp;</listitem>
        <listitem>spacing => 2           &nbsp;&nbsp;</listitem>
        <listitem>active-color => #006600      &nbsp;&nbsp;</listitem>
        <listitem>inactive-color => #CCCCCC    &nbsp;&nbsp;</listitem>
        <listitem>font-family => Courier, Verdana    &nbsp;&nbsp;</listitem>
        <listitem>font-size => 8         &nbsp;&nbsp;</listitem>
        <listitem>color => #000000       &nbsp;&nbsp;</listitem>
        <listitem>for horizontal bar:    &nbsp;&nbsp;</listitem>
        <itemizedlist>
         <listitem>width => 15           &nbsp;&nbsp;</listitem>
         <listitem>height => 20          &nbsp;&nbsp;</listitem>
        </itemizedlist>
        <listitem>for vertical bar:      &nbsp;&nbsp;</listitem>
        <itemizedlist>
         <listitem>width => 20           &nbsp;&nbsp;</listitem>
         <listitem>height => 15          &nbsp;&nbsp;</listitem>
        </itemizedlist>
       </itemizedlist>
      </entry>
     </row>
     <row>
      <entry><emphasis>cell</emphasis>&nbsp;</entry>
      <entry>integer                  &nbsp;</entry>
      <entry>null                     &nbsp;</entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
  <para>
   <emphasis>$attributes</emphasis> is an associative array or string of HTML tag attributes.
  </para>
  <para>
   <emphasis>$cell</emphasis> is an integer that allows to identify each cell, and properties
    to apply.
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>setCellAttributes()</emphasis> method is used to give a look and feel,
   such as spacing, size and color, to the progress bar cells.
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a progress bar with smaller cell. It's a dynamic example, 
   the progress bar will run.
   <para><graphic fileref="../media/screenshots/bluesand.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes('active-color=#3874B4 inactive-color=#EEEECC width=10');
$ui->setBorderAttributes('width=1 color=navy');
$ui->setStringAttributes('width=60 font-size=14 background-color=#EEEEEE align=center');

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
   To display a progress bar with more or less cells, see {@tutorial ui.setcellcount.cls} 
  </para>
 </refsect1>
</refentry>
