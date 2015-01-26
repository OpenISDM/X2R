<?php
/*++
    Copyright (c) 2014  OpenISDM

    Project Name:

        OpenISDM VR X2R

    Version:

        1.0

    File Name:

        uriSelection.php

    Abstract:

        uriSelection.php will call URI Search Service (USS) to search the
        corresponding URI terms from repository which user choose and user 
        could select the best of search result to map to original file. If
        can not find the search result which user want, user can use URI
        Management Service (UMS) to add a URI manually.

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
    
  

    $prefixOriginalFile = "orig_";
    $prefixProcessedFile = "proc_";
    $originalFilePath = "original/";
    $processedFilePath = "processed/";

    $token = "";
	$fileID = "";
	$originalURI = "";

	
	$token = $_GET["token"];
	$fileID = $_GET["fileID"];
	$termNum = $_GET["termNum"];
	
	$originalFilePath .= $prefixOriginalFile.$fileID.'.json';
	$processedFilePath .= $prefixProcessedFile.$fileID.'.json';

	$extractionResult = json_decode(file_get_contents($processedFilePath), true);
	
	
	$mappingData = $extractionResult["mapping"];
	
	$originalURI = $mappingData[$termNum]["originalURI"];
	

	
	SetCookie("fileID", $fileID, time()+3600);
    SetCookie("token", $token, time()+3600);
	SetCookie("termNum", $termNum, time()+3600);
	SetCookie("originalURI", $originalURI, time()+3600);
?>

<!DOCTYPE html>

<!--
---- saved from url=(0040)http://getbootstrap.com/examples/navbar/
-->

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

    <!--
    ---- Link to SyntaxHighter
    -->
    
    <script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
    <script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shBrushJScript.js"></script>
    <link type="text/css" rel="stylesheet" href="syntaxhighlighter_3.0.83/styles/shCoreDefault.css"/>
    <script type="text/javascript">SyntaxHighlighter.all();</script>

    <!--
    ---- Links to jQuery and jQuery UI
    ---- <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> 
    ---- <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    -->

    <!--
    ---- Comment out for using old version jquery for DataTables
    ---- <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    -->

    <!--
    ---- DataTables CSS
    -->

    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">     

    <!--
    ---- jQuery
    -->

    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>     

    <!--
    ---- DataTables
    -->

    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

    <!--
    ---- jQuery-JSON
    -->

    <script type="text/javascript" charset="utf8" src="./lib/jquery.json-2.4.js"></script>  

    <script type="text/javascript">

    /*++
        Function Name:

            ViewAllTerms

        Function Description:

            View all URI terms which extracted by extractor.

        Parameters:

        Returned Value:

        Possible Error Code:

    --*/

    function ViewAllTerms() {
      $('#collapseOne').collapse('toggle');      
    }

    $('#tabs a').click(function (e) {
      e.preventDefault();
     $(this).tab('show');
    });
    </script>

    <script type="text/javascript">

    //
    // Functions of manipulating cookies
    //

    /*++
        Function Name:

            SetCookie

        Function Description:

            Set cookie to save status.

        Parameters:

            string cname - The name of cookie

            cvalue - The value of cookie

            string exdays - The expire days of cookie

        Returned Value:

        Possible Error Code:

    --*/
    
    function SetCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires=" + d.toGMTString();
      document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    /*++
        Function Name:

            SetCookieExpire

        Function Description:

            Set the expire date of cookie.

        Parameters:

            string cname - The name of cookie

        Returned Value:

        Possible Error Code:

    --*/
    
    function SetCookieExpire(cname) {     
      var expires = "expires=Thu, 01 Jan 1970 00:00:00 GMT";
      document.cookie = cname + "=" + "" + "; " + expires;
    }

    /*++
        Function Name:

            GetCookie

        Function Description:

            Get the information of cookie.

        Parameters:

            string cname - The name of cookie

        Returned Value:

        Possible Error Code:

    --*/
        
    function GetCookie(cname) {
      var name = cname + "=";
      var cookies = document.cookie.split(';');      
      
      for(var i = 0; i < cookies.length; i++) {
        
        var cookie = cookies[i].trim();
        
        if (cookie.indexOf(name) == 0) {
          return cookie.substring(name.length, cookie.length);
        }
      } 
    
      return "";
    }
    
    </script>
	
	
    <script type="text/javascript">

	function ReplaceURI (uri)
	{
		var replacedURI = "";
		var fileID = "";
		var mapping = "";
		var term = "";
		var originalURI = "";
		
		if(GetCookie("token") != "") {
			fileID = GetCookie("fileID");
			termNum = GetCookie("termNum");
			originalURI = GetCookie("originalURI");
			
		}
	//alert(originalURI);
		
		$.ajax({
			url: "./saveData.php",  
            type: "POST",
            data: { fileID : fileID,
					termNum : termNum, replacedURI : uri, originalURI : originalURI},
            success: function(data){
                if ( data == '1'){
                    alert('Replaced Unsucess');
                } else {
                    // do something if success 
                }
               
            } 
        });  
	
		
	
		
		

	}

    $(document).ready(function(){

      //
      // ToDo: Add functions to Redo/Undo/Reset
      //

      $('#dynamicTable').html('<table class="display" id="example"></table>');
      var oTable = $('#example').dataTable({
        "aoColumns":[         
          {"sTitle": "URI"},
		  {"sTitle": "Data Source Name"},
          {"sTitle": "Term"},
		  {"sTitle": "Description"},
		  {"sTitle": "Replace"}
        ]
      });

	  var nEditing = null;      
  
      $('#new').click( function (e) {
        e.preventDefault();
        
        var aiNew = oTable.fnAddData( [ '', '', '', '',  
          '<a class="replace" href="">Replace</a>'] );
        var nRow = oTable.fnGetNodes( aiNew[0] );

      } );
	  
      //
      // Initial the first data
      //

      var fileID = "";
      var token = "";
      if(GetCookie("token") != "") {
        fileID = GetCookie("fileID");
        token = GetCookie("token");
      }

	  
	  $('#example a.replace').live('click', function (e) {
        e.preventDefault();
		
       
        var nRow = $(this).parents('tr')[0];
		var uri = "";
		var returnData;
		var aData = oTable.fnGetData(nRow);
		
		
		
		
			
		ReplaceURI(aData[0]);
				
		
        
      } );

	$.getJSON('./processed/proc_' + fileID + '.json',function(data){
        console.log(data);
		var q = "";
        var mapping = "";        
        var termNum = "";

		
		termNum = GetCookie("termNum");
		
	
		
        mapping = data["mapping"];                    

	
        q = mapping[termNum]["term"];




      $.getJSON( "../USS/USSmain.php", { "q": q, "output": "application/json" })    
       .done(function(data){
		console.log(data);

		var term;
		var thead;
		var tbody;
		var tr;
		var returnData;
		var URI;
		var description;
		var row = new Array(); 
		var heads = new Array();
		var body = new Array();
		
		var table = $('#example').dataTable();
        oSettings = table.fnSettings();
        table.fnClearTable(this);
		
		term = data["term"];
        returnData = data["data"];

		for (var i = 0; i < returnData.length; i++) {
          
		  var dataSourceName = returnData[i]["dataSourceName"];
          
		  console.log(dataSourceName);
          
          if(returnData[i]["response"] != null) {
            

            for (var j = 0; j < returnData[i]["response"]["head"]["vars"].length; j++) {
              heads[j] = returnData[i]["response"]["head"]["vars"][j];            

            }

            for (var j = 0; j < returnData[i]["response"]["results"]["bindings"].length; j++) {
				
			  row.length = 0;
				
              for (var k = 0; k < heads.length; k++) {
                
				body[k] = returnData[i]["response"]["results"]["bindings"][j][heads[k]]["value"];
				
				if( k == 0)
				{
					URI = body[k];
					row.push(URI);
					row.push(dataSourceName);
					row.push(term);
				}
				
				if( k == 1)
				{
					description = body[k];
					row.push(description);
				}
              }
			  row.push('<a class="replace" href=" ">Replace</a>');
			  
			  table.oApi._fnAddData(oSettings, row);
            }

          }else{
            
            alert("Response is null");
          
          } // End of if
      
      } // End of outter for loop
		
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        table.fnDraw();

        //
        // Stop form submit button do not submit form to server and force to use AJAX to submit form.
        //

        return false;     
		
      
		});//USS
		});//processed file
		
    });


    </script>
	
	
    <script type="text/javascript">
        $(document).ready(function(){
          var taskID = "";
          var token = "";
		  var termNum;
          if(GetCookie("token") != "") {
            fileID = GetCookie("fileID");
            token = GetCookie("token");
			termNum = GetCookie("termNum");
          }      
		  termNum = parseInt(termNum) + 1;
		  
          var nextlink = "uriSelection.php?fileID=" + fileID + "&token=" + token + "&termNum=" + termNum;
          console.log(nextlink);

          $("#NextTerm").attr("href", nextlink);  
                   
        });
    </script>
	
	
    <script type="text/javascript">
        $(document).ready(function(){
          var taskID = "";
          var token = "";
		  var termNum;
          if(GetCookie("token") != "") {
            fileID = GetCookie("fileID");
            token = GetCookie("token");
			termNum = GetCookie("termNum");
          }      

		  
           
          var nextlink = "refinedRdfFileGeneratiion.php?fileID=" + fileID + "&token=" + token + "&termNum=" + termNum;
          console.log(nextlink);

          $("#NextStep").attr("href", nextlink);  
                   
        });
    </script>

	

  <style type="text/css"></style><script type="text/javascript" async="" src="./index_files/vglnk.js"></script><script type="text/javascript" src="chrome-extension://bfbmjmiodbnnpllbbbfblcplfjjepjdn/js/injected.js"></script><style type="text/css">body {
 text-shadow: 0px 0px 1px #909090 !important;
}</style>

  <!--
  ---- USS CSS
  -->

  <link href="./css/uss.css" rel="stylesheet" type="text/css" >  
  
