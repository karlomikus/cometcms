var ko = require('knockout');

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
    self.searching = ko.observable(false);

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
        self.searching(true);
        $.ajax({
            url: '/admin/users/api/user',
            cache: false,
            contentType: 'application/json',
            type: "GET",
            data: { q: self.search_string() },
            success: function (result) {
                self.found_users.removeAll();
                $.each(result, function(key, val) {
                    val.pivot = {user_id: val.id};
                    self.found_users.push(new SquadMemberViewModel(self, val))
                });
                self.searching(false);
            },
            error: function (jqXHR) {
                console.log(jqXHR.statusText);
            }
        });
    };

    // self.prepareImage = function () {
    //     var input = $("#file-image")[0];
    //     if(input.files && input.files[0]) {
    //         var fileReader = new FileReader();
    //         fileReader.onload = function (e) {
    //             console.log(e.target.result);
    //         }
    //         fileReader.readAsDataURL(input.files[0]);
    //     }
    // };
};

var SquadMemberViewModel = function (parent, memberData) {
    var self = this;

    self.member_id = ko.observable(memberData.pivot.id);
    self.user_id = ko.observable(memberData.pivot.user_id);
    self.name = ko.observable(memberData.name);
    self.team_id = ko.observable(parent.team_id);
    self.position = ko.observable(memberData.pivot.position);
    self.status = ko.observable(memberData.pivot.status);
    self.captain = ko.observable(memberData.pivot.captain);

    var userImage = memberData.image;
    if(userImage == null) {
        userImage = 'noavatar.jpg';
    }

    self.image = ko.observable(userImage);

    self.addToMembers = function() {
        // Check if member is already added to team
        var exists = $.grep(parent.members(), function(e) { return e.user_id() === self.user_id(); });
        if(exists.length === 0)
            parent.members.push(self);
    };

    self.removeFromMembers = function (member) {
        parent.members.remove(member);
    };

    self.toggleCaptain = function (member) {
        ko.utils.arrayForEach(parent.members(), function (m) {
            m.captain(0);
        });

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

    $("#game").select2({
        templateResult: formatGame
    });

    $('#squad-form').submit(function (ev) {
        ev.preventDefault();

        // Disabled save button while processing form
        var $button = $("#save-squad");
        $button.attr('disabled', true);

        // Setup ajax, added CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        });

        var data = ko.toJSON(squadViewModel);
        var posting = null;

        if (modelData) {
            posting = $.post("/admin/teams/edit/" + modelData.id, data, 'json');
        }
        else {
            posting = $.post("/admin/teams/new", data, 'json');
        }

        posting.fail(function (response) {
            $button.attr('disabled', false);
            console.log(response.statusText);
        });

        posting.done(function (resp) {
            window.location.href = resp.location;
        });
    });

    ko.applyBindings(squadViewModel, document.getElementById('squad-form'));
});