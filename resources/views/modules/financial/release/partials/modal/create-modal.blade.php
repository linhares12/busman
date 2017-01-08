<button type="button" class="btn btn-{{$classColor}} btn-sm" data-tt="tooltip" data-toggle="modal" data-target="#newReleaseModal"  title="Novo Lançamento" style="border-radius: 50%">
  <i class="fa fa-plus"></i>
</button>

<!-- Modal Novo Lançamento -->
<div class="modal fade" id="newReleaseModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Novo Lançamento</h4>
      </div>
      <div class="modal-body">
      <!-- Form de inserção -->
      {{Form::open(['url' => '/admin/release/create', 'class' => 'create_form form-horizontal', 'name' => 'createReceipt'])}}

        <div class="form-group {{ $errors->has('payday') ? ' has-error' : '' }}" id="paydayDiv">
            {!!Form::label('payday', 'Vencimento', ['class' => 'col-md-4 control-label', 'for' => 'payday'])!!}
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span> 
                {!!Form::text('payday', null, ['class' => 'form-control datepicker_actual', 'value' => "{{ old('payday')}}"])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}" id="descriptionDiv">
            {!!Form::label('description', 'Descrição', ['class' => 'col-md-4 control-label', 'for' => 'description'])!!}
            <div class="col-md-6"> 
              {!!Form::text('description', null, ['class' => 'form-control', 'value' => "{{ old('description')}}"])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}" id="categoryDiv">
            {!!Form::label('category', 'Categoria', ['class' => 'col-md-4 control-label', 'for' => 'category'])!!}
            <div class="col-md-6">
              <div id="categoryField">
                {!!Form::select('category', $categories, null, ['class' => 'form-control', 'style' => 'width:100%', 'value' => "{{ old('category')}}", 'placeholder' => 'Selecione...'])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}" id="valueDiv">
            {!!Form::label('value', 'Valor', ['class' => 'col-md-4 control-label', 'for' => 'value'])!!}
            <div class="col-md-6">
              <div class="input-group" id="valueDiv">
              <span class="input-group-addon" id="basic-addon1">R$</span>
              {!!Form::text('value', null, ['class' => 'form-control money', 'value' => "{{ old('value')}}"])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('account') ? ' has-error' : '' }}" id="accountDiv">
            {!!Form::label('account', 'Conta', ['class' => 'col-md-4 control-label', 'for' => 'account'])!!}
            <div class="col-md-6" >
            <div id = "categoryDiv"> 
              {!!Form::select('account', $accounts, null, ['class' => 'form-control', 'style' => 'width:100%', 'value' => "{{ old('account')}}", 'placeholder' => 'Selecione...'])!!}
              </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}" id="statusDiv">
          {!!Form::label('status', '1º lançamento pago?', ['class' => 'col-md-4 control-label', 'for' => 'status'])!!}
          <div class="col-md-6"> 
            <input type="checkbox" class="flat-red" name="status" id="status">
          </div>
        </div>

        <div class="form-group {{ $errors->has('repeat') ? ' has-error' : '' }}" id="repeatDiv">
          {!!Form::label('repeat', 'Repetir', ['class' => 'col-md-4 control-label', 'for' => 'receipt'])!!}
          <div class="col-md-6"> 
            <input type="radio" class="flat-red" name="repeat" value="unique" checked /> Não 
            <input type="radio" class="flat-red" name="repeat" value="fixed"/> Recorrente 
            <input type="radio" class="flat-red" name="repeat" id="create_installment" value="installment"/> Parcelado
          </div>
        </div>

        <div class="form-group {{ $errors->has('receipt') ? ' has-error' : '' }}" id="create_installment_block" style="display: none">
          {!!Form::label('installment_qty', 'Qtd de parcelas: ', ['class' => 'col-md-4 control-label', 'for' => 'installment_qty'])!!}
          <div class="col-md-6"> 
            <div class="col-md-6">
            {!!Form::number('installment_qty',  null, ['class' => 'form-control', 'id' => 'installment_qty', 'value' => "{{ old('value')}}", 'min' => '2'])!!}
            </div>
          </div>
        </div>
        {!!Form::close()!!}
      <!-- ./Form de inserção -->

      <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="createErrorReport">
        
      </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="validateForm('createReceipt', 'createErrorReport')">Salvar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./Modal Novo Lançamento -->


<script>

function validateForm(form, errorDiv) {
  var x = document.forms[form];
  var error = "";

  if(x['payday'].value == '' ){
    document.getElementById('paydayDiv').className = 'form-group has-error';
    error = error.concat('<li>Campo data é obrigatório</li>'); //has-error
  }else if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(x['payday'].value)){
    document.getElementById('paydayDiv').className = 'form-group has-error';
    error = error.concat('<li>Formato de data inválido. (Correto: dd/mm/aaaa)</li>'); //has-error
  }else{
    document.getElementById('paydayDiv').className = 'form-group';
  }

  if(x['description'].value == ''){
    document.getElementById('descriptionDiv').className = 'form-group has-error';
    error = error.concat('<li>Campo descrição é obrigatório</li>');
  }else{
      document.getElementById('descriptionDiv').className = 'form-group';
    }

  if(x['category'].value == ''){
    document.getElementById('categoryDiv').className = 'form-group has-error';
    document.getElementById('categoryField').style.border = '1px #dd4b39 solid';


    error = error.concat('<li>Campo categoria é obrigatório</li>'); //
  }else{
      document.getElementById('categoryDiv').className = 'form-group';
    }

  if(x['account'].value == ''){
    document.getElementById('accountDiv').className = 'form-group has-error';
    error = error.concat('<li>Campo conta é obrigatório</li>'); //
  }else{
      document.getElementById('accountDiv').className = 'form-group';
    }

  if(x['value'].value == ''){
    document.getElementById('valueDiv').className = 'form-group has-error';
    error = error.concat('<li>Campo valor é obrigatório</li>');
  }else{
      document.getElementById('valueDiv').className = 'form-group';
    }

  if(document.getElementById('create_installment').checked){
    if (x['installment_qty'].value <= 1) {
      document.getElementById('create_installment_block').className = 'form-group has-error';
      error = error.concat('<li>O número de lançamentos não é válido</li>');
    }else{
      document.getElementById('create_installment_block').className = 'form-group';
    }
  }

  if (error != '') {
    document.getElementById(errorDiv).style.display = 'block'

    document.getElementById(errorDiv).innerHTML = error;
  }else{
    x.submit();
  }
}


function create_show_parcelas(){
  var status = $('input[id="create_installment"]:checked').val()
  if(status == 'installment'){
    document.getElementById('create_installment_block').style.display = 'block'
  }else{
    document.getElementById('create_installment_block').style.display = 'none'
  }
}

</script>