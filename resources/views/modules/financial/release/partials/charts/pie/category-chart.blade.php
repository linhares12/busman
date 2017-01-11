<div class="box box-{{$classColor}}">
  <div class="box-header with-border">
    <h3 class="box-title">Gráfico Mensal Por Categoria</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      
    </div>
  </div>
  <div class="box-body" style="min-height: 380px">
    @if(empty($PieData))
      <div style="text-align: center;">Nenhum lançamento</div>
      <canvas id="pieChart"></canvas>
    @else
      <canvas id="pieChart"></canvas>
    @endif
  </div><!-- /.box-body -->
</div><!-- /.box -->

<script>

  $(function () {

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
      <?php $pieTotal = array_sum(array_column($PieData, 'value')); if ($pieTotal == 0) $pieTotal = 1;?>
      @foreach($PieData as $slice)
      <?php $value = number_format(($slice['value'] * 100)/$pieTotal, 2, '.', ''); ?>
      {
        value: "{{$value}}",
        color: "{{$slice['color']}}",
        highlight: "{{$slice['color']}}",
        label: "{{$slice['name']}}"
      },
      @endforeach
    ];
    var pieOptions = {
      // String - Template string for single tooltips
      tooltipTemplate: "<%if (label){%><%=label %>: <%}%> <%=formatNum(value) + '%' %>",
      // String - Template string for multiple tooltips
      multiTooltipTemplate: "R$<%=formatNum(value) %>",
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 4,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 60, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
  });
</script>
