<!-- Modal Deletar Lançamento -->
<div class="modal modal-danger fade" id="deleteUserModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Usuário <strong id="deleteUserName"></strong></h4>
      </div>
      <div class="modal-body">
        <!-- Form de inserção -->
        {{Form::open(['url' => '/admin/usuario', 'class' => 'delete_form', 'name' => 'deleteUserForm', 'method' => 'DELETE'])}}

        <input type="hidden" name="id" id="del_user_id">

        <strong"><i class="fa fa-exclamation-triangle"></i> Tem certeza que quer eliminar este usuário?</strong>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        
        {!!Form::close()!!}
        <button  type="button" class="btn btn-default btn-flat" onclick="deleteUser('deleteUserForm')">Eliminar</button>
        <!-- ./Form de inserção -->
      </div>
    </div>
  </div>
</div>
<!-- ./Modal Deletar Lançamento -->

<script>
function deleteUser(deleteform){
  var dform = document.forms[deleteform];
  dform.action = '/admin/usuario/' + dform['id'].value;
  dform.submit();
}
$('#deleteUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id')
    var name = button.data('name')

    var modal = $(this)

    modal.find('#del_user_id').val(id)
    modal.find('#deleteUserName').text(name)
  });
</script>