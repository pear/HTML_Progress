<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>PEAR::HTML_Progress - Generator </title>
<meta name="author" content="Laurent Laville" />
<style type="text/css">
{literal}
body {
    background-color: #444444;
    font-family:      Verdana, Arial, helvetica;
    font-size:        10pt;
}
h1 {
    color:            #FFC;
    text-align:       center;
}
.maintable {
    width:            100%;
    border-width:     0;
    border-style:     thin dashed;
    border-color:     #D0D0D0;
    background-color: #EEE;
    cellspacing:      2;
    cellspadding:     3;
}
.header {
    text-align:       center;
    color:            #FFC;
    background-color: #AAA;
    white-space:      nowrap;
}
input {
    font-family:      Verdana, Arial, helvetica;
}
input.flat {
    border-style:     solid;
    border-width:     2px 2px 0 2px;
    border-color:     #996;
}
span.qfError {
    color:            #FF0000;
}
span.qfLabel {
    font-weight:      bold;
}
{/literal}

{$qf_style}
</style>

{if $qf_script}
<script type="text/javascript">
<!--
{$qf_script}
//-->
</script>
{/if}
</head>
<body>

{if $form.javascript}
    {$form.javascript}
</script>
{/if}

<table class="maintable">
    <form{$form.attributes}>{$form.hidden}

    {foreach item=sec key=i from=$form.sections}
        <tr>
            <td class="header" colspan="2">
            <b>{$sec.header}</b></td>
        </tr>

        {foreach item=element from=$sec.elements}

            <!-- submit or reset button (don't display on frozen forms) -->
            {if $element.type eq "submit" or $element.type eq "reset"}
                {if not $form.frozen}
                <tr>
                    <td>&nbsp;</td>
                    <td align="left">{$element.html}</td>
                </tr>
                {/if}

            <!-- normal elements -->
            {else}
                <tr>
                    <td align="right" valign="top">
                        <b>{$element.label}</b>
                    <td>

                    {if $element.error}<span class="qfError">{$element.error}</span><br />{/if}
                    {if $element.type eq "group"}
                        {foreach key=gkey item=gitem from=$element.elements}
                            {$gitem.label}
                            {$gitem.html}
                            {if $element.separator}{cycle values=$element.separator}{/if}
                        {/foreach}
                    {else}
                        {$element.html}
                    {/if}
                    </td>
                </tr>

            {/if}
        {/foreach}
    {/foreach}

    </form>
</table>

<p>
{foreach key=name item=error from=$form.errors}
    <span class="qfError">{$error}</span> in element [{$name}]<br />
{/foreach}
</p>

</body>
</html>