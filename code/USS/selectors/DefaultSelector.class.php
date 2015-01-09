<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        defaultSelector.class.php

    Abstract:

        DefaultSelector class returns 
        the rank one result automatically

        

    Authors:   


        Feng-Pu Yang, fengpuyang@gmail.com
        Gentry Yao,   polo90406@gmail.com
        

    See Also:

        

    Major Revision History:
    
--*/

include('../QuerySelector.php');

class DefaultSelector implement QuerySelector
{
        public function setRanker($ranker)
    {
        $this->ranker = $ranker;

    }

    public function select($resultSet)
    {
        $rankedResultSet = $this->ranker.rank($resultSet);
        $result = $rankedResultSet[0];
        
        return $result;
    }

}