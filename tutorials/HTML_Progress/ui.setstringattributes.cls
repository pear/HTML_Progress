<refentry id="{@id}">
 <refnamediv>
  <refname>setStringAttributes Manual</refname>
  <refpurpose>defines look and feel of the progress bar string</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setStringAttributes</important>( $attributes )</para>
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
        <listitem>id => installationProgress  &nbsp;&nbsp;</listitem>
        <listitem>width => 50                 &nbsp;&nbsp;</listitem>
        <listitem>font-family => Verdana, Arial, Helvetica, sans-serif &nbsp;&nbsp;</listitem>
        <listitem>font-size => 12             &nbsp;&nbsp;</listitem>
        <listitem>color => #000000            &nbsp;&nbsp;</listitem>
        <listitem>background-color => #FFFFFF &nbsp;&nbsp;</listitem>
        <listitem>align => right ( left, center ) &nbsp;&nbsp;</listitem>
        <listitem>for horizontal bar:         &nbsp;&nbsp;</listitem>
        <itemizedlist>
         <listitem>valign => right (left, top, bottom)    &nbsp;&nbsp;</listitem>
        </itemizedlist>
        <listitem>for vertical bar:           &nbsp;&nbsp;</listitem>
        <itemizedlist>
         <listitem>valign => bottom (top, left, right)    &nbsp;&nbsp;</listitem>
        </itemizedlist>
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
  <para>The <emphasis>setStringAttributes()</emphasis> method is used to give a look and feel,
   such as alignment, size and color, to the progress bar string.
  </para>
  <para>
  <tip><title></title>
   You may also used an existing StyleSheet and a CSS id with pre-defined style.
   For example:
   <para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
// specify a user-ident (instead of the auto-generated value)
$bar->setIdent('myPB');
$bar->setStringPainted(true);

$ui =& $bar->getUI();
$ui->setStringAttributes('id="myPBstring"');
...
?>
   ]]>
   </programlisting>
   <example>
   <![CDATA[
<!-- custom stylesheet -->
...
.myPB .myPBstring { width: 100px; background-color: lightyellow; color: black; }
...
   ]]>
   </example>
   </para>
   <para><graphic fileref="../media/screenshots/string1.png"></graphic></para>
  </tip>
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a progress bar with a custom style string. It's a static example, 
   the progress bar will not run.
   <para><graphic fileref="../media/screenshots/redsandback.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setValue(50);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setFillWay('reverse');
$ui->setCellCount(5);
$ui->setCellAttributes('active-color=#970038 inactive-color=#FFDDAA width=20');
$ui->setBorderAttributes('width=1 color=#000000');
$ui->setStringAttributes('font-size=14 color=#FF0000 align=left valign=bottom');

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
$bar->display();
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
   To display the progress bar string, take care that method in {@tutorial progress.setstringpainted.cls} 
   was also invoked.
  </para>
 </refsect1>
</refentry>
