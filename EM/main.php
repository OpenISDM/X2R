<?php
//namespace X2R\EM;
require 'vendor/autoload.php';
include_once 'extractor.class.php';
include_once 'mapper.class.php';

header ('Content-Type: text/html; charset=utf-8');


$g = getGraph();



$d = new Extractor($g);
$d->getUris();
$kk = $d->tokenize('a+b+cd-E~G!H*&F/史提芬福66_123AlfDioGiftedDFDFSFSDFddddfwerWW-IU');
print_r($kk);
$dd = 1;






function getGraph()
{
	$file = '../../data/MAD_D.rdf';
    $data = file_get_contents($file);
    $g;
    try {
        $g = new EasyRdf_Graph(' ', $data, 'rdfxml');
    } catch (Exception $e) {
        echo 'exception!! invalid RDF.';
    } finally {
        return $g;
    }

}