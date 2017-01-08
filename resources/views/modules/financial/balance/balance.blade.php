@extends('layouts.admin')

@section('main_content')
<?php 

$urlNavegation = '/admin/lancamentos/balanco';

 ?>
<div class="row">
  <div class="col-md-12">
      <div class="row">  <!-- Navegação entre meses -->
        <div class="col-md-2">
          <div class="input-group input-append">
            <input type="text" class="form-control datepickerMonth" onchange="goToMonth(this)" value="{{$date['firstDay']->format('m')}}/{{$date['firstDay']->format('Y')}}" aria-describedby="basic-addon1">
            <span class="input-group-addon add-on"><i class="fa fa-calendar"></i></span>
          </div>

        </div>
        
        <div class="col-sm-6 col-sm-offset-1" style="padding: 10px">
          <div class="month-navigation col-sm-12 text-center">
              <a class="pull-left" href="{{$urlNavegation}}/{{date('m/Y', strtotime('-1 months', strtotime($date['firstDay']->format('Y-m-d'))))}}" title="Anterior" style="color: #000; font-size: 20px">
              <i class="fa fa-arrow-left"></i></a>

              <label> {{\Lang::get('database.'.$date['firstDay']->format('F')).' / '. $date['firstDay']->format('Y')}} </label>
              
              <a class="pull-right" href="{{$urlNavegation}}/{{date('m/Y', strtotime('+1 months', strtotime($date['firstDay']->format('Y-m-d'))))}}" title="Próximo" style="color: #000; font-size: 20px">
                <i class="fa fa-arrow-right"></i>
              </a>
          </div>
      </div>
    </div><br/><!-- ./ Navegação entre meses -->

    
    @include('modules.financial.balance.partials.charts.line.monthBalance-chart')
    @include('modules.financial.balance.partials.charts.bar.yearlyBalance-chart')
    @include('modules.financial.balance.partials.charts.line.yearlyProfit-chart')

    

    
  </div>
</div>

<script>
  function formatCurrency(value) {
    return value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
  }

  function goToMonth(date) {
    location.href="{{URL::to('/')}}{{$urlNavegation}}/" + date.value;
  }

  function formatNum(value) {
    return value.replace('.', ',');
  }

  $(document).ready(function(){
    $('.datepickerMonth').datepicker( {
        format: 'mm/yyyy',
        viewMode: 'months', 
        minViewMode: 'months',
        language: 'pt'
    });
  });
</script>
@stop

