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

    self.member_id = ko.observable(memberData.id);
    self.user_id = ko.observable(memberData.pivot.user_id);
    self.name = ko.observable(memberData.name);
    self.team_id = ko.observable(parent.team_id);
    self.position = ko.observable(memberData.pivot.position);
    self.status = ko.observable(memberData.pivot.status);
    self.captain = ko.observable(memberData.pivot.captain);

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

    $('#squad-form').submit(function (ev) {
        ev.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        });

        // Image
        // var imgData = new FormData(document.getElementById("squad-form"));
        // squadViewModel.image = imgData.get("image");

        var data = ko.toJSON(squadViewModel);
        var posting = null;

        if (modelData) {
            posting = $.post("/admin/teams/edit/" + modelData.id, {data: data});
        }
        else {
            posting = $.post("/admin/teams/new", data, 'json');
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

    ko.applyBindings(squadViewModel, document.getElementById('squad-form'));
});