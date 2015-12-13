var Vue = require('Vue');
var _ = require('underscore');
Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();
Vue.config.debug = true;

/**
 * Datetime filter
 */
Vue.filter('moment', function (value, format) {
    return moment(value).format(format);
});

/**
 * TODO: Handle validation errors, selected gameID, member search dropdown status message
 */
var vm = new Vue({
    el: '#squad-form',

    data: {
        teamID: null,
        games: [],
        history: [],
        squad: {
            name: null,
            description: null,
            gameId: null,
            roster: []
        },
        foundUsers: [],
        searchTerm: null,
        isSearching: false,
        isSubmitting: false
    },

    ready: function () {
        this.initMembersSearch();
        this.initFormData();
        this.getHistory();
    },

    methods: {

        /**
         * Setup member search
         */
        initMembersSearch: function () {
            $('#search-users').focus(function () {
                $('#found-users-list').dropdown();
            });
        },

        /**
         * Setup form data
         */
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
                }).error(this.handleError);
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
            }).error(this.handleError);
        },

        /**
         * Add new member to roster
         * @param user
         */
        addMember: function (user) {
            // Vue - Change detection caveat
            user = Object.assign({}, user, {position: null, captain: false, status: null, userId: user.id});

            var exists = $.grep(this.squad.roster, function (e) {
                return e.userId === user.id;
            });

            if (exists.length === 0) {
                this.squad.roster.push(user);
            }
        },

        /**
         * Remove member index from array
         * @param index
         */
        removeMember: function (index) {
            this.squad.roster.splice(index, 1);
        },

        /**
         * Make selected member a captain
         * @param index
         */
        makeCaptain: function (index) {
            this.squad.roster.forEach(function (member, i) {
                member.captain = index == i;
            });
        },

        /**
         * Get users by a search term
         */
        getUsers: function () {
            if (this.searchTerm.length < 3) return;
            var self = this;
            this.isSearching = true;
            this.$http.get('/admin/api/users', {q: this.searchTerm}, function (response) {
                this.foundUsers = response.data.map(function (obj) {
                    if (obj.image == null) {
                        obj.image = 'noavatar.jpg';
                    }
                    return obj;
                });
                self.isSearching = false;
            });
        },

        /**
         * Fetch squad history
         */
        getHistory: function () {
            if (this.teamID) {
                this.$http.get('/admin/api/teams/history/' + this.teamID, function (response) {
                    this.history = _.groupBy(response.data, function (historyItem) {
                        return historyItem.replacedOn;
                    });
                }).error(this.handleError);
            }
        },

        /**
         * Submit form
         */
        onSubmit: function () {
            this.isSubmitting = true;
            var self = this;
            if (this.teamID) {
                this.$http.put('/admin/teams/' + this.teamID, this.squad, function (response) {
                    showAlert.success(response.message);
                }).error(this.handleError).always(function () {
                    self.isSubmitting = false;
                });
                this.getHistory();
            } else {
                this.$http.post('/admin/teams/', this.squad, function (response) {
                    showAlert.success(response.message);
                    var newTeamId = response.data.id;
                    window.location.href = '/admin/teams/edit/' + newTeamId;
                }).error(this.handleError).always(function () {
                    self.isSubmitting = false;
                });
            }
        },

        /**
         * Handle errors
         * @param response
         */
        handleError: function (response) {
            showAlert.error(response.message);
        }
    }
});