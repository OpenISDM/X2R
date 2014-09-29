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


$changes;
$format;

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

    $mappingObj = json_decode($mapping)->{'mapping'};

    foreach ($mappingObj as $mEntry) {

        $oUri = $mEntry->{'originalURI'};
        $uUri = $mEntry->{'replacedURI'};
        $change[$oUri] = $uUri;

    }
    
    //$obj = json_decode($mapping);
    //print_r $obj;

    

}

if ($rdfContent)
{

    //echo $rdfContent; 
    $era = new Easy_Rdf_Adapter($rdfContent);
    $m = new Mapper($era);
    $m->refactoring('rename', $change);
    $result = $m->serialize($format);
 
    echo $result;



}