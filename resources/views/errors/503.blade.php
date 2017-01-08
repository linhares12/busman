@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">503</div>
            <div class="panel-body">
                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! Erro 503.</h3>

                    <p>
                        Erro interno do servidor.
                    </p>
                    <a href="/" class="btn btn-primary">Ir para Home</a>
                </div>
                <!-- /.error-content -->
            </div>
        </div>
    </div>
</div>

@stop