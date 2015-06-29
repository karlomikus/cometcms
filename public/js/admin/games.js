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

    if(initData.image === undefined) {
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

    //$('#game-form').submit(function (ev) {
    //    ev.preventDefault();
    //    $.ajaxSetup({
    //        headers: {
    //            'X-CSRF-TOKEN': $('input[name="_token"]').val()
    //        },
    //        contentType: "application/json; charset=utf-8",
    //        dataType: "json"
    //    });
    //
    //    var data = ko.toJSON(gameViewModel);
    //    var posting = null;
    //
    //    if (modelData) {
    //        posting = $.post("/admin/games/edit/" + modelData.id, data, 'json');
    //    }
    //    else {
    //        posting = $.post("/admin/games/new", data, 'json');
    //    }
    //
    //    posting.fail(function (response) {
    //        $.each(response.responseJSON, function (key, val) {
    //            console.log(val[0]);
    //        });
    //    });
    //
    //    posting.done(function (resp) {
    //        window.location.href = resp.location;
    //    });
    //});

    ko.applyBindings(gameViewModel, document.getElementById('game-form'));
});