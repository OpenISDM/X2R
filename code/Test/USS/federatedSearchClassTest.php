<?php

require dirname(dirname(dirname(__FILE__))) .'/USS/federatedSearch.class.php';

class FederatedSearchClassTest extends PHPUnit_Framework_TestCase
{
	public function testIntegrateSearchedResults()
	{
		$search = new FederatedSearch;
		$sparqlTask = new Endpoint;
		$sparqlTask->outputFormat = 'application/json';
		$sparqlTask->searchTerm = $term;
		$sparqlTask->sparqlEndpoint->dataSourceName = 'http://dbpedia.org';
		$sparqlTask->searchedResult = "";
		$sparqlTasks[] = $sparqlTask;
		
		$dir = dirname(__FILE__);
		$dir .= '/testCase_federatedSearchClass.json';
		
		$expection = json_decode(file_get_contents($dir), true);
		
		
		
		$this->assertEquals($expection,$search->integrateSearchedResults($sparqlTasks));
	}
	
/*	public function provider()
	{
		$dir = dirname(__FILE__);
		$dir .= '/testCase_federatedSearchClass.json';
		
		$expection1 = json_decode(file_get_contents($dir), true);
		
		return array(
			array("typhoon",$expection1)
		);
		
	}*/


}
