/**
 * Match viewmodels
 */
'use strict';

var MatchViewModel = function MatchViewModel(matchData) {
    var self = this;

    self.match_id = ko.observable(matchData.id);
    self.opponent_id = ko.observable(matchData.opponent_id);
    self.team_id = ko.observable(matchData.team_id);
    self.game_id = ko.observable(matchData.game_id);
    self.rounds = ko.observableArray();

    // Fill in the rounds
    if (matchData.rounds.length > 0) {
        $.each(matchData.rounds, function (key, val) {
            self.rounds.push(new RoundViewModel(this, val));
        });
    } else {
        self.rounds.push(new RoundViewModel(self, {}));
    }

    // Viewmodel methods
    self.addRound = function () {
        self.rounds.push(new RoundViewModel(self, { scores: [] }));
    };

    self.removeRound = function (round) {
        self.rounds.remove(round);
    };

    self.matchRounds = ko.computed(function () {
        return '(BO' + self.rounds().length + ')';
    });

    self.getScore = ko.computed(function () {
        var homeScore = 0;
        var guestScore = 0;

        ko.utils.arrayForEach(self.rounds(), function (round) {
            ko.utils.arrayForEach(round.scores(), function (score) {
                homeScore += parseInt(isNaN(score.home()) ? 0 : score.home());
                guestScore += parseInt(isNaN(score.guest()) ? 0 : score.guest());
            });
        });

        return [homeScore, guestScore];
    });

    self.finalScore = ko.computed(function () {
        return self.getScore()[0] + ':' + self.getScore()[1];
    });

    self.outcome = ko.computed(function () {
        if (self.getScore()[0] > self.getScore()[1]) return 'win';else if (self.getScore()[0] < self.getScore()[1]) return 'lose';else return 'draw';
    });

    self.outcomeClass = ko.computed(function () {
        if (self.getScore()[0] > self.getScore()[1]) return 'label-success';else if (self.getScore()[0] < self.getScore()[1]) return 'label-danger';else return 'label-warning';
    });
};

var RoundViewModel = function RoundViewModel(parent, roundsData) {
    var self = this;

    self.round_id = ko.observable(roundsData.id);
    self.match_id = ko.observable(parent.match_id);
    self.map_id = ko.observable(roundsData.map_id);
    self.scores = ko.observableArray();
    self.notes = ko.observable(roundsData.notes);

    // Fill in the scores
    if (roundsData.scores.length > 0) {
        $.each(roundsData.scores, function (key, val) {
            self.scores.push(new ScoreViewModel(self, val));
        });
    } else {
        self.scores.push(new ScoreViewModel(self, {}));
    }

    // Viewmodel methods
    self.addScore = function () {
        self.scores.push(new ScoreViewModel(self, {}));
    };

    self.removeScore = function (score) {
        self.scores.remove(score);
    };
};

var ScoreViewModel = function ScoreViewModel(parent, scoreData) {
    var self = this;

    self.score_id = ko.observable(scoreData.id);
    self.round_id = ko.observable(parent.round_id);
    self.home = ko.observable(scoreData.home);
    self.guest = ko.observable(scoreData.guest);
};

/**
 * Data binding
 */
var defaultModelData = { rounds: [{ scores: [], notes: null }] };
var matchParams = window.location.pathname.split('/');
var matchID = matchParams[matchParams.length - 1];
var matchViewModel = null;

if ($.isNumeric(matchID)) {
    var getData = $.getJSON('/admin/matches/api/edit/' + matchID);
    getData.done(function (data) {
        matchViewModel = new MatchViewModel(data);
        ko.applyBindings(matchViewModel, document.getElementById('match-form'));
    });
} else {
    matchViewModel = new MatchViewModel(defaultModelData);
    ko.applyBindings(matchViewModel, document.getElementById('match-form'));
}

console.log(matchViewModel);

/**
 * Events
 */
$('#match-form').submit(function (ev) {
    ev.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });
    var data = ko.toJSON(matchViewModel);
    var posting = null;

    if ($.isNumeric(matchID)) {
        posting = $.post('/admin/matches/edit/' + matchID, { data: data });
    } else {
        posting = $.post('/admin/matches/new', { data: data });
    }

    posting.done(function (resp) {
        console.log(resp.alerts[0].message);
        window.location.href = resp.location;
    });
});
//# sourceMappingURL=main.js.map