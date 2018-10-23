var ninjaapp = angular.module('app', ["ngRoute"]);
ninjaapp.controller('ctrl', ['$scope','$http', function($scope,$http) {
    $scope.url = "";
    $scope.errorMessage = "";
    $scope.toggleLoading = "";
    $scope.bidthing = "cpc";
    $scope.values = "title,city,state,company,cpc";
    $scope.clickcast = false;
    $scope.limit = 100;
    $scope.begin = 0;
    
    $scope.example = [];

    $scope.jobArr = [];
    $scope.cityArr = [];
    $scope.titleArr = [];
    $scope.priceArr = [];
    $scope.companyArr = [];

    $scope.titlenew=[];
    $scope.citynew=[];
    $scope.pricenew=[];
    $scope.companynew=[];
  

    // Form validation
    

    // Create the different tabs with the model
    $scope.createCity = function() {
        if ($scope.citynew.length > 0 && $scope.jobArr.length > 0){
            console.log('do nothing for city, its already done');
        }else {
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.cityArr.push($scope.jobArr[x]['city']);
            }
            $scope.citynew = $scope.generateCount($scope.cityArr);
        }
    }
    $scope.createTitle = function() {
        if ($scope.titlenew.length > 0 && $scope.jobArr.length > 0){
            console.log('do nothing for title, its already done');
        }else {
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.titleArr.push($scope.jobArr[x]['title']);
            }
            $scope.titlenew = $scope.generateCount($scope.titleArr);
        }
    }
    $scope.createCompany = function() {
        if ($scope.companynew.length > 0 && $scope.jobArr.length > 0){
            console.log('do nothing for company, its already done');
        }else {
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.companyArr.push($scope.jobArr[x]['company']);
            }
            $scope.companynew = $scope.generateCount($scope.companyArr);
        }
    }
    $scope.createBid = function() {
        if ($scope.pricenew.length > 0 && $scope.jobArr.length > 0){
            console.log('do nothing for bid, its already done');
        }else {
        for(var x=0;x<$scope.jobArr.length;x++){
            $scope.priceArr.push($scope.jobArr[x][$scope.bidthing]);
        }
        $scope.pricenew = $scope.generateCount($scope.priceArr);
        }
    }

    // for advanced grep tool
    $scope.valueArr = [];
    $scope.valuePicked = "";
    $scope.getTag = "";
    $scope.innerValPicked = "";
    $scope.innerValArr = [];
    $scope.finalGrepArr = [];
    $scope.grepMostCommon = [];
    $scope.setupGrep = function(){
        if($scope.valueArr.length > 0){
            console.log('do nothing we got the data');
        }else {
            $scope.valueArr = $scope.values.split(",");
        }
    }
    $scope.getFunc = function(newval){
        $scope.getTag = newval;
    }
    $scope.newValue = function(newVal){
        $scope.valuePicked = newVal;
        $scope.innerValArr = [];
        for(var x=0;x<$scope.jobArr.length;x++){
            if($scope.innerValArr.indexOf($scope.jobArr[x][newVal]) > -1){
            }else{
                $scope.innerValArr.push($scope.jobArr[x][newVal]);
            }
        }
    }
    $scope.newInner = function(v){
        $scope.innerValPicked = v;
    }
    $scope.grepFind = function(){
        if ($scope.getTag != "" && $scope.innerValPicked != "" && $scope.valuePicked != ""){
            $scope.finalGrepArr = [];
            for (var c = 0; c < $scope.jobArr.length; c++){
                if($scope.jobArr[c][$scope.valuePicked] == $scope.innerValPicked){
                    $scope.finalGrepArr.push($scope.jobArr[c][$scope.getTag]);
                }
            }
            // call function to get count
            $scope.grepMostCommon = $scope.generateCount($scope.finalGrepArr);
        }
    }



    // moveBack()
    $scope.moveBack = function(){
        if($scope.begin - $scope.limit <= 0){
            $scope.begin = 0;
        }else{
            $scope.begin -= $scope.limit;
        }
    }
        // moveForward()
    $scope.moveForward = function(){
        $scope.begin += $scope.limit;
    }

    $scope.backToStart = function(){
        $scope.begin = 0;
    }

    //calc average 
    $scope.calculateAverage = function(MyData,tag){ 
        var sum = 0; 
        for(var i = 0; i < MyData.length; i++){
            sum += Number(MyData[i][tag]); //don't forget to add the base 
        }
    
        var avg = sum/MyData.length;
    
        return avg; 
    };

    //function to sort a bunch of obj by count that works well for angular call later on 
    $scope.generateCount = function(originalArr) {
        newArr = [];
        for (var x = 0; x<originalArr.length;x++) {
            if (newArr.length > 0) {
                var found = false;
                for (var i = 0; i < newArr.length; i++) {
                    if (newArr[i].name === originalArr[x]) {
                        newArr[i].count++;
                        found = true;
                    }
                }
                if (found === false) {
                    newArr.push({name:originalArr[x],count:1});
                }
            } else {
                newArr.push({name:originalArr[x],count:1});
            }
        }
        return newArr;
    }





