var Chart = require('chart.js');

var options = {
    //responsive: true,
    barShowStroke: false
};

var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
        "November", "December"],
    datasets: [
        {
            label: "Matches",
            fillColor: "#ed6a5a",
            pointColor: "rgba(255,0,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,0,0,1)",
            data: [5, 3, 6, 7, 2, 4, 6]
        }
    ]
};

var ctx = $("#matches-graph").get(0).getContext("2d");
var matchesChart = new Chart(ctx).Bar(data, options);