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
include 'caseBasedTokenizer.class.php';
include 'delimitBasedTokenizer.class.php';

Abstract Class RdfGraph
{


    private $x2rGraph = array();
    private $uriIndex = array();
    private $tupleIdCounter = 0;



    
    /*++
    Function (Constructor) Name:

        RdfGraph

    Function Description:
        
        This constructor call the 'parse' method to 
        represents the inputed RDF as an internal/ 
        runtime representation, i.e. RdfGraph 

    Parameters:


    Returned Value:
        

    Possible Error Code:

    Note (W.T)

    PHP does not provide for an automatic chain of constructors;
    that is, if you instanti- ate an object of a derived class, 
    only the constructor in the derived class is automatically 
    called. For the constructor of the parent class to be called, 
    the constructor in the derived class must explicitly call 
    the constructor. [cited from 'Programming PHP']

    The child class of RdfGraph should explicitly call the 
    parent constructor, i.e., $this->RdfGraph(); 
        
    --*/
    function RdfGraph()
    {
        $this->parse();
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


    Returned Value:
        

    Possible Error Code:

    --*/

    public abstract function parse();

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

}
