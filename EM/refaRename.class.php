<?php
header ('Content-Type: text/html; charset=utf-8');
include_once 'refactor.class.php';
include_once 'rdfGraph.class.php';
include_once 'EasyRdfAdapter.class.php';
Class Rename extends Refactor
{

    function Rename($graph)
    {
    	$this->graph = $graph;
    }

    public function refactoring($change)
    {
    	//refactoring: replace uri
        /*
         *  For each change pair:
         *  1. find all matched tuple id
         *  2. for each tuple
         *      2.1. clone and replace the tuple 
         *      2.2. remove old tuple
         *      2.3. add new clone&replace tuple
         */ 

        $index = $this->graph->getIndex();
        $uris = array_keys($index);

        foreach ($change as $oUri => $rUri) {
            
        	if (in_array($oUri, $uris)) //validity of change
        	{
        		$impactTuples = $index[$oUri];

        		foreach ($impactTuples as $iTuple) {

        		    //2.1. clone replace

                    $tup = $this->graph->getTupleById($iTuple); //clone
                    
                    if ($tup['subject'] == $oUri)               //start replace
                    {
                    	$tup['subject'] = $rUri;
                    }

                    if ($tup['predicate'] == $oUri)
                    {
                    	$tup['predicate'] = $rUri;
                    }

                    if ($tup['objectType'] == 'uri')
                    {
                        if ($tup['objectValue'] == $oUri)
                        {
                    	    $tup['objectValue'] = $rUri;      
                        }
                    }                                          //end replace


        		    //2.2. remove
               
                    $this->graph->removeTuple($iTuple);
        		    //2.3. add
                    $s = $tup['subject'];
                    $p = $tup['predicate'];
                    $ot = $tup['objectType'];
                    $ov = $tup['objectValue'];
                    $od = $tup['objectDatatype'];
        		    $this->graph->addTupleById($iTuple, $s, $p, $ot, $ov, $od);
        		}


        	}
        }

        return $this->graph;


    }






 }



$file = '../../data/MAD_D.rdf';
$data = file_get_contents($file);
$a = new Easy_Rdf_Adapter($data);
$a->removeTuple('1');
$b = new Rename($a);
$alf = array('http://openisdm.iis.sinica.edu.tw/VR/中山運動中心' => 'alf', 'http://openisdm.iis.sinica.edu.tw/VR/大同運動中心' => 'c');
$g = $b->refactoring($alf);
echo ($g->serialize('rdfxml'));

