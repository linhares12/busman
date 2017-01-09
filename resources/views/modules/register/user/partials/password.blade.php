<!-- Modal Editar Usuário -->
<div class="modal fade" id="resetPassModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Alterar Senha</h4>
      </div>
      <div class="modal-body">
      <!-- Form de inserção -->
      {{Form::open(['url' => '/admin/usuario/pass/reset', 'class' => 'edit_form form-horizontal', 'name' => 'passReset', 'method' => 'POST'])}}

        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}" id="divResetPass">
            {!!Form::label('password', 'Nova Senha', ['class' => 'col-md-4 control-label', 'for' => 'password'])!!}
            <div class="col-md-6"> 
              {!!Form::password('password', ['class' => 'form-control', 'value' => "{{ old('password')}}", 'id' => 'reset_password'])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" id="divResetConfirm">
            {!!Form::label('password_confirmation', 'Confirmar Nova Senha', ['class' => 'col-md-4 control-label', 'for' => 'password_confirmation'])!!}
            <div class="col-md-6"> 
              {!!Form::password('password_confirmation', ['class' => 'form-control', 'value' => "{{ old('password_confirmation')}}", 'id' => 'reset_password_confirm'])!!}
            </div>
        </div>

        <input type="hidden" name="id" id="user_reset_id">
        

      {!!Form::close()!!}
      <!-- ./Form de inserção -->
      <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="resetErrorReport">
        
      </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="validateReset('passReset', 'resetErrorReport')">Salvar</button>
        
      </div>
    </div>
  </div>
</div>
<!-- ./Modal Novo Lançamento -->


<script>

function validateReset(form, errorDiv) {
  var x = document.forms[form];
  var error = "";

  if(x['password'].value == ''){
    document.getElementById('divResetPass').className = 'form-group has-error';
    error = error.concat('<li>Campo Senha é obrigatório</li>');
  }else if(x['password'].value.length < 6){
    document.getElementById('divResetPass').className = 'form-group has-error';
    error = error.concat('<li>A senha deve ter ao menos 6 caracteres</li>');
  }else{
    document.getElementById('divResetPass').className = 'form-group';
  }

  if(x['password_confirmation'].value == ''){
    document.getElementById('divResetConfirm').className = 'form-group has-error';
    error = error.concat('<li>A confirmação de senha é obrigatório</li>');
  }else if(x['password_confirmation'].value != x['password'].value){
    document.getElementById('divResetConfirm').className = 'form-group has-error';
    error = error.concat('<li>A confirmação de senha confere</li>');
  }else{
    document.getElementById('divResetConfirm').className = 'form-group';
  }

  if (error != '') {
    document.getElementById(errorDiv).style.display = 'block'

    document.getElementById(errorDiv).innerHTML = error;
  }else{
    x.submit();
  }
}

$('#resetPassModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id')

    var modal = $(this)

    modal.find('#user_reset_id').val(id)

  });
</script>