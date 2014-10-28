<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        urisearchresults.class.php

    Abstract:

        UriSearchResults is the class for 
        representing search results
        from different Endpoints with 
        different rank scores.

    Authors:      

        Gentry Yao,   polo90406@gmail.com
        Feng-Pu Yang, fengpuyang@gmail.com

    See Also:

        

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');

class UriSearchResults
{

    private $resultSet = [];

    public function addOneResult($dataSourceName, $searchedResult)
    {
        $result  = array(
                        'dataSourceName' => $dataSourceName,
                        'response' => json_decode($searchedResult)
                    );

        $this->resultSet['data'][] = $result;

    }


    public function addOneScore($uri, $scoreName, $scoreValue)
    {

    }


    public function hasNextResult()
    {

    }

    public function getNextResult()
    { //TODO: if no more result, return end of results, 'EOR'
      //       else return next result

    }

    public function removeOneResult($uri)
    {

    }

    public function removeMultipleResult($uris)
    {

    }
}