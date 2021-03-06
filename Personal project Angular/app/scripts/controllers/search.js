'use strict';

/**
 * @ngdoc function
 * @name coursExoApp.controller:SearchCtrl
 * @description
 * # SearchCtrl
 * Controller of the coursExoApp
 */
angular.module('coursExoApp')
    .controller('SearchCtrl', function ($scope, $routeParams, serviceAjax) {
        $scope.query = $routeParams.query;
		$scope.data= {
			"currentPage":1
		}
        $scope.loading = true;
        $scope.orderByPredicate = "title";
        $scope.orderByReverse = false;

        $scope.loadMovies = function(){
            $scope.loading = true;
            serviceAjax.search($scope.query, $scope.data.currentPage).success(function(data){
                $scope.loading = false;
                $scope.movies = data.results;
                $scope.totalPages = data.total_pages;
            });
        };

        $scope.pageChanged = function(){
            $scope.loadMovies();
        };

        $scope.clickPredicateName = function(){
            $scope.orderByReverse = !$scope.orderByReverse;
            $scope.orderByPredicate = 'title';
        }

        $scope.clickPredicateRate = function(){
            $scope.orderByReverse = !$scope.orderByReverse;
            $scope.orderByPredicate = 'vote_average';
        }

        $scope.loadMovies();
    });

