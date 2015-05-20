/**
 * Match viewmodels
 */
var MatchViewModel = function (matchData) {
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
    }
    else {
        self.rounds.push(new RoundViewModel(self, {}))
    }

    // Viewmodel methods
    self.addRound = function () {
        self.rounds.push(new RoundViewModel(self, {scores: []}));
    };

    self.removeRound = function (round) {
        self.rounds.remove(round);
    };
};

var RoundViewModel = function (parent, roundsData) {
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
    }
    else {
        self.scores.push(new ScoreViewModel(self, {}))
    }

    // Viewmodel methods
    self.addScore = function () {
        self.scores.push(new ScoreViewModel(self, {}));
    };

    self.removeScore = function (score) {
        self.scores.remove(score);
    };
};

var ScoreViewModel = function (parent, scoreData) {
    var self = this;

    self.score_id = ko.observable(scoreData.id);
    self.round_id = ko.observable(parent.round_id);
    self.home = ko.observable(scoreData.score_home);
    self.guest = ko.observable(scoreData.score_guest);
};

/**
 * Data binding
 */
var defaultModelData = {rounds: [{scores: []}]};
var matchParams = (window.location.pathname).split("/");
var matchID = matchParams[matchParams.length - 1];
if ($.isNumeric(matchID)) {
    $.getJSON("/admin/matches/api/edit/" + matchID, function (data) {
        var matchViewModel = new MatchViewModel(data);
        ko.applyBindings(matchViewModel, document.getElementById('match-form'));
    });
}
else {
    var matchViewModel = new MatchViewModel(defaultModelData);
    ko.applyBindings(matchViewModel, document.getElementById('match-form'));
}

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
    $.post("/admin/matches/new", data, function (response) {
        console.log(response);
    });
});
//# sourceMappingURL=main.js.map