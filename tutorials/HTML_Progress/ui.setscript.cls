<refentry id="{@id}">
 <refnamediv>
  <refname>setScript Manual</refname>
  <refpurpose>defines the external JavaScript file to manage the progress bar</refpurpose>
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
  <para><emphasis>void</emphasis> <important>setScript</important>( $url )</para>
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
      <entry><emphasis>url</emphasis>&nbsp;</entry>
      <entry>file ressource          &nbsp;</entry>
      <entry>Null                    &nbsp;</entry>
     </row>
    </tbody>
    </tgroup>
   </table>
  </para>
  <para>
   <emphasis>$url</emphasis> is an URL that identify a JavaScript file target.
  </para>
 </refsect1>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>The <emphasis>setScript()</emphasis> method is used to identify an external JavaScript
   file, that will used to replace the default internal code, to manage the progress bar.
   If you have provided a custom javascript and want to revert to the built-in-behavior, 
   set the URL back to null.
  </para>
 </refsect1>
 <refsect1 id="{@id example}">
  <title>Example</title>
  <para>
   Example below will produced a horizontal progress bar custom cell contents.
   It's a dynamic example, the progress bar will run.
   <para><graphic fileref="../media/screenshots/bluesandplus.png"></graphic></para>
   <programlisting role="php">
   <![CDATA[
<?php
require_once ('HTML/Progress.php');

$bar = new HTML_Progress();
$bar->setIncrement(10);
$bar->setBorderPainted(true);

$ui =& $bar->getUI();
$ui->setCellAttributes(array(
	'active-color' => '#3874B4',
	'inactive-color' => '#EEEECC',
	'width' => 10
));
$ui->setBorderAttributes('width=1 color=navy');
$ui->setStringAttributes(array(
	'width' => 60,
	'font-size' => 14,
	'background-color' => '#EEEEEE',
	'align' => 'center'
));
$ui->setScript('progress.js');

foreach (range(0,2) as $index) {
    $ui->setCellAttributes('color=silver', $index);
}
foreach (range(3,6) as $index) {
    $ui->setCellAttributes('color=yellow', $index);
}
foreach (range(7,9) as $index) {
    $ui->setCellAttributes('color=orange', $index);
}

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
	background-color: #EEEEEE;
	color: #000000;
	font-family: Verdana, Arial;
}
// -->
</style>
<script type="text/javascript" src="<?php echo $ui->getScript(); ?>"></script>
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
  <para><title>JavaScript external code from file progress.js</title>
   <example>
   <![CDATA[
var isDom = document.getElementById?true:false;
var isIE  = document.all?true:false;
var isNS4 = document.layers?true:false;
var cellCount = 10;

function setprogress(pIdent, pValue, pString, pDeterminate)
{
        if (isDom)
            prog = document.getElementById(pIdent+'installationProgress');
        if (isIE)
            prog = document.all[pIdent+'installationProgress'];
        if (isNS4)
            prog = document.layers[pIdent+'installationProgress'];
	if (prog != null) 
	    prog.innerHTML = pString;

        if (pValue == pDeterminate) {
	    for (i=0; i < cellCount; i++) {
                showCell(i, pIdent, "hidden");	
            }
        }
        if ((pDeterminate > 0) && (pValue > 0)) {
            i = (pValue-1) % cellCount;
            showCell(i, pIdent, "visible");	
        } else {
            for (i=pValue-1; i >=0; i--) {
                showCell(i, pIdent, "visible");	
                if (isDom)
                    document.getElementById(pIdent+'progressCell'+i+'A').innerHTML = i;
                if (isIE)
                    document.all[pIdent+'progressCell'+i+'A'].innerHTML = i;
                if (isNS4)
                    document.layers[pIdent+'progressCell'+i+'A'].innerHTML = i;
            }
	}
}

function showCell(pCell, pIdent, pVisibility)
{
	if (isDom)
	    document.getElementById(pIdent+'progressCell'+pCell+'A').style.visibility = pVisibility;
	if (isIE)
	    document.all[pIdent+'progressCell'+pCell+'A'].style.visibility = pVisibility;
	if (isNS4)
	    document.layers[pIdent+'progressCell'+pCell+'A'].style.visibility = pVisibility;

}
   ]]>
   </example>
  </para>
 </refsect1>
 <refsect1 id="{@id seealso}">
  <title>See Also</title>
  <para>
   The {@link HTML_Progress_UI::getScript()} method is an easy way to build the default
   internal JavaScript code, that will manage the progress bar.
  </para>
 </refsect1>
</refentry>
