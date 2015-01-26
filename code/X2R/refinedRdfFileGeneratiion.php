<?php
/*++
    Copyright (c) 2014  OpenISDM

    Project Name:

        OpenISDM VR X2R

    Version:

        1.0

    File Name:

        refinedRdfFileGeneratiion.php

    Abstract:

        refinedRdfFileGeneratiion.php is to finalize the X2R process and download the processed
        file or mapping file from URL.

    Authors:

        Yi-Zong Anderson Ou, dreambig.ou@gmail.com
        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.

    Major Revision History:

--*/
?>

<?php
	error_reporting(0);
	
    $prefixOriginalFile = "orig_";
    $prefixProcessedFile = "proc_";
    $originalFilePath = "original/";
    $processedFilePath = "processed/";
	$mappingFilePath = "mapping/";

	$fileID = "";
	
	$fileID = $_GET["fileID"];

	$originalFilePath .= $prefixOriginalFile.$fileID.'.json';
	$processedFilePath .= $prefixProcessedFile.$fileID.'.json';

	$processedResult = file_get_contents($processedFilePath);


	$mappingFilePath .= 'map_'.$fileID.'.mapping';
	
	
?>

<!DOCTYPE html>

<!--
---- saved from url=(0040)http://getbootstrap.com/examples/navbar/
--->

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://getbootstrap.com/docs-assets/ico/favicon.png">

    <title>X2R</title>

    <!--
    ---- Bootstrap core CSS
    -->

    <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">

    <!--
    ---- Custom styles for this template
    -->

    <link href="http://getbootstrap.com/examples/navbar/navbar.css" rel="stylesheet">

    <!--
    ---- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries
    ---- [if lt IE 9]
    ----  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    ----  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    ---- [endif]
    -->

  
    <script type="text/javascript">
      

    
    </script>
   

  <style type="text/css"></style><script type="text/javascript" async="" src="./index_files/vglnk.js"></script><script type="text/javascript" src="chrome-extension://bfbmjmiodbnnpllbbbfblcplfjjepjdn/js/injected.js"></script><style type="text/css">body {
 text-shadow: 0px 0px 1px #909090 !important;
}</style></head>

  <body style="">

    <div class="container">

      <!--
      ---- Static navbar
      -->

      <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">URI Search Service</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class=""><a href="index.html">URI Search</a></li>
            <li class="active"><a href="x2rConverterIndex.php">X2R</a></li>
            <li class=""><a href="http://openisdm.iis.sinica.edu.tw/">OpenISDM</a></li>      
          </ul>          
        </div>
      </div>

      <!--
      ---- Main component for refinedRdfFileGeneratiion web page
      -->

        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <p>Processed file with replaced URI:  <button type="button" class="btn btn-default">View original file</button> </p>
            <textarea id="processedContent" placeholder="" name="processedContent" id="processedContent" rows="20" cols="150">
			<?
				echo $processedResult;
			?>
			</textarea>
        
            <p>Processed File URL: <a href="http://www.uss.com/file/#12345">http://www.uss.com/file/#12345</a> <button type="button" class="btn btn-default">Copy the link</button> <button type="button" class="btn btn-primary">Download</button> </p>

            <p>Mapping File URL: <a href="<?echo $mappingFilePath?>"><? echo "http://"; echo getenv(DOMAIN_NAME); echo $mappingFilePath?></a> <button type="button" class="btn btn-default">Copy the link</button> <button type="button" class="btn btn-primary">Download</button> </p>
      
          </div>
          <div class="col-md-2"></div>
        </div>
        
      <div class="row">
          <div class="col-md-5"></div>
          <div class="col-md-1">
            <p>        
                 <button type="button" class="btn btn-default">Previous</button>
            </p>
        </div>

        <div class="col-md-1">
            <p>        
                <button type="button" class="btn btn-primary">Back to USS</button>
            </p>
        </div>
        <div class="col-md-5"></div>
      </div>

          <!-- <div class="form-group">
            <label class="col-sm-2 control-label">Format</label>
              <div class="col-sm-2">
                <select class="form-control" name="format">
                  <option>text/html</option>
                  <option>application/json</option>            
                </select>
              </div>
          </div> -->
         <!--  <div class="form-group">
            <div class="col-sm-6"></div>
            <div class="col-sm-2">
              <button type="submit" id="btn-submit" class="btn btn-primary">Search</button>
            </div>
          </div> -->
        <!-- </form> -->

      </div>

    <!--
    ---- /container
    -->

    <div class="container">
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-9" role="dataView">
      <table class="table table-hover"></table>
        </div>
      </div>
    </div>

    <!--
    ---- Bootstrap core JavaScript
    ---- Placed at the end of the document so the pages load faster
    -->

    <script src="./index_files/jquery-1.10.2.min.js"></script>
    <script src="./index_files/bootstrap.min.js"></script>
</body>
</html>