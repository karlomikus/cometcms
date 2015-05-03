'use strict';

var app = angular.module('cometapp', []);

app.controller('MatchesController', function($scope, MatchFormData) {
    MatchFormData.get().then(function(response) {
        $scope.form = response.data;
    });
});

app.service('MatchFormData', function($http) {
    this.get = function() {
        return $http.get('/admin/matches/form');
    }
});