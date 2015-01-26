<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        sparqlRepositoryOperationStatus.php

    Abstract:

        sparqlRepositoryOperationStatus.php check the status of sparql endpoint
		and get the information from this endpoint.
        
    Authors:      

        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.
		
    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');
include_once 'sparqlRepositoryInformation.php';

class sparqlRepositoryOperationStatus
{

	/*public checkEndpointOperationStatus()
	{
		;
	}*/
	
	/*++
        Function Name:

            GetRepositoryOperationalStatus

        Function Description:

            This function get the parameter from endpoint.

        Parameters:

            string value - The codeName of the endpoint code.
			
			string sites - The siteURL of the endpoint code.

        Returned Value:

            If the function returned normally, the returned is an endpoint parameter;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/  
	
	public function GetRepositoryOperationalStatus($value,$sites)
	{
		$sparqlEndpoint = new sparqlRepositoryInformation;
		
		$sparqlEndpoint->codeName = $value;

		$sparqlEndpoint->dataSourceName = 
			$this->setRepositoryOperationalStatus($value, '', '', 'dataSourceName');

		$sparqlEndpoint->siteURL = $sites;

		$sparqlEndpoint->sparqlEndpointURL = 
			$this->setRepositoryOperationalStatus($value, '', '', 'sparqlEndpointURL');

		$sparqlEndpoint->operationStatus = '';
		
		//echo $sparqlEndpoint->sparqlEndpointURL;
		
		return $sparqlEndpoint;
	}

    /*++
        Function Name:

            setRepositoryOperationalStatus

        Function Description:

            This function set the parameter from endpoint.

        Parameters:

            string endpointCodeName - The name of the endpoint code.

            string endpointName - The name of the endpoint.

            string siteURL - The endpoint site URL.

            string item - The item which we want to get.

        Returned Value:

            If the function returned normally, the returned is an endpoint parameter;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/  
	
	private function setRepositoryOperationalStatus($endpointCodeName = '', 
						$endpointName = '', $siteURL = '', $item)
	{
		//
        // filter with enpointName;
        //

        $contents = file_GET_contents('../X2R/config/endpoints.json'); 
		
        $endpointsArray = json_decode($contents, true);     

        foreach ($endpointsArray['endpoints'] as $subArray) {
            if ($endpointCodeName != '') {
                if($subArray['codeName'] == $endpointCodeName) {                    
                    $itemValue = $subArray[$item];
                }                
            } elseif ($endpointName != '') {
                if ($subArray['endpointName'] == $endpointName) {
                    $itemValue = $subArray[$item];
                }
            } elseif ($siteURL != '') {
                if ($subArray['siteURL'] == $siteURL) {
                    $itemValue = $subArray[$item];
                }
            }            
        }        
        return $itemValue;
	}
}