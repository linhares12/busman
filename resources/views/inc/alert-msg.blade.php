<!-- Mensagens Erro -->
@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="pull-right my-close" data-dismiss="alert"><strong>&times;</strong>
    </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- ./ Mensagens Erro -->

<!-- Mensagens Sucesso -->
@if (session('success'))
  <div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="pull-right my-close" data-dismiss="alert"><strong>&times;</strong>
    </button>
    {{ session('success') }}
  </div>
@endif
<!-- ./ Mensagens Sucesso -->

<!-- Mensagens Warning -->
@if (session('warning'))
  <div class="alert alert-warning alert-dismissible fade in" role="alert" id="success-alert">
    <button type="button" class="pull-right my-close" data-dismiss="alert"><strong>&times;</strong>
    </button>
    {{ session('warning') }}
  </div>
@endif
<!-- ./ Mensagens Warning -->

<!-- Mensagens Info -->
@if (session('info'))
  <div class="alert alert-info alert-dismissible fade in" role="alert">
    <button type="button" class="pull-right my-close" data-dismiss="alert"><strong>&times;</strong>
    </button>
    {{ session('info') }}
  </div>
@endif
<!-- ./ Mensagens Info -->
