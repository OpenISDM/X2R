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

	$token = "";
	$fileID = "";
	
	$token = $_GET["token"];
	$fileID = $_GET["fileID"];
	

	SetCookie("fileID", $fileID, time()+3600);
    SetCookie("token", $token, time()+3600);
	SetCookie("termNum", '0', time()+3600);
	


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
    ---- USS CSS
    -->

    <link href="./css/uss.css" rel="stylesheet" type="text/css" >

    <!--
    ---- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries
    ---- [if lt IE 9]
    ----  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    ----  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    ---- [endif]
    -->

	<style type="text/css"></style><script type="text/javascript" async="" src="./index_files/vglnk.js"></script>
	<script type="text/javascript" src="chrome-extension://bfbmjmiodbnnpllbbbfblcplfjjepjdn/js/injected.js"></script>

	<!--
	----  Move to uss.css
	---- <style type="text/css">body {
	---- text-shadow: 0px 0px 1px #909090 !important;
	----  }
	---- </style>
	-->
  
	<script type="text/javascript">

 $(document).ready(function(){

      //
      // ToDo: Add functions to Redo/Undo/Reset
      //

      $('#dynamicTable').html('<table class="display" id="example"></table>');
      var oTable = $('#example').dataTable({
        "aoColumns":[
                 
          {"sTitle": "Original URI"},
          {"sTitle": "Term"},
          {"sTitle": "Replaced URI"},
   
        ]
      });

 
        //
        // Get the row as a parent of the link that was clicked on
        //

        var nRow = $(this).parents('tr')[0];
        


      //
      // Initial the first data
      //

      var fileID = "";
      var token = "";
	  var termNum = "";
	  
      if(GetCookie("token") != "") {
        fileID = GetCookie("fileID");
        token = GetCookie("token");
		termNum = GetCookie("termNum");
      }

	
      $.getJSON('./original/orig_' + fileID + '.json',function(data){
        console.log(data);
		
        var mapping = ""; 
        var URI = "";
        var term = "";
   
        var row = new Array();        
        
        mapping = data["mapping"];              

        //
        // Ref: http://www.meadow.se/wordpress/?p=536
        //

        var table = $('#example').dataTable();
        oSettings = table.fnSettings();
        table.fnClearTable(this);

   
        URI = mapping[termNum]["originalURI"];
		
        term = mapping[termNum]["term"];
		
		Replaced = mapping[termNum]["replacedURI"];
		
        Replaced = "";
  
        row.length = 0;
        
        row.push(URI);
        row.push(term);
        row.push(Replaced);
		  
        table.oApi._fnAddData(oSettings, row);
       

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

      <!--
      ---- Fist Row
      -->

      <div class="row"> 
        <div class="col-md-2">
          <ul class="list-group">
            <li class="list-group-item">
              <span class="badge">30</span>
              All terms
            </li>
            <li class="list-group-item">
              <span class="badge">20</span>
              Finished terms
            </li>
            <li class="list-group-item">
              <span class="badge">10</span>
              To-Do terms
            </li>
          </ul>

        </div>        
        <div class="col-md-8">
          <h4><label for="termsToSearch">Extracted terms</label></h4>
          <dl class="dl-horizontal">
            <dt>Original URI:</dt>
            <dd>http://www.yourdomain.com/typhoon</dd>
            <dt>Term:</dt>
            <dd>typhoon</dd>
            <dt>Replaced URI:</dt>
            <dd>http://www.dbpedia.org/typhoon</dd>
          </dl>
        
          <div class="row">
            <div class="col-md-4">              
              <div class="btn-group">
                <button type="button" class="btn btn-default" onclick="ViewAllTerms()">View all terms</button>
                
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li>                                
                    <a href="">View finished terms</a>
                    <a href="">View to-do terms</a>                                
                  </li>                              
                </ul>
              </div>
            </div>            
            <div class="col-md-offset-8">
              
              <div class="btn-group">

                <!--
                ---- <button type="button" class="btn btn-default">Undo</button>
                -->

                <button type="button" class="btn btn-default">Reset</button>

                <!--
                ---- <button type="button" class="btn btn-default">Redo</button>
                -->

              </div>

              <div class="btn-group">
                <button type="button" class="btn btn-default">&larr; Previous</button>
                <button type="button" class="btn btn-default">Next &rarr;</button>
              </div>
            </div>
          </div>

          <div class="panel-group" id="accordion">
              <div class="panel panel-default">

                <!--
                ---- <div class="panel-heading">
                ----   <h1 class="panel-title">
                ----     <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                ----     </a>
                ----   </h1>
                ---- </div>
                -->

                <div id="collapseOne" class="panel-collapse collapse">
                  <div class="panel-body">
                    <div class="termsTable">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>                            
                            <th>Original URI</th>                
                            <th>Term</th>                
                            <th>Replaced URI</th>                
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>                            
                            <td>http://www.yourdomain.com/typhoon</td>
                            <td>typhoon</td>
                            <td>http://www.uss.org/typhoon</td>
                          </tr>
                          <tr>
                            <td>2</td>                            
                            <td>http://www.yourdomain.com/alert</td>
                            <td>alert</td>
                            <td>http://www.uss.org/alert</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>http://www.yourdomain.com/alert</td>
                            <td>alert</td>
                            <td>http://www.uss.org/alert</td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>http://www.yourdomain.com/alert</td>
                            <td>alert</td>
                            <td>http://www.uss.org/alert</td>
                          </tr>
                          <tr>
                            <td>5</td>                            
                            <td>http://www.yourdomain.com/alert</td>
                            <td>alert</td>
                            <td>http://www.uss.org/alert</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>        
                </div>
              </div>
            </div>
          
            <div class="selectTerms">
              <h4><label for="termsToSearch">Search and select URI</label></h4>

              <!--
              ---- Nav tabs
              -->

              <ul class="nav nav-tabs" id="tabs">
                <li class="active"><a href="#byTerms" data-toggle="tab">By Term</a></li>
                <li class><a href="#bySynonyms" data-toggle="tab">By Synonyms</a></li>
                <li class><a href="#addNewURI" data-toggle="tab">Add New URI</a></li>
              </ul>

              <!--
              ---- Tab panes
              -->

              <div class="tab-content" id="tabsContent">
                <div class="tab-pane active in" id="byTerms">
                  <form class="form-horizontal" role="form">        
                    <div class="form-group">
                      <label class="col-sm-2 control-label"> Term </label>
                      <div class="col-sm-10">              
                          <div class="col-xs-4">
                            <input type="text" class="form-control" id="inputSearchedTerm" placeholder="typhoon">
                          </div>

                          <div class="btn-group">
                            
                            <button type="submit" class="btn btn-default">Search</button>
                            
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li>

                                <!--
                                ---- Button trigger modal
                                -->

                                <a href="" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-cog"></span>Setting</a>                               
                              </li>                              
                            </ul>
                          </div>

                          <!--
                          ---- Search  Modal
                          -->

                          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title" id="myModalLabel">Setting</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="checkbox">
                                    <label>
                                      <input type="checkbox" value="withSynonyms" checked="true">
                                      Search with synonyms if no available URI
                                    </label>            
                                  </div>
                                  <div class="radio">
                                    <label>
                                      <input type="radio" name="defaultURISources" id="defaultURISources" value="defaultURISources" checked="true">
                                      Search with default URI sources 
                                    </label>
                                    <button type="button" class="btn btn-default">View</button>
                                  </div>
                                  <div class="radio">
                                    <label>
                                      <input type="radio" name="customizedURISource" id="customizedURISource" value="customizedURISource">
                                      Search with customized URI sources
                                    </label>
                                    <button type="button" class="btn btn-default">Edit</button>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </form>

                  <div class="uriTable">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>

                            <!--
                            ---- <div class="checkbox">
                            ----     <input type="checkbox" value="all" checked="true">
                            ---- </div>
                            -->

                          </th>
                          <th>URI</th>
                          <th>Source</th>
                          <th>Term</th>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>
                            <div class="checkbox">                      
                                  <input type="checkbox" value="1" checked="true">                      
                            </div>
                          </td>
                          <td>http://www.companyA.com/uri1</td>
                          <td>CompanyA</td>
                          <td>typhoon</td>
                          <td>Typhoon is a weather phenomenon in the pacific ocean.</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>
                            <div class="checkbox">
                                  <input type="checkbox" value="2" checked="false">
                            </div>
                          </td>
                          <td>http://www.companyB.com/uri2</td>
                          <td>CompanyB</td>
                          <td>Typhoon Maroko</td>
                          <td>Typhoon Maroko casued severe disaster in south Taiwan in 2010</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>
                            <div class="checkbox">
                                  <input type="checkbox" value="2" checked="false">
                            </div>
                          </td>
                          <td>http://www.companyB.com/uri3</td>
                          <td>CompanyB</td>
                          <td>Typhoon Maroko</td>
                          <td>Typhoon Maroko casued severe disaster in south Taiwan in 2010</td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>
                            <div class="checkbox">
                                  <input type="checkbox" value="2" checked="false">
                            </div>
                          </td>
                          <td>http://www.companyB.com/uri4</td>
                          <td>CompanyB</td>
                          <td>Typhoon Maroko</td>
                          <td>Typhoon Maroko casued severe disaster in south Taiwan in 2010</td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>
                            <div class="checkbox">
                                  <input type="checkbox" value="2" checked="false">
                            </div>
                          </td>
                          <td>http://www.companyB.com/uri5</td>
                          <td>CompanyB</td>
                          <td>Typhoon Maroko</td>
                          <td>Typhoon Maroko casued severe disaster in south Taiwan in 2010</td>
                        </tr>
                        <tr>
                          <td>6</td>
                          <td>
                            <div class="checkbox">
                                  <input type="checkbox" value="" checked="false">
                            </div>
                          </td>
                          <td>http://www.companyB.com/uri6</td>
                          <td>CompanyB</td>
                          <td>Typhoon Maroko</td>
                          <td>Typhoon Maroko casued severe disaster in south Taiwan in 2010</td>
                        </tr>
                        <tr>
                          <td>7</td>
                          <td>
                            <div class="checkbox">
                                  <input type="checkbox" value="2" checked="false">
                            </div>
                          </td>
                          <td>http://www.companyB.com/uri7</td>
                          <td>CompanyB</td>
                          <td>Typhoon Maroko</td>
                          <td>Typhoon Maroko casued severe disaster in south Taiwan in 2010</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="bySynonyms">Search by Synonyms...TBC</div>
                <div class="tab-pane" id="addNewURI">Add New URI...TBC</div>                
              </div>
          </div>

        </div>
        
        <div class="col-md-2"> 

        <!--
        ---- Left
        -->

        </div>

        <!--
        ---- End of first row
        -->

      </div> 

      <ul class="pager">
        <li><a href="#">Previous Step</a></li>
        <li><a href="#">Next Step</a></li>
      </ul>

    <!--
    ---- /container
    -->

    </div> 

    <!--
    ---- Bootstrap core JavaScript
    ---- ==================================================
    ---- Placed at the end of the document so the pages load faster
    -->

    <script src="./index_files/jquery-1.10.2.min.js"></script>
    <script src="./index_files/bootstrap.min.js"></script>
</body>
</html>