<?php
// error reporting. Should be turned off once site is live.
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once 'class.common.php';

// if request is made to fetch data using API call 
if(isset($_POST["apiBtn"])){
    ini_set('max_execution_time', 0);
	require_once 'apiData.php';
}

// if request is made to goto Edit Page in-order to make changes in the files.
if (isset($_POST["editPageBtn"])) {
	require_once "edit.php";
	exit;
}

// if user wants to download the results of API call into a file
if (isset($_POST["downloadAPIBtn"])) {
	$commonObj = new Common();
	$commonObj->downloadFile("output/filteredApiOutput.csv","Filtered_API_Output.csv");
}

// if user wants to download the results of API call into a file
if (isset($_POST["downloadAPIResponseBtn"])) {
	$commonObj = new Common();
	$commonObj->downloadFile("output/API Response Status.txt","API_Response_Status.txt");
}

// if user wants to download the file containing the format of the filters
if (isset($_POST["downloadFilterFormatBtn"])) {
	$commonObj = new Common();
	$commonObj->downloadFile("output/ApiFilterFormat.txt","API_Filter_Format.txt");
}

// TODO
// if user wants to download the file containing the format of the filters
if (isset($_POST["downloadSeleniumBtn"])) {
//	$commonObj = new Common();
//	$commonObj->downloadFile("output/ApiFilterFormat.txt","API_Filter_Format.txt");
    $seconds=ini_get('max_execution_time'); 
    
    set_time_limit(-1);// setting it for up to 2 hours..
    exec('java -jar  proj1.jar'); 
    set_time_limit(30);// setting it back to 30 seconds(php default)
    echo "<script type='text/javascript'>alert('Downloading of web pages complete!');</script>";
        // shell_exec("java -jar ");
}
// if user wants to download the file containing the format of the filters
// TODO
if (isset($_POST["parseSeleniumOutput"])) {
//	$commonObj = new Common();
//	$commonObj->downloadFile("output/ApiFilterFormat.txt","API_Filter_Format.txt");
}
// call the parseGlssdoorputput File
if (isset($_POST["parseGlassdoorOutput"])) {
//	$commonObj = new Common();
        require_once "parseGlassdoor.php";
    
}

if (isset($_POST["downloadGlassdoorOutput"])) {
        $commonObj = new Common();
        $commonObj->downloadFile("output/glassdoorOutput.csv", "Glassdoor_Output.csv");
}
if (isset($_POST["callCrunchbase"])) {
require_once "crunchbase.php";
    //require_once "class.crunchbase.php";
}

if(isset($_POST['downloadCrunchbaseAcquisitions'])){
    
    $commonObj = new Common();
    $commonObj->downloadFile("output/crunchBase/acquisitions.csv", "acquisitions.csv");
 
}

if(isset($_POST['downloadCrunchbaseFundingRounds'])){
    
    $commonObj = new Common();
    $commonObj->downloadFile("output/crunchBase/fundingRound.csv", "fundingRound.csv");
 
}

if(isset($_POST['downloadCrunchbaseFunds'])){
    
    $commonObj = new Common();
    $commonObj->downloadFile("output/crunchBase/funds.csv", "funds.csv");
 
}
if(isset($_POST['downloadCrunchbaseInvestments'])){
    
    $commonObj = new Common();
    $commonObj->downloadFile("output/crunchBase/investment.csv", "investment.csv");
 
}

if(isset($_POST['downloadCrunchbaseIPO'])){
    
    $commonObj = new Common();
    $commonObj->downloadFile("output/crunchBase/ipo.csv", "ipo.csv");
 
}

if(isset($_POST['downloadCrunchbaseOrganizationData'])){
    
    $commonObj = new Common();
    $commonObj->downloadFile("output/crunchBase/organization.csv", "organization.csv");
 
}
require_once 'views/mainView.php';


?>