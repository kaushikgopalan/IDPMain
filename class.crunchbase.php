<?php
class CrunchBase {
	private $fp;
	private $totalPages;
	private $organizations;
	private $organization;
	private $organizationsProperties = array ();
	private $organizationsHeaders = array ();
	private $fundingRoundHeaders = array ();
	private $investmentHeaders = array();
	private $acquisitionsHeaders = array();
	private $ipoHeaders = array();
	private $fundsHeaders = array();
	

	/**
	 * Save the properties retrieved from /organizations endpoint
	 * 
	 * @param unknown $apiLink: crunchbase base api path
	 * @param unknown $key: user key
	 * @param unknown $pageNum: page number to retrieve
	 */
	public function saveOrganizationsProperties($apiLink, $key, $pageNum) {
		
		$link = $apiLink . "organizations/?user_key=" . $key . "&page=" . $pageNum . "&sort_order=created_at+DESC";
		$this->organizations = file_get_contents ( $link );
		$this->organizations = json_decode ( $this->organizations, true );
		$data = $this->organizations ['data'];
		if ($pageNum == 1) {
			$paging = $data ['paging'];
			$this->totalPages = $paging ['number_of_pages'];
			
			$this->organizationsHeaders = parse_ini_file("editableFiles/crunchbaseHeaders.ini");
			$this->organizationsHeaders = $this->organizationsHeaders['organizationsPropertiesHeader'];
			$this->organizationsHeaders = explode(",",$this->organizationsHeaders);
			
			$this->fp = fopen ( "output/crunchBase/organizations.csv", "w" );
			fputcsv ( $this->fp, $this->organizationsHeaders );
		}
		if ($pageNum > $this->totalPages) {
			fclose ( $this->fp );
			echo "Completed!!";
		}else {
			$items = $data ['items'];
			foreach ( $items as $item ) {
				$this->organizationsProperties = array_fill_keys ( $this->organizationsHeaders, "--" );
				foreach ( $item ['properties'] as $propertiesKey => $propertiesValue ) {
					if (in_array ( rtrim ( $propertiesKey ), $this->organizationsHeaders )) {
						$this->organizationsProperties [rtrim ( $propertiesKey )] = $propertiesValue;
					}
				}
				fputcsv ( $this->fp, $this->organizationsProperties );
			}
			$this->saveOrganizationsProperties ( $apiLink, $key, $pageNum + 1 );
		}
	}
	
