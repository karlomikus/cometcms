"use strict";

var squadViewModel = null;
var defaultModelData = {roster:[{pivot: {}}]};

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
            if(!jQuery.isEmptyObject(val.pivot))
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
                self.found_users.removeAll();
                $.each(result, function(key, val) {
                    val.pivot = {user_id: val.id};
                    self.found_users.push(new SquadMemberViewModel(self, val))
                });
            },
            error: function (jqXHR) {
                console.log(jqXHR.statusText);
            }
        });
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

    self.addToMembers = function() {
        parent.members.push(self);
    };

    self.removeFromMembers = function (member) {
        parent.members.remove(member);
    };

    self.toggleCaptain = function (member) {
        if(member.captain()) {
            member.captain(0);
        } else {
            member.captain(1);
        }
    };
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