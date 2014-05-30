<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        extractor.class.php

    Abstract:

        extractor.class.php is the class for modeling the 
        URI extracting & transforming process as below. 
        
        Step 1. Load the RDF content to a Graph data structure
        Step 2. Traverse the Graph to finding all the URIs
        Step 3. Transform these URIs to search friendly terms
        Step 4. Wrap these terms as a JSON output



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');
require_once 'vendor/autoload.php';
include_once 'rdfGraph.class.php';

Class Easy_Rdf_Adapter extends rdfGraph
{
    protected function EasyRdfAdapter()
    {
        $this->rdfGrapn();
    }

    public function parse()
    {
        echo 'test';

    }

}

$a = new Easy_Rdf_Adapter();

