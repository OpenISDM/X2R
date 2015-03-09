<?php

require dirname(dirname(dirname(dirname(__FILE__)))) .'/USS/endpoints/linkedgeodata.php';

class linkedgeodataTest extends PHPUnit_Framework_TestCase
{
	public function testComposeQuery()
	{
		$endpoint = new linkedgeodata();
		
		$sparqlQueryString = '';
		$sparqlQueryString = "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> \n";
		$sparqlQueryString .= "PREFIX lgdo: <http://linkedgeodata.org/ontology/> \n";
		$sparqlQueryString .= "SELECT * \n";
		$sparqlQueryString .= "FROM <"."http://linkedgeodata.org/"."> { \n";
		$sparqlQueryString .= "?s a lgdo:"."typhoon"." ;\n";
		$sparqlQueryString .= "rdfs:label ?o \n";
		$sparqlQueryString .= "} ";
		
		$this->assertEquals($sparqlQueryString,
			$endpoint->composeQuery("typhoon", "http://linkedgeodata.org/", 10, $filter));
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