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
		 //
        // ToDo: 1. Offset
        //       2. Order by
        //       3. Variable check
        //       4. Terms with spaces
        //

        $sparqlQueryString = '';

        //
        // Compose Query according to endpoints
        // Setting Data Source Name (DSN)
        //

        if (!empty($dataSourceName)) {
            
            $sparqlQueryString = "SELECT DISTINCT ?s ?o FROM <".$dataSourceName."> WHERE { \n";

        } else {
            $sparqlQueryString = "SELECT DISTINCT ?s ?o WHERE { \n";
        }
        
        $sparqlQueryString .= "?s <http://www.w3.org/2000/01/rdf-schema#label> ?o . \n";
		
        $sparqlQueryString .= "?o bif:contains \"".$term."\" . \n";

        //
        // For search both lower-case and upper-case ex: Typhoon and typhoon
        //

        if (ctype_upper(substr($term, 0, 1))) {
            $sparqlQueryString .= "FILTER ( regex(str(?o), '^".$term."') || regex(str(?o), '^".strtolower($term)."')) . \n";
        } else {
            $sparqlQueryString .= "FILTER ( regex(str(?o), '^".$term."') || regex(str(?o), '^".ucfirst(strtolower($term))."')) . \n";
        }

        //
        // Customized filters
        //

        if (!empty($filters)) {
            
            foreach ($filters as $key => $filterString) {

                $sparqlQueryString .= "FILTER (!regex(str(?s), '^".$filterString."')) . \n";
            }
        }
        
        $sparqlQueryString .= "FILTER (lang(?o) = 'en') . \n";
        $sparqlQueryString .= "} \n";

        //
        // ToDo: Implement offset here
        //

        $query .= "Limit ".$limit." \n";

        return $sparqlQueryString;
	}
	
    /*++
    Function Name:

        query

    Function Description:
        
        This method let you query Endpoint
        in SPARQL, and return result in 
        JSON string.   

    Parameters: $sparqlQueryString      

    Return: $queryResult
 
        
    --*/

    public function query($sparqlQueryString)
    {

        //TODO: implement this method by 
        //reusing legacy code
		
		$params = array(
            'default-graph-uri' => rtrim($dataSourceName, '/'),
            'should-sponge' => 'soft',
            'query' => $sparqlQueryString,
            'debug' => 'on',
            'timeout' => '30000',
            'output' => $output,
            'save' => 'display',
            'fname' => ''
        );

        $querypart = '?';
        foreach ($params as $name => $value) {
            $querypart = $querypart . $name . '=' . urlencode($value) . '&';
        }
        
        $sparqlURL = $baseURL . $querypart;   
		
		$ch = curl_init();
		
        curl_setopt($ch, CURLOPT_URL, $sparqlURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);   
		
        $queryResult = curl_exec($ch);
		
		curl_close($ch);
		
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
