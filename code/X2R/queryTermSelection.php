<?php
/*++
    Copyright (c) 2014  OpenISDM

    Project Name:

        OpenISDM VR X2R

    Version:

        1.0

    File Name:

        queryTermSelection.php

    Abstract:

        queryTermSelection.php will call extractor to extract the URI terms where
        resource user provide and show these terms on this page. User can
        Edit/Delete these terms which extracted by extractor.

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
    
    $inputText = "";
    $inputMethod = "";
    $inputName = "";
    $inputFormat = "";
    $taskID = "";
    $fileID = "";
    $token = "";
    $prefixOriginalFile = "orig_";
    $prefixProcessedFile = "proc_";
    $prefixToken = "token_";
    $originalFilePath = "original/";
    $processedFilePath = "processed/";

    if (isset($_POST["pastedText"])) {

      $inputText = $_POST["pastedText"];
      $inputMethod = "ProcessByPastedText";
      $inputName = "No file name";
      $inputFormat = $_POST["inputFormat"];
      $token = uniqid($prefixToken);     
      $fileID = uniqid();
      $originalFilePath .= $prefixOriginalFile.$fileID.'.json';
      $processedFilePath .= $prefixProcessedFile.$fileID.'.json';
      
	
      if (file_exists($originalFilePath)) {

        //
        // ToDO: check file existence, then create new uid
        //

      } else {
          file_put_contents($originalFilePath, $inputText);
      }

      if (file_exists($processedFilePath)) {

        //
        // ToDO: check file existence, then create new uid
        //

      } else {
          file_put_contents($processedFilePath, $inputText);
      }

      //echo "file get by pasted text: " .$inputText."<br />";

    }
	
	
/*	$baseURL = '../EM/extractor.php';
	 
	$params = array(
	  			'excludedNamespaces' => '',
				'checkUrisStatus' => '1',
				'rdfContent' => $inputText);
				
	$querypart = '?';
	 
	foreach ($params as $name => $value) {
		$querypart = $querypart . $name . '=' . urlencode($value) . '&';
	}		
	 
	$extractorURL = $baseURL . $querypart;   
	 
	$ch = curl_init();
	 
    curl_setopt($ch, CURLOPT_URL, $extractorURL);
	 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);  
      
	$response = curl_exec($ch);
	
	echo $extractorURL;

	$extractionResult = json_encode($response);

	file_put_contents($originalFilePath, stripslashes($extractionResult));*/
	
	//$extractionResult = json_decode(file_get_contents("./files/extractorResult v0.3.json"), true);
	

    //
    // // ProcessByFileURL
    // if (isset($_POST["fileURL"]) && $inputText == "") {
    //   // ToDo: Validate the input URL
    //   //filter_var(urldecode($_POST["fileURL"]), FILTER_VALIDATE_URL);
    //   //echo "fileURL: " .$_POST["fileURL"] ."<br />";
    //   //$inputText = file_get_contents(urldecode($_POST["fileURL"]));
    //
    //   //echo "file get from url: " .$inputText."<br />";
    // }
    //
    // // ProcessByUploadedFile
    // if (isset($_FILES["uploadedFile"])) {
    //   if ($_FILES["uploadedFile"]["error"] > 0 && $inputText == "") {
    //     //echo "file uploaded error code: " .$_FILES["uploadedFile"]["error"]. "<br />";
    //     // ToDo: Validate the uploaded File
    //   } elseif ($inputText == "") {
    //     // echo "file name: " .$_FILES["uploadedFile"]["name"]. "<br />";
    //     // echo "file type: " .$_FILES["uploadedFile"]["type"]. "<br />";
    //     // echo "file size: " .($_FILES["uploadedFile"]["size"] / 1024 ). "KB<br />";
    //     // echo "file temp name: " .$_FILES["uploadedFile"]["tmp_name"]. "<br />";
    //     // ToDO: have a good naming scheme of file to let user retrieeve history files
    //     $originalFilePath = $originalFilePath . basename($_FILES["uploadedFile"]["name"]);
    //
    //     // ToDo: Check the existence of file
    //     if(move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $originalFilePath)) {
    //         // echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded";
    //     } else {
    //         // echo "There was an error uploading the file, please try again!";
    //     }
    //   }
    //
    // } else {
    //   // Error handling
    // }
    //
    
	
	
	
	
    if ($token != "") {

/*
      //
      // Create a task in X2R database
      // make this to load from a configuration file
      //

      $host = 'mysql:host=140.109.17.52:3307;dbname=X2R';
      $user = 'Gentry';
      $pwd = 'openisdm';

      $sql = "";
      $sqlParameters = array();

      try {

        $db_conn = new PDO($host, $user, $pwd);

      } catch (PDOException $e) {

        echo "could not connect to database<br>";

        //
        // Note The Typecast To An Integer!
        //

        echo "Code: ".($e->getCode());
        echo "<br>Error message: ".($e->getMessage());
        exit;
      }    

      $sql = "INSERT INTO `X2R`.`task` (`taskID`, `token`, `inputMethod`, `originalFilePath`, `processedFilePath`) 
              VALUES (NULL, :token, :inputMethod, :originalFilePath, :processedFilePath);";
      
      $sqlParameters = array();
      $sqlParameters = array(
        "token" => $token,
        "inputMethod" => $inputMethod,
        "originalFilePath" => $originalFilePath,
        "processedFilePath" => $processedFilePath
      );

      //
      // $taskID is generated by the autoincreasing primary key in the data table in database
      //

      $statement = $db_conn->prepare($sql);

      if ($statement) {
        $result = $statement->execute($sqlParameters);

        if ($result) {

          $taskID = $db_conn->lastInsertId();
          
        } else {
          $error = $statement->errorInfo();
          echo "Query failed with message: ". $error[2];
        }
      }

      //
      // Generate sql query to add a row in related input method table
      //

      switch ($inputMethod) {
        case "ProcessByPastedText":
          
          $sql = "INSERT INTO `X2R`.`processByPastedText` (`processByPastedTextID`, `taskID`, `format`, `uploadTimestamp`) 
            VALUES (NULL, :taskID, :inputFormat, CURRENT_TIMESTAMP);";

          $sqlParameters = array();
          $sqlParameters = array(
            "taskID" => $taskID,
            "inputFormat" => $inputFormat
          );
          break;

        case "ProcessByFileURL":

          //
          // ToDo: Generate the SQL
          //

          $sql = "";
          break;

        case "ProcessByUploadedFile":

          //
          // ToDo: Generate the SQL
          //

          $sql = "";
          break;
        
        default:
          # code...
          break;
      }

      //
      // Insert a row into in input method tables
      //

      $statement = $db_conn->prepare($sql);

      if ($statement) {
        $result = $statement->execute($sqlParameters);

        if ($result) {

          //
          // ToDo: Actions when successfully insert into database
          //

        } else {
          $error = $statement->errorInfo();
          echo "Query failed with message: ". $error[2];
        }
      }

      //
      // Pre-process default extractor
      // ToDo: Integrate with the real extractor
      // fiel_get_content cannot used in the localhost. bug
      //
*/
	  /*++
	  
		Call Extractor
			POST /extractor{?excludedNamespaces, checkUrisStatus, 
							rdfContent}
	  
		Query Parameters:
			excludedNamespaces – (optional) This specifies a list of 
								namespaces to be skipped. That is, if 
								a found URI belonged to this list, the 
								URI will not be processed anymore.
			checkUrisStatus – (required) This determines if extractor 
								checks the status codes of found URIs.
			rdfContent – (required) This specifies the content of RDF to 
								be processed.
	  
		Response Headers:
			Content-Type – application/json
	  
		Status Codes:	
			200 – no error
			404 – exception
		
	  --*/
/*
	  $baseURL = '../EM/extractor';
	  $params = array(
	  			'excludedNamespaces' => '',
				'checkUrisStatus' => '1',
				'rdfContent' => $statement,);
	  $querypart = '?';
	  foreach ($params as $name => $value) {
	  $querypart = $querypart . $name . '=' . urlencode($value) . '&';}		
	  $extractorURL = $baseURL . $querypart;   
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, $extractorURL);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLINFO_HEADER_OUT, true);  
      
	  $response = curl_exec($ch);

	  $extractionResult = json_decode($response);

	  
	*/
	  //
/*	  
      $extractionResult = json_decode(file_get_contents("./files/extractorResult v0.3.json"), true);

      $mappingMeta = $extractionResult['metaData'];
      $mappingData = $extractionResult['mapping'];

      //
      // Store meta into db
      //

      $sql = "INSERT INTO `X2R`.`task` (`taskID`) 
              VALUES (:taskID);";
      
      $sqlParameters = array();
      $sqlParameters = array("taskID" => $taskID);
      
      $statement = $db_conn->prepare($sql);

      if ($statement) {
        $result = $statement->execute($sqlParameters);

        if ($result) {

          //
          // ToDo: Actions when successfully insert into database
          //

        } else {
          $error = $statement->errorInfo();
          echo "Query failed with message: ". $error[2];
        }   
      }

      //
      // Store data in mappingData into database
      //

      foreach ($mappingData as $data) {
        $term = $data["term"];
        $originalURIText = $data["originalURI"];
        $originalURIMD5 = md5($originalURIText);
        
        if ($data["replacedURI"] != "") {
          $replacedURIText = $data["replacedURI"];
          $replacedURIMD5 = md5($replacedURIText);
        } else {
          $replacedURIText = null;
          $replacedURIMD5 = null;
        }
        
        $status = $data["status"];
        $lineNumbers = $data["lineNumbers"];
                
        $sql = "INSERT INTO `X2R`.`mappingData` (`MappingDataID`, `TaskID`, `Term`, `OriginalURIMD5`, `OriginalURIText`, `ReplacedURIMD5`, `ReplacedURIText`, `Status`, `LineNumbers`) 
                VALUES (NULL, :taskID, :term, :originalURIMD5, :originalURIText, :replacedURIMD5, :replacedURIText, :status, :lineNumbers);";
        
        $sqlParameters = array();
        $sqlParameters = array(
          "taskID" => $taskID,
          "term" => $term,
          "originalURIMD5" => $originalURIMD5,
          "originalURIText" => $originalURIText,
          "replacedURIMD5" => $replacedURIMD5,
          "replacedURIText" => $replacedURIText,
          "status" => $status,
          "lineNumbers" => $lineNumbers
        );

        $statement = $db_conn->prepare($sql);

        if ($statement) {
          $result = $statement->execute($sqlParameters);

          if ($result) {

            //
            // ToDo: Actions when successfully insert into database
            //

          } else {
            $error = $statement->errorInfo();
            echo "Query failed with message: ". $error[2];
          }
        }
      }*/

      //
      // End of calling extractor
      //

      //
      // Write cookie
      //

      SetCookie("fileID", $fileID, time()+3600);
      SetCookie("token", $token, time()+3600);
	
      //
      // Show the input text and code.
      //

      $inputText = "<pre class=\"brush: js class-name:'height_600px_class'\" style=\"height:400px; overflow:hidden;\">".$inputText."</pre>";

    } else {

      //
      // If the token is not set
      //

      return;
    }
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

    //
    // For data tables handling
    //

    /*++
        Function Name:

            RestoreRow

        Function Description:

            Restore a row of the URI term table.

        Parameters:

            oTable - The URI term table

            string nRow - The row which user want to restore

        Returned Value:

        Possible Error Code:

    --*/
 /*       
    function RestoreRow ( oTable, nRow )
    {
      var aData = oTable.fnGetData(nRow);
      var jqTds = $('>td', nRow);
      
      for ( var i=0, iLen=jqTds.length ; i<iLen ; i++ ) {
        oTable.fnUpdate( aData[i], nRow, i, false );
      }
      
      oTable.fnDraw();
    }
*/
    /*++
        Function Name:

            EditRow

        Function Description:

            Edit a row of the URI term table.

        Parameters:

            oTable - The URI term table

            string nRow - The row which user want to edit

        Returned Value:

        Possible Error Code:

    --*/
 /*   
    function EditRow ( oTable, nRow )
    {
      var aData = oTable.fnGetData(nRow);
      var jqTds = $('>td', nRow);

      jqTds[2].innerHTML = '<input id="edit" type="text" value="'+aData[2]+'">';
      jqTds[5].innerHTML = '<a class="edit" href="">Save</a>';

      //
      // ToDo: When press edit button, make the focus on the input field for better UX.
      //

    }
*/
    /*++
        Function Name:

            SaveRow

        Function Description:

            Save a row of the URI term table.

        Parameters:

            oTable - The URI term table

            string nRow - The row which user want to save 

        Returned Value:

        Possible Error Code: 

    --*/
    /*
    function SaveRow ( oTable, nRow)
    {       
      var taskID = "";
      var token = "";
      var originalURI = "";
      var replacedTerm = "";
      var params = new Array();

      var jqInputs = $('#edit', nRow);
      var jqIds = $("span", nRow);

      oTable.fnUpdate( jqInputs[0].value, nRow, 2, false );            
      oTable.fnUpdate( '<a class="edit" href="">Edit</a>', nRow, 5, false );
    
      if(GetCookie("taskID") != "" && GetCookie("token") != "") {
        taskID = GetCookie("taskID");
        token = GetCookie("token");
      }
      
      replacedTerm = jqInputs[0].value;
      mappingDataID = jqIds[0].id;            

      //
      // Request to server to updated the terms
      // ToDo: Security issue and verify successful
      //

      var request = $.ajax({
          type: "POST",
          url: "./dbCrud.php",          
          data: { taskID: taskID, token: token, method: 'update', fieldName: "term",
                  value: replacedTerm, mappingDataID: mappingDataID
                },
          dataType: "json"
        });

        //
        // ToDo: Error handling
        //

        request.done(function( msg ) {
          alert( "Save data successfully" );
        });

        request.fail(function( msg ) {
          alert( "Save data fail: " + msg );
        });

      oTable.fnDraw();
    }
*/
    /*++
        Function Name:

            DeleteRow

        Function Description:

            Delete a row of the URI term table.

        Parameters:

            oTable - The URI term table

            string nRow - The row which user want to delete

        Returned Value:

        Possible Error Code:

    --*/
    /*
    function DeleteRow (oTable, nRow)
    {
      var taskID = "";
      var token = "";      
      var params = new Array();
      var jqIds = $("span", nRow);
          
      if(GetCookie("taskID") != "" && GetCookie("token") != "") {
        taskID = GetCookie("taskID");
        token = GetCookie("token");
      }
      mappingDataID = jqIds[0].id;      

      //
      // Request to server to updated the terms
      // ToDo: Security issue and verify successful
      //

      var request = $.ajax({
          type: "POST",
          url: "./dbCrud.php",          
          data: { taskID: taskID, token: token, method: 'delete', mappingDataID: mappingDataID
                },
          dataType: "json"
        });

        //
        // ToDo: Error handling
        //

        request.done(function( msg ) {
          alert( "Delete row successfully: " + msg );
          oTable.fnDeleteRow( nRow );
        });

        request.fail(function( msg ) {
          alert( "Delete row fail: " + msg );
        });      
    }
*/
    $(document).ready(function(){

      //
      // ToDo: Add functions to Redo/Undo/Reset
      //

      $('#dynamicTable').html('<table class="display" id="example"></table>');
      var oTable = $('#example').dataTable({
        "aoColumns":[
          {"sTitle": "#"},          
          {"sTitle": "Original URI"},
          {"sTitle": "Extracted Term"},
          {"sTitle": "Line Number"},
          {"sTitle": "Status"},
          {"sTitle": "Edit"},
          {"sTitle": "Delete"}
        ]
      });

      var nEditing = null;      
  
      $('#new').click( function (e) {
        e.preventDefault();
        
        var aiNew = oTable.fnAddData( [ '', '', '', '', '', 
          '<a class="edit" href="">Edit</a>', '<a class="delete" href="">Delete</a>' ] );
        var nRow = oTable.fnGetNodes( aiNew[0] );
        EditRow( oTable, nRow );
        nEditing = nRow;
      } );

      $('#example a.delete').live('click', function (e) {
        e.preventDefault();
        
        var nRow = $(this).parents('tr')[0];        

        //
        // childNodes[5] is the "Edit" field.
        //

        if ( nRow.childNodes[5].innerText == "Save" ) {

          //
          // Currently editing this row
          //

          alert("Please finish editing before delete the row.");

        } else if ( nRow.childNodes[5].innerText == "Edit"){

          //
          // No edit in progress. Delete the row
          //

          DeleteRow( oTable, nRow );
        }
        
      } );

      $('#example a.edit').live('click', function (e) {
        e.preventDefault();

        //
        // Get the row as a parent of the link that was clicked on
        //

        var nRow = $(this).parents('tr')[0];
        alert(nRow);
        if ( nEditing !== null && nEditing != nRow ) {

          //
          // Currently editing - but not this row - restore the old before continuing to edit mode.
          // ToDo: Decide to restore or keep the latest one.
          //

          RestoreRow( oTable, nEditing );
          EditRow( oTable, nRow );
          nEditing = nRow;
        }
        else if ( nEditing == nRow && this.innerHTML == "Save" ) {

          //
          // Editing this row and want to save it.
          //

          SaveRow( oTable, nEditing);
          nEditing = null;
        }
        else {

          //
          // No edit in progress - let's start one.
          //

          EditRow( oTable, nRow );
          nEditing = nRow;
        }
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

   /*   var request = $.ajax({
        type: "POST",
        url: "./dbCrud.php",
        data: { taskID: taskID, token: token, method: "read", data: ""},
        dataType: "json"
      });*/

	
	  
      $.getJSON('./original/orig_' + fileID + '.json',function(data){
        console.log(data);
		
        var mapping = "";        
        var URI = "";
        var term = "";
        var lineNumber = "";
        var status = "";
        var mappingDataID = "";
        var row = new Array();        
        
        mapping = data["mapping"];                    

        //
        // Ref: http://www.meadow.se/wordpress/?p=536
        //

        var table = $('#example').dataTable();
        oSettings = table.fnSettings();
        table.fnClearTable(this);

        for (var i = 0; i < mapping.length; i++) {
          URI = mapping[i]["originalURI"];
          term = mapping[i]["term"];
          lineNumber = mapping[i]["lineNumbers"];
          status = mapping[i]["status"];
          mappingDataID = mapping[i]["mappingDataID"];

          row.length = 0;
          
          row.push('<span id='+mappingDataID+'>' +  i + '</span>');          
          row.push(URI);
          row.push(term);
          row.push(lineNumber);
          row.push(status);
          row.push('<a class="edit" href=" ">Edit</a>');
          row.push('<a class="delete" href=" ">Delete</a>');
          
          table.oApi._fnAddData(oSettings, row);

        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        table.fnDraw();

        //
        // Stop form submit button do not submit form to server and force to use AJAX to submit form.
        //

        return false;

      }); 

    });


    </script>

    <script type="text/javascript">
      window.onload = function(){
        console.log("loading ready...");

        $("#btnRefresh").click(function(){
          
          var inputFormat = "";
          var taskID = "";
          
          if(GetCookie("taskID") != "") {
            taskID = GetCookie("taskID");
			fileID = GetCookie("fileID");
          }

          //
          // Get JSON data from server by AJAX
          // ToDo: Add var to specify the parameters of extractor such as format, delimiter
          //

          $.getJSON("./tempExtractor.php", {"taskID": taskID})
          .done(function(data){

            console.log(data);
            var mapping = "";
            var meta = "";
            var URI = "";
            var term = "";
            var lineNumber = "";
            var status = "";
            var mappingDataID = "";
            var row = new Array();            
            var tbody = "";

            meta = data["metaData"];
            mapping = data["mapping"];;

            // 
            // Ref: http://www.meadow.se/wordpress/?p=536
            //

            var table = $('#example').dataTable();
            oSettings = table.fnSettings();
            table.fnClearTable(this);

            for (var i = 0; i < mapping.length; i++) {
              URI = mapping[i]["originalURI"];
              term = mapping[i]["term"];
              lineNumber = mapping[i]["lineNumbers"];
              status = mapping[i]["status"];
              mappingDataID = mapping[i]["mappingDataID"];

              row.length = 0;
              
              row.push('<span id='+mappingDataID+'>' +  i + '</span>');              
              row.push(URI);
              row.push(term);
              row.push(lineNumber);
              row.push(status);
              row.push('<a class="edit" href=" ">Edit</a>');
              row.push('<a class="delete" href=" ">Delete</a>');
              
              table.oApi._fnAddData(oSettings, row);

            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            table.fnDraw();

            //
            // Stop form submit button do not submit form to server and force
            // to use AJAX to submit form.
            //

            return false;
          });
        });
      }
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
          var taskID = "";
          var token = "";
		  var termNum = 0;
          if(GetCookie("token") != "") {
		  
            fileID = GetCookie("fileID");
            token = GetCookie("token");
          }      

		  
           
          var nextlink = "uriSelection.php?fileID=" + fileID + "&token=" + token + "&termNum=" + termNum;
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
          <h4><label for="inputFile">Input File</label></h4>
          <dl class="dl-horizontal">
            <dt>Input Name: </dt>
            <dd> <?php echo $inputName; ?>
              <div class="btn-group">
                <button type="button" class="btn btn-default btn-xs" onclick="ViewAllTerms()">View original input</button>
                
                <button type="button" class="btn btn-default btn-xs  dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li>                                
                    <a href="">Open in external page</a>
                  </li>                              
                </ul>
              </div>
            </dd>
            <dt>Input Format: </dt>
            <dd><?php echo $inputFormat; ?></dd>
            <dt>Input Method: </dt>
            <dd><?php echo $inputMethod; ?></dd>
          </dl>          

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
    
          <div>
           <h4>
            <label for="extractor">Extractor
              <div class="btn-group">
                <button type="submit" class="btn btn-default" id="btnRefresh">Refresh list</button>
                
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li>

                    <!--
                    ---- Button trigger modal
                    -->

                    <a href="" data-toggle="modal" data-target="#extractorModal"><span class="glyphicon glyphicon-cog"></span> Setting</a>                               
                  </li>                              
                </ul>
              </div>
             </label>
           </h4>
          </div>  

          <!--
          ---- Extractor Modal
          -->

          <div class="modal fade" id="extractorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Setting</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" role="form">            
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Delimeter</label>
                      <div class="col-sm-10">
                        <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Default delimeter <span class="glyphicon glyphicon-question-sign"></span>
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            Customized delimeter <button type="button" class="btn btn-default btn-sm">Modify delimeter</button>
                          </label>
                        </div>
                      </div>
                    </div>                    
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
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
        <li><a href="x2rConverterIndex.php" id="previousStep">Previous Step</a></li>        
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