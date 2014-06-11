<?php
header ('Content-Type: text/html; charset=utf-8');
include_once 'EasyRdfAdapter.class.php';
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



    }

    public function serialize($format)
    {
        
        $output = $this->graph->serialize($format);

        return $output;

    }


}


