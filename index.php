<!DOCTYPE html>
<html>
   <head>
      <base href="/php/php/">
      <title>Inner XML Parsing Tool Talroo</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
      <link rel="icon" href="static/img/five.png">
      <!-- bootstrap requirements internal files -->
      <link rel="stylesheet" href="static/css/bootstrap.min.css">
      <script src="static/js/jquery321min.js"></script>
      <script src="static/js/413bootstrapbundelmin.js"></script>
      <!-- EXTERNAL FILES -->
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
      <!-- AngularJS framework -->
      <script src="static/js/164angularmin.js"></script>
      <script src="static/js/169angularroutemin.js"></script>
      <script src="static/js/app.js"></script>
      <!-- Personal CSS -->
      <link rel="stylesheet" type="text/css" href="static/css/style.css" />
      <script>
        // This only works with the external files added above for bootstrap -- need to configure the internal docs to fit thoes again instead of current external ones
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
      </script>
   </head>
   <!-- BODY -->
   <body ng-app='app' ng-controller='ctrl'>
      <!-- BEGIN NAV -->
      <div class="container-fluid">
      <nav class="navbar navbar-fixed-top navbar-inverse">
         <div class="container-fluid">
            <div class="navbar-header">
               <div class="navbar-toggler navbar-toggler-right hidden-lg hidden-md hidden-sm">
                  <span class="navbar-toggler-icon" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <img src="static/img/hamburger.png" alt="expand">
                  </span>
               </div>
               <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                  <ul ng-click="backToStart()" class="nav navbar-nav">
                     <li class="active">
                        <a href="#/!">OVERVIEW <span class="sr-only">(current)</span></a>
                     </li>
                     <li>
                        <a href="#!title" ng-click="createTitle()">TITLE</a>
                     </li>
                     <li>
                        <a href="#!city" ng-click="createCity()">CITY</a>
                     </li>
                     <li>
                        <a href="#!price" ng-click="createBid()">BID</a>
                     </li>
                     <li>
                        <a href="#!company" ng-click="createCompany()">COMPANY</a>
                     </li>
                     <li>
                        <a href="#!example" ng-click="firstLinesExampleRun()">EXAMPLE</a>
                     </li>
                     <li>
                        <a href="#!advancedGrep" ng-click="setupGrep()">ADVANCED (beta)</a>
                     </li>
                  </ul>
               </div>
            </div>
      </nav>
      </div>
      <script>$('.nav.navbar-nav > li').on('click', function(e) {
         $('.nav.navbar-nav > li').removeClass('active');
         $(this).addClass('active');
         });   
      </script>
      <!-- END NAV -->
      <!-- BEGIN HEADER -->
      <header class="container">
         <div class="jumbotron">
            <h1> XML Tool
            </h1>
            <h3 ng-show = "errorMessage" class="alert alert-danger">{{errorMessage}}</h3>
            <h3 ng-show = "toggleLoading" class="alert alert-info">{{toggleLoading}}</h3>
         </div>
      </header>
      <div class="container">
         <div class="row mb-4 box-shadow">
            <div class="pb-5 padd col-xs-12">
               <form class="form" name="myForm">
                  <div class="form-group">
                     <input class="form-control" ng-pattern="/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i" type="text" placeholder="URL (required)" name="url" ng-model='url' required />
                     <span class="red" ng-show="myForm.url.$touched && myForm.url.$invalid">The URL is invalid.</span>
                  </div>
                  <div class="form-group">
                     <label class="form-label">VALUES (required) - ex: title,city,state,cpc:</label>
                     <input class="form-control" ng-pattern="/^[a-zA-Z0-9,_-]+$/i" type="text" placeholder="VALUES (required) - ex: title,city,state,cpc" ng-model=values name="values"/>
                     <span class="red" ng-show="myForm.values.$touched && myForm.values.$invalid">The Values field is invalid.</span>
                     <label class="form-label" data-toggle="tooltip" data-placement="right" title="Bid tag must also be a values tag to work">BID TAG (required)  - ex: cpc:</label>
                     <input class="form-control" type="text" placeholder="BID (required)  - ex: cpc" ng-model=bidthing name="bid"/>
                  </div>
                  <!-- TURNNED OFF BECAUSE NEW DOWNLOAD DOESN'T REQUIRE YOU TO LIST CLICKCAST OR NOT
                    <div class="form-group">
                     <label class="form-check-label" for='exampleCheck1'>Clickcast Feed:</label>
                     <input class="form-check-input" id='exampleCheck1' type="checkbox" value="0" ng-model=clickcast name="clickcast"/>
                  </div> -->
                  <input ng-disabled="!myForm.$valid" ng-click="run()" type="submit"/>
               </form>
            </div>
         </div>
      </div>
      <?php
         // Turn Error Reporting Off for Production
        //  error_reporting(0);
        //  function test_input($data) {
        //    $data = trim($data);
        //    $data = stripslashes($data);
        //    $data = htmlspecialchars($data);
        //    return $data;
        //  }
        //  if (empty($_POST["url"])) {
        //    $url = "";
        //  } else{
        //    $website = test_input($_POST["url"]);
        //    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        //    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
        //      echo "Invalid URL"; 
        //    }else {
        //      $url = $_POST['url'];
        //      $u = json_encode((string)$url);
        //    }
        //  } 
         
        //  if (empty($_POST["values"])) {
        //    $values = "";
        //  } else{
        //    $valcheck = preg_replace('/\s+/', '', $_POST["values"]);
        //    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        //    if (preg_match("/^[a-zA-Z0-9,_-]+$/i",$valcheck)) {
        //      $v = json_encode((string)$_POST['values']);
        //      $values = explode(",",$valcheck);
        //    }else {
        //      echo "Invalid Characters in Values - Only Letters, numbers, whitespaces, dashes, underscores and commas are allowed"; 
        //    }
        //  } 
        //  if(!isset($_POST['clickcast']))
        //  {
        //    $clickcast = false;
        //  } else {
        //    $clickcast = true;
        //  }
        //  // echo $values;
         
        //  include("scripts/parsexml.php"); 
        //  $x = json_encode((new Parsexml($url,$values))->parse($clickcast)); 
        //  //  do I still need this since its in download.php?
        //  if (preg_match("/(.gz)$/",$url)){
        //    $url = "compress.zlib://" . $url;
        //  }
         
        //  // read first part of the xml file for example.htm
        // //  $file = fopen($url,"rb");
        // //  $firstlines = fread($file, 8192);
        // //  fclose($file);
        // //  $y = json_encode((string)$firstlines);

        //  $handle = fopen($url, "rb");
        //  if (FALSE === $handle) {
        //   exit("Failed to open stream to URL");
        //  }

        //  $contents = "";
        //  $count = 0;
        //  while ($count < 2) {
        //     $contents .= fread($handle, 8192);
        //     $count ++;
        //  }
        //  fclose($handle);
        /* 
        $y = preg_split('/(<.*?>.*?<\/.*?>)/',$contents,-1,PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        */
          
        // //  $y = explode(">",$contents);
        //  $y = json_encode($y);
        //  //  echo $y;
         
        //  //  add price to the model for angular
        //  if (empty($_POST["bid"])) {
        //    $bid = "";
        //  } else{
        //    $bidstring = test_input($_POST["bid"]);
        //    $bidstring = preg_replace('/\s+/', '', $bidstring);
        //    // check if bid address syntax is valid (this regular expression also allows dashes in the bid)
        //    if (!preg_match("/[a-z]/i",$bidstring)) {
        //      echo "Invalid bid"; 
        //    // $bid = $_POST['bid'];
        //    }else {
        //      $z = json_encode((string)$bidstring);
        //    }
        //  } 
         ?>
      <!-- <span ng-init="jobArr = <?php //echo htmlspecialchars($x); ?>; example = <?php //echo htmlspecialchars($y); ?>; bidthing = <?php //echo htmlspecialchars($z); ?>; url = <?php //echo htmlspecialchars($u); ?>; values = <?php //echo htmlspecialchars($v); ?>"></span> -->
      <div class="container">
         <div ng-view></div>
      </div>

   </body>