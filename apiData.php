<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

try {
	
	require_once 'class.APIData.php';
	require_once 'class.common.php';
	
	$apiData = new APIData();

	// file pointer of the output CSV file.
	$fp = $apiData->getCSV();
	// file pointer of the API Response status log file
	$apiStatusLogFile = $apiData->getApiResponseFile();
	// file pointer of the API Filter Format file
	$apiFilterFormatFile = $apiData->getFilterFormatFile();

	//get the partnerId, key and IP
	$ip = $apiData->getIP();
	$key = $apiData->getPartnerKey();
	$partnerID = $apiData->getPartnerID();

	// read the list of companies for which data must be collected
	$companyList = array_values(file("editableFiles/company list.txt"));

	// read the filters file. Filter file contains the list of headings which must be extracted from the API response.
	$filters = $apiData->readFilterIniFile();

	// print the column headers into file
	$apiData->printOutputHeadings($fp,$filters);


	foreach ($companyList as $companyName){
		// remove, if any, whitespaces present in the beginning and/or end of company name,
		$companyName = trim($companyName);
		// if company name contains a space in between, encode it.
		$companyName = str_replace(" ","%20",$companyName);
		// make the API call
		$response = $apiData->callAPI($partnerID, $key, $companyName, $ip);
		if(!empty($response)){
			// log for the API response status v/s the corresponding API call(i.e. company name)
			$apiData->logApiResponseStatus($apiStatusLogFile, $companyName, $response["status"],$response["response"]["totalRecordCount"]);
			// parse the response into desired format and output it to the CSV file
			$data = $apiData->parseData($response,null,$fp,$filters,$apiFilterFormatFile);
			// call to print the last result
			$apiData->printToCSVFile($fp);
			// remove values from output array before next run
			$apiData->removeValuesFromOutputArray($filters);
		} else {
			// log for the API response status i.e. no response was received.
			$apiData->logApiResponseStatus($apiStatusLogFile, $companyName, "Response was empty");
		}
	}
	// inform user that all the required data has been fetched
	$message = "Data has been Fetched!!";
	echo "<script type='text/javascript'>alert('$message');</script>";
} catch (Exception $e) {
	error_log($e->getMessage(),3,"/var/tmp/error.log");
	error_log("\n");
}
?>