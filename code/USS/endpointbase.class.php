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

    //TODO: classify existing Endpoints 
    //      and test representive one for each class 
    //      There are many attributes can be used to 
    //      classify Endpoints. For example, the 
    //      used framework can be one. In the 
    //      first step, we test Endpoints, which are
    //      built on top of Virtuoso (OpenLink Virtuoso 
    //      Universal Server, http://www.virtuoso.com)
    //      
    //      Each tested Endpoint will be included in 
    //      the following consts. 
    const DBPEDIA = 'http://dbpedia.sparql...';
    const DATAGOV = 'http://...';
}

/* Usage Example:
   echo EndpointBase::DATAGOV;
   echo EndpointBase::DBPEDIA;
*/