	/**
	 * store all the properties and relationship data of
	 *  individual organization.
	 *  
	 *  Not to be used anymore as /organizations endpoint
	 * is not used
	 */
	public function saveOrganizationPropertiesAndRelationships($apiLink, $key) {
		if (file_exists ( "output/crunchBase/organizations.csv" ) &&
				filesize ( "output/crunchBase/organizations.csv" ) > 0) {
					$fp = fopen ( "output/crunchBase/organizations.csv", "r" );
					fgetcsv ( $fp ); // since headers - line must be ignored
	
					// save the headers
					$fp_organizationProperties = $this->saveOrganizationPropertiesHeaders();
					$fp_fundingRound = $this->saveFundingRoundHeaders();
					$fp_investment = $this->saveInvestmentHeaders();
					$fp_acquisitions = $this->saveAcquisitionsHeaders();
					$fp_ipo = $this->saveIpoHeaders();
					$fp_funds = $this->saveFundsHeaders();
						
					while ( ! feof ( $fp ) ) {
						$line = fgetcsv ( $fp );
	
						// hit the api and get organization data
						$organizationEndPoint = $line [1];
						$link = $apiLink . $organizationEndPoint . "/?user_key=" . $key;
						$this->organization = file_get_contents ( $link );
						$this->organization = json_decode ( $this->organization, true );
	
						// save the properties of organization
						$this->saveEachOrganizationProperties ($fp_organizationProperties);
	
						// save the relationships data
						$data = $this->organization ['data'];
						$relationships = $data['relationships'];
						$property = $data['properties'];
						$company_name = $property['permalink'];
	
						// save the data for funding rounds
						$this->saveFundingRounds($fp_fundingRound,$relationships['funding_rounds'],$company_name);
	
						// save the data for investment
						$this->saveInvestment($fp_investment, $relationships['investments'], $company_name);
	
						// save the data for acquisitions
						$this->saveAcquisitions($fp_acquisitions, $relationships['acquisitions'], $company_name);
	
						// save the data for acquisitions
						$this->saveIpo($fp_ipo, $relationships['ipo'], $company_name);
	
						// save the data for acquisitions
						$this->saveFunds($fp_funds, $relationships['funds'], $company_name);
					}
						
					fclose ( $fp );
					fclose ( $fp_organizationProperties );
					fclose ($fp_fundingRound);
					fclose ($fp_investment);
					fclose ($fp_acquisitions);
					fclose ($fp_ipo);
					fclose ($fp_funds);
					
				} else {
					echo "Organizations Data Missing!! First call the /organizations endpoint.";
				}
	}
	
	
	/**
	 * store all the properties and relationship data of
	 *  individual organization.
	 *  Makes use of editable company list for endpoints
	 */
	public function saveOrganizationData($apiLink, $key) {
		if (file_exists ( "editableFiles/company list.txt" ) &&
				filesize ( "editableFiles/company list.txt" ) > 0) {
					
					// read the list of companies for which data must be collected
					$companyList = array_values(file("editableFiles/company list.txt"));
					
					// save the headers
					$fp_organizationProperties = $this->saveOrganizationPropertiesHeaders();
					$fp_fundingRound = $this->saveFundingRoundHeaders();
					$fp_investment = $this->saveInvestmentHeaders();
					$fp_acquisitions = $this->saveAcquisitionsHeaders();
					$fp_ipo = $this->saveIpoHeaders();
					$fp_funds = $this->saveFundsHeaders();
	
					foreach ($companyList as $company ) {
						$company = trim($company);
						// hit the api and get organization data
						$organizationEndPoint = $company;
						$link = $apiLink . "organizations/" . $organizationEndPoint . "/?user_key=" . $key;
						$this->organization = file_get_contents ( $link );
						$this->organization = json_decode ( $this->organization, true );
						
						// save the properties of organization
						$this->saveEachOrganizationProperties ($fp_organizationProperties);
	
						// save the relationships data
						$data = $this->organization ['data'];
						$relationships = $data['relationships'];
						$property = $data['properties'];
						$company_name = $property['permalink'];
						// save the data for funding rounds
						$this->saveFundingRounds($fp_fundingRound,$relationships['funding_rounds'],$company_name);
	
						// save the data for investment
						$this->saveInvestment($fp_investment, $relationships['investments'], $company_name);
	
						// save the data for acquisitions
						$this->saveAcquisitions($fp_acquisitions, $relationships['acquisitions'], $company_name);
	
						// save the data for acquisitions
						$this->saveIpo($fp_ipo, $relationships['ipo'], $company_name);
	
						// save the data for acquisitions
						$this->saveFunds($fp_funds, $relationships['funds'], $company_name);
					}
	
					fclose ( $fp_organizationProperties );
					fclose ($fp_fundingRound);
					fclose ($fp_investment);
					fclose ($fp_acquisitions);
					fclose ($fp_ipo);
					fclose ($fp_funds);
				} else {
					echo "Organizations Endopoints Missing!!";
				}
	}
	
	/**
	 * save the headers for funding round and output into csv file as HEAD line
	 */
	private function saveFundingRoundHeaders(){
		$fp_fundingRound = fopen ( "output/crunchBase/fundingRound.csv", "w" );
		$this->fundingRoundHeaders = parse_ini_file("editableFiles/crunchbaseHeaders.ini");
		$this->fundingRoundHeaders = $this->fundingRoundHeaders['realtionship_funding_rounds'];
		$this->fundingRoundHeaders = "company_name,".$this->fundingRoundHeaders; // explicitly add company_name header
		$this->fundingRoundHeaders = explode(",",$this->fundingRoundHeaders);
		fputcsv($fp_fundingRound,$this->fundingRoundHeaders);
		return $fp_fundingRound;
	}
	
	/**
	 * save the headers for investment and output into csv file as HEAD line
	 */
	private function saveInvestmentHeaders(){
		$fp_investment = fopen ( "output/crunchBase/investment.csv", "w" );
		$this->investmentHeaders = parse_ini_file("editableFiles/crunchbaseHeaders.ini");
		$this->investmentHeaders = $this->investmentHeaders['relationship_investments'];
		$this->investmentHeaders = "company_name,".$this->investmentHeaders; // explicitly add company_name header
		$this->investmentHeaders = explode(",",$this->investmentHeaders);
		fputcsv($fp_investment,$this->investmentHeaders);
		return $fp_investment;
	}
	
