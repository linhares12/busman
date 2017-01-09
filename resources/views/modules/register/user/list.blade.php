@extends('layouts.admin')

@section('main_content')
	<div class="row">
  		<div class="col-md-12">
  			<div class="box box-primary">

  				<div class="box-header with-border"><!-- box-header -->
  			    	<h3 class="box-title">{{$title}}</h3><br><br>
  			    	<font style="color: #FFAE00; font-size: 15px"><i class="fa fa-exclamation-triangle"></i></font> Todos os usuários terão acesso aos mesmos dados e as mesmas permissões

	  			    <div class="box-tools pull-right">

	  			      	<!-- Button trigger modal - Create Account-->
          				@include('modules.register.user.partials.create')

	  			      	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	  			      	</button>
	  			    </div>
  				</div><!-- /.box-header -->
  			  
  			  	<div class="box-body">
  			  		<div class="col-md-12 table-responsive">
	  			  		<table class="table">
	  			  		  	<thead>
	  			  		  		<tr>
			  			  		    <th>Nome</th>
			  			  		    <th style="width: 30%">E-mail</th>
			  			  		    <th style="width: 20%">Status</th>
			  			  		    <th style="width: 5%"></th>
	  			  		  		</tr>
			  		  		</thead>
	  			  		  	<tbody>
	  			  		  	@if(count($users) > 0)
	  			  		  		@foreach($users as $user)
	  			  		  			<tr>
	  			  		  				<td>{{$user['name']}}</td>
	  			  		  				<td>{{$user['email']}}</td>
	  			  		  				<td>{{trans('database.'.$user['status'])}}</td>
	  			  		  				<td style="width: 10%; text-align: right;">
	  			  		  					<a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#resetPassModal" data-id="{{$user['id']}}" title="Alterar senha"><i class="ion ion-ios-locked"></i></a>

	  			  		  					<a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#editUserModal" data-id="{{$user['id']}}" data-name="{{$user['name']}}" data-email="{{$user['email']}}" title="Editar"><i class="fa fa-edit"></i></a>

	  			  		  					<a style="color: #000; font-size: 18px" data-tt="tooltip" data-toggle="modal" data-target="#deleteUserModal" data-id="{{$user['id']}}" data-name="{{$user['name']}}" title="Eliminar"><i class="fa fa-trash-o"></i></a>
	  			  		  				</td>
	  			  		  			</tr>
	  			  		  		@endforeach
  			  		  		@endif
	  			  		  	</tbody>
			  		  	</table>
		  		  	</div>
  			  	</div>
		  	</div>
  		</div>
	</div>

	@include('modules.register.user.partials.edit')
	@include('modules.register.user.partials.delete')
	@include('modules.register.user.partials.password')
	@include('inc.alert-msg')

<script>
	$(function () {
		$("[data-tt=tooltip]").tooltip();
	});
</script>

@stop