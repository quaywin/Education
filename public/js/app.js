"use strick";

app = angular.module('school', [
  'ngRoute',
  'home.controller',
  'account.controller',
  'navigation.controller',
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
      //404
      .when('/home/404', {
        templateUrl: '/home/404'
      })
      .otherwise({
        redirectTo: '/'
      });
  }
]);
app.run(function($rootScope, $location, $cookies) {
  $rootScope.$on("$routeChangeStart", function(event, next, current) {
    if ($cookies['loggedin'] != null && $cookies['loggedin'] != undefined && next.$$route != undefined) {
      if (next.$$route.originalPath == '/account/login' || next.$$route.originalPath == '/account/signup'|| next.$$route.originalPath == '/') {
        $location.path('/account/profile')
      }
    }
  });
});