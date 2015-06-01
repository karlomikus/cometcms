"use strict";

$(document).ready(function() {

    //$('.load-dialog').click('loadPopupDialog');

    $('a[data-popup="true"]').click(function (e) {
        $("#modal-loader").show();

        e.preventDefault();
        var url = $(this).attr("href");
        var modalElement = $('#popup-form-dialog');
        var modalContent = modalElement.find('.modal-content');

        modalContent.empty();
        modalElement.modal('toggle');
        modalContent.load(url, function () {
            $("#modal-loader").hide();
        });
    });

});