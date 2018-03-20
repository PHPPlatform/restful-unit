<?php

// this package is installed at vendor/php-platform/restful-unit
$packageRootDir = dirname(__FILE__).'/../../../..';

// include autoload.php from vendor directory
include_once $packageRootDir.'/vendor/autoload.php';

// delete coverage.xml if present
$coverageFile = $packageRootDir.'/coverage.xml';
if(is_file($coverageFile)){
	unlink($coverageFile);
}

// copy resources/.htaccess and resources/index.php to root of the package
$restfulRootDir = $packageRootDir.'/vendor/php-platform/restful/';

copy($restfulRootDir.'/resources/.htaccess',$packageRootDir.'/.htaccess');
$index = file_get_contents($restfulRootDir.'/resources/index.php');

if(defined('APP_COVERAGE') && APP_COVERAGE == "true"){
	// concat index.inc and resources/index.php and copy to {package_root}/index.php
	$__indexFixture = file_get_contents(dirname(__FILE__).'/index.inc');
	
	// get a temp directory to store coverage files for each request testcase / service request in this run
	$coverageDir = sys_get_temp_dir().'/php-platform/restful-unit/test-coverage/'.microtime(true);
	mkdir($coverageDir,0777,true);
	chmod($coverageDir, 0777);
	
	$__indexFixture = str_replace('COVERAGE_DIR', "'$coverageDir'", $__indexFixture);
	$index = $__indexFixture.$index;
	
	// generate the coverage for unit tests other than rest-services in the same run 
	$filter = new \PHP_CodeCoverage_Filter();
	$filter->addDirectoryToWhitelist($packageRootDir.'/src');
	$nonRestfulcoverage = new \PHP_CodeCoverage(null,$filter);
	$nonRestfulcoverage->start('testPhpPlatformNonRestful');
	
	register_shutdown_function(function () use($coverageDir,$nonRestfulcoverage){
		// aggregate the coverage reports
		$coverageFiles = array_diff(scandir($coverageDir),array('.','..'));
		
		$phpCodeCoverage = new PHP_CodeCoverage();
		
		foreach ($coverageFiles as $coverageFile){
			$coverage = include $coverageDir.'/'.$coverageFile;
			$phpCodeCoverage->merge($coverage);
		}
		
		$nonRestfulcoverage->stop();
		$phpCodeCoverage->merge($nonRestfulcoverage);
		
		$writer = new PHP_CodeCoverage_Report_Clover();
		$writer->process($phpCodeCoverage, 'coverage.xml');
		
	});
}

file_put_contents($packageRootDir.'/index.php', $index);

//php-platform/restful/config.json is rewritten during tests
// so revert the config.json changes after the tests
$tmpConfigfile = tempnam(sys_get_temp_dir(), "qgfd");
copy($restfulRootDir.'/config.json', $tmpConfigfile);

register_shutdown_function(function() use($tmpConfigfile,$restfulRootDir){
	copy($tmpConfigfile, $restfulRootDir.'/config.json');
});