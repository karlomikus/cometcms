/**
 * Match viewmodels
 */
var MatchViewModel = function (matchData) {
    var self = this;

    self.opponent_id = ko.observable();
    self.team_id = ko.observable();
    self.game_id = ko.observable();
    self.rounds = ko.observableArray();

    self.addRound = function () {
        self.rounds.push(new RoundViewModel(this));
    };
};

var RoundViewModel = function (parent) {
    var self = this;

    self.match_id = parent.match_id;
    self.map_id = ko.observable();
    self.scores = ko.observableArray();
    self.notes = ko.observable();

    self.addScore = function () {
        self.scores.push(new ScoreViewModel(this));
    };

    self.removeScore = function () {
        self.scores.remove(this);
    }
};

var ScoreViewModel = function (parent) {
    var self = this;

    self.round_id = ko.observable();
    self.home = ko.observable();
    self.guest = ko.observable();
};

/**
 * Resource data
 */
//$.getJSON("/admin/matches/edit/3", function (data) {
//    console.log(data);
//
//    var match = new Match();
//    match.opponent_id = data.opponent_id;
//    match.team_id = data.team_id;
//    match.game_id = data.game_id;
//
//    $.each(data.rounds, function (key, roundVal) {
//        var round = new Round();
//        round.match_id = roundVal.match_id;
//        round.notes = roundVal.notes;
//        round.map_id = roundVal.map_id;
//
//        $.each(roundVal.scores, function (key, scoreVal) {
//            var score = new Score();
//            score.round_id = roundVal.round_id;
//            score.home = roundVal.score_home;
//            score.guest = roundVal.score_guest;
//
//            round.scores.push(score);
//        });
//
//        match.rounds.push(round)
//    });
//
//    console.log(match);
//});

/**
 * Data binding
 */
var matchViewModel = new MatchViewModel({});
ko.applyBindings(matchViewModel, document.getElementById('match-form'));

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