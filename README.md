# BusMan - Lite#  (Não estável)

Solução open source para gerenciamento de receitas e despensas. Ideal para uso pessoal e em pequenas empresas. Uso individual.

Caso deseje customização, melhora no desenpenho, layout ou mais funções, entre em contato como [desenvolvedor](https://albasolucoes.com).

### Requisitos ###

* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

### Instalação ###

* Clone e instale as dependências com composer
```
    git clone https://github.com/albasolucoes/busman.git

    composer install
```

* Copie o arquivo *.env.example* com o nome *.env*
```
    copy .env.example .env
```
* No arquivo *.env* criado, edite as informações de acesso ao banco de dados e servidor de e-mail(opcional), assim como qualquer outra informação pertinente à sua hospedagem.

![Configurando acesso ao banco](/db_config.png)

* Crie uma nova chave para a aplicação

```
    php artisan key:generate

```

* Siga com os comandos abaixo para criar as tabelas e os dados básicos

```
    php artisan migrate

    php artisan db:seed
```

* Entre com usuário e senha de administrador padrão:

```
    E-mail: admin@admin.com
    Senha:  busman.123
```

* Após o primeiro acesso, você pode editar as credenciais ou criar novo acesso no genrenciador de usuários, disponível no menu lateral.

>Todos os usuários criados terão o mesmo acesso a todas as informações.
>Qualquer usuário pode ser eliminado ou editado, contando que haja ao menos 1 ativo.

![Editar Usuários](/user_nenu.png)

* Enjoy :satisfied:

### Manual de Usuário ###

* *[Em construção]*

### Recursos utilizados ###

* [Laravel 5.3](https://github.com/laravel/laravel)
* [Admin LTE Template](https://github.com/almasaeed2010/AdminLTE/)

### Com quem falar ###

* Para contratação de serviços: [contato@albasolucoes.com](mailto:contato@albasolucoes.com)
* Para reportar um erro: Abra um [Issue](https://github.com/albasolucoes/busman/issues)
* Site do desenvolvedor: [Alba Soluções Web](https://albasolucoes.com)