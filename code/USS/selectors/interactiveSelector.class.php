<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        interactiveSelector.class.php

    Abstract:

        InteractiveSelector class delegates 
        the result selection task to human users

        

    Authors:   


        Feng-Pu Yang, fengpuyang@gmail.com
        Gentry Yao,   polo90406@gmail.com
        

    See Also:

        

    Major Revision History:
    
--*/
include('../QuerySelector.php');

class InteractiveSelector implements QuerySelector
{
        public function setRanker($ranker)
    {
        $this->ranker = $ranker;

    }


    public function select($resultSet)
    {
        $rankedResultSet = $this->ranker.rank($resultSet);
        $result = $this->userInteract($resultSet);
        
        return $result;
    }

    private function userInteract($resultSet)
    {

        //TODO: User interaction Hook
        return $result;
    }

}