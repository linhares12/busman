<!-- Modal Editar Usuário -->
<div class="modal fade" id="editUserModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Usuário</h4>
      </div>
      <div class="modal-body">
      <!-- Form de inserção -->
      {{Form::open(['url' => '', 'class' => 'edit_form form-horizontal', 'name' => 'editUser', 'method' => 'PUT'])}}

        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}" id="divEditName">
            {!!Form::label('name', 'Nome', ['class' => 'col-md-4 control-label', 'for' => 'name'])!!}
            <div class="col-md-6"> 
              {!!Form::text('name', null, ['class' => 'form-control', 'value' => "{{ old('name')}}", 'id' => 'edit_user_name'])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}" id="divEditEmail">
            {!!Form::label('email', 'E-mail', ['class' => 'col-md-4 control-label', 'for' => 'email'])!!}
            <div class="col-md-6"> 
              {!!Form::email('email', null, ['class' => 'form-control', 'value' => "{{ old('email')}}", 'id' => 'edit_user_email'])!!}
            </div>
        </div>

        <input type="hidden" name="id" id="user_id">
        

      {!!Form::close()!!}
      <!-- ./Form de inserção -->
      <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="editErrorReport">
        
      </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="validateForm4('editUser', 'editErrorReport')">Salvar</button>
        
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

function validateForm4(form, errorDiv) {
  var x = document.forms[form];
  var error = "";

  if(x['name'].value == ''){
    document.getElementById('divEditName').className = 'form-group has-error';
    error = error.concat('<li>Campo Nome é obrigatório</li>');
  }else{
    document.getElementById('divEditName').className = 'form-group';
  }

  if(x['email'].value == ''){
    document.getElementById('divEditEmail').className = 'form-group has-error';
    error = error.concat('<li>Campo Email é obrigatório</li>');
  }else if(!is_email(x['email'].value)){
    document.getElementById('divEditEmail').className = 'form-group has-error';
    error = error.concat('<li>Insira um email válido</li>');
  }else{
    document.getElementById('divEditEmail').className = 'form-group';
  }

  if (error != '') {
    document.getElementById(errorDiv).style.display = 'block'

    document.getElementById(errorDiv).innerHTML = error;
  }else{
    x.action = '/admin/usuario/' + x['id'].value;
    x.submit();
  }
}

$('#editUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id')
    var name = button.data('name')
    var email = button.data('email')

    var modal = $(this)

    modal.find('#user_id').val(id)
    modal.find('#edit_user_name').val(name)
    modal.find('#edit_user_email').val(email)

  });
</script>