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
include_once 'caseBasedTokenizer.class.php';
include_once 'delimitBasedTokenizer.class.php';
include_once 'EasyRdfAdapter.class.php';

class Extractor
{

    private $filteredUri = array();
    private $graph;


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
    
    function Extractor(rdfGraph $graph)
    {
    	$this->graph = $graph;

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

   public function getQueryTerms()
   {
        $allUris = $this->graph->getUris();
        //TODO: do actual filtering 
        $filteredUris = $allUris;
        foreach ($filteredUris as $uri)
        {
            echo ($this->tokenize($this->uriTail($uri)));
            echo '<br>';
        }

   }

   public function uriDomain($uri)
   {
        //return the head (domain) of $uri
        return $udomain;

   }

    public function uriTail($uri)
    {
        $utail = end(preg_split("[/]", $uri));
        return $utail;
    }

    protected function validUri($uri)
    {
        //protocol: http or https
        //TODO: validation rules here

        return true;
    }


    public function tokenize($str)
    {
        $d = new Delimit_Based_Tokenizer();
        $c = new Case_Based_Tokenizer();
        $tempArr = $d->tokenizeStr($str);
        $finalArr = $c->tokenizeArr($tempArr);
        $finalStr = $d->arrToString($finalArr);
        return $finalStr;

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

/* test script

$file = '../../data/MAD_D.rdf';
$data = file_get_contents($file);
$a = new Easy_Rdf_Adapter($data);
$b = new Extractor($a);
$b->getQueryTerms();
$a->serialize('rdfxml');
end test script */