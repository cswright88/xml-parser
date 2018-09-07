<!DOCTYPE html>
<html>
<head>
<title>Inner XML Parsing Tool Talroo</title>
  <meta charset="UTF-8">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
  <!-- AngularJS framework -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
  <script src="static/js/app.js"></script>
  <link rel="stylesheet" type="text/css" href="static/css/style.css" />
  <style>
input[type=text] {
   width: 500px;
}
</style>
</head>
<body ng-app='app' ng-controller='ctrl'>
<!-- Begin app -->


<header class="container">
  <div class="jumbotron">
    <h1> XML Tool
    </h1>
    <!-- <p>Testurl: </br>
    ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/1051_JC.xml</br>
    ftp://recruitics:sc1tiurcer@www2.jobs2careers.com/994_JC_PPA.xml</br>
    https://exchangefeeds.s3.amazonaws.com/3f8752623cd8d9075ec95b01a021ab0d/feed.xml
  </p> -->
  </div>
</header><p></p>
<!-- Make bootstrap container -->


<div class="container">
  <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
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
<script>$('.nav.navbar-nav > li').on('click', function(e) {
    $('.nav.navbar-nav > li').removeClass('active');
    $(this).addClass('active');
});   </script>

    <div class="row">
      <form action="" method="POST" class="form">
        <div class="form-group"><input class="form-control" type="text" placeholder="URL" ng-model=url name="url"/></div>
        <div class="form-group"><input class="form-control" type="text" placeholder="VALUES" ng-model=values name="values"/></div>
        <div class="form-group">
        <label class="form-check-label" for='exampleCheck1'>Clickcast Feed:</label>
        <input class="form-check-input" id='exampleCheck1' type="checkbox" value="0" ng-model=clickcast name="clickcast"/></div>
        <input type="submit"/>
        </div>
      </form>
      <?php
          $url = $_POST['url'];
          $values =  explode(",",$_POST['values']);
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
        //   echo $x;
          ?>
<span ng-init="jobArr = <?php echo htmlspecialchars($x); ?>"></span>
<div ng-view></div>
<script ng-init="create()" async="true"></script>






</div>
</body>