	/**
	 * save the headers for acquisitions and output into csv file as HEAD line
	 */
	private function saveAcquisitionsHeaders(){
		$fp_acquisitions = fopen ( "output/crunchBase/acquisitions.csv", "w" );
		$this->acquisitionsHeaders = parse_ini_file("editableFiles/crunchbaseHeaders.ini");
		$this->acquisitionsHeaders = $this->acquisitionsHeaders['relationship_acquisitions'];
		$this->acquisitionsHeaders = "company_name,".$this->acquisitionsHeaders; // explicitly add company_name header
		$this->acquisitionsHeaders = explode(",",$this->acquisitionsHeaders);
		fputcsv($fp_acquisitions,$this->acquisitionsHeaders);
		return $fp_acquisitions;
	}
	
	/**
	 * save the headers for ipo and output into csv file as HEAD line
	 */
	private function saveIpoHeaders(){
		$fp_ipo = fopen ( "output/crunchBase/ipo.csv", "w" );
		$this->ipoHeaders = parse_ini_file("editableFiles/crunchbaseHeaders.ini");
		$this->ipoHeaders = $this->ipoHeaders['relationship_ipo'];
		$this->ipoHeaders = "company_name,".$this->ipoHeaders; // explicitly add company_name header
		$this->ipoHeaders = explode(",",$this->ipoHeaders);
		fputcsv($fp_ipo,$this->ipoHeaders);
		return $fp_ipo;
	}
	
	/**
	 * save the headers for ipo and output into csv file as HEAD line
	 */
	private function saveFundsHeaders(){
		$fp_funds = fopen ( "output/crunchBase/funds.csv", "w" );
		$this->fundsHeaders = parse_ini_file("editableFiles/crunchbaseHeaders.ini");
		$this->fundsHeaders = $this->fundsHeaders['relationship_funds'];
		$this->fundsHeaders = "company_name,".$this->fundsHeaders; // explicitly add company_name header
		$this->fundsHeaders = explode(",",$this->fundsHeaders);
		fputcsv($fp_funds,$this->fundsHeaders);
		return $fp_funds;
	}
	
	/**
	 * save the individual organization properties headers and 
	 * output into csv file as HEAD line
	 */
	private function saveOrganizationPropertiesHeaders(){
		$fp_organizationProperties = fopen ( "output/crunchBase/organization.csv", "w" );
		$this->organizationsHeaders = parse_ini_file ( "editableFiles/crunchbaseHeaders.ini" );
		$this->organizationsHeaders = $this->organizationsHeaders ['organizationPropertiesHeader'];
		$this->organizationsHeaders = explode ( ",", $this->organizationsHeaders );
		fputcsv ( $fp_organizationProperties, $this->organizationsHeaders );
		return $fp_organizationProperties;
	}
	
	/*
	 * store all the properties of each organization
	 */
	private function saveEachOrganizationProperties($fp_organizationProperties) {
		$data = $this->organization ['data'];
		$properties = $data ['properties'];
		if(count($properties)>0){
			$this->organizationsProperties = array_fill_keys ( $this->organizationsHeaders, "" );
			foreach ( $properties as $propertiesKey => $propertiesValue ) {
				if (in_array ( rtrim ( $propertiesKey ), $this->organizationsHeaders )) {
					$this->organizationsProperties [rtrim ( $propertiesKey )] = $propertiesValue;
				}
			}
			fputcsv ( $fp_organizationProperties, $this->organizationsProperties );
		}
	}
	
	/**
	 * save the funding rounds properties
	 * 
	 * @param unknown $fp_fundingRound: file pointer
	 * @param unknown $fundingRounds: data about funding round from the organization data
	 * @param unknown $company_name: name of the company
	 */
	private function saveFundingRounds($fp_fundingRound,$fundingRounds,$company_name){
		$items = $fundingRounds['items'];
		if(count($items)>0){
			$fundingRoundsProperties = array_fill_keys ( $this->fundingRoundHeaders, "" );
			foreach ($items as $item){
				$properties = $item['properties'];
				foreach ($properties as $propertiesKey => $propertiesValue){
					if (in_array ( rtrim ( $propertiesKey ), $this->fundingRoundHeaders )) {
						// save the of comapny explicitly in the csv file as this is not part of
						// properties section of funding rounds
						$fundingRoundsProperties["company_name"] = $company_name;
						
						// save the properties of funding round
						$fundingRoundsProperties[rtrim($propertiesKey)] = 
								$fundingRoundsProperties[rtrim($propertiesKey)]."**".$propertiesValue;
					}
				}
			}
			fputcsv($fp_fundingRound,$fundingRoundsProperties);
		}
	}
	
