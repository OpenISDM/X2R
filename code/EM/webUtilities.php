<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        webUtilities.php

    Abstract:

        webUtilities contains common methods 
        for implementing simple HTTP POST API
        



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/

function getParameter($para)
{
    $notAssign = False;


    if(!empty($_POST[$para])) 
    {

        return $_POST[$para];     

    }
    else
    {
        return $notAssign;
    }
}