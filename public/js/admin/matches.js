"use strict";

var matchViewModel = null;
var defaultModelData = {game_id: 1, rounds: [{scores: [], notes: null}], participants: {team: []}};

/**
 * Main match viewmodel. Depends on other viewmodels.
 * @param matchData Existing match data
 * @param addonData Contains meta data like games, teams, opponents
 * @constructor
 */
var MatchViewModel = function (matchData, addonData) {
    var self = this;

    self.match_id = ko.observable(matchData.id);
    self.opponent_id = ko.observable(matchData.opponent_id);
    self.team_id = ko.observable(matchData.team_id);
    self.game_id = ko.observable(matchData.game_id);
    self.rounds = ko.observableArray();
    self.games = ko.observableArray(addonData);

    self.home_team = ko.observableArray();
    self.guest_team = ko.observableArray(matchData.participants.opponent);
    self.guest_team_name = ko.observable();
    self.searchingTeamMembers = ko.observable(0);

    // Fill in the rounds
    if (matchData.rounds.length > 0) {
        $.each(matchData.rounds, function (key, val) {
            self.rounds.push(new RoundViewModel(self, val));
        });
    }
    else {
        self.rounds.push(new RoundViewModel(self, {}))
    }

    // Fill in the team participants
    if (matchData.participants.team.length > 0) {
        $.each(matchData.participants.team, function (key, val) {
            var transformedData = {pivot: {id: val.id, user_id: val.user_id}, name: val.name};
            self.home_team.push(new ParticipantViewModel(self, transformedData));
        });
    }

    // Viewmodel computed properties
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
        if (self.getScore()[0] > self.getScore()[1])
            return 'win';
        else if (self.getScore()[0] < self.getScore()[1])
            return 'lose';
        else
            return 'draw';
    });

    self.outcomeClass = ko.computed(function () {
        if (self.getScore()[0] > self.getScore()[1])
            return 'label-success';
        else if (self.getScore()[0] < self.getScore()[1])
            return 'label-danger';
        else
            return 'label-warning';
    });

    // Viewmodel methods
    self.addRound = function () {
        self.rounds.push(new RoundViewModel(self, {scores: []}));
    };

    self.removeRound = function (round) {
        if (self.rounds().length == 1) {
            alert('You can\'t delete the last game.');
            return;
        }
        if (confirm('Are you sure you want to delete this game?'))
            self.rounds.remove(round);
    };

    self.fetchTeamMembers = function () {
        self.home_team.removeAll();
        self.searchingTeamMembers(1);
        $.ajax({
            url: '/admin/teams/api/team/' + self.team_id(),
            contentType: 'application/json',
            type: "GET",
            success: function (result) {
                ko.utils.arrayForEach(result.data.roster, function (item) {
                    self.home_team.push(new ParticipantViewModel(self, item));
                });
                self.searchingTeamMembers(0);
            },
            error: function (jqXHR) {
                console.log(jqXHR.statusText);
                self.searchingTeamMembers(0);
            }
        });
    };

    /**
     * Add opponent participant name to array and reset the input box
     */
    self.addOpponentTeamMember = function () {
        self.guest_team.push(self.guest_team_name());
        self.guest_team_name('');
    };

    /**
     * Set game icon data attribute used by select2 plugin
     * @param option
     * @param item
     */
    self.setGameIcons = function (option, item) {
        ko.applyBindingsToNode(option, {attr: {'data-icon': item.image}}, item);
    };
};

var RoundViewModel = function (parent, roundsData) {
    var self = this;

    // Get maps by game ID.
    self.getMaps = function (id) {
        return parent.games().filter(function (game) {
            return game.id == id;
        })[0].maps;
    };

    self.round_id = ko.observable(roundsData.id);
    self.match_id = ko.observable(parent.match_id);
    self.map_id = ko.observable(roundsData.map_id);
    self.scores = ko.observableArray();
    self.notes = ko.observable(roundsData.notes);
    self.maps = ko.observableArray();

    ko.utils.arrayPushAll(self.maps, self.getMaps(parent.game_id()));

    // We have to manually sub to game_id changes, and update the maps
    parent.game_id.subscribe(function (newGameID) {
        self.maps.removeAll();
        ko.utils.arrayPushAll(self.maps, self.getMaps(newGameID));
    });

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
        if (self.scores().length == 1) {
            alert('You can\'t delete the last score.');
            return;
        }
        self.scores.remove(score);
    };
};

var ScoreViewModel = function (parent, scoreData) {
    var self = this;

    self.score_id = ko.observable(scoreData.id);
    self.round_id = ko.observable(parent.round_id);
    self.home = ko.observable(scoreData.home);
    self.guest = ko.observable(scoreData.guest);
};

var ParticipantViewModel = function(parent, data) {
    var self = this;

    self.roster_id = ko.observable(data.pivot.id);
    self.user_id = ko.observable(data.pivot.user_id);
    self.name = ko.observable(data.name);
    self.active = ko.observable(1);

    self.toggleActiveHomeParticipant = function (participant) {
        if(participant.active())
            participant.active(0);
        else
            participant.active(1);
    };
};

/**
 * Main form processing
 */
$(document).ready(function () {

    var form = $('#match-form');

    // ---------------------------- Data Binding ---------------------------- //
    console.log('Loading viewmodel...');
    if (matchData) {
        matchViewModel = new MatchViewModel(matchData, metaData);
    }
    else {
        matchViewModel = new MatchViewModel(defaultModelData, metaData);
    }
    console.log('Viewmodel loaded!');
    ko.applyBindings(matchViewModel, document.getElementById('match-form'));
    form.show();

    // ---------------------------- Select box formatting ---------------------------- //
    function formatGame (game) {
        if (!game.id) { return game.text; }
        return $(
            '<span><img src="/uploads/games/' + game.element.dataset.icon + '" class="img-game" /> ' + game.text + '</span>'
        );
    }

    $("#game").select2({
        templateResult: formatGame
    });

    // ---------------------------- Form submit ---------------------------- //
    form.submit(function (ev) {
        ev.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        });
        var data = ko.toJSON(matchViewModel);
        var posting = null;

        if (matchData) {
            posting = $.post("/admin/matches/edit/" + matchData.id, data, 'json');
        }
        else {
            posting = $.post("/admin/matches/new", data, 'json');
        }

        posting.fail(function (response) {
            $.each(response.responseJSON, function (key, val) {
                console.log(val[0]);
            });
        });

        posting.done(function (resp) {
            window.location.href = resp.location;
        });
    });
});