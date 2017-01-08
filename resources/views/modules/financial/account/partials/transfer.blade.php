<button type="button" class="btn btn-primary btn-sm" data-tt="tooltip" data-toggle="modal" data-target="#transferModal"  title="Transferência entre contas" style="border-radius: 50%">
  <i class="ion-arrow-swap"></i>
</button>

<!-- Modal Novo Lançamento -->
<div class="modal fade" id="transferModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transferencia entre contas</h4>
      </div>
      <div class="modal-body">
      <!-- Form de inserção -->
      {{Form::open(['url' => '/admin/account/transfer', 'class' => 'create_form form-horizontal', 'name' => 'transferAccount'])}}

        <!--div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}"  id="nameDiv">
            {!!Form::label('identifyer', 'Identificador', ['class' => 'col-md-4 control-label', 'for' => 'identifyer'])!!}
            <div class="col-md-6"> 
              {!!Form::text('identifyer', null, ['class' => 'form-control', 'value' => "{{ old('identifyer')}}"])!!}
            </div>
        </div-->

        <div class="form-group {{ $errors->has('outgoing_account') ? ' has-error' : '' }}"  id="outgoingDiv">
            {!!Form::label('outgoing_account', 'Conta Origem', ['class' => 'col-md-4 control-label', 'for' => 'outgoing_account'])!!}
            <div class="col-md-6" >
              {!!Form::select('outgoing_account', $accArray, null, ['class' => 'form-control', 'style' => 'width:100%', 'value' => "{{ old('outgoing_account')}}", 'placeholder' => 'Selecione...'])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('incoming_account') ? ' has-error' : '' }}"  id="incomingDiv">
            {!!Form::label('incoming_account', 'Conta Destino', ['class' => 'col-md-4 control-label', 'for' => 'incoming_account'])!!}
            <div class="col-md-6" >
              {!!Form::select('incoming_account', $accArray, null, ['class' => 'form-control', 'style' => 'width:100%', 'value' => "{{ old('incoming_account')}}", 'placeholder' => 'Selecione...'])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}"  id="valueDiv">
            {!!Form::label('value', 'Valor', ['class' => 'col-md-4 control-label', 'for' => 'value'])!!}
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">R$</span>
                {!!Form::text('value', null, ['class' => 'form-control money', 'value' => "{{ old('value')}}"])!!}
              </div>
            </div>
        </div>

      {!!Form::close()!!}
      <!-- ./Form de inserção -->
      <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="transferErrorReport"></ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="validateForm3('transferAccount', 'transferErrorReport')">Salvar</button>
        
      </div>
    </div>
  </div>
</div>
<!-- ./Modal Novo Lançamento -->


<script>
function validateForm3(form, errorDiv) {
  var x = document.forms[form];
  var error3 = "";
/*
  if(x['identifyer'].value == ''){
    document.getElementById('nameDiv').className  = 'form-group has-error';
    error3 = error3.concat('<li>Informe um identificador para a transferência</li>'); //has-error
  }else{
    document.getElementById('nameDiv').className = 'form-group';
  }*/

  if(x['outgoing_account'].value == ''){
    document.getElementById('outgoingDiv').className  = 'form-group has-error';
    error3 = error3.concat('<li>Informe a conta de origem</li>'); //has-error
  }else{
    document.getElementById('outgoingDiv').className = 'form-group';
  }

  if(x['incoming_account'].value == ''){
    document.getElementById('incomingDiv').className  = 'form-group has-error';
    error3 = error3.concat('<li>Informe a conta de destino</li>'); //has-error
  }else{
    document.getElementById('incomingDiv').className = 'form-group';
  }

  if(x['value'].value == ''){
    document.getElementById('valueDiv').className  = 'form-group has-error';
    error3 = error3.concat('<li>Informe um valor para a transferência</li>'); //has-error
  }else{
    document.getElementById('valueDiv').className = 'form-group';
  }
//alert(error3);
  if(x['outgoing_account'].value == x['incoming_account'].value && x['outgoing_account'].value != ''){
    document.getElementById('incomingDiv').className  = 'form-group has-error';
    document.getElementById('outgoingDiv').className  = 'form-group has-error';
    error3 = error3.concat('<li>As contas de origem e destino não podem ser a mesma</li>'); //has-error
  }else if(x['incoming_account'].value == ''){
    document.getElementById('incomingDiv').className  = 'form-group has-error';
  }else if(x['outgoing_account'].value == ''){
    document.getElementById('outgoingDiv').className  = 'form-group has-error';
  }else{
    document.getElementById('incomingDiv').className = 'form-group';
    document.getElementById('outgoingDiv').className = 'form-group';
  }

  if (error3 != '') {
    document.getElementById(errorDiv).style.display = 'block'

    document.getElementById(errorDiv).innerHTML = error3;
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