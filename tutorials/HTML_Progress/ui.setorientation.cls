<refentry id="{@id}">
 <refnamediv>
  <refname>setOrientation Manual</refname>
  <refpurpose>defines the orientation of the progress bar</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setOrientation</important>( $orient )</para>
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
      <entry><emphasis>orient</emphasis>&nbsp;</entry>
      <entry>integer                    &nbsp;</entry>
      <entry>HTML_PROGRESS_BAR_HORIZONTAL | [ HTML_PROGRESS_BAR_VERTICAL ]&nbsp;</entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
  <para>
   <emphasis>$orient</emphasis> is an integer with identify, actually in version 1.0, only 2 shapes,
   Horizontal and Vertical Progress Bars.
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>setOrientation()</emphasis> method is used to change orientation
   of the progress bar after you invoked the constructor. For example, you can swap from a
   horizontal progress bar to a vertical one, by only one call such as: 
   <emphasis>setOrientation(HTML_PROGRESS_BAR_VERTICAL)</emphasis>.
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a vertical progress bar with only 6 cells.
   It's a dynamic example, the progress bar will run.
   <para><graphic fileref="../media/screenshots/vertical1.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIdent('PB1');
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setOrientation(HTML_PROGRESS_BAR_VERTICAL);
$ui->setFillWay('natural');
$ui->setCellCount(6);
$ui->setCellAttributes(array(
	'active-color' => '#970038',
	'inactive-color' => '#FFDDAA',
	'width' => 50,
	'height' => 13
));
$ui->setBorderAttributes('width=1');
$ui->setStringAttributes(array(
	'font-size' => 8,
	'color' => '#FF0000',
	'background-color' => '#C3C6C3',
	'align' => 'center', 
	'valign' => 'bottom'
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
	background-color: #C3C6C3;
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
   To display a progress bar filled in reverse order, have a look on {@tutorial ui.setfillway.cls} 
  </para>
 </refsect1>
</refentry>
