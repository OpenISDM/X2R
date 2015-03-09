<?php

require dirname(dirname(dirname(dirname(__FILE__)))) .'/USS/endpoints/dbpedia.php';

class dbpediaTest extends PHPUnit_Framework_TestCase
{
	public function testComposeQuery()
	{
		$endpoint = new dbpedia();
		
		
		$sparqlQueryString = '';
		$sparqlQueryString = "SELECT DISTINCT ?s ?o FROM <"."http://dbpedia.org"."> WHERE { \n";
		$sparqlQueryString .= "?s <http://www.w3.org/2000/01/rdf-schema#label> ?o . \n";
		$sparqlQueryString .= "?o bif:contains \""."typhoon"."\" . \n";
		if (ctype_upper(substr("typhoon", 0, 1))) {
            $sparqlQueryString .= "FILTER ( regex(str(?o), '^"."typhoon"."') || regex(str(?o), '^".strtolower("typhoon")."')) . \n";
        } else {
            $sparqlQueryString .= "FILTER ( regex(str(?o), '^"."typhoon"."') || regex(str(?o), '^".ucfirst(strtolower("typhoon"))."')) . \n";
        }
		$sparqlQueryString .= "FILTER (lang(?o) = 'en') . \n";
        $sparqlQueryString .= "} \n";
		
		$this->assertEquals($sparqlQueryString,
			$endpoint->composeQuery("typhoon", "http://dbpedia.org", 10, $filter));
	}
	
/*	public function provider()
	{
		$dir = dirname(__FILE__);
		$dir .= '/testCase_dbpedia_composeQuery.txt';
		$fp=fopen($dir,"r");
		
		$expection1=fgets($fp,1024);
		
		fclose($fp);
		
		return array(
			array("typhoon",$expection1)
		);
		
	}*/

}