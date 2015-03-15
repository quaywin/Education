app = angular.module('student.controller',[]);
app.controller('ProfileController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.loadProfile = function(){
    $http.post('/account/getUser',{}).success(function(data){
      if(data.status === true){
        $scope.Model = data.data;
      }
    });
  };
  $scope.init = function(){
    $scope.loadProfile();
  };
  return $scope.init();
}]);
app.controller('ChangePasswordController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.change = function(){
    $http.post('/student/updatePassword',{currentpassword:$scope.CurrentPassword,newpassword:$scope.NewPassword,confirmpassword:$scope.ConfirmPassword}).success(function(data){
      if(data.status === true){
        toastr.success('Change password successful');
        $location.path('/account/profile');
      }else{
        toastr.error('Cannot change password');
      }
    });
  };
}]);
app.controller('ScoreController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.CurrentPage = 1;
  $scope.ListSubject = [];
  $scope.Count = 0;
  $scope.getListSubject = function(page){
    $http.post('/student/getListScoreByUserId',{page:page}).success(function(data){
      $scope.ListSubject = data.data;
      $scope.Count = data.count;
      $scope.Pages = data.pages;
      $scope.PageSize = data.pageSize;
      $scope.CurrentPage = page;
      if($scope.ListSubject.length === 0 && $scope.CurrentPage>1){
        $scope.CurrentPage --;
        $scope.getListSubject($scope.CurrentPage);
      }
    });
  };
  $scope.init = function(){
    $scope.getListSubject($scope.CurrentPage);
  };
  return $scope.init();
}]);