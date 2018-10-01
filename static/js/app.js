var ninjaapp = angular.module('app', ["ngRoute"]);
ninjaapp.controller('ctrl', ['$scope', function($scope) {
    $scope.url = "";
    $scope.bidthing = "cpc";
    $scope.cityMsg="this is the city stuff";
    $scope.values = "title,city,state,company,cpc";
    $scope.clickcast = false;
    $scope.limit = 100;
    $scope.begin = 0;
    
    $scope.example = [];

    $scope.jobArr = [];
    $scope.cityArr = {};
    $scope.titleArr = {};
    $scope.priceArr = {};
    $scope.companyArr = {};

    $scope.titlenew=[];
    $scope.citynew=[];
    $scope.pricenew=[];
    $scope.companynew=[];
  

    $scope.createCity = function() {
        if ($scope.citynew.length > 0 && $scope.jobArr.length > 0){
            // console.log('do nothing for city, its already done');
        }else {
            // console.log('do something for city, this shit is empty');
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.cityArr[$scope.jobArr[x]['city']] = 1 + ($scope.cityArr[$scope.jobArr[x]['city']] || 0 );
            }
            // console.log(Object.keys($scope.cityArr));
            keyArr = Object.keys($scope.cityArr);
            for(var i=0;i<keyArr.length;i++){
                $scope.citynew.push({
                    name:keyArr[i],
                    count:$scope.cityArr[keyArr[i]]
                });
            }
        }
    }
    $scope.createTitle = function() {
        if ($scope.titlenew.length > 0 && $scope.jobArr.length > 0){
            // console.log('do nothing for title, its already done');
        }else {
            // console.log('do something for title, this shit is empty');
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.titleArr[$scope.jobArr[x]['title']] = 1 + ($scope.titleArr[$scope.jobArr[x]['title']] || 0 );
            }
            // console.log(Object.keys($scope.titleArr));
            keyArr = Object.keys($scope.titleArr);
            for(var i=0;i<keyArr.length;i++){
                $scope.titlenew.push({
                    name:keyArr[i],
                    count:$scope.titleArr[keyArr[i]]
                });
            }
        }
    }
    $scope.createCompany = function() {
        if ($scope.companynew.length > 0 && $scope.jobArr.length > 0){
            // console.log('do nothing for company, its already done');
        }else {
            // console.log('do something for company, this shit is empty');
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.companyArr[$scope.jobArr[x]['company']] = 1 + ($scope.companyArr[$scope.jobArr[x]['company']] || 0 );
            }
            // console.log(Object.keys($scope.companyArr));
            keyArr = Object.keys($scope.companyArr);
            for(var i=0;i<keyArr.length;i++){
                $scope.companynew.push({
                    name:keyArr[i],
                    count:$scope.companyArr[keyArr[i]]
                });
            }
        }
    }
    $scope.createBid = function() {
        if ($scope.pricenew.length > 0 && $scope.jobArr.length > 0){
            // console.log('do nothing for bid, its already done');
        }else {
            // console.log('do something for bid, this shit is empty');
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.priceArr[$scope.jobArr[x][$scope.bidthing]] = 1 + ($scope.priceArr[$scope.jobArr[x][$scope.bidthing]] || 0 );
            }
        //    console.log(Object.keys($scope.priceArr));
           keyArr = Object.keys($scope.priceArr);
           for(var i=0;i<keyArr.length;i++){
               $scope.pricenew.push({
                   name:keyArr[i],
                   count:$scope.priceArr[keyArr[i]]
               });
           }
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



