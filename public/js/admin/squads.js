"use strict";

var squadViewModel = null;
var defaultModelData = {};

var SquadViewModel = function (squadData) {
    var self = this;

    self.squad_id = ko.observable();
    self.name = ko.observable();
    self.description = ko.observable();
    self.members = ko.observableArray();
};

var SquadMemberViewModel = function (parent, memberData) {
    var self = this;

    self.user_id = ko.observable();
    self.squad_id = ko.observable(parent.squad_id);
    self.position = ko.observable();
    self.status = ko.observable();
    self.captain = ko.observable();
};