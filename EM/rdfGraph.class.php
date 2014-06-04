<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        rdfGraph.class.php

    Abstract:

        rdfGraph.class.php is the class for modeling the 
        RDF graph in a standard way. Developers can add
        new third party RDF parsers into X2R by adapting
        the parser's output to rdfGraph. For example, 
        eayRdfAdapter.class.php is an adapter, which 
        adapts utilities of EasyRDF to rdfGraph.  
        




    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');
include_once 'caseBasedTokenizer.class.php';
include_once 'delimitBasedTokenizer.class.php';

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

        $data


    Returned Value:
        

    Possible Error Code:

    Note (W.I.)

    PHP does not provide for an automatic chain of constructors;
    that is, if you instanti- ate an object of a derived class, 
    only the constructor in the derived class is automatically 
    called. For the constructor of the parent class to be called, 
    the constructor in the derived class must explicitly call 
    the constructor. [cited from 'Programming PHP']

    The child class of RdfGraph should explicitly call the 
    parent constructor, i.e., $this->RdfGraph(); 
        
    --*/
    function RdfGraph($data)
    {
        $this->parse($data);
    }



    /*++
    Function Name:

        parse

    Function Description:
        
        This is an abstract method for developers
        to define RDF parser-specific parse 
        process. For example, programmer adapt 
        parser, such as EasyRDF. And then use 
        the protected method, 'addTuple', to 
        add each tuple found in the inputed RDF
        into rdfGraph. 

    Parameters:

        $data


    Returned Value:
        

    Possible Error Code:

    --*/

    public abstract function parse($data);



    /*++
    Function Name:

        addTuple

    Function Description:
        
        This method provides an incremental way to
        turn input RDF data into X2R specific rdfGraph, 
        where the incremental way means that one tuple 
        per time.  

    Parameters:

        $s
        $p
        $ot
        $ov
        $od


    Returned Value:
        

    Possible Error Code:

    --*/


    protected function addTuple($s, $p, $ot, $ov, $od)
    {
        $tid = $this->getTupleId();
        $newTuple = array();
        $newTuple['subject'] = $s;
        $newTuple['predicate'] = $p;
        $newTuple['objectType'] = $ot;
        $newTuple['objectValue'] = $ov;
        $newTuple['objectDatatype'] = $od;
        $this->x2rGraph[$tid] = $newTuple;
        $this->addIndex($tid);

        return $tid;

    }


    /*++
    Function Name:

        getGraph

    Function Description:
        
        Get the internal rdfGraph 
        in the form of associative
        array. 

    Parameters:


    Returned Value:
        

    Possible Error Code:

    --*/

    protected function getGraph()
    {
        return $this->x2rGraph;
    }

    /*++
    Function Name:

        getIndex

    Function Description:
        
        Get the internal index 
        in the form of associative
        array. 

    Parameters:

        $data


    Returned Value:
        

    Possible Error Code:

    --*/

    protected function getIndex()
    {
        return $this->uriIndex;
    }

    /*++
    Function Name:

        getUris

    Function Description:
        
        This method returns all
        unique URIs as an array. 

    Parameters:


    Returned Value:
        

    Possible Error Code:

    --*/

    public function getUris()
    {
        return array_keys($this->uriIndex);
    }


    /*++
    Function Name:

        addIndex

    Function Description:
        
        During addTuple(), the indexing
        is conducted simultaneously. The 
        rdfGraph is index by URIs. For 
        the sake of resource saving, it uses 
        tuple-id as the reference to 
        actual tuple of the rdfGraph.  

    Parameters:

        $tid


    Returned Value:
        

    Possible Error Code:

    --*/

    protected function addIndex($tid)
    {
        $tuple = $this->x2rGraph[$tid];
        $sub = $tuple['subject'];
        $pre = $tuple['predicate'];
        $obType = $tuple['objectDatatype'];
        

        
        //check subject
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

    /*++
    Function Name:

        getTupleId

    Function Description:
        
        This protected method is only 
        used for indexing purpose. 
        Within the life cycle of rdfGraph 
        instance, this method generates 
        a unique id for each method call. 

    Parameters:


    Returned Value:
        

    Possible Error Code:

    --*/

    protected function getTupleId()
    {
        $this->tupleIdCounter = $this->tupleIdCounter + 1;
        return (string)$this->tupleIdCounter;
    }


    /*++
    Function Name:

        tupleTailType

    Function Description:
        
        Different parser might use different 
        terms to represent same concept of tuple Type.
        This method is a mapping from parser-specific 
        terms to X2R standard terms. To decouple the 
        tight dependency between underlying parser
        and X2R interface.   

    Parameters:

        $uorl


    Returned Value:
        

    Possible Error Code:

    --*/

    protected function tupleTailType($uorl)
    {
        if ($uorl == 'uri')
        {
            return 'URI';
        }
        elseif ($uorl == 'literal')
        {
            return 'Literal';
        }
        else 
        {
            return 'false';
        }
    }



}
