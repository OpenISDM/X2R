<?php

header ('Content-Type: text/html; charset=utf-8');

error_reporting(0);

class dbpedia 
{
	public function composeQuery($term, $dataSourceName = '', $limit = 10, $filters = array(''))
	{
		 //
        // ToDo: 1. Offset
        //       2. Order by
        //       3. Variable check
        //       4. Terms with spaces
        //

        $sparqlQueryString = '';

        //
        // Compose Query according to endpoints
        // Setting Data Source Name (DSN)
        //

        if (!empty($dataSourceName)) {
            
            $sparqlQueryString = "SELECT DISTINCT ?s ?o FROM <".$dataSourceName."> WHERE { \n";

        } else {
            $sparqlQueryString = "SELECT DISTINCT ?s ?o WHERE { \n";
        }
        
        $sparqlQueryString .= "?s <http://www.w3.org/2000/01/rdf-schema#label> ?o . \n";
		
        $sparqlQueryString .= "?o bif:contains \"".$term."\" . \n";

        //
        // For search both lower-case and upper-case ex: Typhoon and typhoon
        //

        if (ctype_upper(substr($term, 0, 1))) {
            $sparqlQueryString .= "FILTER ( regex(str(?o), '^".$term."') || regex(str(?o), '^".strtolower($term)."')) . \n";
        } else {
            $sparqlQueryString .= "FILTER ( regex(str(?o), '^".$term."') || regex(str(?o), '^".ucfirst(strtolower($term))."')) . \n";
        }

        //
        // Customized filters
        //

        if (!empty($filters)) {
            
            foreach ($filters as $key => $filterString) {

                $sparqlQueryString .= "FILTER (!regex(str(?s), '^".$filterString."')) . \n";
            }
        }
        
        $sparqlQueryString .= "FILTER (lang(?o) = 'en') . \n";
        $sparqlQueryString .= "} \n";

        //
        // ToDo: Implement offset here
        //

        $query .= "Limit ".$limit." \n";

        return $sparqlQueryString;
	}
	
	public function query($sparqlQueryString)
    {

        //TODO: implement this method by 
        //reusing legacy code
		
		$params = array(
            'default-graph-uri' => rtrim($dataSourceName, '/'),
            'should-sponge' => 'soft',
            'query' => $sparqlQueryString,
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