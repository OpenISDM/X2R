<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        x2r.php i

    Abstract:

       X2R integrated X2R's components to perform
        batch mode transformation from raw data to 
        RDF. 

        Other integrated works can also be performed 
        by adding methods in this class

        This class is the API for GUI, CLI or other 
        application development. Some more flexible
        interfaces should be added in the future work.

        We plan to refine this class by using it in 
        adapting old GUI and developing a new CLI.  


    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');
require 'vendor/autoload.php';
include_once 'USS/urisearchservice.class.php';
include_once 'USS/ussContainer.class.php';
include_once 'USS/resultprocessor.class.php';
include_once 'USS/federatedsearch.class.php';
include_once 'EM/extractor.class.php';
include_once 'EM/mapper.class.php';
include_once 'EM/easyRdfAdapter.class.php';

class X2R
{

    public function batchedProcess($rdfContent)
    {
        //Parse rdfContent into Graph Model defined by X2R
        $graph = new Easy_Rdf_Adapter($rdfContent);

        //Process by Extractor
        $extractor = new Extractor($graph);
        $queryTerms = $extractor->getQueryTerms();
        $exchangeDataFromExtractor = json_encode($queryTerms);

        //Hand over to USS
        $uss = new UriSearchService();
        //----start uss configuration (default)
        $ussContainer = new UssContainer();
        $parser = $ussContainer->getParser('default');
        $selector = $ussContainer->getSelector('default');
        $ranker = $ussContainer->getRanker('default');
        $filter = $ussContainer->getFilter('default');

        $resultProcessor = new ResultProcessor();
        $resultProcessor.addOneFilter($filter);
        $resultProcessor.addOneRanker($ranker);

        $federatedsearch = new FederatedSearch();

        $uss->setFederatedSearch($federatedSearch)
            ->setParser($parser)
            ->setProcessor($rsultProcessor)
            ->setSelector($selector);

        $searchResult = $uss->search($exchangeDataFromExtractor);
        $exchangeDataFromUss = json_encode();

        
        //Hand over to Mapper
        $mapper = new Mapper($graph);
        $uriChanges = $this->getChangesFromExchangeData($exchangeDataFromUss);
        $mapper->refactoring('rename', $uriChanges);
        $format = 'rdf/xml';
        $result = $mapper->serialize($format);


        return $result;


    }


    private getChangesFromExchangeData($exchangeData)
    {
        $changes; 
        $mappingObj = json_decode($exchangeData)->{'mapping'};
        foreach ($mappingObj as $mEntry) {

            $oUri = $mEntry->{'originalURI'};
            $uUri = $mEntry->{'replacedURI'};
            $change[$oUri] = $uUri;
        }

        return $changes;
    }



}