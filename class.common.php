<?php

// class that contains all the common functions.

class Common {	
	// function that allows a particular file to be downloaded. 
	// Required inputs are source file name along with path & the destination file name. 
	public function downloadFile($file,$outputFileName){
		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.$outputFileName);
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}

	}
        public function downloadCrunchbase($file, $outputFileName){
            // write Crunchbase related code here.
            // re think if we can use the existing function itself.
        }
}