import Vue from 'vue';
import VueResource from 'vue-resource';
import _ from 'underscore';

Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = $('input[name="_token"]').val();
Vue.config.debug = true;

/**
 * Datetime filter
 */
Vue.filter('moment', function (value, format) {
    return moment(value).format(format);
});

/**
 * TODO: Member search dropdown status message, image upload
 */
new Vue({
    el: '#squad-form',

    data: {
        squad: {
            id: null,
            name: null,
            description: null,
            gameId: null,
            image: null,
            roster: []
        },
        games: [],
        history: [],
        foundUsers: [],
        searchTerm: null,
        isSubmitting: false
    },

    ready: function () {
        this.initMembersSearch();
        this.initFormData();
        this.getGames();
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
            var squadID = parseInt($('#team-id').val());
            if (squadID) {
                this.$http.get('/admin/api/teams/' + squadID).then((response) => {
                    response.data.roster.data = response.data.roster.data.map(function (obj) {
                        if (obj.image == null) {
                            obj.image = 'noavatar.jpg';
                        }
                        return obj;
                    });

                    this.squad = response.data;
                    this.squad.roster = response.data.roster.data;
                }, (response) => {
                    this.handleError(response);
                });
            }
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
            this.$http.get('/admin/api/users', {q: this.searchTerm}, function (response) {
                this.foundUsers = response.data.map(function (obj) {
                    if (obj.image == null) {
                        obj.image = 'noavatar.jpg';
                    }
                    return obj;
                });
            });
        },

        /**
         * Fetch squad history
         */
        getHistory: function () {
            if (this.squad.id) {
                this.$http.get('/admin/api/teams/history/' + this.squad.id).then((response) => {
                    this.history = _.groupBy(response.data, function (historyItem) {
                        return historyItem.replacedOn;
                    });
                }, (response) => {
                    this.handleError(response);
                });
            }
        },

        /**
         * Fetch games for games dropdown
         */
        getGames: function () {
            this.$http.get('/admin/api/games/').then((response) => {
                this.games = response.data;
                var self = this;
                var $game = $('#game');
                $game.select2({
                    placeholder: 'Select a game...',
                    data: this.games,
                    templateResult: formatGame
                }).on('change', function () {
                    self.squad.gameId = parseInt($(this).val());
                });

                if (this.squad.gameId) {
                    $game.select2('val', this.squad.gameId);
                }
            }, (response) => {
                this.handleError(response);
            });
        },

        /**
         * Submit form
         */
        onSubmit: function () {
            if(!$('#squad-form').valid()) return;
            var self = this;
            self.isSubmitting = true;
            if (this.squad.id) {
                this.$http.put('/admin/teams/' + this.squad.id, this.squad, function (response) {
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
            var message = '';
            if (_.isArray(response.message)) {
                _.each(response.message, function (msg) {
                    message += msg + '<br>';
                });
            }
            else {
                message = response.message;
            }

            showAlert.error(message);
        }
    }
});