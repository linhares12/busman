@extends('layouts.admin')

@section('main_content')

<?php 

/* Não comentar */
$sum_payd = [0];
$sum_not_payd = [0];
$percentage = 0;
$today = date('d/m/Y');

if ($type == 'receipt') {
  $classColor = 'info';
  $barColor = '#00a65a';
  $releaseType = 'Receitas';
  $urlNavegation = '/admin/lancamentos/receitas';
}else{
  $classColor = 'danger';
  $barColor = '#dd4b39';
  $releaseType = 'Despesas';
  $urlNavegation = '/admin/lancamentos/despesas';
}
/* Não comentar */

?>
<div class="row">
  <div class="col-md-12">

    <div class="row">  <!-- Navegação entre meses -->
      <div class="col-md-2">
        <div class="input-group input-append">
          <input type="text" class="form-control datepickerMonth" onchange="goToMonth(this)" value="{{$date->format('m')}}/{{$date->format('Y')}}" aria-describedby="basic-addon1">
          <span class="input-group-addon add-on"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
      
      <div class="col-sm-6 col-sm-offset-1" style="padding: 10px">
        <div class="month-navigation col-sm-12 text-center">
            <a class="pull-left" href="{{$urlNavegation}}/{{date('m/Y', strtotime('-1 months', strtotime($date->format('Y-m-d'))))}}" title="Anterior" style="color: #000; font-size: 20px">
            <i class="fa fa-arrow-left"></i></a>

            <label> {{\Lang::get('database.'.$date->format('F')).' / '. $date->format('Y')}} </label>
            
            <a class="pull-right" href="{{$urlNavegation}}/{{date('m/Y', strtotime('+1 months', strtotime($date->format('Y-m-d'))))}}" title="Próximo" style="color: #000; font-size: 20px">
              <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
  </div><br/><!-- ./ Navegação entre meses -->

    <div class="box box-{{$classColor}}">

      <div class="box-header with-border"><!-- box-header -->
        <h3 class="box-title">{{$title}}</h3>

        <div class="box-tools pull-right">
          <!-- Button trigger modal -->
          @include('modules.financial.release.partials.modal.create-modal')

          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div><!-- /.box-header -->
      
      <div class="box-body">
      
        <div class="row">
          <div class="col-md-12 table-responsive">
          <table id="example2" class="table">
            <thead>
              <tr>
                <th style="width: 5%">Pago</th>
                <th style="width: 10%">Vencimento</th>
                <th style="width: 30%">Descrição</th>
                <th style="width: 10%">Conta</th>
                <!--th style="width: 2%"></th-->
                <th style="width: 12%">Categoria</th>
                <th style="width: 10%">Recorrência</th>
                <th style="width: 10%">Valor</th>
                <th style="width: 7%"></th>
              </tr>
            </thead>
            <tbody>
            @if(count($releases) > 0)
              @foreach($releases as $release)
                <tr 
                  @if(strtotime(str_replace('/', '-', $release['payday'])) < strtotime(date('d-m-Y')) && $release['status'] != 'payd')
                    style="background-color: #F47070" title="Lançamento atrasado!" data-tt="tooltip"
                  @elseif(strtotime(str_replace('/', '-', $release['payday'])) == strtotime(date('d-m-Y')) && $release['status'] != 'payd')
                    style="background-color: #FCB54F" title="Vence hoje!" data-tt="tooltip"
                  @endif>
                  
                  <td style="width: 5%">
                    @if($release['status'] != 'payd')
                      <i class="fa fa-minus" title="Pendente" data-tt="tooltip"></i>
                      <font style="color: rgba(0,0,0,0)">A</font>
                      <?php $sum_not_payd[] = $release['value'] ?>
                    @else
                      <i class="fa fa-check" title="Pago" data-tt="tooltip"></i>
                      <font style="color: rgba(0,0,0,0)">B</font>
                      <?php $sum_payd[] = $release['value'] ?>
                    @endif
                  </td>

                  <td style="width: 10%">{{$release['payday']}}</td>
                  <td style="width: 30%">{{$release['description']}}</td>
                  <td style="width: 10%">{{$release['accountName']}}</td>

                  <!--td style="width: 2%"><div style="width: 20px; height: 20px;border-radius: 50%; background-color: {{$release['categoryColor']}}"></div>
                  </td-->
                  <td style="width: 10%"><div class="pull-left" style="width: 20px; height: 20px;border-radius: 50%; margin-right: 5px; background-color: {{$release['categoryColor']}}"></div> {{$release['categoryName']}}</td>

                  <td style="width: 10%">{!!$release['recurrence']!!}</td>
                  <td style="width: 10%">R$ {{number_format($release['value'], 2, ',', '.')}}</td>
                  <td style="width: 7%; text-align: right;">
                    @if($release['status'] != 'payd')
                      <a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#efective" data-op="efetivar" data-id="{{$release['id']}}" data-date="{{$release['payday']}}" data-description="{{$release['description']}}" data-value="{{$release['value']}}" data-repeat="{{$release['repeatNumber']}}" title="Efetivar"><i class="fa fa-check"></i></a>
                    @else
                      <a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#efective" data-op="estorno" data-id="{{$release['id']}}" data-date="{{$release['payday']}}" data-description="{{$release['description']}}" data-value="{{$release['value']}}" data-repeat="{{$release['repeatNumber']}}" title="Estornar"><i class="fa fa-reply"></i></a>
                    @endif

                    <a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#editReleaseModal" data-id="{{$release['id']}}" data-payd="{{$release['status']}}" data-date="{{$release['payday']}}" data-description="{{$release['description']}}" data-category="{{$release['category']}}" data-account="{{$release['account']}}" data-value="{{$release['value']}}" data-repeat="{{$release['repeatNumber']}}" title="Editar"><i class="fa fa-edit"></i></a>

                    <a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#deleteRelease" data-id="{{$release['id']}}" data-date="{{$release['payday']}}" data-description="{{$release['description']}}" data-repeat="{{$release['repeatNumber']}}" title="Eliminar"><i class="fa fa-trash-o"></i></a>
                  </td>
                </tr>
              @endforeach
            @endif
            </tbody>

          </table>
        </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-md-10">
            @include('inc.alert-msg')
          </div>
        </div><!-- /.row -->

      </div><!-- ./box-body -->
      
      
      
    </div><!-- /.box -->

    <div class="row">
      <?php
        $total_payd = array_sum($sum_payd);
        $total_not_payd = array_sum($sum_not_payd);
        $total_expense = $total_payd + $total_not_payd;
        if ($total_expense > 0) {
          $percentage = ($total_payd/$total_expense)*100;
        }
        
      ?>
      <div class="col-md-4 col-sm-6 col-xs-12 pull-right">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL</span>
              <span class="info-box-number">R$ {{number_format($total_expense, 2, ',', '.')}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: {{number_format($percentage, 2,'.',',') }}%"></div>
              </div>
                  <span class="progress-description">
                    {{number_format($percentage, 0,',','.') }}% Pago
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12 pull-right">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Efetivado</span>
              <span class="info-box-number">R$ {{number_format($total_payd, 2, ',', '.')}} </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12 pull-right">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pendente</span>
              <span class="info-box-number">R$ {{number_format($total_not_payd, 2, ',', '.')}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        
    </div><!-- /.row -->

  </div><!-- /.col 12 -->

  <!-- Charts -->
    <section class="content">
      <div class="row">

        <div class="col-md-6">
          <!-- DONUT CHART -->
          @include('modules.financial.release.partials.charts.pie.category-chart')
        </div><!-- /.col (LEFT) -->

        <div class="col-md-6">
          <!-- BAR CHART -->
          @include('modules.financial.release.partials.charts.bar.month-chart')
        </div><!-- /.col (RIGHT) -->

      </div><!-- /.row -->
    </section><!-- /.content -->
        
</div><!-- /.row Charts-->

<!-- Edit Modal -->
@include('modules.financial.release.partials.modal.edit-modal')

<!-- Delete Modal -->
@include('modules.financial.release.partials.modal.delete-modal')

<!-- Efective Modal -->
@include('modules.financial.release.partials.modal.efective-modal')

<!-- Cummon Script -->
<script>

function goToMonth(date) {
  location.href="{{URL::to('/')}}{{$urlNavegation}}/" + date.value
}
function formatNum(value) {
  return value.replace('.', ',')
}

$(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "order": [[ 1, "asc" ]],
      "columnDefs": [
        { "orderable": false, "targets": 7 }
      ],
      "language": {
        "search": "Procurar:",
        "lengthMenu": "Mostrar _MENU_ itens",
        "info":           "Mostrando de _START_ a _END_ de _TOTAL_ itens",
        "infoEmpty":      "Mostrando de 0 a 0 de 0 itens",
        "sZeroRecords": "Nenhum registro encontrado",
        "paginate": {
                "first":      "Primeira",
                "last":       "Última",
                "next":       "Próxima",
                "previous":   "Anterior"
            },
      }
    });
  });

