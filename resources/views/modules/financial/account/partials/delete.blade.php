<!-- Modal Deletar Lançamento -->
<div class="modal modal-danger fade" id="deleteAccountModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Conta <strong id="deleteAccName"></strong></h4>
      </div>
      <div class="modal-body">
        <!-- Form de inserção -->
        {{Form::open(['url' => '/admin/account/delete', 'class' => 'delete_form', 'name' => 'deleteAccount'])}}

        <strong"><i class="fa fa-exclamation-triangle"></i> Cuidado! Ao eliminar uma conta, todos os lançamentos associados a esta serão eliminados. <font style='text-decoration: underline;'>Incluindo os já efetivados no passado.</font></strong>

        <input type="hidden" name="id" id="id">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        <a class="pull-left" style='color: #fff' onclick="document.deleteAccount.submit();">Sim. Quero eliminar esta conta</a>
        {!!Form::close()!!}
        <!-- ./Form de inserção -->
      </div>
    </div>
  </div>
</div>
<!-- ./Modal Deletar Lançamento -->

<script>

$('#deleteAccountModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id')
    var name = button.data('name')
    var amount = button.data('balance')

    var modal = $(this)

    modal.find('#id').val(id)
    modal.find('#deleteAccName').text(name)
  });
</script>