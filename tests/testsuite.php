<?php

/**
 * HTML output for PHPUnit suite tests.
 * 
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'TestUnit.php';
require_once 'HTML_TestListener.php';
require_once 'HTML/Progress.php';

$title = 'PhpUnit test run, HTML_Progress class';
?>
<html>
<head>
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="./stylesheet.css" type="text/css" />
</head>
<body>
<h1><?php echo $title; ?></h1>
      <p>
	This page runs all the phpUnit self-tests, and produces nice HTML output.
      </p>
      <p>
	Unlike typical test run, <strong>expect many test cases to
	  fail</strong>.  Exactly those with <code>pass</code> in their name
	should succeed.
      </p>
      <p>
      For each test we display both the test result -- <span
      class="Pass">ok</span>, <span class="Failure">FAIL</span>, or
      <span class="Error">ERROR</span> -- and also a meta-result --
      <span class="Expected">as expected</span>, <span
      class="Unexpected">UNEXPECTED</span>, or <span
      class="Unknown">unknown</span> -- that indicates whether the
      expected test result occurred.  Although many test results will
      be 'FAIL' here, all meta-results should be 'as expected', except
      for a few 'unknown' meta-results (because of errors) when running
      in PHP3.
      </p>
      
<h2>Tests</h2>
	<?php
	$testcases = array(
   	    'HTML_Progress_TestCase_DM',
    	    'HTML_Progress_TestCase_UI_setOrientation',
    	    'HTML_Progress_TestCase_UI_setFillWay',
    	    'HTML_Progress_TestCase_UI_setCellCount',
    	    'HTML_Progress_TestCase_UI_setCellAttributes',
    	    'HTML_Progress_TestCase_UI_setScript',
    	    'HTML_Progress_TestCase_setIndeterminate',
            'HTML_Progress_TestCase_setBorderPainted',
            'HTML_Progress_TestCase_setStringPainted',
            'HTML_Progress_TestCase_getString',
            'HTML_Progress_TestCase_getDM',
            'HTML_Progress_TestCase_setDM',
            'HTML_Progress_TestCase_getUI',
            'HTML_Progress_TestCase_setUI',
            'HTML_Progress_TestCase_addListener',
            'HTML_Progress_TestCase_removeListener'
	);

	
	$suite = new PHPUnit_TestSuite();

	foreach ($testcases as $testcase) {
    	    include_once $testcase . '.php';
            $suite->addTestSuite($testcase);
	}

	$listener = new HTML_TestListener();
        $result = TestUnit::run($suite, $listener);
	$result->removeListener($listener);
	$result->report();

	?>
</body>
</html>
