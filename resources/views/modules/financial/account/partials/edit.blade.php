<!-- Modal Editar Lançamento -->
<div class="modal fade" id="editAccountModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Conta</h4>
      </div>
      <div class="modal-body">
      <!-- Form de inserção -->
      {{Form::open(['url' => '/admin/account/edit', 'class' => 'edit_form form-horizontal', 'name' => 'editAccount'])}}

        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            {!!Form::label('name', 'Nome', ['class' => 'col-md-4 control-label', 'for' => 'name'])!!}
            <div class="col-md-6"> 
              {!!Form::text('name', null, ['class' => 'form-control', 'value' => "{{ old('name')}}", 'id' => 'edit_name'])!!}
            </div>
        </div>

        <input type="hidden" name="id" id="id">
        <small>(Caso deseje alterar o saldo, faça um lançamento de receita ou despesa)</small>
        

      {!!Form::close()!!}
      <!-- ./Form de inserção -->
      <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="editErrorReport">
        
      </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="validateForm2('editAccount', 'editErrorReport')">Salvar</button>
        
      </div>
    </div>
  </div>
</div>
<!-- ./Modal Novo Lançamento -->


<script>

function validateForm2(form, errorDiv) {
  var x = document.forms[form];
  var error = "";

  if(x['name'].value == ''){
    x['name'].style.border = '1px #800000 solid';
    error = error.concat('<li>Informe um nome para a conta</li>'); //has-error
  }

  if (error != '') {

    document.getElementById(errorDiv).style.display = 'block';

    document.getElementById(errorDiv).innerHTML = error;

  }else{
    x.submit();
  }
}

$('#editAccountModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id')
    var name = button.data('name')
    var amount = button.data('balance')

    var modal = $(this)

    modal.find('#id').val(id)
    modal.find('#edit_name').val(name)

  });
</script>