<!-- Modal Eliminar -->
<div class="modal fade" id="deleteRelease" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Lançamento</h4>
      </div>
      <div class="modal-body">

        {{Form::open(['url' => '/admin/release/delete', 'class' => 'delete_form form-horizontal'])}}

        <div class="form-group {{ $errors->has('id') ? ' has-error' : '' }}">
          {!!Form::label('del_description', 'Descrição', ['class' => 'col-md-4 control-label', 'for' => 'del_description'])!!}
          <div class="col-md-6"> 
            {!!Form::text('del_description', null, ['class' => 'form-control', 'id' => 'del_description', 'disabled', 'value' => "{{ old('del_description')}}"])!!}
          </div>
        </div>

        <div class="form-group {{ $errors->has('receipt') ? ' has-error' : '' }}" id="repeat_delete">
          {!!Form::label('receipt', 'Eliminar Repetições?', ['class' => 'col-md-4 control-label', 'for' => 'receipt'])!!}
          <div class="col-md-6"> 
            <input type="radio" class="flat-red" name="repeat" id="future_only_delete" value="only" checked
            /> Apenas esta <br />
            <input type="radio" class="flat-red" name="repeat" id="future_repeat_delete" value="future"/> Esta e futuras <br />
            <input type="radio" class="flat-red" name="repeat" id="all_repeat_delete" value="all"/> Todas <br />
            <small id="alert_masive_delete" style="display: none"><strong style="color: #800">Cuidado! Você está realizando uma alteração massiva.</strong></small>
          </div>
        </div>

        <input type="hidden" name="id" id="del_id">
        <input type="hidden" name="date" id="del_date">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger">Confirmar</button>
        {!!Form::close()!!}
      </div>
    </div>
  </div>
</div>

<script>
function show_alert_delete() {
  document.getElementById('alert_masive_delete').style.display = 'block';
}

function close_alert_delete() {
  document.getElementById('alert_masive_delete').style.display = 'none';
}

  $('#deleteRelease').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var description = button.data('description')
  var repeat = button.data('repeat')
  var date = button.data('date')

  var modal = $(this)

  modal.find('#del_description').val(description)
  modal.find('#del_id').val(id)
  modal.find('#del_date').val(date)


  if(repeat > 1 || repeat == ':inf'){
    document.getElementById('repeat_delete').style.display = 'block';
  }else{
    document.getElementById('repeat_delete').style.display = 'none';
  }
})
</script>
<!-- ./Modal Eliminar -->