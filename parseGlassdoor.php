<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include_once 'simple_html_dom.php';
include_once 'class.parseGlassdoor.php';

$parseGlassdoor = new ParseGlassdoor();
$html = new simple_html_dom();
$isHeaderRequired = true;
/*
 * loop over all the downloaded company pages and 
 * print the values in csv file
 */
if($handle = opendir('./public/companyPages/')){
	while (false !== ($file = readdir($handle))) {
		// Skip '.' and '..'
		if( $file == '.' || $file == '..')
			continue;
		
		$html->load_file("./public/companyPages/".$file);
		$parseGlassdoor->getOverallRating($html);
		$parseGlassdoor->getAditionalInfo($html);
		$parseGlassdoor->getRatings($html);
		$parseGlassdoor->getStars($html);
		
		// print to csv
		if($isHeaderRequired){
			$parseGlassdoor->printToCSVFile($parseGlassdoor->getKeysArray());
			// headers in csv/excel should be printed only once
			$isHeaderRequired = false;
		}
		$parseGlassdoor->printToCSVFile($parseGlassdoor->getValuesArray());
		$parseGlassdoor->resetArrays();
	}
}
$parseGlassdoor->closeOpenConnections();
closedir($handle);

// inform user that all the required data has been fetched
$message = "Parsing Complete!!";
echo "<script type='text/javascript'>alert('$message');</script>";

