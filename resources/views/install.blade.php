@extends('layouts.app')

@section('content')
	
	<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Instalação - Busman</div>
            <div class="panel-body">
		        <div class="error-content">
	          		<h3>Complete as informações abaixo</h3>
					@include('inc.alert-msg')
	          		{{Form::open(['url' => '/install', 'class' => 'install_form', 'name' => 'createUser'])}}
					<div class="row">
	          			<h4 class="col-md-12">Dados de acesso (Obrigatório)</h4>
	          			<div class="col-md-4">
					
	          		  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}" id="divName">
	          		      {!!Form::label('name', 'Nome', ['class' => 'control-label', 'for' => 'name'])!!}
	          		      <div> 
	          		        {!!Form::text('name', null, ['class' => 'form-control', 'value' => "{{ old('name')}}", 'placeholder' => 'Seu Nome Completo'])!!}
	          		      </div>
	          		  </div>

	          		  <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}" id="divEmail">
	          		      {!!Form::label('email', 'E-mail*', ['class' => 'control-label', 'for' => 'email'])!!}
	          		      <div> 
	          		        {!!Form::email('email', null, ['class' => 'form-control', 'value' => "{{ old('email')}}", 'placeholder' => 'email@seudominio.com'])!!}
	          		      </div>
	          		  </div>
					</div>

					<div class="col-md-4">

	          		  <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}" id="divPass">
	          		      {!!Form::label('password', 'Senha*', ['class' => 'control-label', 'for' => 'password'])!!}
	          		      <div> 
	          		        {!!Form::password('password', ['class' => 'form-control', 'value' => "{{ old('password')}}", 'placeholder' => 'Senha'])!!}
	          		      </div>
	          		  </div>
	          		  <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" id="divPass">
	          		      {!!Form::label('password_confirmation', 'Confirmar Senha*', ['class' => 'control-label', 'for' => 'password_confirmation'])!!}
	          		      <div> 
	          		        {!!Form::password('password_confirmation', ['class' => 'form-control', 'value' => "{{ old('password_confirmation')}}", 'placeholder' => 'Confirmar Senha'])!!}
	          		      </div>
	          		  </div>
					</div>


	          		</div>
	          		<hr>
	          		<div class="row">
	          			<h4 class="col-md-12">Informações do Banco de Dados (Obrigatório)</h4>
	          			<div class="col-md-4">
					
	          		  <div class="form-group {{ $errors->has('db_database') ? ' has-error' : '' }}" id="divName">
	          		      {!!Form::label('db_database', 'Nome do Banco de dados*', ['class' => 'control-label', 'for' => 'db_database'])!!}
	          		      <div> 
	          		        {!!Form::text('db_database', null, ['class' => 'form-control', 'value' => "{{ old('db_database')}}", 'placeholder' => 'busmamDB'])!!}
	          		      </div>
	          		  </div>
					</div>
					<div class="col-md-4">
	          		  <div class="form-group {{ $errors->has('db_username') ? ' has-error' : '' }}" id="divEmail">
	          		      {!!Form::label('db_username', 'Usuario do Banco de dados*', ['class' => 'control-label', 'for' => 'db_username'])!!}
	          		      <div> 
	          		        {!!Form::text('db_username', null, ['class' => 'form-control', 'value' => "{{ old('db_username')}}", 'placeholder' => 'root'])!!}
	          		      </div>
	          		  </div>
					</div>

					<div class="col-md-4">

	          		  <div class="form-group {{ $errors->has('db_password') ? ' has-error' : '' }}" id="divPass">
	          		      {!!Form::label('db_password', 'Senha do Banco de dados*', ['class' => 'control-label', 'for' => 'db_password'])!!}
	          		      <div> 
	          		        {!!Form::password('db_password', ['class' => 'form-control', 'value' => "{{ old('db_password')}}", 'placeholder' => 'senha'])!!}
	          		      </div>
	          		  </div>
					</div>


	          		</div>
					<hr>
	          		<div class="row">
	          			<h4 class="col-md-12">Informações do Servidor de Email (Opcional)</h4>
	          			<div class="col-md-4">
						<div class="form-group {{ $errors->has('mail_host') ? ' has-error' : '' }}" id="divName">
	          		      {!!Form::label('mail_host', 'Servidor SMTP', ['class' => 'control-label', 'for' => 'mail_host'])!!}
	          		      <div> 
	          		        {!!Form::text('mail_host', null, ['class' => 'form-control', 'value' => "{{ old('mail_host') }}", 'placeholder' => 'mail.seudominio.com'])!!}
	          		      </div>
	          		  </div>
						
					
	          		  <div class="form-group {{ $errors->has('mail_port') ? ' has-error' : '' }}" id="divName">
	          		      {!!Form::label('mail_port', 'Porta', ['class' => 'control-label', 'for' => 'mail_port'])!!}
	          		      <div> 
	          		        {!!Form::text('mail_port', null, ['class' => 'form-control', 'value' => "{{ old('mail_port')}}", 'placeholder' => '25'])!!}
	          		      </div>
	          		  </div>
					</div>
					<div class="col-md-4">
	          		  <div class="form-group {{ $errors->has('mail_username') ? ' has-error' : '' }}" id="divEmail">
	          		      {!!Form::label('mail_username', 'Usuario SMTP', ['class' => 'control-label', 'for' => 'mail_username'])!!}
	          		      <div> 
	          		        {!!Form::text('mail_username', null, ['class' => 'form-control', 'value' => "{{ old('mail_username')}}", 'placeholder' => 'user@seudominio.com'])!!}
	          		      </div>
	          		  </div>

	          		  <div class="form-group {{ $errors->has('mail_password') ? ' has-error' : '' }}" id="divPass">
	          		      {!!Form::label('mail_password', 'Senha SMTP', ['class' => 'control-label', 'for' => 'mail_password'])!!}
	          		      <div> 
	          		        {!!Form::password('mail_password', ['class' => 'form-control', 'value' => "{{ old('mail_password')}}", 'placeholder' => 'senha'])!!}
	          		      </div>
	          		  </div>
					</div>

					<div class="col-md-4">
	          		  <div class="form-group {{ $errors->has('mail_encryption') ? ' has-error' : '' }}" id="divEmail">
	          		      {!!Form::label('mail_encryption', 'Criptografia', ['class' => 'control-label', 'for' => 'mail_encryption'])!!}
	          		      <div> 
	          		        {!!Form::select('mail_encryption', ['SSL' => 'SSL', 'TLS' => 'TLS'], null, ['class' => 'form-control', 'value' => "{{ old('mail_encryption')}}", 'placeholder' => 'Selecione...'])!!}
	          		      </div>
	          		  </div>
					</div>
	          		</div>

	          		<div class="row">
	          			<div class="col-md-12">
	          				<button type="submit" class="pull-right btn btn-primary">
	          					Instalar
	          				</button>
	          			</div>
	          		</div>
					
	          		{!!Form::close()!!}
		        </div>
		        <!-- /.error-content -->
	        </div>
        </div>
    </div>
</div>

@stop