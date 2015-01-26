<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        federatedsearch.class.php

    Abstract:

        FederatedSearch is the top level class 
        for organizing and conducting the whole 
        URI searching task

    Authors:      
        
        Feng-Pu Yang, fengpuyang@gmail.com
        Gentry Yao,   polo90406@gmail.com

    See Also:

        

    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');
include_once 'sparqlRepositoryOperationStatus.php';

class FederatedSearch
{
	function FederatedSearch()
	{
		$this->defaultSearch = new Endpoint();

	}

	public function addEndpoints($endpointList)
	{

	}

	public function getEndpointList()
	{

	}

	public function removeEndpoints($endpointList)
	{

	}

	public function search($sites,$term,$output,$limit)
	{
		$sparqlTasks = $this->defaultSearch->SynthesiseMultipleSparqlQueries(
			$sites,$term,$output,$limit);
	
		foreach ($sparqlTasks as $key => $sparqlTask) {  
			$sparqlTask->searchedResult = $this->defaultSearch->performQuery(
				$sparqlTask->sparqlQuery,
				$sparqlTask->sparqlEndpoint->sparqlEndpointURL,
				$sparqlTask->sparqlEndpoint->dataSourceName,
				$sparqlTask->outputFormat
				);
		}
		
		$resultSet = integrateSearchedResults($sparqlTasks);
		
		return $resultSet;
	}
    /*++
        Function Name:

            integrateSearchedResults

        Function Description:

            This function integrate the sparql query return data.

        Parameters:

            sparqlTasks sparqlTasks - The task for sparql query.

        Returned Value:

            If the function returned normally, the returned is an array of searched results;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/
	
	public function integrateSearchedResults($sparqlTasks)
	{
		
		$integratedResult = array('term' => $sparqlTasks[0]->searchTerm, 'data' => array());

        switch ($sparqlTasks[0]->outputFormat) {

            //
            // ToDo: Make other output ex: text/html
            //

            case 'application/json':
                foreach ($sparqlTasks as $key => $sparqlTask) {
                    $result  = array(
                        'dataSourceName' => $sparqlTask->sparqlEndpoint->dataSourceName,
                        'response' => json_decode($sparqlTask->searchedResult)
                    );
                    
                    $integratedResult['data'][] = $result;
                }
                return json_encode($integratedResult);
                break;
            
            default:
                # code...
				
                break;
        }
	}	
}