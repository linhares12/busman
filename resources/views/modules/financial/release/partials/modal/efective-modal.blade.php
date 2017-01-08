<!-- Modal Efetivar -->
<div class="modal fade" id="efective" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Efetivar Pagamento</h4>
      </div>
      <div class="modal-body">
        {{Form::open(['url' => '/admin/release/efective', 'class' => 'efective_form form-horizontal'])}}
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            {!!Form::label('description', 'Descrição', ['class' => 'col-md-4 control-label', 'for' => 'description'])!!}
            <div class="col-md-6"> 
              {!!Form::text('description', null, ['class' => 'form-control', 'value' => "{{ old('description')}}", 'id' => 'efective_description'])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}">
            {!!Form::label('value', 'Valor', ['class' => 'col-md-4 control-label', 'for' => 'value'])!!}
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">R$</span>
                {!!Form::text('value', null, ['class' => 'form-control money', 'value' => "{{ old('value')}}", 'id' => 'efective_value'])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
            {!!Form::label('date', 'Data', ['class' => 'col-md-4 control-label', 'for' => 'date'])!!}
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                {!!Form::text('date', null, ['class' => 'form-control datepicker', 'id' => 'efective_date', 'value' => "{{ old('date')}}"])!!}
              </div>
            </div>
        </div>

        <input type="hidden" name="id" id="id">
        <input type="hidden" name="original_date" id="original_date">


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="subEfective">Efetivar</button>
        {!!Form::close()!!}
      </div>
    </div>
  </div>
</div>

<script>
  $('#efective').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var payd = button.data('payd')
  var date = button.data('date')
  var description = button.data('description')
  var value = button.data('value')
  var repeat = button.data('repeat')
  var operacao = button.data('op');

  var modal = $(this)

  modal.find('#id').val(id)
  modal.find('#efective_description').val(description)
  modal.find('#efective_date').val(date)
  modal.find('#original_date').val(date)
  modal.find('#efective_value').val(formatMoney(value))
  //alert(operacao)
  if (operacao == 'estorno') {
    //document.getElementById('#myModalLabel').innerHTML = 'Estornar pagamento';
    modal.find('#myModalLabel').text('Estornar pagamento')
    modal.find('#subEfective').text('Estornar')
  }else{
    modal.find('#myModalLabel').text('Estornar pagamento')
    modal.find('#subEfective').text('Efetivar')
  }
})
</script>
<!-- ./Modal Efetivar -->