var datetimepicker = require('jquery-datetimepicker');

$(document).ready(function () {

    var editor = new SimpleMDE({ element: $("#post-content")[0] });

    $('#publish_date_start').datetimepicker({
        format: 'Y-m-d H:i'
    });

    $('#publish_date_end').datetimepicker({
        format: 'Y-m-d H:i'
    });
});