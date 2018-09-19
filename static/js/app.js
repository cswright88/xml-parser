var ninjaapp = angular.module('app', ["ngRoute"]);
ninjaapp.controller('ctrl', ['$scope', function($scope) {
    $scope.origURL = ""
    $scope.url = $scope.origURL;
    $scope.cityMsg="this is the city stuff";
    $scope.values = "title,city,price,cpc";
    $scope.clickcast = false;
    $scope.limit = 100;
    $scope.begin = 0
    $scope.jobArr = [];
    $scope.cityArr = {};
    $scope.titleArr = {};
    $scope.priceArr = {};

    $scope.titlenew=[];
    $scope.citynew=[];
    $scope.pricenew=[];
  

    $scope.create = function() {
        if($scope.jobArr.length != 0){
            // console.log($scope.jobArr);
            for(var x=0;x<$scope.jobArr.length;x++){
                $scope.titleArr[$scope.jobArr[x]['title']] = 1 + ($scope.titleArr[$scope.jobArr[x]['title']] || 0 );
                $scope.cityArr[$scope.jobArr[x]['city']] = 1 + ($scope.cityArr[$scope.jobArr[x]['city']] || 0 );
                $scope.priceArr[$scope.jobArr[x]['price']] = 1 + ($scope.priceArr[$scope.jobArr[x]['price']] || 0 );
                $scope.priceArr[$scope.jobArr[x]['cpc']] = 1 + ($scope.priceArr[$scope.jobArr[x]['cpc']] || 0 );
                
            }
            // console.log(Object.keys($scope.titleArr));
            keyArr = Object.keys($scope.titleArr);
            for(var i=0;i<keyArr.length;i++){
                $scope.titlenew.push({
                    name:keyArr[i],
                    count:$scope.titleArr[keyArr[i]]
                });
            }
            // console.log(Object.keys($scope.cityArr));
            keyArr = Object.keys($scope.cityArr);
            for(var i=0;i<keyArr.length;i++){
                $scope.citynew.push({
                    name:keyArr[i],
                    count:$scope.cityArr[keyArr[i]]
                });
            }
            keyArr = Object.keys($scope.priceArr);
            for(var i=0;i<keyArr.length;i++){
                $scope.pricenew.push({
                    name:keyArr[i],
                    count:$scope.priceArr[keyArr[i]]
                });
            }


        }else{
            $scope.cityMsg = 'no city content';
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
    .when("/city", {
        templateUrl : "templates/city.htm"
    });
});



