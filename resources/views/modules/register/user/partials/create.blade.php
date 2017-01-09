<button type="button" class="btn btn-primary btn-sm" data-tt="tooltip" data-toggle="modal" data-target="#createUserModal"  title="Novo Usuário" style="border-radius: 50%">
  <i class="fa fa-plus"></i>
</button>

<!-- Modal Novo Lançamento -->
<div class="modal fade" id="createUserModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nova Conta</h4>
      </div>
      <div class="modal-body">
      <!-- Form de inserção -->
      {{Form::open(['url' => '/admin/usuario', 'class' => 'create_form form-horizontal', 'name' => 'createUser'])}}

        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}" id="divName">
            {!!Form::label('name', 'Nome', ['class' => 'col-md-4 control-label', 'for' => 'name'])!!}
            <div class="col-md-6"> 
              {!!Form::text('name', null, ['class' => 'form-control', 'value' => "{{ old('name')}}"])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}" id="divEmail">
            {!!Form::label('email', 'E-mail', ['class' => 'col-md-4 control-label', 'for' => 'email'])!!}
            <div class="col-md-6"> 
              {!!Form::email('email', null, ['class' => 'form-control', 'value' => "{{ old('email')}}"])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}" id="divPass">
            {!!Form::label('password', 'Senha', ['class' => 'col-md-4 control-label', 'for' => 'password'])!!}
            <div class="col-md-6"> 
              {!!Form::password('password', ['class' => 'form-control', 'value' => "{{ old('password')}}"])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" id="divConfirmPass">
            {!!Form::label('password_confirmation', 'Confirmar Senha', ['class' => 'col-md-4 control-label', 'for' => 'password_confirmation'])!!}
            <div class="col-md-6"> 
              {!!Form::password('password_confirmation', ['class' => 'form-control', 'value' => "{{ old('password_confirmation')}}"])!!}
            </div>
        </div>

      {!!Form::close()!!}
      <!-- ./Form de inserção -->
      <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="createErrorReport">
        
      </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="validateForm3('createUser', 'createErrorReport')">Salvar</button>
        
      </div>
    </div>
  </div>
</div>
<!-- ./Modal Novo Lançamento -->


<script>
function is_email(email){
  er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}/; 
  if( er.exec(email) )
  {
    return true;
  }
}

function validateForm3(form, errorDiv) {
  var x = document.forms[form];
  var error = "";

  if(x['name'].value == ''){
    document.getElementById('divName').className = 'form-group has-error';
    error = error.concat('<li>Campo Nome é obrigatório</li>');
  }else{
    document.getElementById('divName').className = 'form-group';
  }

  if(x['email'].value == ''){
    document.getElementById('divEmail').className = 'form-group has-error';
    error = error.concat('<li>Campo Email é obrigatório</li>');
  }else if(!is_email(x['email'].value)){
    document.getElementById('divEmail').className = 'form-group has-error';
    error = error.concat('<li>Insira um email válido</li>');
  }else{
    document.getElementById('divEmail').className = 'form-group';
  }

  if(x['password'].value == ''){
    document.getElementById('divPass').className = 'form-group has-error';
    error = error.concat('<li>Campo Senha é obrigatório</li>');
  }else if(x['password'].value.length < 6){
    document.getElementById('divConfirmPass').className = 'form-group has-error';
    error = error.concat('<li>A senha deve ter ao menos 6 caracteres</li>');
  }else{
    document.getElementById('divPass').className = 'form-group';
  }

  if(x['password_confirmation'].value == ''){
    document.getElementById('divConfirmPass').className = 'form-group has-error';
    error = error.concat('<li>A confirmação de senha é obrigatório</li>');
  }else if(x['password_confirmation'].value != x['password'].value){
    document.getElementById('divConfirmPass').className = 'form-group has-error';
    error = error.concat('<li>A confirmação de senha confere</li>');
  }else{
    document.getElementById('divConfirmPass').className = 'form-group';
  }

  if (error != '') {
    document.getElementById(errorDiv).style.display = 'block'

    document.getElementById(errorDiv).innerHTML = error;
  }else{
    x.submit();
  }
}

$(document).ready(function(){
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
});
</script>