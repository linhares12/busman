@extends('layouts.admin')

@section('main_content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">404</div>
            <div class="panel-body">
		        <div class="error-content">
	          		<h3><i class="fa fa-warning text-yellow"></i> Oops! Página não encontrada.</h3>

	          		<p>
		            	Desculpe, mas a página que está procurando não existe ou foi movida.
	          		</p>
	          		<a href="/" class="btn btn-primary">Ir para Home</a>
		        </div>
		        <!-- /.error-content -->
	        </div>
        </div>
    </div>
</div>

@stop