var Vue = require('Vue');
Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();

/**
 * Vue Viewmodel
 */
var vm = new Vue({
    el: '#squad-form',

    data: {
        team_id: null,
        name: null,
        description: null,
        game_id: null,
        squad: {
            roster: []
        },
        foundUsers: [],
        search_term: null
    },

    ready: function () {
        this.team_id = $('#team-id').val();
        // Get team information and pass it to the form
        this.$http.get('/admin/teams/api/team/' + this.team_id, function (data) {
            data.roster = data.roster.map(function (obj) {
                if (obj.image == null) {
                    obj.image = 'noavatar.jpg';
                }
                return obj;
            });
            this.squad = data;
        });
    },

    methods: {
        addMember: function (user) {
            user['pivot'] = {
                user_id: user.id,
                position: null,
                status: null
            };

            var exists = $.grep(this.squad.roster, function (e) {
                return e.pivot.user_id === user.id;
            });

            if (exists.length === 0) {
                this.squad.roster.push(user);
            }
        },
        removeMember: function (index) {
            this.squad.roster.splice(index, 1);
        },
        getUsers: function () {
            this.$http.get('/admin/users/api/user', {q: this.search_term}, function (data) {
                this.foundUsers = data.map(function (obj) {
                    if (obj.image == null) {
                        obj.image = 'noavatar.jpg';
                    }
                    return obj;
                });
            });
        },
        saveForm: function () {

        }
    }
});

/**
 * Page events
 */
$(document).ready(function () {
    $("#game").select2({
        templateResult: formatGame
    });

    $("#search-users").focus(function () {
        if ($(this).val()) {
            $('#found-users-list').dropdown();
        }
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
});