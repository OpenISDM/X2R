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

    public function parse($data)
    {

        $g;

        try
        {
            $g = new EasyRdf_Graph(' ', $data, 'rdfxml');
        } catch (Exception $e) 
        {
            echo 'exception!! invalid RDF.';
            error_log('exception!! invalid RDF.', 0);
        } finally 
        {
            //If parse is success, then add contents 
            //into graph model. 
            $this->buildGraphModel($g);



        }
        

    }



private function buildGraphModel($g)
    {

        $count = 0;
        $rdfType = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type';
        $assarr = $g->toRdfPhp();


        //obj-pre-sub  
        foreach ($assarr as $obj => $presub)
        {
           
            foreach($presub as $pre => $subArr)
            {

                $subType = $subArr[0]['type'];
                $subValue = $subArr[0]['value'];

                
                if ($this->tupleTailType($subType) != 'false')
                {


                    $ttype = $this->tupleTailType($subType);
                    
                    if (in_array('datatype', (array_keys($subArr[0]))))
                    {
                        $od = $subArr[0]['datatype'];
                    }
                    else
                    {
                        $od = NULL;   
                    }

                    $this->addTuple($obj, $pre, $subType, $subValue, $od);

                }else
                {
                   //TODO: unexpected object type handling
                }
                
               


            }


        }



    }








}


$file = '../../data/MAD_D.rdf';
$data = file_get_contents($file);
$a = new Easy_Rdf_Adapter($data);

