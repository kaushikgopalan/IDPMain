<?php
// class that contains functions that help in fetching data using API call

class APIData {
	// initialize class variables
	private $keyPrefix;
	private $filteredOutput = array();
	private $allowToPrintFilterId = false;

	// function to read the company list from the file
	public function readCompanyList($path){
		try {
			return array_values($path);
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function to read the "filters" file
	public function readFilterIniFile(){
		try {
			return parse_ini_file("editableFiles/filter.ini");
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function that returns handle to Output file. 
	// Output file is a CSV file that contains the data obtained using API.
	public function getCSV(){
		try {
			return fopen("output/filteredApiOutput.csv", "w");
		}catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function to output data obtained using API into a CSV file
	public function printToCSVFile($filePointer){
		try{
			fputcsv($filePointer,$this->filteredOutput);
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function that initailizes an array with "--" values
	// this array contains the data obtained using API, which later needs to be dumped into a file
	public function initializeOutputArray($filters){
		try{
			//initialize output array with "--" values
			$this->filteredOutput = array_fill_keys(array_keys($filters), "--");
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// funtion to empty the array contents
	public function removeValuesFromOutputArray(){
		try{
			$this->filteredOutput = array();
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function to print the "headings" for CSV file ( headings for data obtained using API)
	public function printOutputHeadings($fp,$filters){
		try{
			// printing the headings
			fputcsv($fp,array_values(array_keys($filters)));
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function that parses the data obtained after making API call.
	// It also makes call to the function that dumps this data to a file
	public function parseData($response, $prefix, $fp, $filters, $apiFilterFormatFile){
		try {
			foreach ($response as $key => $value){
				if (is_array($value)) {
					if(is_numeric($key)){
						$this->printToCSVFile($fp);
						$this->initializeOutputArray($filters);
						$this->keyPrefix = "";
						
						// filter IDs should be allowed to be print only once the actual data for company starts
						// data such as * success message of API call etc * should not be allowed to print
						// moreover, such data, even if included in filter.ini file, wont be able to print the 
						// correct response values because of the way code is written
						$this->allowToPrintFilterId = true;
						
						// each time a new company response is fetched, enter a demarcation point
						fwrite($apiFilterFormatFile, "\r\n********************************\r\n");
					}
					else
						$this->keyPrefix = $this->keyPrefix.$key.":";
					$this->parseData($value,$this->keyPrefix,$fp,$filters,$apiFilterFormatFile);
				} else {
						// print the **filter IDs** that need to be known for editing the filter.ini file
						$this->printFilterIDs($apiFilterFormatFile, $prefix.$key."\n\r");
						
						$this->filterData($prefix.$key,str_replace(",", ";", str_replace(array("\n","\t","\0","x0B","\r"), " ", $value)));
						$this->keyPrefix = "";
				}
			}
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function that makes the API call for fetching the data.
	// inputs required are Partner ID, Partner Key, Company name for which data needs to fetched and the IP address of the user
	public function callAPI($partnerID,$key,$companyName,$ip){
		try {
			$api = "http://api.glassdoor.com/api/api.htm?v=1&format=json&t.p=".$partnerID."&t.k=".$key."&action=employers&q=".$companyName."&userip="."&useragent=Mozilla/%2F4.0";
			$response = file_get_contents($api);
			$response = json_decode($response,true);
			return $response;
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function that puts the data obtained from API call into an array based upon the filters.
	private function filterData($key,$value){
		try {
			if (array_key_exists($key,$this->filteredOutput)) {
				$this->filteredOutput[$key] = $value;
			}
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	// function to get the IP of the user from the configuration file
	public function getIP(){
		try {
			$fileContents = parse_ini_file("editableFiles/configFile.ini");
			return $fileContents["ip"];
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}

	// function to get the Partner Key from the configuration file
	public function getPartnerKey(){
		try {
			$fileContents = parse_ini_file("editableFiles/configFile.ini");
			return $fileContents["key"];
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	// function to get the Partner ID from the configuration file
	public function getPartnerID(){
		try {
			$fileContents = parse_ini_file("editableFiles/configFile.ini");
			return $fileContents["partnerID"];
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	// function to log the "status" of the request made to server to fetch data using API.
	public function logApiResponseStatus($filePointer,$companyName,$status,$numberOfRecords){
		try {
			// if no records were fetched, explicitly mention it in the log along with the original status.
			if($numberOfRecords == 0){
				$status .= ". Number of Records found were 0"; 
			}
			$outputString = "Response for Company: ".str_replace("%20"," ",$companyName).".".PHP_EOL."Status: ".trim($status).PHP_EOL.PHP_EOL;
			fwrite($filePointer,$outputString);
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	// function to return handle for file that contains status of the request made made to server to fetch data using API.
	public function getApiResponseFile(){
		return fopen("output/API Response Status.txt","w");
	}
	
	// function to return handle for file that contains the filter formats
	public function getFilterFormatFile(){
		return fopen("output/ApiFilterFormat.txt", "w");
	}
	
	// function to print the filters IDs into file
	private function printFilterIDs($apiFilterFormatFile,$filterId){
		if ($this->allowToPrintFilterId) {
			fwrite($apiFilterFormatFile, $filterId."\n\r");
		}
	}
}

?>