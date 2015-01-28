<?php

require 'PHPUnit/Autoload.php';
require dirname(dirname(dirname(__FILE__))) .'/USS/endpoint.class.php';

class endpointclassTest extends PHPUnit_Framework_TestCase
{
	public function testGetBaseUrl()
	{
		$endpoint = new Endpoint;
		
		$endpoint->configEndpointBaseUrl('http://dbpedia.org/sparql/');
		$this->assertEquals('http://dbpedia.org/sparql/',$endpoint->getBaseUrl());
	}
	
	public function testGetTTL()
	{
		$endpoint = new Endpoint;
		
		$endpoint->configTimeToLiveInSeconds(1);
		$this->assertEquals(1,$endpoint->getTTL());
	}
	
	public function testGetEndpointStatus()
	{
		$endpoint = new Endpoint;
		
		$this->assertTrue($endpoint->getEndpointStatus('127.0.0.1'));
	}
}
