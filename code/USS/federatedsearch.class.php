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

	public function search($sparqlQuery)
	{
		
	}
}