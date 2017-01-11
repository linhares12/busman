@extends('layouts.admin')

@section('main_content')
<div class="row">
    <div class="col-md-12" id="create-box" @if(old('id')) style="display:none;" @else style="display:block;" @endif>
         <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Gerenciamento de Categorias [Criar]</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="col-md-12">
                    {{Form::open(['url' => '/admin/config/categorias/create', 'class' => 'form-inline', 'id' =>'create-form'])}}

                    <div class="col-md-3">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            {!!Form::label('name', 'Nome: ', ['for' => 'name'])!!}
                            <input type="text" name="name" class="form-control" value="{{ old('name')}}", id="nameColor">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('color') ? ' has-error' : '' }}">
                            {!!Form::label('color', 'Cor: ', ['for' => 'color'])!!}

                            <div class="input-group my-colorpicker2">
                                <input type="text" name="color" class="form-control" value="{{ old('color')}}" id="colorText" placeholder="Clique no ícone &rarr;">
                                <div class="input-group-addon">
                                <i class="glyphicon glyphicon-tint" id="iconColor" style="border-radius: 50%; width: 20px; height: 20px"></i>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <script>
                            $(document).ready(function () {
                              $("#iconColor").click(function() { 
                                document.getElementById('iconColor').className = '';
                               });

                                $( document.body ).click(function() {
                                    if (document.getElementById('colorText').value == '') {
                                        document.getElementById('iconColor').className = 'glyphicon glyphicon-tint';
                                    }else{
                                        document.getElementById('iconColor').className = '';
                                    }
                                });
                            });
                        </script>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                            {!!Form::label('type', 'Tipo: ', ['for' => 'type'])!!}
                            <input type="radio" class="flat-red" name="type" value="expense" @if(old('type') == 'expense') checked @endif /> Despesa
                           <input type="radio" class="flat-red" name="type" value="receipt" @if(old('type') == 'receipt') checked @endif/> Receita

                        </div>
                        {!! Form::submit('Criar', ['class' => 'btn btn-primary btn-flat pull-right'])!!}
                    </div>
                    <!-- /.col -->
                    {{Form::close([])}}

                </div>
            </div>
        </div>
    </div>
    <?php //var_dump(old()) ?>
    <div class="col-md-12" id="edit-box" @if(old('id')) style="display:block;" @else style="display:none;" @endif>
         <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Gerenciamento de Categorias [Editar]</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="col-md-12">
                    {!! Form::open(['url' => '/admin/config/categorias/update/', 'class' => 'create-form form-inline', 'id' =>'edit-form']) !!}

                    <div class="col-md-3">
                        {!!Form::text('id', null, ['class' => 'form-control', 'id' =>'editCatId', 'value' => "{{ old('id')}}", 'style' => 'display:none'])!!}
                        <div class="form-group {{ $errors->has('name_edit') ? ' has-error' : '' }}">
                            {!!Form::label('name_edit', 'Nome', ['for' => 'name_edit'])!!}
                            {!!Form::text('name_edit', null, ['class' => 'form-control', 'id' =>'editCatName', 'value' => "{{ old('name_edit')}}"])!!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('color_edit') ? ' has-error' : '' }}">
                            {!!Form::label('color_edit', 'Cor', ['for' => 'color_edit'])!!}

                            <div class="input-group my-colorpicker3">
                                {!!Form::text('color_edit', null, ['class' => 'form-control', 'id' =>'editCatColor', 'value' => "{{ old('color_edit')}}"])!!}
                                <div class="input-group-addon"><i style="border-radius: 50%"></i></div>
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">

                        {{ Form::submit('Salvar', ['class' => 'btn btn-success btn-flat'])}}
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default btn-flat" onclick="cancelEdit();">Cancelar</button>

                    </div>
                    <!-- /.col -->

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        @include('inc.alert-msg')
    </div>
</div>

<div class="row">
    
    <div class="col-md-6">
        <div class="box box-danger">

            <div class="box-header with-border">
                <h3 class="box-title">Despesa</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body" style="max-height: 400px; min-height: 400px; overflow-y: scroll;">
                <table class="table table-hover">
                    <tr>
                        <th>Categoria</th>
                        <th style="width: 40px">Cor</th>
                        <th></th>
                    </tr>
                    @if($categories->isEmpty())
                    <tr><td>Nenhuma categoria encontrada</td></tr>
                    @else
                    @foreach($categories as $category)
                    @if($category->type == 'expense' && $category->name != 'account_transfer')
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            @if($category->color == "")
                            <i class="fa fa-minus"></i>
                            @else
                            <div style="width: 20px; height: 20px;border-radius: 50%; background-color: {{$category->color}}"></div>
                            @endif
                        </td>
                        <td>
                            <a title="Editar" onclick="editCategory('{{$category->id}}', '{{$category->name}}', '{{$category->color}}')"><i class="fa fa-edit"></i></a>
                            <a title="Eliminar"  data-toggle="modal" data-target="#deleteModal" data-id="{{$category->id}}" data-name="{{$category->name}}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endif

                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-info">

            <div class="box-header with-border">
                <h3 class="box-title">Receita</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body" style="max-height: 400px; min-height: 400px; overflow-y: scroll;">
                <table class="table table-hover">
                    <tr>
                        <th>Categoria</th>
                        <th style="width: 40px">Cor</th>
                        <th></th>
                    </tr>
                    @if($categories->isEmpty())
                    <tr><td>Nenhuma categoria encontrada</td></tr>
                    @else
                    @foreach($categories as $category)
                    @if($category->type == 'receipt' && $category->name != 'account_transfer')
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            @if($category->color == "")
                            <div style="width: 20px; height: 20px;border-radius: 50%;">
                                <i class="fa fa-minus"></i>
                            </div>
                            @else
                            <div style="width: 20px; height: 20px;border-radius: 50%; background-color: {{$category->color}}"></div>
                            @endif
                        </td>
                        <td>
                            <a title="Editar" onclick="editCategory('{{$category->id}}', '{{$category->name}}', '{{$category->color}}')"><i class="fa fa-edit"></i></a>
                            <a title="Eliminar"  data-toggle="modal" data-target="#deleteModal" data-id="{{$category->id}}" data-name="{{$category->name}}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endif

                </table>

            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Eliminar Categoria</h4>
            </div>
            <div class="modal-body">
                Tem certeza que deseja eliminar a categoria <b id="name">name</b> ?
                {{Form::open(['url' => '/admin/config/categorias/delete'])}}
                <input type="hidden" name="cat_id" class="form-control" id="cat_id">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger btn-flat">Eliminar</button>
                {{Form::close([])}}
            </div>
        </div>
    </div>
</div>

<script>

    $('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
            var name = button.data('name')
            var id = button.data('id')
            var modal = $(this)
            modal.find('#name').text(name)
            modal.find('#cat_id').val(id)
            });
    function cancelEdit() {
    document.getElementById("create-box").style.display = "block";
    document.getElementById("edit-box").style.display = "none";
    }

    function editCategory(id, name, color) {
    document.getElementById("create-box").style.display = "none";
    document.getElementById("edit-box").style.display = "block";
    document.getElementById("editCatId").value = id;
    document.getElementById("editCatName").value = name;
    $('.my-colorpicker3').colorpicker('setValue', color);
    }

    $(function () {
    $('.my-colorpicker2').colorpicker();
    $('.my-colorpicker3').colorpicker();
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
    });
    });
</script>
@stop