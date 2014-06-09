<?php
header ('Content-Type: text/html; charset=utf-8');
include_once 'EasyRdfAdapter.class.php';
class Mapper
{
  
    function Mapper(rdfGraph $graph)
    {
        $this->graph = $graph;

    }


    protected function refactoring($change)
    {
        // replace uri
    }

    protected function impactAnalysis($change)
    {
        // analyze by index
    }

    public function serialize($format)
    {
        
        $output = $this->graph->serialize($format);

        return $output;

    }


}

$file = '../../data/MAD_D.rdf';
$data = file_get_contents($file);
$a = new Easy_Rdf_Adapter($data);
$b = new Mapper($a);
$b->serialize('rdfxml');