<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        queryparser.class.php

    Abstract:

        QueryParser is the class for decoupling 
        the query language from actual search tasks. 
        By this parser, new query language can be
        easily added by simpily adding a corresponding 
        parser. And the existing search tasks can be 
        reuse for different query languages. 

    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com
        Gentry Yao,   polo90406@gmail.com
        

    See Also:

        

    Major Revision History:
    
--*/

header ('Content-Type: text/html; charset=utf-8');

interface QueryParser
{

    /*++
    Function (Constructor) Name:

        QueryParser

    Function Description:
        
        This constructor takes no parameters

    Parameters: N/A

    Note (W.I.):


 
        
    --*/

    function QueryParser()
    {

    }

    /*++
    Function Name:

        parse

    Function Description:
        
        This method parses query string
        and return SPARQL search and 
        result integration commands.   

    Parameters: $queryString      

    Return: $taskCommands
 
        
    --*/


    public function parse($queryString)
    {
        
    }
}