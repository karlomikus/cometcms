'use strict';

var app = angular.module('cometapp', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('MatchesController', function ($scope, Matches) {
    // Initial data, if any
    $scope.match = {};
    Matches.get(3).success(function (response) {
        console.log(response);
        $scope.match = response;
    });

    // Add new round
    $scope.addRound = function() {
        $scope.match.rounds.push({
            map_id: 0,
            match_id: 3,
            notes: 'An example round note...',
            scores: [{
                score_home: 0,
                score_guest: 0
            }]
        });
    };

    $scope.addScore = function() {

    };

    $scope.submit = function () {

    };
});

app.service('Matches', function ($http) {
    this.get = function (id) {
        return $http.get('/admin/matches/edit/' + id);
    }
});
//# sourceMappingURL=main.js.map