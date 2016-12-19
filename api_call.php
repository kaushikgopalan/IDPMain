<?php

$apiLink = "https://api.crunchbase.com/v/3/";
$key = "d1b6b0c5425908feb10417b4cbf55ac3";
$pageNum = 1;
$companyName = "google";

$link = $apiLink."organizations/" . $companyName . "?user_key=".$key;

// "https://api.crunchbase.com/v/3/organizations/google?user_key=d1b6b0c5425908feb10417b4cbf55ac3"

// $orgs = file_get_contents($link);
// $orgs = json_decode($this->organizations,true);

// print_r($orgs);


function httpGet($url)
{
    $ch = curl_init();
    $certPath = 'C:\\xampp\\htdocs\\cur\\New\ folder\\IDP4\\cacert.pem';

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_CAINFO, $certPath);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_VERBOSE, true);

 	// curl_setopt($ch,CURLOPT_HEADER, true);
 	  // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);


    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

$orgs = httpGet($link);
$orgs = json_decode($orgs, true);

$data = $orgs['data']['relationships'];

// print_r($data);

$processed_data = [];

foreach ($data as $key => $value) {
	echo "-------------------------------------------------------<br/>";
	// echo $key . '<br/>';
	$fpu = null;

	if (isset($value['paging']['first_page_url'])) {
		$fpu = $value['paging']['first_page_url'];
	}
	// echo "$fpu<br/>";

	if (isset($fpu)) {
		$processed_data[$key] = $fpu;
		echo $key . '<br/>';
		$fpu = $value['paging']['first_page_url'];
		echo "$fpu<br/>";
	}
}
