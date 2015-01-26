<?php

	set_magic_quotes_runtime(0);
	
    $prefixProcessedFile = "proc_";
    $processedFilePath = "processed/";

    $fileID = $_POST['fileID'];
    $termNum = $_POST['termNum'];
    $uri = $_POST['replacedURI'];
	$oUri = $_POST['originalURI'];
	

	$processedFilePath .= $prefixProcessedFile.$fileID.'.json';
	
	$json = json_decode(file_get_contents($processedFilePath), true);
	
	$mapping = $json["mapping"];
	
	$length = count($mapping);
	
    // Save Data Back
    if ($uri != null){


        $json["mapping"][$termNum]["replacedURI"] = $uri;


        file_put_contents($processedFilePath, stripslashes(json_encode($json)));
         

        echo '0';
    } else {

        echo '1';
    }
	
	
	$oUri = str_replace('%3A', ':', $oUri);
	$oUri = str_replace('%2F', '/', $oUri);
	
	$mappingFilePath .= 'mapping/'.'map_'.$fileID.'.mapping';
	
	 if (file_exists($mappingFilePath)) {

		$tempArray = json_decode(file_get_contents($mappingFilePath), true);

      }
	  else{

		$tempArray = array(
			"mapping" => array()
		);
			
	}
	$tempArray["mapping"][]["originalURI"] = $oUri;
	$tempArray["mapping"][$termNum]["replacedURI"] = $uri;
	
	file_put_contents($mappingFilePath, stripslashes(json_encode($tempArray)));
	