<refentry id="{@id}">
 <refnamediv>
  <refname>getStringAttributes Manual</refname>
  <refpurpose>returns attributes list of the progress bar string</refpurpose>
 </refnamediv>
 <refsynopsisdiv>
  <refsynopsisdivinfo>
   <author>
    by Laurent Laville
    <authorblurb>{@link mailto:pear@laurent-laville.org}</authorblurb>
   </author>
   <copyright>February 2004, Laurent Laville</copyright>
   <releaseinfo>HTML_Progress 1.0+</releaseinfo>
  </refsynopsisdivinfo>
 </refsynopsisdiv>
 <refsect1 id="{@id synopsis}">
  <title>Synopsis</title>
  <para><emphasis>mixed</emphasis> <important>getStringAttributes</important>( $asString )</para>
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
      <entry><emphasis>asString</emphasis>&nbsp;</entry>
      <entry>boolean                      &nbsp;</entry>
      <entry>false | [ true ]             &nbsp;</entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>getStringAttributes()</emphasis> method is used to retrieve attributes
   of a progress bar string. Ouput could be an array or a string.
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will show you the attributes definition of a progress bar string in two formats:
   array (default) and string.
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();

$ui =& $bar->getUI();

print '<pre>';
var_dump($ui->getStringAttributes());         // see output 1.
var_dump($ui->getStringAttributes(true));     // see output 2.
print '</pre>';
?>
   ]]>
   </programlisting>
   <para>Output 1.</para>
   <example>
   <![CDATA[
array(8) {
  ["id"]=>
  string(20) "installationProgress"
  ["width"]=>
  int(50)
  ["font-family"]=>
  string(37) "Verdana, Arial, Helvetica, sans-serif"
  ["font-size"]=>
  int(12)
  ["color"]=>
  string(7) "#000000"
  ["background-color"]=>
  string(7) "#FFFFFF"
  ["align"]=>
  string(5) "right"
  ["valign"]=>
  string(5) "right"
}
   ]]>
   </example>
   <para>Output 2.</para>
   <example>
   <![CDATA[
string(176) " id="installationProgress" width="50" font-family="Verdana, Arial, Helvetica, sans-serif" font-size="12" color="#000000" background-color="#FFFFFF" align="right" valign="right""
   ]]>
   </example>
  </para>
 </refsect1>
 <refsect1 id="{@id seealso}">
  <title>See Also</title>
  <para>
   To set progress bar string attributes, read the {@tutorial ui.setstringattributes.cls}.
  </para>
 </refsect1>
</refentry>
