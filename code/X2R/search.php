<?php
/*++
Copyright (c) 2014  OpenISDM

    Project Name:

        OpenISDM VR X2R

    Version:

        1.0

    File Name:

        search.php

    Abstract:

        search.php is a components of URI Search Service (USS) of X2R in the
        OpenISDM Virtual Repository project. It receives the search requests
        and perform search of the interests term.

    Authors:

        Yi-Zong Anderson Ou, dreambig.ou@gmail.com
        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.

    Major Revision History:

--*/

    error_reporting(0);

    set_include_path(get_include_path() . PATH_SEPARATOR . './lib/');
    set_include_path(get_include_path() . PATH_SEPARATOR . './');    

    //
    // Include FirePHP for debugging
    //

    require_once 'FirePHPCore/fb.php';
    require_once 'EasyRdf.php';
    require_once 'sparqlTaskClass.php';

    //
    // Start FirePHP
    //

    ob_start();
    FB::info('Start debugging');

    //
    // Receive client requests
    //

    if (isset($_GET['q'])) {
        $query = explode(' ', $_GET['q']); 
        $term = $query[0];

        //
        // Default values
        //

        $defaultSites = 'dbp';
        $sites = explode(',', $defaultSites);
        $output = 'text/html';
        $limit = 10; 
                
        if (isset($_GET['sites'])) {

            //
            // ToDo: check with right delimiter, space and so on
            //

            $sites = explode(',', $_GET['sites']);
        }
        
        if (isset($_GET['output'])) {
            
            
            $output = 'application/json';
        }

        //
        // Add function to iterative
        //

        if (isset($_GET['limit'])) {
            
            $limit = $_GET['limit'];
        }
    } else {

        echo 'Please enter strings to search...';        
        return;
    }

    //
    // 1. Compose query and filter the endpoint-list to extract requested
    //       endpoint URL.
    // Generate tasks according to sites

    if (!empty($sites)) {

        foreach ($sites as $key => $value) {
            $sparqlTask = new SparqlTask();
            $sparqlTask->searchTerm = $term;
            $sparqlTask->output = $output;
            $sparqlTask->limit = $limit;

            //
            // $value is codeName
            //

            $sparqlTask->dataSourceName = getEndpointParam($value, '', '', 'dataSourceName'); 
            $sparqlTask->sparqlEndpointURL = getEndpointParam($value, '', '', 'sparqlEndpointURL');
            $sparqlTask->sparqlQuery = composeQuery(
                $sparqlTask->searchTerm, 
                $sparqlTask->dataSourceName, 
                $sparqlTask->limit,
                $sparqlTask->filters
            );
            $sparqlTasks[] = $sparqlTask;
        }
    }

    //
    // 2.1 Connect individual endpoint and send query
    //

    foreach ($sparqlTasks as $key => $sparqlTask) {  

        //
        // ToDo: Make multi-thread tasks execution
        //

        $sparqlTask->returnResult = sendSparqlQuery(
            $sparqlTask->sparqlQuery,
            $sparqlTask->sparqlEndpointURL,
            $sparqlTask->dataSourceName,
            $sparqlTask->output
        );
    }

    //
    // 2.2 Integrates results
    //

    echo integrateReturnData($sparqlTasks);

    /*++
        Function Name:

            composeQuery

        Function Description:

            This function compose query according to endpoints

        Parameters:

            string term - The term of interest to search.

            string dataSourceName - The name of data source.

            string limit - The number of how many result we want to show.

            array filters - The array of filters setting.

        Returned Value:

            If the function returned normally, the returned is a sparql query;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/
    
    function composeQuery($term, $dataSourceName = '', $limit = 10, $filters = array(''))
    {

        //
        // ToDo: 1. Offset
        //       2. Order by
        //       3. Variable check
        //       4. Terms with spaces
        //

        $query = '';

        //
        // Compose Query according to endpoints
        // Setting Data Source Name (DSN)
        //

        if (!empty($dataSourceName)) {
            
            $query = "SELECT DISTINCT ?s ?o FROM <".$dataSourceName."> WHERE { \n";

        } else {
            $query = "SELECT DISTINCT ?s ?o WHERE { \n";
        }
        
        $query .= "?s <http://www.w3.org/2000/01/rdf-schema#label> ?o . \n";
        $query .= "?o bif:contains \"".$term."\" . \n";

        //
        // For search both lower-case and upper-case ex: Typhoon and typhoon
        //

        if (ctype_upper(substr($term, 0, 1))) {

            $query .= "FILTER ( regex(str(?o), '^".$term."') || regex(str(?o), '^".strtolower($term)."')) . \n";

        } else {

            $query .= "FILTER ( regex(str(?o), '^".$term."') || regex(str(?o), '^".ucfirst(strtolower($term))."')) . \n";

        }

        //
        // Customized filters
        //

        if (!empty($filters)) {
            
            foreach ($filters as $key => $filterString) {

                $query .= "FILTER (!regex(str(?s), '^".$filterString."')) . \n";
            }
        }
        
        $query .= "FILTER (lang(?o) = 'en') . \n";
        $query .= "} \n";

        //
        // ToDo: Implement offset here
        //

        $query .= "Limit ".$limit." \n";

        return $query;
    }

    /*++
        Function Name:

            getEndpointParam

        Function Description:

            This function get the parameter from endpoint.

        Parameters:

            string endpointCodeName - The name of the endpoint code.

            string endpointName - The name of the endpoint.

            string siteURL - The endpoint site URL.

            string item - The item which we want to get.

        Returned Value:

            If the function returned normally, the returned is an endpoint parameter;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/    
    
    function getEndpointParam($endpointCodeName = '', $endpointName = '', $siteURL = '', $item)
    {

        //
        // filter with enpointName;
        //

        $contents = file_GET_contents('config/endpoints.json');         
        $endpointsArray = json_decode($contents, true);     

        foreach ($endpointsArray['endpoints'] as $subArray) {
            if ($endpointCodeName != '') {
                if($subArray['codeName'] == $endpointCodeName) {                    
                    $itemValue = $subArray[$item];
                }                
            } elseif ($endpointName != '') {
                if ($subArray['endpointName'] == $endpointName) {
                    $itemValue = $subArray[$item];
                }
            } elseif ($siteURL != '') {
                if ($subArray['siteURL'] == $siteURL) {
                    $itemValue = $subArray[$item];
                }
            }            
        }        
        return $itemValue;
    }

    /*++
        Function Name:

            sendSparqlQuery

        Function Description:

            This function send a sparql query to the data source where we set.

        Parameters:

            sparqlQuery query - The sparql query.

            string baseURL - The endpoint site URL.

            string dataSourceName - The name of data source.

            string output - The path of output file.

        Returned Value:

            If the function returned normally, the returned is a sparql query result;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/

    function sendSparqlQuery($query, $baseURL, $dataSourceName, $output='text/html')
    {
        $params = array(
            'default-graph-uri' => rtrim($dataSourceName, '/'),
            'should-sponge' => 'soft',
            'query' => $query,
            'debug' => 'on',
            'timeout' => '30000',
            'output' => $output,
            'save' => 'display',
            'fname' => ''
        );

        $querypart = '?';
        foreach ($params as $name => $value) {
            $querypart = $querypart . $name . '=' . urlencode($value) . '&';
        }
        
        $sparqlURL = $baseURL . $querypart;   

        //
        // Currently disable sending header to sparql endpoint
        //

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sparqlURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);        
        $response = curl_exec($ch);

        $result = array(
            'header' => '',
            'body' => '',
            'curlError' => '',
            'httpCode' => '',
            'lastUrl' => '');

        $headerSize = utf8_encode(curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $result['header'] = substr($response, 0, $headerSize);
        $result['body'] = substr($response, $headerSize);
        $result['httpCode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result['lastUrl'] = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        //
        // ToDo: Record error handling
        //

        file_put_contents('log/log.txt', 'SparqlURL: ');
        file_put_contents('log/log.txt', $sparqlURL.'\r\n', FILE_APPEND);
        file_put_contents('log/log.txt', 'Response: ', FILE_APPEND);
        file_put_contents('log/log.txt', $response.'\r\n', FILE_APPEND);
        
        $info = curl_getinfo($ch);
        file_put_contents('log/log.txt', 'Info: ', FILE_APPEND);
        file_put_contents('log/log.txt', $info.'\r\n', FILE_APPEND);
        
        curl_close($ch);

        return $response;
    }

    /*++
        Function Name:

            integrateReturnData

        Function Description:

            This function integrate the sparql query return data.

        Parameters:

            sparqlTasks sparqlTasks - The task for sparql query.

        Returned Value:

            If the function returned normally, the returned is an array of searched results;
            otherwise, the returned value is null.

        Possible Error Code or Exception:

    --*/

    function integrateReturnData($sparqlTasks)
    {
        $integratedResult = array('term' => $sparqlTasks[0]->searchTerm, 'data' => array());

        switch ($sparqlTasks[0]->output) {

            //
            // ToDo: Make other output ex: text/html
            //

            case 'application/json':
                foreach ($sparqlTasks as $key => $sparqlTask) {
                    $result  = array(
                        'dataSourceName' => $sparqlTask->dataSourceName,
                        'response' => json_decode($sparqlTask->returnResult)
                    );
                    
                    $integratedResult['data'][] = $result;
                }

                echo json_encode($integratedResult);
                break;
            
            default:
                # code...
                break;
        }
	}   
?>