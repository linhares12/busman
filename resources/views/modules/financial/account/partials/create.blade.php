<button type="button" class="btn btn-primary btn-sm" data-tt="tooltip" data-toggle="modal" data-target="#createAccountModal"  title="Novo Lançamento" style="border-radius: 50%">
  <i class="fa fa-plus"></i>
</button>

<!-- Modal Novo Lançamento -->
<div class="modal fade" id="createAccountModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nova Conta</h4>
      </div>
      <div class="modal-body">
      <!-- Form de inserção -->
      {{Form::open(['url' => '/admin/account/create', 'class' => 'create_form form-horizontal', 'name' => 'createAccount'])}}

        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            {!!Form::label('name', 'Nome', ['class' => 'col-md-4 control-label', 'for' => 'name'])!!}
            <div class="col-md-6"> 
              {!!Form::text('name', null, ['class' => 'form-control', 'value' => "{{ old('name')}}"])!!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('opening_balance') ? ' has-error' : '' }}">
            {!!Form::label('opening_balance', 'Saldo Inicial', ['class' => 'col-md-4 control-label', 'for' => 'opening_balance'])!!}
            <div class="col-md-6">
              <div class="input-group" id="valueDiv">
              <span class="input-group-addon" id="basic-addon1">R$</span>
              {!!Form::text('opening_balance', null, ['class' => 'form-control money', 'value' => "{{ old('opening_balance')}}"])!!}
              </div>
            </div>
        </div>

      {!!Form::close()!!}
      <!-- ./Form de inserção -->
      <ul class="alert alert-danger col-md-12" style="padding: 20px; display: none" id="createErrorReport">
        
      </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="validateForm2('createAccount', 'createErrorReport')">Salvar</button>
        
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
    document.getElementById(errorDiv).style.display = 'block'

    document.getElementById(errorDiv).innerHTML = error;
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