<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        mapper.class.php

    Abstract:

        mapper.class.php is the class for modeling the 
        URI transformation (refactoring) process.

        Currently, the mapper only support one kind of 
        transformation (refactoring) - rename URI. 

        The rename URI is to replace an existing URI 
        with a new URI.  
        



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');
include_once 'EasyRdfAdapter.class.php';
include_once 'refaRename.class.php';
class Mapper
{
  
    function Mapper(rdfGraph $graph)
    {
        $this->graph = $graph;

    }


    public function refactoring($refType, $change)
    {
        $this->getRefactor($refType)->refactoring($change);

    }

    protected function impactAnalysis($change)
    {
        // analyze by index
    }

    protected function getRefactor($refactorType)
    {
        $refactor;
        switch($refactorType)
        {
            case 'rename':
            $refactor = new Rename($this->graph);
            break;
            default:
            $refactor = new Rename($this->graph);
        }
        return $refactor;



    }

    public function serialize($format)
    {
        
        $output = $this->graph->serialize($format);

        return $output;

    }


}


