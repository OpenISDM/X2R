<?php
/*++
Copyright (c) 2014  OpenISDM

    Project Name:

        OpenISDM VR X2R

    Version:

        1.0

    File Name:

        x2rConverterIndex.php

    Abstract:

        This module implement the main page of X2R. It contains three ways to
        let user choose the type of input text/files to be processed.
        Currently, we can accept the source by pasted text, file URL and 
        uploaded file.

    Authors:

        Yi-Zong Anderson Ou, dreambig.ou@gmail.com
        Gentry Yao, polo90406@gmail.com

    License:

        This file is subject to the terms and conditions defined in
        file 'COPYING.txt', which is part of this source code package.

    Major Revision History:

--*/
?>

<!DOCTYPE html>

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

    <style type="text/css"></style>
    <script type="text/javascript" async="" src="./index_files/vglnk.js"></script>
    <script type="text/javascript" src="chrome-extension://bfbmjmiodbnnpllbbbfblcplfjjepjdn/js/injected.js"></script>
    <style type="text/css">body {
      text-shadow: 0px 0px 1px #909090 !important;
    }</style>
</head>

  <body style="">
    <div class="container">

      <!--
      ---- The setting of Static navbar
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
        ---- Main component for getting data from different source. After user
        ---- choose, go to queryTermSelection.php.
        -->

        <form class="form-horizontal" role="form"  method="post" action="queryTermSelection.php">
          <div class="form-group">
            <div class="col-sm-12">
              <div class="panel-group" id="accordion">

                <!--
                ---- The format setting of Process by pasted text part
                -->

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Process by pasted text
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="form-group">
                          <label for="pastedText" class="col-sm-2 control-label">Input Text</label>
                            <div class="col-sm-10">
                              <textarea class="form-control"  placeholder="Paste text (ex: RDF) to process" name="pastedText" id="pastedText" rows="20" cols=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">                        
                          <label for="pastedText" class="col-sm-2 control-label">Format</label>
                          <div class="col-sm-2">
                            <select class="form-control" name="inputFormat" id="inputFormat">
                              <option>RDF</option>                            
                            </select>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                </div>

                <!--
                ---- The format setting of Process by file URL part
                -->

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Process by file URL
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <input type="text" class="form-control" name="fileURL">
                    </div>
                  </div>
                </div>

                <!--
                ---- The format setting of Process by uploaded file part
                -->

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        Process by uploaded file
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <input type="hidden" name="MAX_FILE_SIZE" value="100000">
                        <input type="file" name="uploadedFile">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!--
            ---- The button which let user go to next step
            -->

            <div class="form-group">
            <div class="col-sm-8"></div>
            <div class="col-sm-2">
              <button type="submit" id="btn-submit" class="btn btn-primary">Process</button>
            </div>
          </div>
        </form>
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