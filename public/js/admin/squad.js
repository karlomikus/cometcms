"use strict";

var squadViewModel = null;
var defaultModelData = {};

var SquadViewModel = function (squadData) {
    var self = this;

    self.squad_id = ko.observable(squadData.id);
    self.name = ko.observable(squadData.name);
    self.description = ko.observable(squadData.description);
    self.game_id = ko.observable(squadData.game_id);
    self.members = ko.observableArray();

    // User search
    self.found_users = ko.observableArray();
    self.search_string = ko.observable();

    if (squadData.roster.length > 0) {
        $.each(squadData.roster, function (key, val) {
            self.members.push(new SquadMemberViewModel(self, val));
        });
    }
    else {
        self.members.push(new SquadMemberViewModel(self, {}))
    }

    self.findUsers = function() {
        $.ajax({
            url: '/admin/users/api/user/' + self.search_string(),
            cache: false,
            contentType: 'application/json',
            type: "GET",
            success: function (result) {
                self.found_users(result);
            },
            error: function (jqXHR) {
                console.log(jqXHR.statusText);
            }
        });
    };

    self.addToMembers = function(data) {
        self.members.push(self, {member_id: 0, pivot: {user_id: id}});
    };
};

var SquadMemberViewModel = function (parent, memberData) {
    var self = this;

    self.member_id = ko.observable(memberData.id);
    self.user_id = ko.observable(memberData.pivot.user_id);
    self.name = ko.observable(memberData.name);
    self.squad_id = ko.observable(parent.squad_id);
    self.position = ko.observable(memberData.pivot.position);
    self.status = ko.observable(memberData.pivot.status);
    self.captain = ko.observable(memberData.pivot.captain);
};

$(document).ready(function () {
    /**
     * Data binding
     */
    console.log('Loading viewmodel...');
    if (modelData) {
        squadViewModel = new SquadViewModel(modelData);
    }
    else {
        squadViewModel = new SquadViewModel(defaultModelData);
    }
    console.log('Viewmodel loaded!');

    ko.applyBindings(squadViewModel, document.getElementById('squad-form'));
});