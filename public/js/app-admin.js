"use strick";

app = angular.module('admin', [
  'ngRoute',
  'navigation.controller',
  'classes.controller',
  'teacher.controller',
  'subject.controller',
  'role.controller',
  'helper',
  'ngCookies'
]);
app.config([
  '$routeProvider',
  function($routeProvider) {
    $routeProvider
    //Home
      .when('/', {
        templateUrl: '/home'
      })
      //Account
      .when('/account/login', {
        templateUrl: '/account/login'
      })
      .when('/account/signup', {
        templateUrl: '/account/signup'
      })
      .when('/account/profile', {
        templateUrl: '/account/profile'
      })
      .when('/admin/student', {
        templateUrl: '/admin/student'
      })
      .when('/admin/subject', {
        templateUrl: '/admin/subject'
      })
      .when('/admin/class', {
        templateUrl: '/admin/class'
      })
      .when('/admin/teacher', {
        templateUrl: '/admin/teacher'
      })
      .when('/admin/role', {
        templateUrl: '/admin/role'
      })
      .when('/admin/score', {
        templateUrl: '/admin/score'
      })
      //404
      .when('/home/404', {
        templateUrl: '/home/404'
      })
      .otherwise({
        redirectTo: '/'
      });
  }
]);
app.run(function($rootScope, $location, $cookies,$http) {
  $rootScope.$on("$routeChangeStart", function(event, next, current) {
    if ($cookies['loggedin'] != null && $cookies['loggedin'] != undefined && next.$$route != undefined) {
      if (next.$$route.originalPath == '/account/login' || next.$$route.originalPath == '/account/signup'|| next.$$route.originalPath == '/') {
        $http.post('/account/getTypeUser',{}).success(function(data){
          if(data.status == true){
            if(data.data == 1){
              $location.path('/account/profile')
            }
            if(data.data == 2){
              $location.path('/admin/student')
            }
          }
        });
        
      }
    }
  });
});