	/**
	 * save the investments properties for organization
	 * 
	 * @param unknown $fp_investment: file pointer
	 * @param unknown $investment: data about investment from the organization data
	 * @param unknown $company_name: name of the company
	 */
	private function saveInvestment($fp_investment,$investment,$company_name){
		$items = $investment['items'];
		if(count($items)>0){
			$investmentProperties = array_fill_keys ( $this->investmentHeaders, "");
			foreach ($items as $item){
				$properties = $item['properties'];
				foreach ($properties as $propertiesKey => $propertiesValue){
					if (in_array ( rtrim ( $propertiesKey ), $this->investmentHeaders )) {
						// save the of comapny explicitly in the csv file as this is not part of
						// properties section of investments
						$investmentProperties["company_name"] = $company_name;
							
						// save the properties of investments
						$investmentProperties[rtrim($propertiesKey)] =
						$investmentProperties[rtrim($propertiesKey)]."**".$propertiesValue;
					}
				}
			}
			fputcsv($fp_investment,$investmentProperties);
		}
	}
	
	/**
	 * save the investments properties for organization
	 *
	 * @param unknown $fp_acquisitions: file pointer
	 * @param unknown $acquisitions: data about acquisitions from the organization data
	 * @param unknown $company_name: name of the company
	 */
	private function saveAcquisitions($fp_acquisitions,$acquisitions,$company_name){
		$items = $acquisitions['items'];
		if(count($items)>0){
			$acquisitionsProperties = array_fill_keys ( $this->acquisitionsHeaders, "");
			foreach ($items as $item){
				$properties = $item['properties'];
				foreach ($properties as $propertiesKey => $propertiesValue){
					if (in_array ( rtrim ( $propertiesKey ), $this->acquisitionsHeaders )) {
						// save the of comapny explicitly in the csv file as this is not part of
						// properties section of investments
						$acquisitionsProperties["company_name"] = $company_name;
							
						// save the properties of investments
						$acquisitionsProperties[rtrim($propertiesKey)] =
						$acquisitionsProperties[rtrim($propertiesKey)]."**".$propertiesValue;
					}
				}
			}
			fputcsv($fp_acquisitions,$acquisitionsProperties);
		}
	}
	
	/**
	 * save the ipo properties for organization
	 *
	 * @param unknown $fp_ipo: file pointer
	 * @param unknown $ipo: data about ipo from the organization data
	 * @param unknown $company_name: name of the company
	 */
	private function saveIpo($fp_ipo,$ipo,$company_name){
		$items = $ipo['item'];
		if(count($items)>0){
			$ipoProperties = array_fill_keys ( $this->ipoHeaders, "");
			$properties = $items['properties'];
			foreach ($properties as $propertiesKey => $propertiesValue){
				if (in_array ( rtrim ( $propertiesKey ), $this->ipoHeaders )) {
					// save the of comapny explicitly in the csv file as this is not part of
					// properties section of investments
					$ipoProperties["company_name"] = $company_name;
						
					// save the properties of investments
					$ipoProperties[rtrim($propertiesKey)] =
					$ipoProperties[rtrim($propertiesKey)]."**".$propertiesValue;
				}
			}
			fputcsv($fp_ipo,$ipoProperties);
		}
	}
	
	/**
	 * save the investments properties for organization
	 *
	 * @param unknown $fp_funds: file pointer
	 * @param unknown $funds: data about funds from the organization data
	 * @param unknown $company_name: name of the company
	 */
	private function saveFunds($fp_funds,$funds,$company_name){
		$items = $funds['items'];
		if(count($items)>0){
			$fundsProperties = array_fill_keys ( $this->fundsHeaders, "");
			foreach ($items as $item){
				$properties = $item['properties'];
				foreach ($properties as $propertiesKey => $propertiesValue){
					if (in_array ( rtrim ( $propertiesKey ), $this->fundsHeaders )) {
						// save the of comapny explicitly in the csv file as this is not part of
						// properties section of investments
						$fundsProperties["company_name"] = $company_name;
							
						// save the properties of investments
						$fundsProperties[rtrim($propertiesKey)] =
						$fundsProperties[rtrim($propertiesKey)]."**".$propertiesValue;
					}
				}
			}
			fputcsv($fp_funds,$fundsProperties);
		}
	}
}
