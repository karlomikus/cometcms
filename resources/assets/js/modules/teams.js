import Vue from 'vue';
import VueResource from 'vue-resource';
import _ from 'underscore';

Vue.use(VueResource);

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
        games: _page.games,
        history: _page.history,
        foundUsers: [],
        searchTerm: null,
        isSubmitting: false,
        token: null,
        teamID: null
    },

    ready() {
        this.initMembersSearch();
        this.initFormData();
        this.getGames();
        this.getHistory();
        Vue.http.headers.common['X-CSRF-TOKEN'] = this.token;
    },

    methods: {

        /**
         * Setup member search
         */
        initMembersSearch() {
            $('#search-users').focus(function () {
                $('#found-users-list').dropdown();
            });
        },

        /**
         * Initiate form defaults
         * @return {void}
         */
        initFormData() {
            if (this.teamID) {
                this.squad = _page.squad;
                this.squad.roster = _page.squad.roster.data.map(obj => {
                    if (obj.image == null) {
                        obj.image = 'noavatar.jpg';
                    }
                    return obj;
                });
            }
        },

        /**
         * Add new member to roster
         * @param user
         */
        addMember(user) {
            // Vue - Change detection caveat
            user = Object.assign({}, user, {position: null, captain: false, status: null, userId: user.id});

            let exists = $.grep(this.squad.roster, e => {
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
        removeMember(index) {
            this.squad.roster.splice(index, 1);
        },

        /**
         * Make selected member a captain
         * @param index
         */
        makeCaptain(index) {
            this.squad.roster.forEach((member, i) => {
                member.captain = index == i;
            });
        },

        /**
         * Get users by a search term
         */
        getUsers() {
            if (this.searchTerm.length < 3) return;
            this.$http.get('/admin/api/users?q=' + this.searchTerm).then((response) => {
                this.foundUsers = response.data.data.map(obj => {
                    if (obj.image == null) {
                        obj.image = 'noavatar.jpg';
                    }
                    return obj;
                });
            });
        },

        /**
         * Get team history
         * @return {void}
         */
        getHistory() {
            if (this.teamID) {
                this.$http.get('/admin/api/teams/history/' + this.teamID).then((response) => {
                    this.history = _.groupBy(response.data.data, function (historyItem) {
                        return historyItem.replacedOn;
                    });
                }, (response) => {
                    this.handleError(response);
                });
            }
        },

        /**
         * Handle games dropdown
         * @return {void}
         */
        getGames() {
            let self = this;
            let $game = $('#game');
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
        },

        /**
         * Submit form
         * @return {void}
         */
        onSubmit() {
            if(!$('#squad-form').valid()) return;
            this.isSubmitting = true;

            if (this.squad.id) {
                this.$http.put('/admin/teams/' + this.squad.id, this.squad).then((response) => {
                    showAlert.success(response.data.message);
                    this.isSubmitting = false;
                }, (response) => {
                    this.handleError(response.data);
                });
                this.getHistory();
            } else {
                this.$http.post('/admin/teams/', this.squad).then((response) => {
                    showAlert.success(response.message);
                    window.location.href = '/admin/teams/edit/' + response.data.data.id;
                }, (response) => {
                    this.handleError(response.data);
                });
            }
        },

        /**
         * Handle response errors
         * @param  {object} response
         * @return {void}
         */
        handleError(response) {
            let message = '';
            if (_.isArray(response.message)) {
                _.each(response.message, msg => {
                    message += msg + '<br>';
                });
            }
            else {
                message = response.message;
            }
            this.isSubmitting = false;

            showAlert.error(message);
        }
    }
});