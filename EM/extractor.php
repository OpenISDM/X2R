<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        extractor.php

    Abstract:

        The Web interface of Extractor Class
        (extractor.class.php)



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');
require 'vendor/autoload.php';
include_once 'extractor.class.php';
include_once 'easyRdfAdapter.class.php';
include_once 'webUtilities.php';


$excludedNameSpace = getParameter('excludedNameSpace');
$checkUrisStatus = getParameter('checkUrisStatus');
$rdfContent = getParameter('rdfContent');




if ($excludedNameSpace)
{
   //TODO: implement the namespace exclusion
}

if ($checkUrisStatus)
{
    //TODO: implement the uri status test

}

if ($rdfContent)
{
    //echo $rdfContent; 
    $a = new Easy_Rdf_Adapter($rdfContent);
    $b = new Extractor($a);
    $c = $b->getQueryTerms();
    echo json_encode($c);



}



