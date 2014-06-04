<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        easyRdfAdapter.class.php

    Abstract:

        easyRdfAdapter.class.php is the class for adapting the 
        parsing utilities of EasyRDF to the standard operations
        defined by OpenISDM VR X2R. 
        



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

    /*++
    Function Name:

        parse

    Function Description:
        
        In this method, programmer parse RDF
        based on the adapted parser, such as 
        EasyRDF. And then use the protected 
        method, 'addTuple', to add each tuple
        found in the inputed RDF. 

    Parameters:

        $data: 


    Returned Value:
        

    Possible Error Code:

    --*/

    public function parse($data)
    {

        $g;

        try
        {
            //TODO: extract the format, i.g., rdfxml, as parameter
            //TODO: make format flag independent with underlying parser, i.e., EasyRDF or other parser
            //      possible solution, use a RDF parser specific format termology mapping table
            $g = new EasyRdf_Graph(' ', $data, 'rdfxml');
        } 
        catch (Exception $e) 
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

    /*++
    Function Name:

        buildGraphModel

    Function Description:
        
        This is a private method for encapsulating
        the adapting details, which are specific to 
        EasyRDF. 

    Parameters:

        $g


    Returned Value:
        

    Possible Error Code:

    --*/

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

