<?php   // listing-2.2.1.php
require_once 'HTML/QuickForm.php';

$form =& new HTML_QuickForm('installer', 'post', $_SERVER['PHP_SELF'], 'meter');

$form->addElement('header', null, 'Choose PEAR packages to download');

$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'Archive_Tar', null, 'Archive_Tar');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'Config', null, 'Config');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'HTML_QuickForm', null, 'HTML_QuickForm');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'HTML_CSS', null, 'HTML_CSS');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'HTML_Page', null, 'HTML_Page');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'HTML_Template_Sigma', null, 'HTML_Template_Sigma');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'Log', null, 'Log');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'MDB', null, 'MDB');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'PHPUnit', null, 'PHPUnit');
$form->addGroup($checkbox, 'packages', 'Packages:', '<br />');

$form->addElement('submit', 'submit', 'Download');

if ($form->validate()) {

    include_once 'listing-2.2.2.php';

    $packages = $form->exportValue('packages');
    $percent = 0;

    echo '<p><font face="Courier">';
    foreach ($packages as $pkg => $bool) {

        $msg = str_pad("Downloading package: $pkg", max(50,21+strlen($pkg)+4), '.');
        print $msg;
        /* Here you have to the job : download the package  */
        sleep(1);    // but as it's a tutorial we do nothing else than wait ...

        print " OK<br/>\n";

        $percent += intval(round(100 / count($packages)));
        $progress->setValue($percent);
        $progress->display();
    }
    echo '</font></p>';

    if ($percent < 100) {
        $progress->setValue(100);
        $progress->display();
    }

} else {
    $form->display();
}
?>