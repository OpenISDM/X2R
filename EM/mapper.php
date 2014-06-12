<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        mapper.php

    Abstract:

        mapper.php is the Web interface of 
        Mapper class (mapper.class.php)



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/


header ('Content-Type: text/html; charset=utf-8');
require 'vendor/autoload.php';
include_once 'mapper.class.php';
include_once 'easyRdfAdapter.class.php';
include_once 'webUtilities.php';


$format = getParameter('format');
$mapping = getParameter('mapping');
$rdfContent = getParameter('rdfContent');




if ($format)
{
   //TODO: check if the $format is the supported format
}
else
{
    $format = 'rdfxml'; //the decault format
}

if ($mapping)
{
    

}

if ($rdfContent)
{
    //echo $rdfContent; 
    $a = new Easy_Rdf_Adapter($rdfContent);
    $b = new Mapper($a);
    $c = $b->getQueryTerms();
    echo json_encode($c);



}