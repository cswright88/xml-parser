<!DOCTYPE html>
<html>
   <head>
      <title>Inner XML Parsing Tool Talroo</title>
      <meta charset="UTF-8">
      <link rel="icon" href="static/img/five.png">
      <!-- Latest compiled and minified CSS -->
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
      <link rel="stylesheet" href="static/css/bootstrap.min.css">
      <!-- jQuery library -->
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
      <script src="static/js/jquery321min.js"></script>
      <!-- Latest compiled JavaScript -->
      <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
      <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script> -->
      <script src="static/js/413bootstrapbundelmin.js"></script>
      <!-- AngularJS framework -->
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script> -->
      <script src="static/js/164angularmin.js"></script>
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script> -->
      <script src="static/js/169angularroutemin.js"></script>
      <script src="static/js/app.js"></script>
      <link rel="stylesheet" type="text/css" href="static/css/style.css" />
      <style>
         /* input[type=text] { 
         width: 500px;
         }
         */
        .bg-secondary {background-color:grey;}
        .text-white {color:white}
         #rowlg {
         heights:200px;
         }
         html {
         font-size: 14px;
         }
         @media (min-width: 768px) {
         html {
         font-size: 16px;
         }
         }
         .container {
         max-width: 960px;
         }
         .pricing-header {
         max-width: 700px;
         }
         .card-deck .card {
         min-width: 220px;
         }
         .border-top { border-top: 1px solid #e5e5e5; }
         .border-bottom { border-bottom: 1px solid #e5e5e5; }
         .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
         .padd {padding:10px;}
      </style>
   </head>
   <body ng-app='app' ng-controller='ctrl'>
      <!-- Begin app -->
      <!-- <div class="container">
         <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid collapse navbar-collapse">
               <div class="navbar-header">
                  <a class="navbar-brand" href="#">XML Tool</a>
               </div>
               <ul class="nav navbar-nav">
                  <li class="active"><a href="#/!">HOME</a></li>
                  <li><a href="#!title">TITLE</a></li>
                  <li><a href="#!city">CITY</a></li>
                  <li><a href="#!price">PRICE</a></li>
               </ul>
            </div>
         </nav>
      </div> -->
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
            <?php //echo "ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/1051_JC.xml</br> ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/994_JC_PPA.xml</br> https://exchangefeeds.s3.amazonaws.com/3f8752623cd8d9075ec95b01a021ab0d/feed.xml";?>
         </div>
      </header>

      <div class="container">
        <div class="row mb-4 box-shadow">
          <div class="pb-5 padd col-xs-12">
            <form action="" method="POST" class="form">
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="URL" ng-model=url name="url"/>
                </div>
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="VALUES" ng-model=values name="values"/>
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
         error_reporting(0);
         // $url = $_POST['url'];
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
           }
         } 
         
         // $values =  explode(",",$_POST['values']);
         // /([a-zA-Z,]*){0,}/  -- regex to only allow commas an letters
         if (empty($_POST["values"])) {
           $values = "";
         } else{
           $valcheck = $_POST["values"];
           // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
           if (preg_match("/^[a-zA-Z0-9,]+$/i",$valcheck)) {
             $values = explode(",",$_POST['values']);
           }else {
             echo "Invalid values - make sure there are no whitespaces.  Letters, numbers, and commas are allowed"; 
           }
         } 
         // $clickcast = $_POST['clickcast'];
         // $clickcast = false;
         if(!isset($_POST['clickcast']))
         {
           $clickcast = false;
         } else {
           $clickcast = true;
         }
         // echo $values;
         include("scripts/parsexml.php"); 
         $x = json_encode((new Parsexml($url,$values))->parse($clickcast)); 
         
         if (preg_match("/(.gz)$/",$url)){
          $url = "compress.zlib://" . $url;
          }
          $firstlines = array_slice(file($url), 0, 50);
          // $firstlines = file_get_contents($url, NULL, NULL, 0, 50);
          $y = json_encode($firstlines);
          // $y = json_encode(implode('', $firstlines));
         //   echo $x;
      ?>
      <span ng-init="jobArr = <?php echo htmlspecialchars($x); ?>"></span>
      <span ng-init="example = <?php echo htmlspecialchars($y); ?>"></span>
      <div class="container">
         <div ng-view></div>
         <script ng-init="create()" async="true"></script>
      </div>

   </body>