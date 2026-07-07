# Faro Animal

![PHP](https://custom-icon-badges.demolab.com/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![CodeIgniter](https://custom-icon-badges.demolab.com/badge/CodeIgniter-4.7.3-DD4814?logo=codeigniter&logoColor=white)
![MySQL](https://custom-icon-badges.demolab.com/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://custom-icon-badges.demolab.com/badge/Bootstrap-5.3-7952B3?logo=bootstrap&logoColor=white)
![Status](https://custom-icon-badges.demolab.com/badge/status-active-success)
![Environment](https://custom-icon-badges.demolab.com/badge/environment-development-blue)

O **Faro Animal** é um sistema web desenvolvido para auxiliar o gerenciamento interno de uma clínica veterinária.

A aplicação permite que veterinários autenticados realizem o cadastro e gerenciamento de espécies, raças e pets, organizem consultas veterinárias e mantenham um histórico básico de atendimentos, com emissão de fichas de consulta em PDF.

O sistema foi desenvolvido utilizando o framework **CodeIgniter 4** e segue a arquitetura **MVC** (Model-View-Controller), com utilização de **Services** para centralização das regras de negócio.

> Projeto acadêmico desenvolvido para a disciplina de Desenvolvimento Web II (DEW-II).

---

## Sumário

- [Requisitos do trabalho](#requisitos-do-trabalho)
- [Funcionalidades](#funcionalidades)
- [Segurança](#segurança)
- [Arquitetura](#arquitetura)
- [Estrutura de pastas](#estrutura-de-pastas)
- [Fluxo de Funcionamento](#fluxo-de-funcionamento)
- [Tecnologias](#tecnologias)
- [Instalação](#instalação)
- [Configuração do Ambiente](#configuração-do-ambiente)
- [Banco de Dados](#banco-de-dados)
- [Executando o Projeto](#executando-o-projeto)
- [Limitações e trabalhos futuros](#limitações-e-trabalhos-futuros)
- [Entrega do trabalho](#entrega-do-trabalho)
- [Autoras](#autoras)

---

## Requisitos do trabalho

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
- **Requisito 11:** O sistema deverá possuir controle de sessão, contemplando funcionalidades de login, logout e recuperação de senha por meio do envio de e-mail para o endereço previamente cadastrado pelo usuário.
- **Requisito 12:** A aplicação deverá conter pelo menos uma funcionalidade utilizando requisições Ajax ou integração com alguma API externa.
- **Requisito 13:** Os formulários da aplicação deverão utilizar mecanismos de proteção contra ataques do tipo CSRF (Cross-Site Request Forgery), por meio da utilização de tokens CSRF.
- **Requisito 14:** O sistema deverá possuir páginas de erro personalizadas para tratamento de exceções e situações de navegação inválida, incluindo pelo menos uma interface personalizada para erro "Page Not Found" (404).

> A entrega deverá incluir o código-fonte completo do sistema, o banco de dados utilizado, um relatório e um vídeo de apresentação, ambos explicando como cada requisito foi atendido e quais não foram, indicando as limitações encontradas e as principais dificuldades enfrentadas pela equipe.

Um relatório detalhado, com prints e texto explicando como cada requisito acima foi atendido no código, está disponível em [`docs/relatorio-faro-animal.pdf`](docs/relatorio-faro-animal.pdf). O roteiro utilizado para a gravação do vídeo de apresentação está em [`docs/roteiro-video-faro-animal.md`](docs/roteiro-video-faro-animal.md).

---

## Funcionalidades

- Cadastro, login, logout e exclusão de conta de usuários (veterinários);
- Recuperação de senha por e-mail, com token de redefinição válido por 5 minutos;
- Cadastro e gerenciamento (CRUD) de **espécies**;
- Cadastro e gerenciamento (CRUD) de **raças**, vinculadas a uma espécie (relacionamento 1:N);
- Cadastro e gerenciamento (CRUD) de **pets**, vinculados a uma raça;
- Cadastro e gerenciamento (CRUD) de **consultas veterinárias**, vinculadas a um pet e a um veterinário;
- Carregamento dinâmico das raças de acordo com a espécie selecionada, via requisição **AJAX**;
- Exportação da ficha de uma consulta em **PDF** (utilizando Dompdf);
- Listagens com busca e paginação no lado do cliente (Bootstrap Table);
- Proteção **CSRF** em todos os formulários de escrita (criação, edição e exclusão);
- Filtro de autenticação para toda a área restrita, com mensagem de aviso ao tentar acessar sem login;
- Proteção contra **XSS** em formulários e listagens;
- Página de erro **404** personalizada.

---

## Segurança

Além dos mecanismos exigidos pelo roteiro do trabalho (CSRF e área restrita autenticada), o sistema conta com as seguintes proteções:

- **CSRF:** todas as rotas de escrita (`POST`/`DELETE`) exigem o filtro `csrf`, e os formulários incluem o token gerado por `csrf_field()`.
- **Autenticação:** o `AuthFilter` bloqueia o acesso a toda a área restrita para usuários não logados, redirecionando para o login com uma mensagem de aviso (`"Faça login para acessar esta página."`) exibida corretamente na tela.
- **Senhas:** armazenadas com hash via `password_hash`, nunca em texto puro.
- **XSS:** todos os dados vindos do usuário e exibidos de volta na tela — nos formulários (via `old()`) e nas listagens (espécies, raças, pets e consultas) — passam pela função `esc()` do CodeIgniter antes de serem impressos, evitando a execução de scripts injetados em campos de texto livre como anotações, diagnóstico e prescrição.
- **Token de redefinição de senha:** gerado aleatoriamente (`random_bytes`) e válido por apenas 5 minutos.

---

## Arquitetura

O projeto segue a arquitetura **MVC** oferecida pelo CodeIgniter 4, acrescida de uma camada de **Services**:

| Camada | Responsabilidade | Exemplos |
|---|---|---|
| **Model** | Comunicação com o banco de dados, campos permitidos, timestamps e soft delete | `PetModel`, `BreedModel`, `AppointmentModel` |
| **Service** | Regras de negócio, validações e centralização das respostas | `PetService`, `BreedService`, `AuthService` |
| **Controller** | Recebe as requisições HTTP e delega ao Service correspondente | `PetController`, `AuthController` |
| **View** | Exibição das informações, organizada em layouts e partials | `layouts/main.php`, `partials/navbar.php` |
| **Filter** | Interceptação de requisições antes/depois dos Controllers | `AuthFilter` (protege a área restrita) |

Todos os métodos das classes de Service retornam um array padronizado (`success`, `message`, `data`, `invalidArgs`, `errors`), o que uniformiza o tratamento de sucesso, validação e exceções em todos os Controllers.

---

## Estrutura de pastas

```text
faro-animal/
├── app/
│   ├── Config/
│   │   ├── Filters.php             # registro do filtro "auth"
│   │   ├── Routes.php              # rotas públicas e da área restrita
│   │   └── Services.php            # registro das classes de Service
│   ├── Controllers/                # AppointmentController, PetController, ...
│   ├── Filters/
│   │   └── AuthFilter.php          # proteção da área restrita
│   ├── Libraries/
│   │   └── Mail.php                # envio de e-mails (recuperação de senha)
│   ├── Models/                     # AppointmentModel, PetModel, ...
│   ├── Services/                   # regras de negócio (AppointmentService, ...)
│   └── Views/
│       ├── layouts/main.php
│       ├── partials/navbar.php, footer.php
│       ├── emails/reset.php
│       ├── errors/custom404.php
│       └── species/, breeds/, pets/, appointments/, users/
├── docs/
│   ├── relatorio-faro-animal.pdf
│   └── roteiro-video-faro-animal.md
└── public/
    └── assets/
        ├── css/style.css
        ├── img/
        └── sql/ faro_animal.sql    # script de criação do banco
```

---

## Fluxo de Funcionamento

> Página inicial → Cadastro de Usuário → Login → Área restrita → Cadastro de espécies → Cadastro de raças → Cadastro de Pets → Agendamento de consultas → Acompanhamento e histórico → Exportação em PDF

### Cadastro de Pets

Ao cadastrar um animal, o usuário seleciona uma espécie. Em seguida, o sistema realiza uma requisição AJAX (`GET /breeds/specie/{id}`) para carregar automaticamente, sem recarregar a página, as raças relacionadas à espécie selecionada.

### Consultas Veterinárias

Cada consulta é vinculada a um pet previamente cadastrado e ao veterinário autenticado no momento do cadastro. Durante o atendimento, o veterinário pode registrar informações como motivo da consulta, diagnóstico, prescrição e observações.

### Relatórios

A ficha de uma consulta pode ser exportada em formato PDF para impressão ou armazenamento digital, a partir da própria listagem de consultas.

---

## Tecnologias

- [PHP 8.2+](https://www.php.net/)
- [CodeIgniter 4](https://codeigniter.com/user_guide/index.html)
- [MySQL](https://www.mysql.com/)
- [Composer](https://getcomposer.org/download/)
- [Bootstrap 5](https://getbootstrap.com/) + [Bootstrap Icons](https://icons.getbootstrap.com/) + [Bootstrap Table](https://bootstrap-table.com/)
- [Dompdf](https://github.com/dompdf/dompdf) — geração das fichas de consulta em PDF
- [jQuery](https://jquery.com/) — dependência do Bootstrap Table
- Serviço de e-mail nativo do CodeIgniter (SMTP) — recuperação de senha
- [Mailtrap](https://mailtrap.io/) - plataforma de entrega de e-mails projetada para desenvolvedores testarem e enviarem mensagens de forma segura.

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

O CodeIgniter espera um arquivo `.env` na raiz do projeto. O repositório já traz um arquivo de exemplo chamado `_env`, que deve ser copiado e renomeado.

#### 1. Copie o arquivo de exemplo

```bash
cp env .env
```

#### 2. Configure o ambiente e a URL base

```env
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'
```

#### 3. Configure a conexão com o banco de dados

```env
database.default.hostname = localhost
database.default.database = faro_animal
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

#### 4. Configure o envio de e-mails (recuperação de senha)

A funcionalidade de recuperação de senha (Requisito 11) depende de um servidor SMTP configurado nas variáveis abaixo, utilizadas pela classe `App\Libraries\Mail`:

```env
EMAIL_HOST = smtp.exemplo.com
EMAIL_USER = seu-email@exemplo.com
EMAIL_PASS = sua-senha-ou-senha-de-app
EMAIL_PORT = 587
```

> Sem essas variáveis configuradas corretamente, o envio do link de redefinição de senha falhará, embora o restante do sistema continue funcionando normalmente.

---

## Banco de Dados

Execute o arquivo `faro_animal.sql`, que se encontra em `public/assets/sql/faro_animal.sql`, no seu servidor MySQL para criar as tabelas necessárias (`users`, `species`, `breeds`, `pets` e `appointments`).

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

#### 2. Crie o primeiro usuário

Acesse `http://localhost:8080/register` para cadastrar o primeiro veterinário e, em seguida, faça login em `http://localhost:8080/login` para acessar a área restrita.

---

## Limitações e trabalhos futuros

Conforme detalhado no relatório, alguns pontos ficaram fora do escopo desta versão do sistema:

- O uso de AJAX ficou concentrado no carregamento de raças por espécie; outras listagens ainda dependem de recarregamento de página.
- Não há um painel (dashboard) com indicadores gerais da clínica.
- O cadastro de pets não permite o envio de fotos do animal.
- Não há diferenciação de papéis de usuário — todo veterinário autenticado possui as mesmas permissões.
- A paginação e a busca nas listagens são feitas no lado do cliente (Bootstrap Table), não no servidor.
- Não foram implementados testes automatizados.

---

## Entrega do trabalho

Conforme solicitado, a entrega deste trabalho é composta por:

1. **Código-fonte** completo do sistema (este repositório);
2. **Script do banco de dados** — `public/assets/sql/faro_animal.sql`;
3. **Relatório** — `docs/relatorio-faro-animal.pdf`;
4. **Vídeo de apresentação** (gravação de tela, 1080p a 60 FPS, com o compartilhamento de tela visível) — link a ser incluído aqui: `[link do vídeo]`.

---

## Autoras

Desenvolvido por **Bianca** e **Wanessa** — Disciplina de Desenvolvimento Web II (DEW-II), 2026.
