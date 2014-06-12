<?php
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


