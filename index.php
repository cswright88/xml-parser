<!DOCTYPE html>
<html>
   <head>
      <title>Inner XML Parsing Tool Talroo</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
      <link rel="icon" href="static/img/five.png">
      <!-- jQuery library -->
      <script src="static/js/jquery321min.js"></script>
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="static/css/bootstrap.min.css">
      <!-- Downloaded version jquery first -->
      <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
      <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
      <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
      <!-- Latest compiled JavaScript -->
      <script src="static/js/413bootstrapbundelmin.js"></script>
      <!-- AngularJS framework -->
      <script src="static/js/164angularmin.js"></script>
      <script src="static/js/169angularroutemin.js"></script>
      <script src="static/js/app.js"></script>
      <!-- Personal CSS -->
      <link rel="stylesheet" type="text/css" href="static/css/style.css" />
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
                        <a href="#!title">TITLE</a>
                     </li>
                     <li>
                        <a href="#!city">CITY</a>
                     </li>
                     <li>
                        <a href="#!price">BID</a>
                     </li>
                     <li>
                        <a href="#!company">COMPANY</a>
                     </li>
                     <li>
                        <a href="#!example">EXAMPLE</a>
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
         </div>
      </header>
      <div class="container">
         <div class="row mb-4 box-shadow">
            <div class="pb-5 padd col-xs-12">
               <form action="" method="POST" class="form">
                  <div class="form-group">
                     <input class="form-control" type="text" placeholder="URL (required)" ng-model=url name="url"/>
                  </div>
                  <div class="form-group">
                     <label class="form-label">VALUES (required) - ex: title,city,state,cpc:</label>
                     <input class="form-control" type="text" placeholder="VALUES (required) - ex: title,city,state,cpc" ng-model=values name="values"/>
                     <label class="form-label" data-toggle="tooltip" data-placement="right" title="This tag doesn't have to be in the feed for this to work.  This is used to determine average bid.  Make sure your bid tag is also one of your values listed above">BID TAG (required)  - ex: cpc:</label>
                     <input class="form-control" type="text" placeholder="BID (required)  - ex: cpc" ng-model=bidthing name="bid"/>
                  </div>
                  <div class="form-group">
                     <label class="form-check-label" for='exampleCheck1'>Clickcast Feed:</label>
                     <input class="form-check-input" id='exampleCheck1' type="checkbox" value="0" ng-model=clickcast name="clickcast"/>
                  </div>
                  <input type="submit"/>
               </form>
            </div>
         </div>
      </div>
      <?php
         // Turn Error Reporting Off for Production
         error_reporting(0);
         function test_input($data) {
           $data = trim($data);
           $data = stripslashes($data);
           $data = htmlspecialchars($data);
           return $data;
         }
         if (empty($_POST["url"])) {
           $url = "";
         } else{
           $website = test_input($_POST["url"]);
           // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
           if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
             echo "Invalid URL"; 
           }else {
             $url = $_POST['url'];
             $u = json_encode((string)$url);
           }
         } 
         
         if (empty($_POST["values"])) {
           $values = "";
         } else{
           $valcheck = preg_replace('/\s+/', '', $_POST["values"]);
           // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
           if (preg_match("/^[a-zA-Z0-9,]+$/i",$valcheck)) {
             $v = json_encode((string)$_POST['values']);
             $values = explode(",",$valcheck);
           }else {
             echo "Invalid Values - Only Letters, numbers, whitespaces, and commas are allowed"; 
           }
         } 
         if(!isset($_POST['clickcast']))
         {
           $clickcast = false;
         } else {
           $clickcast = true;
         }
         // echo $values;
         
         include("scripts/parsexml.php"); 
         $x = json_encode((new Parsexml($url,$values))->parse($clickcast)); 
         //  do I still need this since its in download.php?
         if (preg_match("/(.gz)$/",$url)){
           $url = "compress.zlib://" . $url;
         }
         
         // read first part of the xml file for example.htm
        //  $file = fopen($url,"rb");
        //  $firstlines = fread($file, 8192);
        //  fclose($file);
        //  $y = json_encode((string)$firstlines);

         $handle = fopen($url, "rb");
         if (FALSE === $handle) {
          exit("Failed to open stream to URL");
         }

         $contents = "";
         $count = 0;
         while ($count < 2) {
            $contents .= fread($handle, 8192);
            $count ++;
         }
         fclose($handle);
         $y = explode(">",$contents);
         $y = json_encode($y);
         //  echo $y;
         
         //  add price to the model for angular
         if (empty($_POST["bid"])) {
           $bid = "";
         } else{
           $bidstring = test_input($_POST["bid"]);
           $bidstring = preg_replace('/\s+/', '', $bidstring);
           // check if bid address syntax is valid (this regular expression also allows dashes in the bid)
           if (!preg_match("/[a-z]/i",$bidstring)) {
             echo "Invalid bid"; 
           // $bid = $_POST['bid'];
           }else {
             $z = json_encode((string)$bidstring);
           }
         } 
         ?>
      <span ng-init="jobArr = <?php echo htmlspecialchars($x); ?>; example = <?php echo htmlspecialchars($y); ?>; bidthing = <?php echo htmlspecialchars($z); ?>; url = <?php echo htmlspecialchars($u); ?>; values = <?php echo htmlspecialchars($v); ?>"></span>
      <div class="container">
         <div ng-view></div>
         <script ng-init="create()"></script>
      </div>
   </body>