</head>


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
      
      <div class="row">
      <div  class="col-md-1"></div>
        <div class="col-md-10">
          <h4><label for="inputFile">Extracted terms</label></h4>
          <dl class="dl-horizontal">
            <dt>Original URI: </dt>
            <dd> <?php echo $mappingData[$termNum]["originalURI"]; ?> </dd>
            <dt>Term: </dt>
            <dd> <?php echo $mappingData[$termNum]["term"]; ?> </dd>
            <dt>Replaced URI: </dt>
            <dd> <?php echo $mappingData[$termNum]["replacedURI"]; ?> </dd>
          </dl>          

		<div class="btn-group">
            <button type="button" class="btn btn-default">&larr; Previous Term</button>
            <button type="button" class="btn btn-default"><a href="" id="NextTerm">Next Term &rarr;</a></button>
        </div>
          <div class="col-md-10">
            <div class="panel-group" id="accordion">
              <div class="panel panel-default">
                <div id="collapseOne" class="panel-collapse collapse">
                  <div class="panel-body">
                    <div class="syntaxHighlighter"><?php echo $inputText; ?></div>                      
                  </div>
                </div>        
              </div>
            </div>
          </div>

		</BR>
          <div>
           <h4>
            <label>Search Result</label>
           </h4>
          </div>  

          <!--
          ---- dynamicTable is to display the extracted terms
          -->

          <div id="dynamicTable"></div>

        <!--
        ---- End of middle column
        -->

        </div> 

        <!--
        ---- Right column
        -->

        <div class="col-md-1"> 

        <!--
        ---- End of right col
        -->

        </div>

        <!--
        ---- End of first row
        -->

      </div> 
      <ul class="pager">
        <li><a href="queryTermSelection.php" id="previousStep">Previous Step</a></li>        
        <li><a href="" id="NextStep">Next Step</a></li>
      </ul> 

      <!--
      ---- /container
      -->

    </div>

    <!--
    ---- Bootstrap core JavaScript
    ---- ==================================================
    ---- Placed at the end of the document so the pages load faster
    ---- Comment out the jquery-1.10.2.min.js for using the old versio of jquery for DataTable
    ---- <script src="./index_files/jquery-1.10.2.min.js"></script>
    -->

    <script src="./index_files/bootstrap.min.js"></script>
</body>
</html>