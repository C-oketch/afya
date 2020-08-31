<div class="footer">
            <span>Copyright &copy; 2016. Prioritymobile.co.ke.by MOKETCH</span>
        </div>
        <!-- Plugins  -->
  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.slimscroll.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/metisMenu.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.time.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.tooltip.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.resize.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.pie.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.selection.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.stack.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.flot.crosshair.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/raphael-2.1.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/morris.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/core.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/mediaquery.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/equalize.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript" src="{{ asset('') }}"></script>
  <script type="text/javascript" src="{{ asset('') }}"></script>
  <script type="text/javascript" src="{{ asset('') }}"></script>
  <script type="text/javascript" src="{{ asset('') }}"></script>
  <script type="text/javascript" src="{{ asset('') }}"></script>
  <script type="text/javascript" src="{{ asset('') }}"></script>



        <!--page js-->
        <script>

            $("#sparkline8").sparkline([5, 6, 7, 2, 0, 4, 2, 4, 5, 7, 2, 4, 12, 14, 4, 2, 14, 12, 7], {
                type: 'bar',
                barWidth: 4,
                height: '60px',
                barColor: '#f7b03e',
                negBarColor: '#c6c6c6'});
            $(".sparkline8").sparkline([4, 2], {
                type: 'pie',
                sliceColors: ['#f7af3e', '#404652']
            });
            $(".sparkline9").sparkline([3, 2], {
                type: 'pie',
                sliceColors: ['#f7af3e', '#404652']
            });
            $(".sparkline10").sparkline([4, 1], {
                type: 'pie',
                sliceColors: ['#f7af3e', '#404652']
            });
            $(".sparkline11").sparkline([1, 3], {
                type: 'pie',
                sliceColors: ['#f7af3e', '#404652']
            });
            $(".sparkline12").sparkline([3, 5], {
                type: 'pie',
                sliceColors: ['#f7af3e', '#404652']
            });
            $(".sparkline13").sparkline([6, 2], {
                type: 'pie',
                sliceColors: ['#f7af3e', '#404652']
            });

            //moris chart
            $(function () {
                var lineData = {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [
                        {
                            label: "Example dataset",
                            fillColor: "rgba(235, 162, 59,0.5)",
                            strokeColor: "rgba(235, 162, 59,1)",
                            pointColor: "rgba(235, 162, 59,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(235, 162, 59,1)",
                            data: [65, 59, 80, 81, 56, 55, 40]
                        },
                        {
                            label: "Example dataset",
                            fillColor: "rgba(247, 176, 62,0.5)",
                            strokeColor: "rgba(247, 176, 62,0.7)",
                            pointColor: "rgba(247, 176, 62,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(247, 176, 62,1)",
                            data: [28, 48, 40, 19, 86, 27, 90]
                        }
                    ]
                };
                var lineOptions = {
                    scaleShowGridLines: true,
                    scaleGridLineColor: "#b5884c",
                    scaleGridLineWidth: 1,
                    bezierCurve: true,
                    bezierCurveTension: 0.4,
                    pointDot: true,
                    pointDotRadius: 4,
                    pointDotStrokeWidth: 1,
                    pointHitDetectionRadius: 20,
                    datasetStroke: true,
                    datasetStrokeWidth: 2,
                    datasetFill: true,
                    responsive: true
                };


                var ctx = document.getElementById("lineChart").getContext("2d");
                var myNewChart = new Chart(ctx).Line(lineData, lineOptions);


                var polarData = [
                    {
                        value: 300,
                        color: "#f7b03e",
                        highlight: "#3d3f4b",
                        label: "App"
                    },
                    {
                        value: 140,
                        color: "#f5c06c",
                        highlight: "#3d3f4b",
                        label: "Software"
                    },
                    {
                        value: 200,
                        color: "#bd914a",
                        highlight: "#3d3f4b",
                        label: "Laptop"
                    }
                ];

                var polarOptions = {
                    scaleShowLabelBackdrop: true,
                    scaleBackdropColor: "rgba(255,255,255,0.75)",
                    scaleBeginAtZero: true,
                    scaleBackdropPaddingY: 1,
                    scaleBackdropPaddingX: 1,
                    scaleShowLine: true,
                    segmentShowStroke: true,
                    segmentStrokeColor: "#fff",
                    segmentStrokeWidth: 2,
                    animationSteps: 100,
                    animationEasing: "easeOutBounce",
                    animateRotate: true,
                    animateScale: false,
                    responsive: true

                };

                var ctx = document.getElementById("polarChart").getContext("2d");
                var myNewChart = new Chart(ctx).PolarArea(polarData, polarOptions);

                var barData = {
                    labels: ["Monday", "Tuesday", "Wedneday", "Thrusday", "Friday"],
                    datasets: [
                        {
                            label: "My Second dataset",
                            fillColor: "#aeaeae",
                            strokeColor: "#aeaeae",
                            highlightFill: "#eda01c",
                            highlightStroke: "#eda01c",
                            data: [28, 48, 40, 19, 86]
                        }
                    ]
                };

                var barOptions = {
                    scaleBeginAtZero: true,
                    scaleShowGridLines: true,
                    scaleGridLineColor: "rgba(0,0,0,.05)",
                    scaleGridLineWidth: 1,
                    barShowStroke: true,
                    barStrokeWidth: 1,
                    barValueSpacing: 1,
                    barDatasetSpacing: 1,
                    responsive: true
                };


                var ctx = document.getElementById("barChart").getContext("2d");
                var myNewChart = new Chart(ctx).Bar(barData, barOptions);

                var radarData = {
                    labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                    datasets: [
                        {
                            label: "My First dataset",
                            fillColor: "rgba(235, 162, 59,1)",
                            strokeColor: "rgba(235, 162, 59,1)",
                            pointColor: "rgba(235, 162, 59,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(235, 162, 59,1)",
                            data: [65, 59, 90, 81, 56, 55, 40]
                        },
                        {
                            label: "My Second dataset",
                            fillColor: "rgba(247, 176, 62,1)",
                            strokeColor: "rgba(247, 176, 62,1)",
                            pointColor: "rgba(247, 176, 62,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(255,255,255,1)",
                            data: [28, 48, 40, 19, 96, 27, 100]
                        }
                    ]
                };

                var radarOptions = {
                    scaleShowLine: true,
                    angleShowLineOut: true,
                    scaleShowLabels: false,
                    scaleBeginAtZero: true,
                    angleLineColor: "rgba(0,0,0,.1)",
                    angleLineWidth: 1,
                    pointLabelFontStyle: "normal",
                    pointLabelFontSize: 10,
                    pointLabelFontColor: "#666",
                    pointDot: true,
                    pointDotRadius: 3,
                    pointDotStrokeWidth: 1,
                    pointHitDetectionRadius: 20,
                    datasetStroke: true,
                    datasetStrokeWidth: 2,
                    datasetFill: true,
                    responsive: true
                };

                var ctx = document.getElementById("radarChart").getContext("2d");
                var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);

                var data = [{
                        label: "Sales 1",
                        data: 21,
                        color: "#d3d3d3"
                    }, {
                        label: "Sales 2",
                        data: 3,
                        color: "#bababa"
                    }, {
                        label: "Sales 3",
                        data: 15,
                        color: "#79d2c0"
                    }, {
                        label: "Sales 4",
                        data: 52,
                        color: "#f7b03e"
                    }];

                var doughnutData = [
                    {
                        value: 300,
                        color: "#d53d2f",
                        highlight: "#ba8036",
                        label: "Chorme"
                    },
                    {
                        value: 150,
                        color: "#dedede",
                        highlight: "#ba8036",
                        label: "Mozilla"
                    },
                    {
                        value: 130,
                        color: "#03a679",
                        highlight: "#ba8036",
                        label: "Safari"
                    }
                ];

                var doughnutOptions = {
                    segmentShowStroke: true,
                    segmentStrokeColor: "#fff",
                    segmentStrokeWidth: 4,
                    percentageInnerCutout: 45, // This is 0 for Pie charts
                    animationSteps: 100,
                    animationEasing: "easeOutBounce",
                    animateRotate: true,
                    animateScale: false,
                    responsive: true
                };


                var ctx = document.getElementById("doughnutChart").getContext("2d");
                var myNewChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);

//line chart
                Morris.Line({
                    element: 'morris-line-chart',
                    data: [{y: '2006', a: 0, b: 10},
                        {y: '2007', a: 25, b: 35},
                        {y: '2008', a: 30, b: 40},
                        {y: '2009', a: 20, b: 25},
                        {y: '2010', a: 37, b: 40}],
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Series A', 'Series B'],
                    hideHover: 'auto',
                    resize: true,
                    lineColors: ['#ddcc36', '#f7b03e']
                });


            });
        </script>
