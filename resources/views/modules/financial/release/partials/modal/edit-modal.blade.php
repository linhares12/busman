<!-- Modal Editar Lançamento -->
<div class="modal fade" id="editReleaseModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Lançamento</h4>
      </div>
      <div class="modal-body">
      <!-- Form de Edição -->
      {{Form::open(['url' => '/admin/release/edit', 'class' => 'edit_form form-horizontal', 'name' => 'editReceipt'])}}

        <div class="form-group {{ $errors->has('payday') ? ' has-error' : '' }}">
            {!!Form::label('payday', 'Vencimento', ['class' => 'col-md-4 control-label', 'for' => 'payday'])!!}
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                {!!Form::text('payday', null, ['class' => 'form-control datepicker_actual', 'id' => 'edit_date', 'value' => "{{ old('payday')}}"])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            {!!Form::label('description', 'Descrição', ['class' => 'col-md-4 control-label', 'for' => 'description'])!!}
            <div class="col-md-6">
              {!!Form::text('description', null, ['class' => 'form-control', 'id' => 'edit_description', 'value' => "{{ old('description')}}"])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}">
            {!!Form::label('category', 'Categoria', ['class' => 'col-md-4 control-label', 'for' => 'category'])!!}
            <div class="col-md-6">
              <div id = "categoryDiv"> 
                {!!Form::select('category', $categories, null, ['class' => 'form-control', 'id' =>'edit_category', 'style' => 'width:100%', 'value' => "{{ old('category')}}", 'placeholder' => 'Selecione...'])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}">
            {!!Form::label('value', 'Valor', ['class' => 'col-md-4 control-label', 'for' => 'value'])!!}
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">R$</span>
                {!!Form::text('value', null, ['class' => 'form-control money', 'id' => 'edit_value', 'value' => "{{ old('value')}}"])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('account') ? ' has-error' : '' }}">
            {!!Form::label('account', 'Conta', ['class' => 'col-md-4 control-label', 'for' => 'account'])!!}
            <div class="col-md-6" >
            <div id = "accountDiv"> 
              {!!Form::select('account', $accounts, null, ['class' => 'form-control', 'id' => 'edit_account', 'style' => 'width:100%', 'value' => "{{ old('account')}}", 'placeholder' => 'Selecione...'])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}" id="status_Div">
          {!!Form::label('status', 'Efetuado?', ['class' => 'col-md-4 control-label', 'for' => 'status'])!!}
          <div class="col-md-6">
            <input type="checkbox" name="status" id="edit_payd" class="flat-red"/>
          </div>
        </div>

        <div class="form-group {{ $errors->has('repeat') ? ' has-error' : '' }}" id="repeat_update">
          {!!Form::label('repeat', 'Alterar Repetições?', ['class' => 'col-md-4 control-label', 'for' => 'repeat'])!!}
          <div class="col-md-6"> 
            <input type="radio" class="flat-red" name="repeat" id="future_only_edit" value="only" checked
            /> Apenas esta <br />
            <input type="radio" class="flat-red" name="repeat" id="future_repeat_edit" value="future"/> Esta e futuras <br />
            <input type="radio" class="flat-red" name="repeat" id="all_repeat_edit" value="all"/> Todas <br />
          </div>
        </div>

        <input type="hidden" name="id" id="id">
        <input type="hidden" name="original_date" id="original_date">

        {!!Form::close()!!}

        <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="editErrorReport">
        
        </ul>
        <small id="alert_masive_edit" style="display: none">
          <strong style="color: #800">
            Cuidado! Você está realizando uma alteração massiva. <br>
            Todos os lançamentos afetados serão identicos a este. Mesmo os campos que você não alterou neste formulário. <br>
          </strong>
          <strong>Obs.:<br></strong>
          <ul>
            <li>Em alterações massivas, no vencimento é modificado apenas o dia.</li>
            <li>Lançamentos fixos não podem ser efetivados massivamente.</li>
          </ul>
          </small>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="validateForm('editReceipt', 'editErrorReport')">Salvar</button>
        <!-- ./Hidden -->


      <!-- ./Form de Edição -->
      </div>
    </div>
  </div>
</div>

<script>

function show_alert_edit() {
  document.getElementById('alert_masive_edit').style.display = 'block'
}

function close_alert_edit() {
  document.getElementById('alert_masive_edit').style.display = 'none'
}

 function formatMoney(a) {
    var c = 2;
    var d = ',';
    var t = '.';
    var n = a, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 }

  $('#editReleaseModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id');
    var payd = button.data('payd');
    var date = button.data('date');
    var description = button.data('description');
    var category = button.data('category');
    var value = button.data('value');
    var account = button.data('account');
    var repeat = button.data('repeat');

    var modal = $(this);

    value = formatMoney(value);

    modal.find('#id').val(id);
    modal.find('#edit_description').val(description);
    modal.find('#edit_date').val(date);
    modal.find('#original_date').val(date);
    modal.find('#edit_value').val(value);
    modal.find('#edit_category').val(category).trigger("change");
    modal.find('#edit_account').val(account).trigger("change");
    
    if(payd === 'payd'){
        modal.find('#edit_payd').iCheck('check');
      }else{
        modal.find('#edit_payd').iCheck('uncheck');
      }

    if(repeat > 1 || repeat === ':inf'){
      document.getElementById('repeat_update').style.display = 'block';
      document.getElementById('status_Div').style.display = 'none';
    }else{
      document.getElementById('repeat_update').style.display = 'none';
      document.getElementById('status_Div').style.display = 'block';
    }

  });
</script>
<!-- ./Modal Editar Lançamento -->