@extends('layouts.admin')

@section('main_content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			               <!-- Info Boxes Style 2 -->

			               <div class="info-box bg-green">
			                 <span class="info-box-icon"><i class="ion ion-ios-download-outline"></i></span>

			                 <div class="info-box-content">
			                   <span class="info-box-text">Recebido no Mês</span>
			                   <span class="info-box-number">R$ {{$recPayd}}</span>

			                   <div class="progress">
			                     <div class="progress-bar" style="width: {{$recPorcentage}}%"></div>
			                   </div>
			                       <span class="progress-description col-md-12">
			                         {{$recPorcentage}}% recebido
			                         <span class="pull-right">
			                         (de R$ {{$recTotal}})
			                       </span>
			                       </span>
			                       
			                 </div>
			                 <!-- /.info-box-content -->
			               </div>
			               <!-- /.info-box -->

			               <div class="info-box bg-red">
			                 <span class="info-box-icon"><i class="ion ion-ios-upload-outline"></i></span>

			                 <div class="info-box-content">
			                   <span class="info-box-text">Pago no Mês</span>
			                   <span class="info-box-number">R$ {{$expPayd}}</span>

			                   <div class="progress">
			                     <div class="progress-bar" style="width: {{$expPorcentage}}%"></div>
			                   </div>
			                       <span class="progress-description col-md-12">
			                         {{$expPorcentage}}% pago
			                         <span class="pull-right">
			                         (de R$ {{$expTotal}})
			                       </span>
			                       </span>
			                 </div>
			                 <!-- /.info-box-content -->
			               </div>
			               <!-- /.info-box -->
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12">
			               <div class="info-box bg-aqua">
			                 <span class="info-box-icon"><i class="ion-social-usd"></i></span>

			                 <div class="info-box-content">
			                   <span class="info-box-text">Saldo Atual</span>
			                   <span class="info-box-number" style="color: {{($amount < 0)? '#800000' : ''}}">R$ {{$amount}}</span>

			                   <div class="progress">
			                     <div class="progress-bar" style="width: {{$amPercentage}}%"></div>
			                   </div>
			                       <span class="progress-description col-md-7">
			                         {{$amPercentage}}% da projeção
			                       </span>
			                 </div>
			                 <!-- /.info-box-content -->
			               </div>
			               <!-- /.info-box -->
			               <div class="info-box bg-yellow">
			                 <span class="info-box-icon"><i class="ion ion-stats-bars"></i></span>

			                 <div class="info-box-content">
			                   <span class="info-box-text">Projeção Fim do Mês</span>
			                   <span class="info-box-number" style="color: {{($projection < 0)? '#800000' : ''}}">R$ {{$projection}}</span>

			                   <div class="progress">
			                     <div class="progress-bar" style="width: 100%"></div>
			                   </div>
			                 </div>
			                 <!-- /.info-box-content -->
			               </div>
			               <!-- /.info-box -->
			             </div>
	</div>
<!-- Small boxes (Stat box) -->
      <div class="row">
      	<div class="col-md-6">
      		<div class="box box-danger">
	            <div class="box-header with-border">
	              <h3 class="box-title"><font style="color: #B30000; font-size: 15px"><i class="fa fa-exclamation-triangle"></i></font> Lançamentos Atrasados</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body" style="max-height: 335px; min-height: 335px; min-height: 335px; overflow-y: scroll;">
	              <table class="table table-hover">
	                <tbody>
	                <tr>
	                  <th>Descrição</th>
	                  <th style="width: 10%">Mês</th>
	                  <th style="width: 4%">Tipo</th>
	                </tr>
	                @if($lateReleases)
	                	@foreach($lateReleases as $late)
	                		<a href="">
								<tr style="cursor: pointer;" onclick="document.location = '{{$late['link']}}';">
								  <td>
								  
								  {{$late['description']}}</td>
								  <td>{{date('m/y', strtotime($late['payday']))}}</td>
								  <td><div style="width: 20px; height: 20px;border-radius: 50%; background-color: {{($late['type'] == 'receipt')? '#2F6E01' : '#800000'}}" title="{{trans('database.'.$late['type'])}}"></div></td>
								</tr>
							</a>
	                	@endforeach
	                @else
						<tr>
						  <td colspan="3">Nenhuma pendência</td>
						</tr>
	                @endif
	                
	              </tbody></table>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer clearfix">
	              
	            </div>
          </div>
      	</div>
      	<div class="col-md-6">
      		<div class="box box-warning">
	            <div class="box-header with-border">
	              <h3 class="box-title"><font style="color: #FFAE00; font-size: 15px"><i class="fa fa-exclamation-triangle"></i></font> Vencendo Hoje</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body" style="max-height: 335px; min-height: 335px; overflow-y: scroll;">
	              <table class="table table-hover">
	                <tbody>
	                <tr>
	                  <th>Descrição</th>
	                  <th>Valor</th>
	                  <th style="width:4%">Tipo</th>
	                </tr>

	                @if($todayReleases)
	                	@foreach($todayReleases as $today)
	                		<a href="">
								<tr style="cursor: pointer;" onclick="document.location = '{{$today['link']}}';">
								  <td>
								  
								  {{$today['description']}}</td>
								  <td>R$ {{number_format($today['value'], 2, ',', '.')}}</td>
								  <td><div style="width: 20px; height: 20px;border-radius: 50%; background-color: {{($today['type'] == 'receipt')? '#2F6E01' : '#800000'}}" title="{{trans('database.'.$today['type'])}}"></div></td>
								</tr>
							</a>
	                	@endforeach
	                @else
						<tr>
						  <td colspan="3">Nenhuma pendência</td>
						</tr>
	                @endif
	              </tbody></table>
	            </div>
	            <!-- /.box-body -->
	            <div class="box-footer clearfix">
	              
	            </div>
          </div>
      	</div>
	     
      </div>
      <!-- /.row -->

	<div class="row">
		<div class="col-lg-12">
		    Antes de começar a realizar os lançamentos, crie ao menos uma conta e algumas categorias.
		</div>
	</div>
@stop