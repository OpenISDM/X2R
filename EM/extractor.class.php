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
//namespace X2R\EM;
header ('Content-Type: text/html; charset=utf-8');
include 'caseBasedTokenizer.class.php';
include 'delimitBasedTokenizer.class.php';


class Extractor
{

    private $filteredUri = array();
    private $graph;
    private $x2rGraph = array();
    private $uriIndex = array();
    private $tupleIdCounter = 0;

    /*++
    Function Name:

        getUris

    Function Description:
        
        Get URIs found in the given RDF.

    Parameters:


    Returned Value:
        
        Return an array of found URIs.

    Possible Error Code:
        
    --*/
    
    public function __construct(EasyRdf_Graph $graph)
    {
    	$this->graph = $graph;
        $this->parse();

    }


    public function getUris()
    {

        $count = 0;
        $rdfType = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type';
        $assarr = $this->graph->toRdfPhp();
        

        print_r($assarr);
        echo '<br><br><br>';
        echo ' alf123 '.implode('  -  ', array_keys($assarr));
        echo '<br><br><br>';



        //obj-pre-sub  
        foreach ($assarr as $obj => $presub)
        {
            
            echo '--------------';
            echo '<br><br><br>';
            echo $obj;
            
            echo '<br><br><br>';
            print_r($presub);
            echo '<br><br><br>';
            echo ' alf123 '.implode('  <br>  ', array_keys($presub));
            echo '<br>--------------';
            
            foreach($presub as $pre => $subArr)
            {
                echo '<br><br>';
                echo $pre;
                echo '<br>';
                echo implode('  <br>  ', array_keys($subArr[0]));
                $subType = $subArr[0]['type'];
                $subValue = $subArr[0]['value'];
                echo '----<br> type -> '.$subType;
                echo '<br> value -> '.$subValue;
                echo '<br><br>';
            }
/*
            foreach ($resdata as $key => $value)
            {
             echo '---33333------';
            echo '<br><br><br>';
            echo $key;
            echo '<br><br><br>';
            print_r($value[0]);
            echo '<br><br><br>';
            echo '----33333-----';

            if ($value[0] == 'uri')
            {

            }

            }
*/


        }




        foreach ($assarr as $resourceKey => $resource) 
        {
            //print_r($resource);
            //echo '<br><br><br>';
            

            foreach ($resource as $property => $values) 
            {
            /*    
                echo '<br><br>+++++++++++'.implode('-', array_keys($assarr[$resourceKey][$property][0])).'<br><br>'; 
                // Only 'some' literal has the dictionary key :: datatype
                echo 'property is '.$property.'<br><br>';
                echo '<br><br>type:====='.$assarr[$resourceKey][$property][0]['type'].'<br>';
                echo '<br><br>value:====='.$assarr[$resourceKey][$property][0]['value'].'<br>';
                echo '<br><br>+oo++ooo||  '.implode('.     v    .', array_keys($assarr[$resourceKey])).'  ||<br><br>';
                $f = array_keys($assarr[$resourceKey][$property][0]);
                print_r($f);
            */

                //echo $count += count($values);
            }
        }
   	

    }

    protected function parse()
    {

    }
/*

Graph model

attributes:

- tupleId (int)
----
 - tupleType (resource/literal)
 - subject (str)
 - predicate (str)
 - objectType (uri/literal)
 - objectValue (str)
 - objectDatatype (NULL/datatype)

Uri index

attributes:

- uri
----
 - tupleIds (array)

*/
    protected function addTuple($ttyp, $s, $p, $ot, $ov, $od)
    {
        $tid = $this->getTupleId();
        $newTuple = array();
        $newTuple['tupleType'] = $ttyp;
        $newTuple['subject'] = $s;
        $newTuple['predicate'] = $p;
        $newTuple['objectType'] = $ot;
        $newTuple['objectValue'] = $ov;
        $newTuple['objectDatatype'] = $od;
        $this->x2rGraph[$tid] = $newTuple;
        

        return $tid;

    }


    protected function addIndex($tid)
    {
        $tuple = $this->x2rGraph[$tid];
        $sub = $tuple['subject'];
        $pre = $tuple['predicate'];
        $obType = $tuple['objectDatatype'];
        

        
        //check subject
        echo $sub;
        $haystack = array_keys($this->uriIndex);
        if (in_array($sub, $haystack))
        {
            $this->uriIndex[$sub][] = $tid;

        }
        else
        {
            $this->uriIndex[$sub] = array($tid);

        }

        //check predicate
        if (in_array($pre, array_keys($this->uriIndex)))
        {
            $this->uriIndex[$pre][] = $tid;

        }
        else
        {
            $this->uriIndex[$pre] = array($tid);

        }

        //check object

        if ($obType == 'URI')
        {
            $obj = $tuple['objectValue'];
            if (in_array($obj, array_keys($this->uriIndex)))
            {
                $this->uriIndex[$obj][] = $tid;

            }
            else
            {
                $this->uriIndex[$obj] = array($tid);

            }
        }



    }

    protected function getTupleId()
    {
        $this->tupleIdCounter = $this->tupleIdCounter + 1;
        return (string)$this->tupleIdCounter;
    }

    public function tokenize($str)
    {
        $d = new Delimit_Based_Tokenizer();
        $c = new Case_Based_Tokenizer();
        $tempArr = $d->tokenizeStr($str);
        $finalArr = $c->tokenizeArr($tempArr);

        return $finalArr;

    }

    public function getFiltedUris()
    {

    	return $this->filteredUri;

    }

    public function addFilteredUri($furi)
    {
    	array_push($this->filteredUri, $furi);

    	return $this->filteredUri;

    }

    //filter heuristics : reachability & well known
    //get_filter_trial : for traceability


}


