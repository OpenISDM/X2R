<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        uss.php

    Abstract:

        uss.php interact with clients who require URI Search Service(USS).
        
    Authors:       

        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.
		
    Major Revision History:
    
--*/

   error_reporting(0);

    set_include_path(get_include_path() . PATH_SEPARATOR . '../X2R/lib/');
    set_include_path(get_include_path() . PATH_SEPARATOR . '../X2R'); 
	set_include_path(get_include_path() . PATH_SEPARATOR . './'); 	
  

    //
    // Include FirePHP for debugging
    //

    require_once 'FirePHPCore/fb.php';
    require_once 'EasyRdf.php';
    require_once 'uriSearchService.class.php';

    //
    // Start FirePHP
    //

    ob_start();
    FB::info('Start debugging');
	
	if (isset($_GET['q']) && $_GET['q'] != null) {
		$query = explode(' ', $_GET['q']); 
		$term = $query[0];

		//
		// Default values
		//

		$defaultSites = 'dbp';
		$sites = explode(',', $defaultSites);
		$output = 'text/html';
		$limit = 10; 
                
		if (isset($_GET['sites'])) {

			//
			// ToDo: check with right delimiter, space and so on
			//

			$sites = explode(',', $_GET['sites']);
		}
			
		if (isset($_GET['output'])) {
            
           
			$output = 'application/json';
		}

		//
		// Add function to iterative
		//

		if (isset($_GET['limit'])) {
            
			$limit = $_GET['limit'];
		}
	} 
	else {

		echo 'Please enter strings to search...';
		return;
	}

	$mu = new UriSearchService;
	
	echo $mu->uriSearch($sites,$output,$limit,$term);

?>