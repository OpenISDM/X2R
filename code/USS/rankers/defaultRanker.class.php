<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        DefaultRanker.class.php

    Abstract:

        DefaultRanker class inherits 
        ResultRanker. It return the 
        top ranked result. 

        

    Authors:   


        Feng-Pu Yang, fengpuyang@gmail.com
        Gentry Yao,   polo90406@gmail.com
        

    See Also:

        

    Major Revision History:
    
--*/
include('../ResultRanker.php');
header ('Content-Type: text/html; charset=utf-8');

class DefaultRanker implements ResultRanker
{

	public function rank($result_set)
    {
    	$ranked_result_set;
        return $ranked_result_set;

    }



}