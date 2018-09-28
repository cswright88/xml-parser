<!DOCTYPE html>
<html>
   <head>
      <title>Inner XML Parsing Tool Talroo</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
      <link rel="icon" href="static/img/five.png">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="static/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="static/js/jquery321min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="static/js/413bootstrapbundelmin.js"></script>
      <!-- AngularJS framework -->
      <script src="static/js/164angularmin.js"></script>
      <script src="static/js/169angularroutemin.js"></script>
      <script src="static/js/app.js"></script>
      <!-- Personal CSS -->
      <link rel="stylesheet" type="text/css" href="static/css/style.css" />
      <style>

      </style>
   </head>
   <body ng-app='app' ng-controller='ctrl'>
<div class="container-fluid">
<nav class="navbar navbar-expand-lg navbar-inverse">
    <div class="navbar-toggler navbar-toggler-right hidden-lg hidden-md hidden-sm">
      <span class="navbar-toggler-icon" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <img src="static/img/hamburger.png" alt="expand">
      </span>
    </div>

  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="nav navbar-nav">
      <li class="active">
        <a href="#/!">HOME <span class="sr-only">(current)</span></a>
      </li>
      <li>
        <a href="#!title">TITLE</a>
      </li>
      <li>
        <a href="#!city">CITY</a>
      </li>
      <li>
        <a href="#!price">PRICE</a>
      </li>
      <li>
        <a href="#!company">COMPANY</a>
      </li>
      <li>
        <a href="#!example">EXAMPLE</a>
      </li>
    </ul>
  </div>
</nav>

</div>

      <script>$('.nav.navbar-nav > li').on('click', function(e) {
         $('.nav.navbar-nav > li').removeClass('active');
         $(this).addClass('active');
         });   
      </script>
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
                  <label class="form-label">BID (required)  - ex: cpc:</label>
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
        $file = fopen($url,"rb");
        $firstlines = fread($file, 4096);
        fclose($file);
        $y = json_encode((string)$firstlines);
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