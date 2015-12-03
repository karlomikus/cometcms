var Vue = require('Vue');
Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();

var vm = new Vue({
    el: '#squad-form',

    data: {
        squad: {
            roster: []
        },
        foundUsers: [],
        searchTerm: null,
        isSearching: false,
        isSubmitting: false
    },

    ready: function () {
        this.onReady();
        this.initFormData();
    },

    methods: {
        onReady: function() {
             $('#game').select2({
                templateResult: formatGame
            });
            $('#search-users').focus(function () {
                $('#found-users-list').dropdown();
            });
        },

        initFormData: function() {
            this.teamID = $('#team-id').val();
            this.$http.get('/admin/teams/api/team/' + this.teamID, function (data) {
                data.roster = data.roster.map(function (obj) {
                    if (obj.image == null) {
                        obj.image = 'noavatar.jpg';
                    }
                    return obj;
                });

                this.squad = data;
            });
        },

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
            if (this.searchTerm.length < 3) return;

            this.isSearching = true;
            this.$http.get('/admin/users/api/user', {q: this.searchTerm}, function (data) {
                this.foundUsers = data.map(function (obj) {
                    if (obj.image == null) {
                        obj.image = 'noavatar.jpg';
                    }
                    return obj;
                });
                this.isSearching = false;
            });
        },

        onSubmit: function () {
            this.isSubmitting = true;
            this.$http.post('/admin/teams/edit/' + this.teamID, this.squad, function (response) {
                showAlert.success(response.message);
                this.isSubmitting = false;
            }).error(function (data, status, request) {
                showAlert.error(data.message);
                this.isSubmitting = false;
            });
        }
    }
});