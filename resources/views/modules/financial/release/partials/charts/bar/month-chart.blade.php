<div class="box box-{{$classColor}}">
  <div class="box-header with-border">
    <h3 class="box-title">Comparativo últimos meses</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <div class="chart">
      <canvas id="barChart" style="height:250px"></canvas>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
function formatCur(value) {
  //value.toFixed(2)
  return value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})
}
  $(function () {

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);

    var barChartData = {
      //labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho"],
      labels: [
        @foreach($historic as $month)
          "{{\Lang::get('database.'.$month['month'])}}",
        @endforeach
      ],
      datasets: [
        {
          label: "{{$releaseType}}",
          fillColor: "{{$barColor}}",
          strokeColor: "{{$barColor}}",
          pointColor: "{{$barColor}}",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          //data: [28, 48, 40, 19, 86, 27, 90]
          data: [
            @foreach($historic as $month)
              {{$month['value']}},
            @endforeach
          ]
        }
      ]
    };

    var barChartOptions = {
      // String - Template string for single tooltips
      tooltipTemplate: "<%if (label){%><%=label %>: <%}%>R$ <%=formatCur(value) %>",
      // String - Template string for multiple tooltips
      multiTooltipTemplate: "R$<%= value %>",
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
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
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });
</script>