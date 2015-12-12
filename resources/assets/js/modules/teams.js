var Vue = require('Vue');
Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();

Vue.filter('moment', function (value, format) {
    return moment(value).format(format);
});

Vue.config.debug = true;

var vm = new Vue({
    el: '#squad-form',

    data: {
        teamID: null,
        games: [],
        squad: {
            name: null,
            description: null,
            gameId: null,
            roster: [],
            history: null
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
        onReady: function () {
            $('#search-users').focus(function () {
                $('#found-users-list').dropdown();
            });
        },

        initFormData: function () {
            this.teamID = $('#team-id').val();

            if (this.teamID) {
                this.$http.get('/admin/api/teams/' + this.teamID, function (response) {
                    response.data.roster.data = response.data.roster.data.map(function (obj) {
                        if (obj.image == null) {
                            obj.image = 'noavatar.jpg';
                        }
                        return obj;
                    });

                    this.squad = response.data;
                    this.squad.roster = response.data.roster.data;
                }).error(function (response) {
                    showAlert.error(response.message);
                });
            }

            this.$http.get('/admin/api/games/', function (response) {
                this.games = response.data;
                var self = this;
                $('#game').select2({
                    placeholder: 'Select a game...',
                    data: this.games
                }).on('change', function () {
                    self.squad.gameId = parseInt($(this).val());
                });
            }).error(function (response) {
                showAlert.error(response.message);
            });
        },

        addMember: function (user) {
            user['position'] = null;
            user['status'] = null;
            user['captain'] = false;
            user['userId'] = user.id;

            var exists = $.grep(this.squad.roster, function (e) {
                return e.userId === user.id;
            });

            if (exists.length === 0) {
                this.squad.roster.push(user);
            }
        },

        removeMember: function (index) {
            this.squad.roster.splice(index, 1);
        },

        makeCaptain: function (index) {
            this.squad.roster.forEach(function (member, i) {
                if (index == i) {
                    member.captain = true;
                } else {
                    member.captain = false;
                }
            });
        },

        getUsers: function () {
            if (this.searchTerm.length < 3) return;

            this.isSearching = true;
            this.$http.get('/admin/api/users', {q: this.searchTerm}, function (response) {
                console.log(response.message);
                this.foundUsers = response.data.map(function (obj) {
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
            if (this.teamID) {
                this.$http.put('/admin/teams/' + this.teamID, this.squad, function (response) {
                    showAlert.success(response.message);
                }).error(function (response) {
                    showAlert.error(response.message);
                }).always(function () {
                    this.isSubmitting = false;
                });
            } else {
                this.$http.post('/admin/teams/', this.squad, function (response) {
                    showAlert.success(response.message);
                }).error(function (response) {
                    showAlert.error(response.message);
                }).always(function () {
                    this.isSubmitting = false;
                });
            }
        }
    }
});