<!-- LINE CHART -->


<div class="box box-default">
      <div class="box-header with-border"><!-- box-header -->
        <h3 class="box-title">Lucro nos últimos meses (Receitas - Despesas)
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="chart">
              <canvas id="lineChartProfit" style="height:350px"></canvas>
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- ./box-body -->

      <div class="box-footer">
        <div class="col-md-2">
          <div class="pull-left" style="width: 15px; height: 15px; background-color: #00c0ef; margin-right: 5px"></div>
          <div class="pull-left"> Lucro líquido</div>
        </div>
       </div>
    </div><!-- /.box -->

<script>
  $(function () {
    
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChartProfit").get(0).getContext("2d");
    var lineChart2 = new Chart(lineChartCanvas);

    var lineChartData2 = {
      labels: [
        @foreach($profit as $month)
          "{{\Lang::get('database.'.$month['month'])}}",
        @endforeach
      ],
      datasets: [
        {
          label: "Lucro",
          fillColor: "#00c0ef",//"rgba(210, 214, 222, 1)",
          strokeColor: "#00c0ef",//"rgba(210, 214, 222, 1)",
          pointColor: "#00c0ef",//"rgba(210, 214, 222, 1)",
          pointStrokeColor: "#00c0ef",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [
            @foreach($profit as $month)
              {{$month['value']}},
            @endforeach
          ]
        },
      ]
    };

    var lineChartOptions2 = {
      // String - Template string for tooltips
      tooltipTemplate: "<%if (label){%><%=label %><%}%>: R$ <%= formatCurrency(value) %>",
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0,
      //Boolean - Whether to show a dot for each point
      pointDot: true,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    lineChartOptions2.datasetFill = false;
    lineChart2.Line(lineChartData2, lineChartOptions2);
    
  });
</script>
