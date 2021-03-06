<?php

// this file is prepended to the index.php and copied to root of the package
require_once dirname(__FILE__).'/vendor/autoload.php';

$filter = new \PHP_CodeCoverage_Filter();
$filter->addDirectoryToWhitelist(dirname(__FILE__).'/src');

$coverage = new \PHP_CodeCoverage(null,$filter);
$coverage->start('testPhpPlatformRestful');

register_shutdown_function(function () use ($coverage){
	$coverage->stop();
	
	$writer = new \PHP_CodeCoverage_Report_PHP();
	
	$coverageFileName = md5($_SERVER['REQUEST_URI'].microtime()).'.php';
	
	// COVERAGE_DIR to be replaced by a new temp direcory for every run
	$writer->process($coverage, COVERAGE_DIR.'/'.$coverageFileName);
});

?>