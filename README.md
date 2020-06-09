# 🚀 challenge-KaBuM-php

Fala galera! 😄

Usei para desenvolver este projeto:

⭐ Backend com PHP 7+ sem frameworks, porém fiz um "mini" framework.

⭐ Para o frontend desenvolvi scripts com Vanilla (Javascript puro \ ES 6+) usando tudo separado por "modulos".

## 🎨 Styles

Nos styles, resolvi desenvolver um mini Design System, utilizando o BEM (Block Element Modificator) + IT (inverted triangle) para flexibilidade e reutilização de classes.

## 📦 Components

A organização dos components estariam melhor se fossem feitos para um SPA, como Angular ou React. Como o teste dizia para fazer com PHP puro, fiz tudo puro 😇

## 📁 Módulos javascript desenvolvidos

| Nome do arquivo | Descrição                                                                                                    |
| --------------- | ------------------------------------------------------------------------------------------------------------ |
| cep.js          | Módulo para busca de CEPs no ViaCEP.                                                                         |
| form-submit.js  | Módulo para feedback visual relacionado a cadastros.                                                         |
| request.js      | Facilitar a padronização de envio de requests no frontend usando o proprio Fetch.                            |
| mask.js         | Módulo para aplicar máscaras em campos.                                                                      |
| remove-modal.js | Módulo para utilizando sweetalert, para aplicar o modal de confirmação de exclusão.                          |
| ready.js        | Módulo para aguardar a página ter seu carregamento completo para começar a aplicar scripts.                  |
| debounce.js     | Módulo para facilitar o uso do conceito de debounce time, para não enviar multiplos requests sem necessidade |

## 🚲 Rotas

| Rota                    | Methods | Descrição                                     |
| ----------------------- | ------- | --------------------------------------------- |
| /api/clients            | GET     | Lista todos clientes cadastrados              |
| /api/clients/insert     | POST    | Adiciona um novo cliente                      |
| /api/clients/update/:id | POST    | Atualiza dados de um usuário                  |
| /api/clients/:id        | DELETE  | Remove um cliente                             |
| /api/address            | GET     | Lista todos endereços de clientes cadastrados |
| /api/address/insert     | POST    | Adiciona um novo endereço                     |
| /api/address/update/:id | POST    | Atualiza dados de um endereço                 |
| /api/address/:id        | DELETE  | Remove um endereço                            |

## 🐳 Run with Docker

```bash
$ docker-compose up
```

```
Basta acessar a url:
http://localhost

Caso necessário, mude a porta de exposição no docker-compose.yml, especificamente no container do apache.
```

## 🆗 Rodar sem o docker

As configurações do banco de dados estão utilizando variáveis de ambiente, basta adicionar as variáveis de ambiente:

| Variavel            | Valor padrão |
| ------------------- | ------------ |
| MYSQL_USER          | root         |
| MYSQL_PASSWORD      | root         |
| MYSQL_DATABASE      | kabum        |
| MYSQL_ROOT_PASSWORD | root         |
| PMA_HOST            | database     |

`PMA_HOST` é o endereço do banco de dados utilizado pelo PhpMyAdmin rodado no docker.

Será necessário criar um database, com o mesmo nome do `MYSQL_DATABASE` e importar os dados contidos em `dockerfiles/mysql/setup.sql` para a mesma.

## Rodar utilizando BrowserSync

Instale os pacotes necessários

```bash
$ yarn install
```

Rode `$ yarn watch`

## Realizar build do bundle pack (.js/.scss)

Instale os pacotes necessários

```bash
$ yarn install
```

Rode `$ yarn build`

## 🔒 Login

Login e senha criados automáticamente ao identificar uma base de dados vazia, apenas para fins de testes.

```
user: admin
pass: admin
```

## 🔒 PhpMyAdmin

Usado para gerenciamento do MySql

```
http://localhost:8080

user: root
pass: root
```

##
