@extends('layouts.app')

@section('content')
	
	<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Instalação - Busman</div>
            <div class="panel-body">
		        <div class="error-content">
	          		<h3>Instalação concluída com sucesso!</h3>
	          		<a href="/" class="btn btn-primary">Ir para Home</a>
					@include('inc.alert-msg')
	          		
		        </div>
		        <!-- /.error-content -->
	        </div>
        </div>
    </div>
</div>

@stop