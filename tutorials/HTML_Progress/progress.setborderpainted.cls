<refentry id="{@id}">
 <refnamediv>
  <refname>setBorderPainted Manual</refname>
  <refpurpose>determines whether the progress bar should paint its border</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setBorderPainted</important>( $paint )</para>
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
      <entry><emphasis>paint</emphasis>&nbsp;</entry>
      <entry>boolean                   &nbsp;</entry>
      <entry>false | [ true ]          &nbsp;</entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>setBorderPainted()</emphasis> method is used to decide whether 
   the progress bar should paint its border or not. The default value is false: 
   progress bar without border.
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a progress bar with a solid red border. It's a static example, 
   the progress bar will not run.
   <para><graphic fileref="../media/screenshots/border1.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setBorderAttributes(array(
        'width' => 2,
        'style' => 'solid',
        'color' => 'red'
        ));

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
   Take care that <emphasis>setBorderPainted()</emphasis> method is not enough to display
   a border. You should also defines border attributes. To do it see
   {@tutorial ui.setborderattributes.cls}.
  </para>
 </refsect1>
</refentry>
