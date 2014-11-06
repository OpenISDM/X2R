<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        ussContainer.class.php

    Abstract:

        

    Authors:   


        Feng-Pu Yang, fengpuyang@gmail.com
        Gentry Yao,   polo90406@gmail.com
        

    See Also:

        

    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');
include_once 'endpoint.class.php';
include_once 'rankers/defaultRanker.class.php';
include_once 'refiners/defaultRefiner.class.php';
include_once 'selectors/defaultSelector.class.php';

class UssContainer
{

    public function getEndpoints()
    {
        $endpoint = new Endpoint();
        return $endpoint;

    }

    public function getParser($parserId)
    {
        $parser = null;
        $defaultParser = new DefaultParser();

        switch($parserId)
        {
            case 'default':
                $parser = $defaultParser();
                
                break;
            
        }
        return $parser;

    }

    public function getSelector($selectorId)
    {
        $selector = null;
        $defaultSelector = new DefaultSelector();
        $interactiveSelector = new InteractiveSelector();
        switch($selectorId)
        {
            case 'default':
                $selector = $defaultSelector;
                break;

            case 'interactive':
                $selector = $interactiveSelector;
                break;
            
        }
        return $selector;

    }

    public function getRanker($rankerId)
    {
        $ranker = null;
        $defaultRanker = new DefaultRanker();
        switch($selectorId)
        {
            case 'default':
                $ranker = $defaultRanker;
                
                break;
            
        }
        return $ranker;

    }

    public function getRefiner($refinerId)
    { 
        $refiner = null;
        $defaultRefiner = new DefaultRefiner();
        $interactiveRefiner = new InteractiveRefiner();
        switch($refinerId)
        {
            case 'default':
                $refiner = $defaultRefiner;
            
            case 'interactive':
                $refiner = $interactiveRefiner;

                break;
            
        }        
        return $refiner;

    }


}