<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        endpointbase.class.php

    Abstract:

        endpointbase.class.php is the class for enumerating
        configurations of endpoints' base URLs. It is used 
        in initializing Endpoint object. 

    See Also:
        endpoint.class.php

    Authors:      

        Gentry Yao,   polo90406@gmail.com
        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/
include_once 'basicenum.class.php';

abstract class EndpointBase extends BasicEnum

{
    const DBPEDIA = 'http://dbpedia.sparql...';
    const DATAGOV = 'http://...';
}

/* Usage Example:
   echo EndpointBase::DATAGOV;
   echo EndpointBase::DBPEDIA;
*/


