<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        urisearchservice.class.php

    Abstract:

        UriSearchService is the top level class 
        for organizing and conducting the whole 
        URI searching task

    Authors:      

        Gentry Yao,   polo90406@gmail.com
        Feng-Pu Yang, fengpuyang@gmail.com

    See Also:

        

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');
include_once 'UssContainer.class.php';
include_once 'sparqlRepositoryOperationStatus.php';

class UriSearchService
{

    function UriSearchService()
    {
        $ussContainer = new UssContainer();
        $this->setRefiner($ussContainer->getRefiner("default"));
        $this->setParser($ussContainer->getParser("default"));
        $this->setProcessor($ussContainer->getProcessor("default"));
        $this->setSelector($ussContainer->getSelector("default"));
        $this->setResultRanker($ussContainer->getResultRanker("default"))

    }


    public function uriSearch($sites,$output,$limit,$term)
    {

        
        // 1. parse the search query
        $command = $this->parseQuery($sites,$term,$output,$limit);
        
        // 2. execute the search task based on the query
        $resultSet = $this->searchUris($sites,$term,$output,$limit); 

        // 3. select one fittest result
        //$result = $this->selectOneResult($resultSet);


        return $resultSet;
    }

    public function setParser($parser)
    {
        $this->parser = $parser;
        return $this;

    }

    public function setFederatedSearch($federatedSearch)
    {
        $this->federatedSearch = $federatedSearch;
        return $this;
    }


    public function setProcessor($rsultProcessor)
    {
        $this->processor = $ersultProcessor;
        return $this;

    }

    public function setSelector($selector)
    {
        $this->selector = $selector;
        return $this;

    }

    protected function parseQuery($sites,$term,$output,$limit)
    {
        $spraql = $this->parser->parse($sites,$term,$output,$limit);
        return $spraql;

    }


    protected function searchUris($sites,$term,$output,$limit)
    {
       $resultSet = $this->federatedSearch.search($sites,$term,$output,$limit);
       return $resultSet;

    }



    protected function selectOneResult($resultSet)
    {
        $result = $this->selector.select();
        return $result;

    }



}