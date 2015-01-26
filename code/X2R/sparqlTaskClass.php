<?php
/*++
Copyright (c) 2014  OpenISDM

    Project Name:

        OpenISDM VR X2R

    Version:

        1.0

    File Name:

        sparqlTaskClass.php

    Abstract:

        sparqlTaskClass.php declare the sparql task variable.

    Authors:

        Yi-Zong Anderson Ou, dreambig.ou@gmail.com
        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.

    Major Revision History:

--*/

    class SparqlTask
    {
        public $limit;
        public $codeName;
        public $fullName;
        public $siteURL;
        public $sparqlEndpointURL;
        public $dataSourceName;
        public $status;

        public $filters;

        public $searchTerm;
        // public $output;
        public $ouput;
        public $sparqlQuery;
        public $returnResult;
        public $responseHeader;
    }
?>