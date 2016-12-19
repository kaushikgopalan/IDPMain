<?php 

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
ini_set('max_execution_time', 0);
error_reporting(0);

include_once 'class.crunchbase.php';

$key = "";
$apiLink = "https://api.crunchbase.com/v/3/";

$cb  = new CrunchBase();

/**
 * /organizations endpoint call is commented because
 * as per the discussions with Kilian, company list
 * will be provided and not required to be fetched
 * via crunchbase.
 */

/*
// to save the /organizations endpoint properties
$cb->saveOrganizationsProperties($apiLink, $key, 1);

// to save the properties and relationship of /organization/:permalink
$cb->saveOrganizationPropertiesAndRelationships($apiLink, $key,$filename);

*/

// to save the properties and relationship of /organization/:permalink, but now with the given company list
$cb->saveOrganizationData($apiLink, $key);

// inform user that all the required data has been fetched
$message = "Data has been Fetched!!";
echo "<script type='text/javascript'>alert('$message');</script>";
?>