/* EVERYTHING BELOW THIS IS NEW CODE FOR THE BRANCH */
    $scope.run = function() {
        $http({
            method  : 'GET',
                url     : "/php/php/scripts/newDownload.php",
            timeout : 60000,
            params  : {
                url:$scope.url,
                values:$scope.values,
                click:$scope.clickcast
            }
            }).then(function successCallback(response) {
                    $scope.jobArr = response.data.data;
                    console.log($scope.jobArr);
                    console.log(response);
                    var str = response.data.message;
                    var success = new RegExp("success");
                    var large = new RegExp("Feed is too large - get with someone who knows grep");
                    var res = success.test(str);
                    var lg = large.test(str);

                    // Error handeling logic 
                    // need it to not display success and display a error from the php code first and then display empty job arr error
                    if (res === false){
                        if(lg == true){
                            $scope.errorMessage = response.data.message;
                        } else {
                            if(response.data.data.length === 0){
                                $scope.errorMessage = "Either the Feed is empty or the xml is incorrectly formated for our Import";
                            } else {
                                $scope.errorMessage = response.data.message;
                            }
                        }
                    } else {
                        $scope.errorMessage = "";
                    }
            },
            function errorCallback(er){
                console.log(er);
                $scope.errorMessage = "error will robinson";
                // var patt = new RegExp('(?<=p0=")(.*)(?=")');
                // var res = patt.exec(unescape(er));
                // $scope.errorMessage = res[0];
            });
        // empty all the arrays 
        $scope.errorMessage = "Loading...";
        $scope.toggleLoading = "";
        $scope.cityArr = [];
        $scope.titleArr = [];
        $scope.priceArr = [];
        $scope.companyArr = [];
        $scope.titlenew=[];
        $scope.citynew=[];
        $scope.pricenew=[];
        $scope.companynew=[];
    }

    $scope.firstLinesExampleRun = function() {
        if ($scope.example.length == 0) {
            $http({
                method  : 'GET',
                url     : "/php/php/scripts/dl_exampleXML.php",
                timeout : 60000,
                params  : {
                    url:$scope.url
                }
                }).then(function(response) {
                        $scope.example = response.data;
                        console.log($scope.example);
                        console.log(response);
                  }, function errorCallback(response) {
                      console.log(response);
            });
        } else {
            console.log("There's already something in the Example - don't do anything");
            // console.log($scope.example.length);
        }

    }















}]);




ninjaapp.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "templates/main.htm"
    })
    .when("/title", {
        templateUrl : "templates/title.htm"
    })
    .when("/price", {
        templateUrl : "templates/price.htm"
    })
    .when("/example", {
        templateUrl : "templates/example.htm"
    })
    .when("/company", {
        templateUrl : "templates/company.htm"
    })
    .when("/advancedGrep", {
        templateUrl : "templates/advancedGrep.htm"
    })
    .when("/city", {
        templateUrl : "templates/city.htm"
    });
});



