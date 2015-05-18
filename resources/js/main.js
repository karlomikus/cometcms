var Match = {
    opponent_id: ko.observable(),
    team_id: ko.observable(),
    game_id: ko.observable(),
    rounds: ko.observableArray()
};

var Round = {
    match_id: ko.observable(),
    map_id: ko.observable(),
    notes: ko.observable(),
    scores: ko.observableArray()
};

var Score = {
    round_id: ko.observable(),
    home: ko.observable(),
    guest: ko.observable()
};

$.getJSON("/admin/matches/edit/3", function (data) {
    console.log(data);

    var match = new Match();
    match.opponent_id = data.opponent_id;
    match.team_id = data.team_id;
    match.game_id = data.game_id;

    $.each(data.rounds, function (key, roundVal) {
        var round = new Round();
        round.match_id = roundVal.match_id;
        round.notes = roundVal.notes;
        round.map_id = roundVal.map_id;

        $.each(roundVal.scores, function(key, scoreVal) {
            var score = new Score();
            score.round_id = roundVal.round_id;
            score.home = roundVal.score_home;
            score.guest = roundVal.score_guest;

            round.scores.push(score);
        });

        match.rounds.push(round)
    });

    console.log(match);
});

ko.applyBindings(Match, document.getElementById('match-form'));