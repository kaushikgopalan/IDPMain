<?php

// get the configuration file contents
if (isset($_POST["configBtn"])) {
	$editFileName = "config";
	$fileContents = file_get_contents("editableFiles/configFile.ini");
	require_once "views/editFileContents.php";
	exit;
}

// get the filter file contents
if (isset($_POST["filterBtn"])) {
	$editFileName = "filter";
	$fileContents = file_get_contents("editableFiles/filter.ini");
	require_once "views/editFileContents.php";
	exit;
}

// edit the company list
if (isset($_POST["companyBtn"])) {
	$editFileName = "company";
	$fileContents = file_get_contents("editableFiles/company list.txt");
	require_once "views/editFileContents.php";
	exit;
}

// save button
if (isset($_POST["save"])) {
	$directory = "editableFiles/";
	$fileName="";
	switch ($_POST["fileType"]){
		case "config":
			$fileName = "configFile.ini";
			break;
		case "filter":
			$fileName = "filter.ini";
			break;
		case "company":
			$fileName = "company list.txt";
			break;
	}
	file_put_contents($directory.$fileName,$_POST["editedData"]);
}

// to goto main page
if (isset($_POST["mainPageBtn"])) {
	require_once "main.php";
	exit;
}

// back button
// in case of back button, do nothing. Simply let the page go back to main view

require_once "views/editView.php";