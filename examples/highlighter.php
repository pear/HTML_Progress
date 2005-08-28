<style>
.hl-main {font-family: monospace; font-size:13px;}
.hl-gutter { background-color: #CCCCCC; padding-right: 10px;
             font-family: monospace; font-size:13px;}
.hl-table {border: solid 1px #000000; }
.hl-default { color: #000000; }
.hl-code { color: #7f7f33; }
.hl-brackets { color: #009966; }
.hl-comment { color: #7F7F7F; }
.hl-quotes { color: #00007F; }
.hl-string { color: #7F0000; }
.hl-identifier { color: #000000; }
.hl-reserved { color: #7F007F; }
.hl-inlinedoc { color: #0000FF; }
.hl-var { color: #0066FF; }
.hl-url { color: #FF0000; }
.hl-special { color: #0000FF; }
.hl-number { color: #007F00; }
.hl-inlinetags { color: #FF0000; }
</style>

<?php
$ok = false;
if (isset($_GET['file'])) {
    $file = trim($_GET['file']);
    if ((stristr($file, '../') == false) &&
        (substr($file, 0,2) == './') && (file_exists($file))) {
        $ok = true;
    }
}

if (!$ok) {
    die ("<b>this syntax is forbidden</b>");

} else {
    @include_once 'include_path.php';
    include_once 'Text/Highlighter.php';

    $hl =& Text_Highlighter::factory('PHP',array('numbers'=>HL_NUMBERS_TABLE));
    $code = file_get_contents($_GET['file']);
    $html = $hl->highlight($code);

    echo $html;
}
?>