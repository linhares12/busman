@extends('layouts.admin')

@section('main_content')
	<div class="row">
  		<div class="col-md-12">
  			<div class="box box-primary">

  				<div class="box-header with-border"><!-- box-header -->
  			    	<h3 class="box-title">{{$title}}</h3>

	  			    <div class="box-tools pull-right">
	  			    	<!-- Button trigger modal - Transfer Values -->
          				@include('modules.financial.account.partials.transfer')

	  			      	<!-- Button trigger modal - Create Account-->
          				@include('modules.financial.account.partials.create')

	  			      	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	  			      	</button>
	  			    </div>
  				</div><!-- /.box-header -->
  			  
  			  	<div class="box-body">
  			  		<div class="col-md-12 table-responsive">
	  			  		<table id="example2" class="table">
	  			  		  	<thead>
	  			  		  		<tr>
			  			  		    <th>Nome da Conta</th>
			  			  		    <th style="width: 10%">Saldo Atual</th>
			  			  		    <th style="width: 20%">Projeção Fim do Mês</th>
			  			  		    <th style="width: 5%"></th>
	  			  		  		</tr>
			  		  		</thead>
	  			  		  	<tbody>
	  			  		  		@foreach($accounts as $acc)
	  			  		  			<tr>
	  			  		  				<td>{{$acc['name']}}</td>
	  			  		  				<td style="{{($acc['amount'] < 0)? 'color:#800000; font-weight: bold' : ''}}">R$ {{number_format($acc['amount'], 2, ',', '.')}}</td>
	  			  		  				<td style="{{($acc['projection'] < 0)? 'color:#800000; font-weight: bold' : ''}}">R$ {{number_format($acc['projection'], 2, ',', '.')}}</td>
	  			  		  				<td style="width: 10%; text-align: right;">
	  			  		  					<a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#editAccountModal" data-id="{{$acc['id']}}" data-name="{{$acc['name']}}" data-balance="{{$acc['amount']}}" title="Editar"><i class="fa fa-edit"></i></a>

	  			  		  					<a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#deleteAccountModal" data-id="{{$acc['id']}}" data-name="{{$acc['name']}}" title="Eliminar"><i class="fa fa-trash-o"></i></a>
	  			  		  				</td>
	  			  		  			</tr>
	  			  		  		@endforeach
	  			  		  	</tbody>
			  		  	</table>
		  		  	</div>
  			  	</div>
		  	</div>
  		</div>
	</div>

	<div class="row">
  		<div class="col-md-12">

  			<div class="col-md-3 col-sm-6 col-xs-12 pull-right">
  				<div class="info-box bg-green"  data-tt="tooltip" title="Projeção para o fim do mês">
  			    <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>
	  			    <div class="info-box-content">
			    		<span class="info-box-text">PROJEÇÃO TOTAL</span>
	  			      	<span class="info-box-number">R$ {{number_format($totalProjection, 2, ',', '.')}}</span>
	  			    </div>
  			  	</div>
  			</div><!-- /.col -->

  			<div class="col-md-3 col-sm-6 col-xs-12 pull-right">
  				<div class="info-box bg-aqua"  data-tt="tooltip" title="Valor total em caixa">
  			    <span class="info-box-icon"><i class="fa fa-usd"></i></span>
	  			    <div class="info-box-content">
			    		<span class="info-box-text">SALDO TOTAL</span>
	  			      	<span class="info-box-number">R$ {{number_format($totalBalabce, 2, ',', '.')}}</span>
	  			    </div>
  			  	</div>
  			</div><!-- /.col -->
  			
  		</div>
	</div>

	@include('modules.financial.account.partials.edit')
	@include('modules.financial.account.partials.delete')
	@include('inc.alert-msg')

<script>
	function formatCurrency(value) {
	    return value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
	  }
	$(function () {
		$("[data-tt=tooltip]").tooltip();

		$('#example2').DataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false,
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
</script>
@stop