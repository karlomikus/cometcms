"use strict";

var gameViewModel = null;
var defaultModelData = {};

var GameViewModel = function (initData) {
    var self = this;

    self.maps = ko.observableArray();

    if (initData.length > 0) {
        $.each(initData, function (key, val) {
            self.maps.push(new MapViewModel(self, val));
        });
    }

    self.addMap = function () {
        self.maps.push(new MapViewModel(self, {}));
    };
};

var MapViewModel = function (parent, initData) {
    var self = this;

    self.name = ko.observable(initData.name);
    self.id = ko.observable(initData.id);

    if(initData.image === undefined || initData.image == null) {
        self.image = ko.observable('nopic.jpg');
    }
    else {
        self.image = ko.observable(initData.image);
    }

    self.removeMap = function (map) {
        parent.maps.remove(map);
    };
};

$(document).ready(function () {
    /**
     * Data binding
     */
    console.log('Loading viewmodel...');
    if (modelData) {
        gameViewModel = new GameViewModel(modelData);
    }
    else {
        gameViewModel = new GameViewModel(defaultModelData);
    }
    console.log('Viewmodel loaded!');

    ko.applyBindings(gameViewModel, document.getElementById('game-form'));
});