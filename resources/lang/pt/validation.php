<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'O campo :attribute deve ser aceito.',
    'active_url'           => 'O campo :attribute não é uma URL válida.',
    'after'                => 'O campo :attribute deve ser uma data posterior a :date.',
    'alpha'                => 'O campo :attribute só pode conter letras.',
    'alpha_dash'           => 'O campo :attribute só pode conter letras, números, and traços.',
    'alpha_num'            => 'O campo :attribute só pode conter letras and números.',
    'array'                => 'O campo :attribute deve ser um array.',
    'before'               => 'O campo :attribute deve ser uma data anterior a :date.',
    'between'              => [
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'file'    => 'O campo :attribute deve estar entre :min e :max kilobytes.',
        'string'  => 'O campo :attribute deve estar entre :min e :max caracteres.',
        'array'   => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'O campo :attribute não bateu com a confirmação.',
    'date'                 => 'O campo :attribute não é uma data válida.',
    'date_format'          => 'O campo :attribute não está de acordo com o formato :format.',
    'different'            => 'O campo :attribute e :other precisam ser diferentes.',
    'digits'               => 'O campo :attribute deve ter :digits digitos.',
    'digits_between'       => 'O campo :attribute deve estar entre :min e :max digitos.',
    'dimensions'           => 'O campo :attribute tem dimensões de imagem inválidos.',
    'distinct'             => 'O campo :attribute tem um valor duplicado.',
    'email'                => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'exists'               => 'O campo :attribute selecionado é inválido.',
    'file'                 => 'O campo :attribute deve ser um arquivo.',
    'filled'               => 'O campo :attribute é obrigatório.',
    'image'                => 'O campo :attribute deve ser uma imagem.',
    'in'                   => 'O campo :attribute selecionado é inválido.',
    'in_array'             => 'O campo :attribute não existe em :other.',
    'integer'              => 'O campo :attribute deve ser um inteiro.',
    'ip'                   => 'O campo :attribute deve ser um endereço de IP válido.',
    'json'                 => 'O campo :attribute deve ser uma sentença Jason válida (JSON string).',
    'max'                  => [
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
        'file'    => 'O campo :attribute não pode ser maior que :max kilobytes.',
        'string'  => 'O campo :attribute não pode ser maior que :max caracteres.',
        'array'   => 'O campo :attribute não pode ter mais que :max itens.',
    ],
    'mimes'                => 'Formato de arquivo não permitido.',
    'mimetypes'            => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
        'file'    => 'O campo :attribute deve ter ao menos :min kilobytes.',
        'string'  => 'O campo :attribute deve ter ao menos :min caracteres.',
        'array'   => 'O campo :attribute deve ter ao menos :min itens.',
    ],
    'not_in'               => 'O campo selecionado :attribute é inválido.',
    'numeric'              => 'O campo :attribute ´deve ser um número.',
    'present'              => 'O campo :attribute deve estar presente.',
    'regex'                => 'O campo :attribute tem formáto inválido.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless'      => 'O campo :attribute é obrigatório a menos que :other seja :values.',
    'required_with'        => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_without'     => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum :values está presente.',
    'same'                 => 'O campo :attribute e :other devem bater.',
    'size'                 => [
        'numeric' => 'O campo :attribute deve ter :size.',
        'file'    => 'O campo :attribute deve ter :size kilobytes.',
        'string'  => 'O campo :attribute deve ter :size caracteres.',
        'array'   => 'O campo :attribute deve conter :size itens.',
    ],
    'string'               => 'O campo :attribute deve ser uma sentença (string).',
    'timezone'             => 'O campo :attribute deve ser uma zona válida.',
    'unique'               => 'Este :attribute já foi utilizado.',
    'uploaded'             => 'O upload do campo :attribute falhou.',
    'url'                  => 'O campo :attribute está em formato inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',

        ],

    ],
    'cpf' => 'O CPF informado não é válido.',
    'cnpj' => 'O CNPJ informado não é válido.',
    'user_status' => 'O Status informado não é válido.',
    'br_states' =>  'O estado informado não é válido.',
    'category_type' => 'O tipo de categoria não é válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    'db_name' => 'nome do banco',
    'db_user' => 'usuário do banco',
    'db_password' => 'senha do usuário',
    'first_name' => 'nome',
    'last_name' => 'sobrenome',
    'cpf' => 'CPF',
    'profile' => 'perfil',
    'phone_1' => 'Telefone 1',
    'phone_2' => 'Telefone 2',
    'password' => 'senha',
    'password_confirmation' => 'confirmação de senha',
    'install_status' => 'status da instalação',
    'system_name' => 'nome do sistema',
    'admin_mail' => 'e-mail do administrador',
    'name' => 'nome',
    'alias' => 'nome fantasia',
    'newFolder' => 'nome da pasta',
    'type' => 'tipo',
    'color' => 'cor'

    ],

];
