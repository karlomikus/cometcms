var Chart = require('chart.js');

var options = {
    //responsive: true,
    barShowStroke: false
};

var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "Lost",
            fillColor: "#ed6a5a",
            pointColor: "rgba(255,0,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,0,0,1)",
            data: [5, 3, 6, 7, 2, 4, 6]
        },
        {
            label: "Won",
            fillColor: "#5ca4a9",
            pointColor: "rgba(0,255,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(0,255,0,1)",
            data: [7, 4, 1, 7, 3, 8, 9]
        },
        {
            label: "Draw",
            fillColor: "#f4f1bb",
            pointColor: "rgba(255,255,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,255,0,1)",
            data: [2, 1, 3, 2, 1, 0, 1]
        }
    ]
};

var ctx = $("#matches-graph").get(0).getContext("2d");
var matchesChart = new Chart(ctx).Bar(data, options);