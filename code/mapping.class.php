<?php

header ('Content-Type: text/html; charset=utf-8');
class Mapping
{
	public $metadata = array();

	public $mapping;

}

class MEntry
{
	public $status;
	public $originalURI;
	public $replacedURI;
	public $term;
	public $lineNumbers;
}