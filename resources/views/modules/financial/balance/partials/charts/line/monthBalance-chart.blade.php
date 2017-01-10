<!-- LINE CHART -->


<div class="box box-default">
      <div class="box-header with-border"><!-- box-header -->
        <h3 class="box-title">Balanço Diário</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="chart">
              <canvas id="lineChart" style="height:350px"></canvas>
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- ./box-body -->
      <div class="box-footer">
        <div class="col-md-2">
          <div class="pull-left" style="width: 15px; height: 15px; background-color: #00a65a; margin-right: 5px"></div>
          <div class="pull-left"> Receitas</div>
        </div>
        <div class="col-md-2">
          <div class="pull-left" style="width: 15px; height: 15px; background-color: #800000; margin-right: 5px"></div>
          <div class="pull-left">Despesas</div>
        </div>
       </div>
    </div><!-- /.box -->
<?php 
//dd($date);
?>
<script>
  
  $(function () {
    
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);

    var lineChartData = {
      labels: [
        @for($i = 1; $i <= $date['lastDay']->format('d'); $i++)
          {{$i}},
        @endfor
      ],
      datasets: [
        {
          label: "Despesas",
          fillColor: "#800000",//"rgba(210, 214, 222, 1)",
          strokeColor: "#800000",//"rgba(210, 214, 222, 1)",
          pointColor: "#800000",//"rgba(210, 214, 222, 1)",
          pointStrokeColor: "#800000",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [
            @for($i = 1; $i <= $date['lastDay']->format('d'); $i++)
              @if(isset($monthExpense[$i]))
                {{$monthExpense[$i]}},
              @else
                0,
              @endif
              //{{ rand(0, 100) }},
            @endfor
          ]
        },
        {
          label: "Receitas",
          fillColor: "#00a65a",//"rgba(60,141,188,0.9)",
          strokeColor: "#00a65a",//"rgba(60,141,188,0.8)",
          pointColor: "#00a65a",
          pointStrokeColor: "#00a65a",//"rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [
            @for($i = 1; $i <= $date['lastDay']->format('d'); $i++)
              @if(isset($monthReceipts[$i]))
                {{$monthReceipts[$i]}},
              @else
                0,
              @endif
              //{{ rand(0, 100) }},
            @endfor
            ]
        }
      ]
    };

    var lineChartOptions = {
      // String - Template string for multiple tooltips
      multiTooltipTemplate: "R$ <%= formatCurrency(value) %>",
      tooltipTemplate: "<%if (label){%> <%=label %><%}%> <%=value %>",

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

    lineChartOptions.datasetFill = false;
    lineChart.Line(lineChartData, lineChartOptions);
    
  });
</script>
