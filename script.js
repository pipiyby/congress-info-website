var myApp = angular.module('myApp', ['angularUtils.directives.dirPagination']);

function MyController($scope,$http) {
      $scope.currentPage = 1;
      $scope.pageSize = 10;
      $scope.meals = [];
      
      var url = 'http://app12016-pipienv.us-west-2.elasticbeanstalk.com/index.php?datab=legislators&byTab=senate&state=senate&callback=JSON_CALLBACK';
      $http.jsonp(url)
          .success(function(data){
          $scope.total = Object.keys(data.results).length;
          $.each(data.results,function(i,d){
              if(d.hasOwnProperty('party')){
                   if(d.party == "R"){
                       d.party = 'r.png';
                   }
                   else if(d.party == "D"){
                       d.party = 'd.png';
                   }
                   else{
                       d.party = 'N.A';
                   }
              }
              else{
                  d.party = 'N.A';
              }
                           
              if(d.hasOwnProperty('chamber')){
                   if(d.chamber == "senate"){
                       d.chamber= '<img style="height:23px" src="s.svg">Senate';
                   }
                   else if(d.chamber == "house"){
                       d.chamber= '<img style="height:23px" src="h.png">House';
                   }
                   else{
                       d.chamber = 'N.A';
                   }
              }
              else{
                       d.chamber = 'N.A';
              }

              if(d.hasOwnProperty('district')){
                   if(d.district != null){
                       d.district= 'District ' + d.district;
                   }
                   else{
                       d.district = 'N.A';
                   }
              }
              else{
                   d.district = 'N.A';
              }

               if(d.hasOwnProperty('state_name')){
                   d.state_name = d.state_name;
               }
               else{
                   d.state_name = 'N.A';
               }
          });
          $scope.resultList = data.results;
          alert(Object.keys(data.results).length);
      }).error(function(data){
          alert("error");
      });

      $scope.pageChangeHandler = function(num) {
          console.log('meals page changed to ' + num);
      };
    }

    function OtherController($scope) {
      $scope.pageChangeHandler = function(num) {
        console.log('going to page ' + num);
      };
}

myApp.controller('MyController', MyController);
myApp.controller('OtherController', OtherController);