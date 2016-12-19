<?php
class ParseGlassdoor {
	
	private $fp;
	private $keysArray = array();
	private $valuesArray = array();
	
	public function __construct(){
		$this->setFilePointer();
	}
	
	/*
	public function getEmployeeLinksData($html){
		$output;
		try {
			foreach ($html->find('.empLinks') as $link){
				foreach ($link->find('.reviews') as $reviews){
					$key =(string) $reviews->childNodes(1);
					$value =(string) $reviews->childNodes(0);
			
					$output[$key] = $value;
				}
				foreach ($link->find('.salaries') as $salaries){
					$key =(string) $salaries->childNodes(1);
					$value =(string) $salaries->childNodes(0);
						
					$output[$key] = $value;
				}
				foreach ($link->find('.interviews') as $interviews){
					$key =(string) $interviews->childNodes(1);
					$value =(string) $interviews->childNodes(0);
				
					$output[$key] = $value;
				}				
			}
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
		return $output;
	}*/
	
	public function getOverallRating($html){
		try {
			$ratingInfo = $html->find('div .ratingInfo',0);
			array_push($this->keysArray,"Overall Rating");
			array_push($this->valuesArray,$ratingInfo->children(0)->plaintext);
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	public function getAditionalInfo($html){
		try {
			$infoDetails = $html->find('div[id=InfoDetails]',0);
			foreach ($infoDetails->find('.empInfo') as $empInfo){
				array_push($this->keysArray,$empInfo->children(0)->plaintext);
				array_push($this->valuesArray,$empInfo->children(1)->plaintext);
			}
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	private function getEmployerId($html){
		foreach($html->find('a') as $a){
			if(strpos($a->href, "employerId=") != FALSE){
				$temp = explode("employerId=",$a->href);
				$temp = explode("&",$temp[1]);
				return $temp[0];
			}
		}
	}
	
	private function getRatingsPopupLink($html){
		try {
			$fileContents = parse_ini_file("editableFiles/configFile.ini");
			return $fileContents["ratingPopupLink_part1"].$this->getEmployerId($html).$fileContents["ratingPopupLink_part2"];
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	private function parseRatings($ratings){
		$count = 0;
		try{
			$ratings = str_replace("{","", $ratings);
			$ratings = str_replace("}", "", $ratings);
			$ratings = str_replace("\"", "", $ratings);
			$elements = explode("]",$ratings);
			$elements = explode("[", $elements[0]);
			$elements = explode(",", $elements[1]);

			
			foreach ($elements as $e){
				switch ($count){
					case 0: $count++;
						break;
					case 1: $count++;
						$element = explode(":", $e);
						$key = $element[1];
						break;
					case 2: $count++;
						$element = explode(":", $e);
						$value = $element[1];
						array_push($this->keysArray,$key);
						array_push($this->valuesArray,$value);
						$count = 0;
						break;
				}
				
			}
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	private function getStarsCountLink($html){
		try {
			$fileContents = parse_ini_file("editableFiles/configFile.ini");
			return $fileContents["starsCount_part1"].$this->getEmployerId($html).$fileContents["starsCount_part2"];
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	private function getStarsCount($stars){
		try{
			$stars = str_replace("{", "", $stars);
			$stars = str_replace("}", "", $stars);
			$stars = str_replace("\"", "", $stars);
			$stars = str_replace("[", "", $stars);
			$stars = str_replace("]", "", $stars);
			$elements = explode("labels:", $stars);
			$elements = explode(",values:", $elements[1]);
			$elements = implode(",", $elements);
			$elements = explode(",",$elements);
			$keySize = count($elements)/2;
			for($i=0;$i<$keySize;$i++){
				array_push($this->keysArray,$elements[$i]);
				array_push($this->valuesArray,$elements[$i+$keySize]);
			}
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	/*
	 * function to output data obtained using API into a CSV file
	 */ 
	public function printToCSVFile($arrayToPrint){
		try{
			fputcsv($this->fp,$arrayToPrint);
		} catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	/*
	 * function that sets handle to Output file.
	 * Output file is a CSV file that contains the data obtained using API.
	 */ 
	private function setFilePointer(){
		try {
			$this->fp = fopen("output/glassdoorOutput.csv", "w");
		}catch (Exception $e) {
			error_log($e->getMessage(),3,"/var/tmp/error.log");
			error_log("\n");
		}
	}
	
	/*
	 * function that gets the values of ratings in 
	 * seen in the popup.
	 */
	public function getRatings($html){
		$ratingsLink = $this->getRatingsPopupLink($html);
		$ratings = file_get_contents($ratingsLink);
		$this->parseRatings($ratings);
	}
	
	/*
	 * function that gets the values of stars in
	 * seen in the popup.
	 */
	public function getStars($html){
		$starsCountLink = $this->getStarsCountLink($html);
		$stars = file_get_contents($starsCountLink);
		$this->getStarsCount($stars);
	}
	
	/*
	 * getter for keys array
	 */
	public function getKeysArray(){
		return $this->keysArray;
	}
	
	/*
	 * getter for values array
	 */
	public function getValuesArray(){
		return $this->valuesArray;
	}
	
	/*
	 * close all open connections
	 * like file-handler etc
	 */
	public function closeOpenConnections(){
		fclose($this->fp);
	}
	
	/*
	 * reset the array values
	 */
	public function resetArrays(){
		$this->keysArray = array();
		$this->valuesArray = array();
	}
}