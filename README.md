# Faro Animal

![PHP](https://custom-icon-badges.demolab.com/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![CodeIgniter](https://custom-icon-badges.demolab.com/badge/CodeIgniter-4-DD4814?logo=codeigniter&logoColor=white)
![Status](https://custom-icon-badges.demolab.com/badge/status-active-success)
![Environment](https://custom-icon-badges.demolab.com/badge/environment-development-blue)

Sistema web desenvolvido para o Trabalho Final da disciplina de Desenvolvimento Web II.

O Faro Animal é um sistema para gerenciamento de uma clínica veterinária!

---

## Sumário

- [Requisitos](#requisitos)
- [Sobre o sistema](#sobre-o-sistema)
- [Tecnologias](#tecnologias)
- [Instalação](#instalação)
- [Configuração do ambiente](#configuração-do-ambiente)
- [Banco de dados](#banco-de-dados)
- [Executando o projeto](#executando-o-projeto)

---

## Requisitos

- **Requisito 01:** A aplicação deverá ser desenvolvida utilizando HTML, CSS, JavaScript e PHP, com utilização do framwork CodeIgniter 4.
- **Requisito 02:** O sistema deverá seguir uma arquitetura em camadas utilizando o padrão MCV (Model-View-Controller), com utilização de classes de serviço (Services) para centralização das regras de negócio.
- **Requisito 03:** As views da aplicação deverão ser organizadas utilizando o conceito de layouts do CodeIgniter, promovendo reutilização de estruturas visuais e padronização das páginas do sistema.
- **Requisito 04:**  Deverá ser utilizado pelo menos um framework front-end, como o Bootstrap, para auxiliar na construção da interface gráfica do sistema.
- **Requisito 05:** A interface do sistema deverá seguir boas práticas de usabilidade, priorizando clareza visual, organização dos elementos, legibilidade, padronização de navegação e facilidade de utilização por parte do usuário.
- **Requisito 06:** O sistema deverá possuir, no mínimo, duas páginas públicas acessíveis sem autenticação, sendo obrigatoriamente uma página principal e uma página de login.
- **Requisito 07:** O sistema deverá possuir uma área restrita acessível apenas após a autenticação do usuário.
- **Requisito 08:** Na área restrita, deverão ser implementadas pelo menos duas operações de CRUD (cadastro, consulta, alteração e exclusão de dados).
- **Requisito 09:** Pelo menos uma das operações de CRUD deverá envolver duas tabelas relacionadas em um relacionamento do tipo 1:N.
- **Requisito 10:** Em pelo menos uma das telas relacionadas às operações de CRUD, deverá existir uma funcionalidade de exportação dos dados em formato PDF.
- **Requisito 11:** O sistema deverá possuir controle de sessão, contemplando funcionalidades de login, logout e recuperação de senha por meio do envio de e-mail para oendereço previamente cadastrado pelo usuário.
- **Requisito 12:** A aplicação deverá conter pelo menos uma funcionalidade utilizando requisições Ajax ou integração com alguma API externa.
- **Requisito 13:** Os formulários da aplicação deverão utilizar mecanismos de proteção contra ataques do tipo CSRF (Cross-Site Request Forgery), por meio da utilização de tokens CSRF.
- **Requisito 14:** O sistema deverá possuir páginas de erro personalizadas para tratamento de exceções e situações de navegação inválida, incluindo pelo menos uma interface personalizada para erro “Page Not Found” (404).

> A entrega deverá incluir o código-fonte completo do sistema, o banco de dados utilizado e um relatório descrevendo as principais funcionalidades implementadas. Nesse relatório, o grupo deverá explicar de forma clara como cada requisito solicitado foi atendido, indicando também quais funcionalidades não foram concluídas, as limitações encontradas durante o desenvolvimento e as principais dificuldades enfrentadas pela equipe ao longo da realização do projeto.

---

## Sobre o sistema



---

## Tecnologias

- [PHP 8.2+](https://www.php.net/)
- [CodeIgniter 4](https://codeigniter.com/user_guide/index.html)
- [MySQL](https://www.mysql.com/)
- [Composer](https://getcomposer.org/download/)
- [Bootstrap](https://getbootstrap.com/)

---

## Instalação

### Composer

Nesse projeto utilizamos o **Composer** para gerenciar os pacotes do **CodeIgniter 4**.

#### 1. Ative as extensões do PHP

No arquivo `php.ini`, habilite as extensões abaixo removendo o `;` do início da linha:

- zip
- intl
- mysqli
- mbstring

#### 2. Clone o repositório

```bash
git clone https://github.com/soutbiaafnts/faro-animal
```

#### 3. Acesse a pasta do projeto

```bash
cd faro-animal
```

#### 4. Instale as dependências

```bash
composer install
```

---

## Configuração do Ambiente

### Dotenv

O CodeIgniter espera um arquivo `.env` na raiz do projeto e já fornece um template padrão.

#### 1. Crie uma cópia do arquivo

```text
env
```

#### 2. Renomeie a cópia para

```text
.env
```

#### 3. Configure os atributos abaixo

```env
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'
```

Configure também os atributos da sessão `DATABASE`:

```env
database.default.hostname = localhost
database.default.database = faro_animal
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

---

## Banco de Dados

Execute o arquivo `farol_animal.sql` que se encontra em `public/assets/farol_animal.sql`.

---

## Executando o Projeto

#### 1. Inicie o servidor local do CodeIgniter

```bash
php spark serve
```

O projeto estará disponível em:

```text
http://localhost:8080
```

---
