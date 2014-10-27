<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        endpoint.class.php

    Abstract:

        Endpoint is the class for modeling 
        public endpoints, such as Dbpedia and Data.gov

    Authors:      

        Gentry Yao,   polo90406@gmail.com
        Feng-Pu Yang, fengpuyang@gmail.com

    See Also:

        EndpointBase (endpointbase.class.php)

    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');

include_once 'endpointbase.class.php';
include_once 'endpoint/dbpedia.php';
include_once 'endpoint/linkedgeodata.php';

error_reporting(0);

class Endpoint
{
    private $baseUrl;
    private $timeToLive; #defaultTimeToLive

    /*++
    Function (Constructor) Name:

        Endpoint

    Function Description:
        
        This constructor takes no parameters,
        and all the configurations are set
        to defaults.

        Its configuration is deferred after
        initialization through configuration 
        methods, where the configuration method 
        means those methods prefix with 'config,'
        such as 'configEndpointBaseUrl' and 
        'configTimeToLiveInSeconds'. 

    Parameters: defer to config-prefix method     

    Note (W.I.):

        The configuration can be done through config-prefix
        methods. Here is an example:

        $ep = new Endpoint();
        $ep->configEndpointBaseUrl('http://dbpedia.sparql...')
           ->configTimeToLiveInSeconds(1);

        Developers can introduce new config-prefix methods, 
        the only constraint of config-prefix methods, are the 
        return statement. It must be 

            'return $this;'

        for chaining the other config-prefix methods. 
        The default value new configuration should also
        be assigned in construct. 

 
        
    --*/

    function Endpoint()
    {

        $this->baseUrl = EndpointBase::DBPEDIA;
        $his->timeToLive = 1; #defaultTimeToLive

    }



    /*++
    Function Name:

        configTimeToLiveInSeconds

    Function Description:
        
        This method let you configure the time to live 
        in the unit of seconds, and return the Endpoint
        object for method chaining.   

    Parameters: $ttl      

    Return: $this
 
        
    --*/

    public function configTimeToLiveInSeconds($ttl)
    {
        //Error handling for parameter checking
        if (is_int($ttl) && $ttl > 0)
        {
            $this->timeToLive = $ttl;
        }
        else
        {
             // Fail-silent (intended no-operation)
        }

        return $this;

    }

    /*++
    Function Name:

        configEndpointBaseUrl

    Function Description:
        
        This method let you configure the base URL 
        of targeted Endpoint, and return the Endpoint
        object for method chaining.   

    Parameters: $endpointUrl      

    Return: $this
 
        
    --*/


    public function configEndpointBaseUrl($endpointUrl)
    {
        //Error handling for parameter checking
        if (EndpointBase::isValidValue($endpointUrl))
        {    $this->baseUrl = $endpointUrl;
        }
        else
        {
            // Fail-silent (intended no-operation)
        }
        return $this;

    }

    /*++
    Function Name:

        getBaseUrl

    Function Description:
        
        This method let you get the current 
        configuration of Endpoint's base URL.   

    Parameters: N/A      

    Return: $this->baseUrl
 
        
    --*/

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /*++
    Function Name:

        getTTL

    Function Description:
        
        This method let you get the current 
        configuration of time-to-live in the 
        unit of second.   

    Parameters: N/A      

    Return: $this->timeToLive
 
        
    --*/

    public function getTTL()
    {
        return $this->timeToLive;
    }

    /*++
    Function Name:

        getEndpointStatus

    Function Description:
        
        This method let you get the status
        of currently wrapped Endpoint, where
        the status means the availablity at 
        the method requesting time.   

    Parameters: $baseUrl   

    Return: $serverAvaliable
 
        
    --*/

    public function getEndpointStatus($baseUrl)
    {
        $serverAvaliable = False;
		
        //TODO: test the server & return the 
        // server's status
        //
        // Available : return True
        // NotAvailable: return False 
		
		$hosts = explode('/', $baseUrl);
		$host = gethostbyname($hosts[2]); 
		$port = 80; 
		$waitTimeoutInSeconds = 1; 
	
		$fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds);

		if($fp){   
			$serverAvaliable = True;
		} else {
		   ;
		}
		
		fclose($fp);
		
        return $serverAvaliable;
    }
	
    /*++
        Function Name:

            composeSparqlQuery

        Function Description:

            This function compose query according to endpoints

        Parameters:

            string term - The term of interest to search.

            string dataSourceName - The name of data source.

            string limit - The number of how many result we want to show.

            array filters - The array of filters setting.

        Returned Value:

            If the function returned normally, the returned is a sparql query;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/
	
	public function composeSparqlQuery($term, $dataSourceName = '', $limit = 10, $filters = array(''))
	{
		$sparqlQueryString = '';
		
		switch($dataSourceName)
		{
			case 'http://dbpedia.org/':
				$ep = new dbpedia();
				
				$sparqlQueryString = $ep->composeQuery($term, $dataSourceName, $limit, $filters);
				
				break;
			
			case 'http://linkedgeodata.org/':
				$ep = new linkedgeodata();
				
				$sparqlQueryString = $ep->composeQuery($term, $dataSourceName, $limit, $filters);
				
				break;
		}
		
		return $sparqlQueryString;
	}
	
    /*++
    Function Name:

        performQuery

    Function Description:
        
        This method let you query Endpoint
        in SPARQL, and return result in 
        JSON string.   

    Parameters: $sparqlQueryString      

    Return: $queryResult
 
        
    --*/

    public function performQuery($sparqlQueryString,$dataSourceName)
    {
		$queryResult = '';
		
		switch($dataSourceName)
		{
			case 'http://dbpedia.org/':
				$ep = new dbpedia();
				
				$queryResult = $ep->query($sparqlQueryString);
				
				break;
			
			case 'http://linkedgeodata.org/':
				$ep = new linkedgeodata();
				
				$queryResult = $ep->query($sparqlQueryString);
				
				break;
		}
		
		return $queryResult;
    }


}


/*  Usage Example:
$filters;
$ep = new Endpoint();
$ep->configEndpointBaseUrl('http://dbpedia.org/sparql/')
   ->configTimeToLiveInSeconds(1);

$baseUrl = $ep->getBaseUrl();
$dataSourceName = rtrim($baseUrl, 'sparql/');
$sparqlQueryString = composeSparqlQuery("typhoon", $dataSourceName, 10, $filters);
$result = query($sparqlQueryString, $baseUrl, $dataSourceName,'json');

echo $result;
/*
