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

include_once 'mapper.class.php';
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
    $format = 'rdfxml'; //set the decault format
}

if ($mapping)
{
    $changes;
    $mappingObj = json_decode($mapping)->{'mapping'};
    foreach ($mappingObj as $mEntry) {

        print_r($mEntry);

    }
    
    //$obj = json_decode($mapping);
    //print_r $obj;

    

}

if ($rdfContent)
{
    //echo $rdfContent; 
    //$a = new Easy_Rdf_Adapter($rdfContent);
    //$b = new Mapper($a);
    //$c = $b->getQueryTerms();
    //echo json_encode($c);



}