$(document).ready(function(){
    $("[data-tt=tooltip]").tooltip();
    $('.select2').select2();
    $('.datepickerMonth').datepicker( {
        format: 'mm/yyyy',
        viewMode: 'months', 
        minViewMode: 'months',
        language: 'pt'
    });

    $('.datepicker_actual').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
        language: 'pt'
    }).datepicker("setDate", "01/{{ $date->format('m')}}/{{$date->format('Y') }}");

    $('.datepicker_today').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
        language: 'pt'
    }).datepicker("setDate", '{{ $today }}');

    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      language: 'pt'
    });

    $('.money').inputmask('decimal', {
      'alias': 'decimal',
      greedy: false,
      digits: 2,
      radixPoint: ',',
      autoGroup: true,
      groupSeparator: '.',
      digitsOptional: false,
      placeholder: '0,00',
      allowMinus: false,
      allowPlus: false,
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });

    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    $('input[id="create_installment"]').on("ifChanged", create_show_parcelas);

    $('input[id="future_repeat_edit"]').on("ifChanged", show_alert_edit);
    $('input[id="all_repeat_edit"]').on("ifChanged", show_alert_edit);
    $('input[id="future_only_edit"]').on("ifChanged", close_alert_edit);

    $('input[id="future_repeat_delete"]').on("ifChanged", show_alert_delete);
    $('input[id="all_repeat_delete"]').on("ifChanged", show_alert_delete);
    $('input[id="future_only_delete"]').on("ifChanged", close_alert_delete);

    
});

</script>
@stop

