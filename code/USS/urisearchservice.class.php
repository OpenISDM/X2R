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

class UriSearchService
{

    function UriSearchService()
    {

    }


    public function uriSearch($queryString)
    {

        
        // 1. parse the search query
        $searchCommand = $this->parseQuery($queryString);
        
        // 2. execute the search task based on the query
        $resultSet = $this->searchUris($searchCommand);

        // 3. select one fittest result
        $result = $this->selectOneResult($resultSet);


        return $result;
    }

    public function setParser($parser)
    {
        $this->parser = $parser;
        return $this;

    }

    public function setEndpoints($endpoints)
    {
        $this->endpoints = $endpoints;
        return $this;
    }

    public function setSelector($selector)
    {
        $this->selector = $selector;
        return $this;

    }


    protected function parseQuery()
    {
        $this->parser->parse();

    }


    protected function searchUris()
    {
       //USS container

    }


    protected function selectOneResult()
    {

    }






}