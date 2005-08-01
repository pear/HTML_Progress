<?php
/**
 * Make package.xml and GNU TAR archive files for HTML_Progress2 class
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'PEAR/Packager.php';
require_once 'PEAR/PackageFileManager.php';

function handleError($e) {

    if (PEAR::isError($e)) {
        die($e->getMessage());
    }
}

// Full description of the package
$description = <<<DESCR
This package provides a way to add a loading bar fully customizable in existing XHTML documents.
Your browser should accept DHTML feature.

Features:
- create horizontal, vertival bar and also circle, ellipse and polygons (square, rectangle).
- allows usage of existing external StyleSheet and/or JavaScript.
- all elements (progress, cells, labels) are customizable by their html properties.
- percent/labels are floating all around the progress meter.
- compliant with all CSS/XHMTL standards.
- integration with all template engines is very easy.
- implements Observer design pattern. It is possible to add Listeners.
- adds a customizable monitor pattern to display a progress bar.
  User-end can abort progress at any time.
- Look and feel can be sets by internal API or external config file
- allows many progress meter on same page without uses of iframe solution.
DESCR;

// Summary of description of the package
$summary = 'How to include a loading bar in your XHTML documents quickly and easily.';

// New version and state of the package
$version = '1.2.2';
$state   = 'stable';

// Notes about this new release
$notes = <<<NOTE
* bugs
- fixed setMaximum with value higher than 200 when using a progress monitor (bug #4885)
- fixed call time pass by reference error in progress monitor

* changes
- getPercentComplete() method has an optional parameter.
  Return may be float (default) or integer.
- removed HTML_CSS dependency

* improvements
- generation of stylesheet is (average) 20 times faster without HTML_CSS

* QA
- Updates headers comment block on all files
- Dependencies has been revisited to higher level
- Fix wrong project links into documentation (README, ReleaseVersion)
  Thanks to Christian Roy to have noticed me.

NOTE;

// Configuration of PEAR::PackageFileManager
$options = array(
    'package'           => 'HTML_Progress',
    'summary'           => $summary,
    'description'       => $description,
    'license'           => 'PHP License 3.0',
    'baseinstalldir'    => 'HTML',
    'version'           => $version,
    'packagedirectory'  => '.',
    'dir_roles'         => array('docs' => 'doc',
                                 'examples' => 'doc',
                                 'tests' => 'test',
                                 'Progress' => 'php',
                                ),
    'state'             => $state,
    'filelistgenerator' => 'cvs',
    'changelogoldtonew' => false,
//    'simpleoutput'      => true,       // see bug#4604
    'notes'             => $notes,
    'ignore'            => array('package.xml', 'package.php',
                                 'examples.xml', 'examples.php',
                                 'Thumbs.db',
                                 'cache/',
                                 'Error/'
                                ),
    'cleardependencies' => true
);


$pkg = new PEAR_PackageFileManager();

$e = $pkg->setOptions( $options );
handleError($e);

// Replaces version number only in necessary files
$phpfiles = array(
    'Progress.php',
    'Progress/monitor.php',
    'Progress/observer.php',
    'Progress/generator.php',
    'Progress/generator/default.php',
    'Progress/generator/HTMLPage.php',
    'Progress/generator/ITDynamic.php',
    'Progress/generator/pages.php',
    'Progress/generator/preview.php',
    'Progress/generator/process.php',
    'Progress/generator/SmartyDynamic.php'
);
foreach ($phpfiles as $file) {
    $e = $pkg->addReplacement($file, 'package-info', '@package_version@', 'version');
    handleError($e);
}
// Maintainers List
$e = $pkg->addMaintainer( 'farell', 'lead', 'Laurent Laville', 'pear@laurent-laville.org' );
handleError($e);

// Dependencies List
$e = $pkg->addDependency('PHP', '4.2.0', 'ge', 'php');
handleError($e);
$e = $pkg->addDependency('HTML_Common', '1.2.1', 'ge', 'pkg', false);
handleError($e);
$e = $pkg->addDependency('PEAR', '1.3.5', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_QuickForm', '3.2.4', 'gt', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_QuickForm_Controller', '1.0.4', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('Image_Color', '1.0.1', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_Page2', '0.5.0', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_Template_IT', '1.1', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('HTML_Template_Sigma', '1.1.2', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('Log', '1.8.7', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('Config', '1.10', 'ge', 'pkg', true);
handleError($e);
$e = $pkg->addDependency('gd', false, 'has', 'ext', true);
handleError($e);

// Writes the new version of package.xml
if (isset($_GET['make'])) {
    $e = @$pkg->writePackageFile();
} else {
    $e = @$pkg->debugPackageFile();
}
handleError($e);

// Build the new binary package
if (!isset($_GET['make'])) {
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?make=1">Make this XML file</a>';
} else {
    $options = $pkg->getOptions();
    $pkgfile = $options['packagedirectory'] . DIRECTORY_SEPARATOR . $options['packagefile'];

    $pkgbin = new PEAR_Packager();

    $e = $pkgbin->package($pkgfile);
    handleError($e);
}
?>