<refentry id="{@id}">
 <refnamediv>
  <refname>setBorderAttributes Manual</refname>
  <refpurpose>defines look and feel of the progress bar border</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setBorderAttributes</important>( $attributes )</para>
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
        <listitem>class => progressBarBorder  &nbsp;&nbsp;</listitem>
        <listitem>width => 0                  &nbsp;&nbsp;</listitem>
        <listitem>style => solid (dashed, dotted, inset, outset)  &nbsp;&nbsp;</listitem>
        <listitem>color => #000000            &nbsp;&nbsp;</listitem>
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
  <para>The <emphasis>setBorderAttributes()</emphasis> method is used to give a look and feel,
   such as size, style and color, to the progress bar border.
  </para>
  <para>
  <tip><title></title>
   You may also used an existing StyleSheet and a CSS class-selector with pre-defined style.
   For example:
   <para>
   <programlisting role="php">
   <![CDATA[
<?php
...
// specify a user-ident (instead of the auto-generated value)
$bar->setIdent('PB1');  
...
$ui =& $bar->getUI();
$ui->setBorderAttributes('class="myProgressBorder"');
...
?>
   ]]>
   </programlisting>
   <example>
   <![CDATA[
<!-- custom stylesheet -->
...
.PB1 .myProgressBar { border: 3px dotted #0000FF; }
...
   ]]>
   </example>
   </para>
   <para><graphic fileref="../media/screenshots/border3.png"></graphic></para>
  </tip>
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a progress bar with a solid navy border. It's a static example, 
   the progress bar will not run.
   <para><graphic fileref="../media/screenshots/border2.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes('active-color=#3874B4 inactive-color=#EEEECC width=10');
$ui->setBorderAttributes('width=1 color=navy');
$ui->setStringAttributes('width=60 font-size=14 background-color=#EEEEEE');

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>ProgressBar </title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>
// -->
</style>
<body>

<?php echo $bar->toHtml(); ?>

</body>
</html>
   ]]>
   </programlisting>
  </para>
 </refsect1>
 <refsect1 id="{@id seealso}">
  <title>See Also</title>
  <para>
   To display the progress bar border, take care that {@tutorial progress.setborderpainted.cls} 
   method was also invoked.
  </para>
 </refsect1>
</refentry>
