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

    Parameters:      

    Possible Error Code:

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

    public function configTimeToLiveInSeconds($ttl)
    {
        //TODO: Error handling for parameter checking
        // (is_int($ttl) && $ttl > 0);

        return $this;

    }

    public function configEndpointBaseUrl($endpointUrl)
    {
        //TODO: Error handling for parameter checking
        // EndpointBase::isValidValue($endpointUrl);
    
        $this->baseUrl = $endpointUrl;
        return $this;

    }


    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getTTL()
    {
        return $this->timeToLive;
    }


    public function getEndpointStatus()
    {
        $serverAvaliable = False;
        //TODO: test the server & return the 
        // status
        // Available : return True
        // NotAvailable: return False 

        return $serverAvaliable;



    }


    public function query($sparqlQueryString)
    {
        $queryResult = '';
        return $queryResult;
    }


}


/*  Usage Example:

$ep = new Endpoint();
$ep->configEndpointBaseUrl('http://dbpedia.sparql...')
   ->configTimeToLiveInSeconds(1);

$baseUrl = $ep->getBaseUrl();
echo $a;
/*
