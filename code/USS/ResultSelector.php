<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        ResultSelector.php

    Abstract:

        ResultSelector is the interfae
        of how to select one fittest 
        result out from a given 
        result set

    Authors:      

        Gentry Yao,   polo90406@gmail.com
        Feng-Pu Yang, fengpuyang@gmail.com

    See Also:

        

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');

interface ResultSelector
{

    public function setRanker($ranker)
    {

    }

    public function select($resultSet)
    {

    }

}