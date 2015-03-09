<?php

require dirname(dirname(dirname(__FILE__))) .'/USS/ussContainer.php';

class UssContainerTest extends PHPUnit_Framework_TestCase
{
	public function testGetParser()
	{
		$container = new UssContainer();
		$defaultParser = new DefaultParser();
		
		$this->assertEquals($defaultParser,$container->getParser('default'));
	}
	
	public function testGetSelector()
	{
		$container = new UssContainer();
		$defaultSelector = new DefaultSelector();
		
		$this->assertEquals($defaultSelector,$container->getSelector('default'));
	}
	
	public function testGetRanker()
	{
		$container = new UssContainer();
		$defaultRanker = new DefaultRanker();
		
		$this->assertEquals($defaultRanker,$container->getRanker('default'));
	}
	
	public function testGetRefiner()
	{
		$container = new UssContainer();
		$defaultRefiner = new DefaultRefiner();
		
		$this->assertEquals($defaultRefiner,$container->getRefiner('default'));
	}
}
