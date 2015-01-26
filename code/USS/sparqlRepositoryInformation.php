<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        sparqlRepositoryInformation.php

    Abstract:

        sparqlRepositoryInformation.php declare the parameter of sparql endpoint
		information.
        
    Authors:      

        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.
		
    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');

class sparqlRepositoryInformation
{

	var $codeName;

	var $dataSourceName;

	var $siteURL;

	var $sparqlEndpointURL;

	var $operationStatus;	
	

}