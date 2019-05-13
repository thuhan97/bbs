$(function () {

    'use strict';
    // Get context with jQuery - using jQuery's .get() method.
    var punishChartCanvas = $('#punishChart').get(0).getContext('2d');
    // This will get the first returned node in the jQuery collection.
    var punishChart = new Chart(punishChartCanvas);

    var punishChartOptions = {
        showScale: true,
        scaleShowGridLines: false,
        pointDot: false,
        responsive: true
    };

    //Create the line chart
    punishChart.Line(punishChartData, punishChartOptions);

    // ---------------------------
    // - END MONTHLY SALES CHART -
    // ---------------------------

    // -------------
    // - PIE CHART -
    // -------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieChart = new Chart(pieChartCanvas);

    var pieOptions = {
        // Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        // String - The colour of each segment stroke
        segmentStrokeColor: '#fff',
        // Number - The width of each segment stroke
        segmentStrokeWidth: 1,
        // Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        // Number - Amount of animation steps
        animationSteps: 100,
        // String - Animation easing effect
        animationEasing: 'easeOutBounce',
        // Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        // Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        // Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: false,
        // String - A legend template
        legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
        // String - A tooltip template
        tooltipTemplate: '<%=value %> <%=label%> users'
    };
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
    // -----------------
    // - END PIE CHART -
    // -----------------

    /* SPARKLINE CHARTS
     * ----------------
     * Create a inline charts with spark line
     */

    // -----------------
    // - SPARKLINE BAR -
    // -----------------
    $('.sparkbar').each(function () {
        var $this = $(this);
        $this.sparkline('html', {
            type: 'bar',
            height: $this.data('height') ? $this.data('height') : '30',
            barColor: $this.data('color')
        });
    });

    // -----------------
    // - SPARKLINE PIE -
    // -----------------
    $('.sparkpie').each(function () {
        var $this = $(this);
        $this.sparkline('html', {
            type: 'pie',
            height: $this.data('height') ? $this.data('height') : '90',
            sliceColors: $this.data('color')
        });
    });

    // ------------------
    // - SPARKLINE LINE -
    // ------------------
    $('.sparkline').each(function () {
        var $this = $(this);
        $this.sparkline('html', {
            type: 'line',
            height: $this.data('height') ? $this.data('height') : '90',
            width: '100%',
            lineColor: $this.data('linecolor'),
            fillColor: $this.data('fillcolor'),
            spotColor: $this.data('spotcolor')
        });
    });
});
