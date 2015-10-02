var datetimepicker = require('jquery-datetimepicker');

$(document).ready(function () {

    var editor = new SimpleMDE({element: $("#post-content")[0]});

    var $startDate = $('#publish_date_start');
    var $endDate =  $('#publish_date_end');

    $startDate.datetimepicker({
        format: 'Y-m-d H:i'
        //onShow: function (ct) {
        //    this.setOptions({
        //        maxDate: $endDate.val() ? $endDate.val() : false
        //    })
        //}
    });
    $endDate.datetimepicker({
        format: 'Y-m-d H:i'
        //onShow: function (ct) {
        //    this.setOptions({
        //        minDate: $startDate.val() ? $startDate.val() : false
        //    })
        //}
    });
});