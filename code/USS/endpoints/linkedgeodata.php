<?php

header ('Content-Type: text/html; charset=utf-8');

error_reporting(0);

class linkedgeodata
{
	public function composeQuery($term, $dataSourceName = '', $limit = 10, $filters = array(''))
	{
		$sparqlQueryString = "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> \n";
		$sparqlQueryString .= "PREFIX lgdo: <http://linkedgeodata.org/ontology/> \n";
		$sparqlQueryString .= "SELECT * \n";
		$sparqlQueryString .= "FROM <".$dataSourceName."> { \n";
		$sparqlQueryString .= "?s a lgdo:".$term." ;\n";
		$sparqlQueryString .= "rdfs:label ?o \n";
		$sparqlQueryString .= "} ";

        return $sparqlQueryString;
	}
	
	public function query($sparqlQueryString)
    {		
		$params = array(
			'default-graph-uri' => rtrim($dataSourceName, '/'),
			'query' => $query,
			'format' => $output,
			'timeout' => '0',
			'debug' => 'on',	
			);	

        $querypart = '?';
        foreach ($params as $name => $value) {
            $querypart = $querypart . $name . '=' . urlencode($value) . '&';
        }
        
        $sparqlURL = $baseURL . $querypart;   
		
		$ch = curl_init();
		
        curl_setopt($ch, CURLOPT_URL, $sparqlURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);   
		
        $queryResult = curl_exec($ch);
		
		curl_close($ch);
		
        return $queryResult;
    }
}



?>