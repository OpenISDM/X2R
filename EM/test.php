<?php
namespace X2r\Em;

header ('Content-Type: text/html; charset=utf-8');
require 'vendor/autoload.php';

$file = "../data/MAD_D.rdf";

if (isset($_GET['q'])) {
echo $_GET['q'];
}

if (isset($_GET['d'])) {
echo $_GET['d'];
}

//$data = readfile($file );
//$foaf = new EasyRdf_Graph(null, $data, "rdfxml");
$foaf = new EasyRdf_Graph("http://localhost/data/MAD_D.rdf");
$foaf->load();
$array = $foaf->resources();
$me = strval($foaf->countTriples());
$a2 = "";
foreach($array as $key => $value){
	$a2.= '<br>'.$key." -> ".$value;
	//echo $a2;
}


$alf123 = $foaf->toRdfPhp();
        $count = 0;
        /*
        while($element = current($array)) {
            echo key($array)."\n";
            next($array);
        }*/
        //implode(array_keys(xx));
        $rdfType = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type';
        
        echo '<?php header("Content-Type"," "text/html; charset=UTF-8" ?>';
        foreach ($alf123 as $resourceKey => $resource) {
        	if ($resourceKey instanceof EasyRdf_Resource){
        		echo "-----haha@@@@@@@";
        	}else{
        		
        		echo $resourceKey."-----".$alf123[$resourceKey][$rdfType][0]['type'];
        	}
        	echo '<br>-oo---oo---oo'.key($resource).'<br><br>';
            foreach ($resource as $property => $values) {
            	echo '<br><br>+++++++++++'.implode('-', array_keys($alf123[$resourceKey][$property][0])).'<br><br>';
				echo '<br><br>type:====='.$alf123[$resourceKey][$property][0]['type'].'<br>';
				echo '<br><br>type:====='.$alf123[$resourceKey][$property][0]['value'].'<br>';
				//echo '<br><br>type:====='.$alf123[$resourceKey][$property][0]['datatype'].'<br>';
				//echo '<br><br>value:====='.$alf123[$resourceKey][$property][0].'<br>';
				echo '<br><br>+oo++ooo||  '.implode('.     v    .', array_keys($alf123[$resourceKey])).'  ||<br><br>';
            	echo '::'.$property.'-------------------------'.$value.'<br><br>';

                $count += count($values);
            }
        }
