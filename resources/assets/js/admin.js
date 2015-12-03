'use strict';

function formatGame (game) {
    if (!game.id) {
        return game.text;
    }
    var gameIcon = 'noicon.png';
    if (game.element.dataset.icon) {
        gameIcon = game.element.dataset.icon;
    }
    return $('<span><img src="/uploads/games/' + gameIcon + '" class="img-game" /> ' + game.text + '</span>');
}

var showAlert = {
    error: function (message) {
        $('#alerts-container').html(this.template('danger', 'An error occured', message));
    },
    success: function (message) {
        $('#alerts-container').html(this.template('success', 'Success!', message));
    },
    template: function (type, title, message) {
        return '<div class="alert alert-' + type + ' alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>' +
            '<h3>' + title + '</h3>' +
            message +
            '</div>';
    }
}

$(document).ready(function () {
    $('a[data-popup="true"]').click(function (e) {
        $('#modal-loader').show();

        e.preventDefault();
        var url = $(this).attr('href');
        var modalElement = $('#popup-form-dialog');
        var modalContent = modalElement.find('.modal-content');

        modalContent.empty();
        modalElement.modal('toggle');
        modalContent.load(url, function () {
            $('#modal-loader').hide();
        });
    });

    $('a[data-confirm]').click(function (e) {
        e.preventDefault();
        var message = $(this).data('confirm');
        var url = $(this).attr('href');

        var modalHTML = '<div class="modal fade" id="confirm-modal" tabindex="-1">' + '<div class="modal-dialog modal-dialog-confirmation modal-sm"><div class="modal-content">' + '<div class="modal-body">' + '<i class="fa fa-fw fa-2x fa-warning pull-left text-danger"></i>' + message + '</div>' + '<div class="modal-footer text-center"><div class="row"><div class="col-md-6"><button type="button" class="btn btn-block btn-sm btn-primary" data-dismiss="modal">Cancel</button></div>' + '<div class="col-md-6"><button type="button" class="btn btn-block btn-sm btn-danger">Delete</button></div></div></div>' + '</div></div></div>';

        var $modal = $(modalHTML);
        var existingModal = $('#confirm-modal');

        if (existingModal.length) {
            existingModal.modal('show');
            existingModal.find('.btn-danger').click(function () {
                window.location.href = url;
            });
        } else {
            $modal.modal('show');
            $modal.find('.btn-danger').click(function () {
                window.location.href = url;
            });
        }
    });

    $(document).on('click', 'a[data-ajax]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var method = $(this).data('ajax');

        if (method == 'get') {
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: ajaxCallbackSuccess
            }).fail(function () {
                console.log('Error while handling ajax request! (data-ajax)');
            });
        }
    });

    $.validator.setDefaults({
        highlight: function highlight(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function unhighlight(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function errorPlacement(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('form').validate();
});