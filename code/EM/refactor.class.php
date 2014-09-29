<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        refactoring.class.php

    Abstract:

        Refactor is the class that reserves
        the flexibility for introducing 
        new kind of RDF refactoring into 
        this RDF analyzing and manupilation 
        framework. 



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');

Abstract Class Refactor
{

        public abstract function refactoring($change);

 }