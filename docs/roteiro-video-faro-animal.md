# Roteiro — Vídeo de Apresentação do Faro Animal

Duração estimada total: **12 a 15 minutos**. Os tempos abaixo são um guia, não uma regra rígida — o importante é mostrar cada requisito com clareza.

---

## Antes de gravar (checklist técnico)

- [ ] Gravação de tela configurada em **1080p, 60 FPS** (conforme pedido pelo professor).
- [ ] Janela do navegador **maximizada**, sem abas/favoritos sensíveis visíveis.
- [ ] Ativar o **destaque de cliques do mouse** (ou aumentar o cursor), se o software de gravação permitir — ajuda quem assiste a acompanhar onde você está clicando.
- [ ] Confirmar que a **barra de tarefas / compartilhamento de tela está visível** durante toda a gravação, como pedido pelo professor.
- [ ] Banco de dados local rodando, com script `faro_animal.sql` já importado.
- [ ] Servidor local rodando (`php spark serve`) **antes** de começar a gravar.
- [ ] Ter pelo menos: 1 usuário cadastrado, 1 espécie, 1 raça, 1 pet e 1 consulta já cadastrados de antemão (evita gravar cadastros repetidos de dados óbvios — você pode mostrar o cadastro ao vivo de **um** deles e usar os outros já prontos para agilizar as demais telas).
- [ ] Ter o editor de código (VS Code ou similar) aberto em outra janela/aba, para alternar rapidamente entre navegador e código quando for explicar um requisito.
- [ ] Definir quem vai narrar (pode ser uma pessoa só narrando e mostrando a tela, mesmo sendo trabalho em dupla).
- [ ] Vídeo pode ser "não listado" no YouTube — não precisa ser público nem privado, só copiar o link para o envio do trabalho.

---

## 1. Abertura (0:00 – 0:40)

**Mostrar na tela:** página inicial do sistema (`/`).

**Falar:**
> "Boa tarde/noite, professor(a). Somos Bianca e Wanessa, e este vídeo apresenta o Faro Animal, um sistema de gerenciamento para clínica veterinária desenvolvido para a disciplina de Desenvolvimento Web II, utilizando o framework CodeIgniter 4. Vamos mostrar o funcionamento geral do sistema e, em seguida, como cada um dos 14 requisitos do trabalho foi atendido."

---

## 2. Visão geral do sistema (0:40 – 2:00)

**Mostrar na tela:** navegar pela home, rolar até a seção "Sobre o sistema" e "Funcionalidades".

**Falar:**
> "O sistema permite que veterinários cadastrem espécies, raças, pets e consultas, mantendo um histórico de atendimentos. Toda a aplicação segue a arquitetura MVC, com uma camada extra de Services para centralizar as regras de negócio — vamos ver isso em detalhe já já."

---

## 3. Requisito 01 — HTML, CSS, JS, PHP e CodeIgniter 4 (2:00 – 2:30)

**Mostrar na tela:** abrir o editor de código, mostrar rapidamente a estrutura de pastas `app/Controllers`, `app/Services`, `app/Models`, `app/Views`, e o `composer.json` com a versão do CodeIgniter.

**Falar:**
> "O projeto foi construído inteiramente em PHP, com o framework CodeIgniter 4, usando HTML, CSS e JavaScript nas views. Aqui vemos a estrutura padrão do framework: Controllers, Models, Views, e a nossa camada de Services."

---

## 4. Requisito 02 — Arquitetura MVC + Services (2:30 – 3:30)

**Mostrar na tela:** abrir um Controller (ex.: `PetController.php`) lado a lado com o Service correspondente (`PetService.php`).

**Falar:**
> "Aqui está um exemplo prático: o `PetController` não contém nenhuma regra de negócio — ele apenas recebe a requisição e chama o `PetService`, que é quem valida os dados, verifica duplicidade e conversa com o `PetModel`. Isso deixa o código organizado e fácil de manter. Todos os Services retornam um formato padronizado, com `success`, `message`, `data` e `invalidArgs`, o que uniformiza o tratamento de erros em toda a aplicação."

---

## 5. Requisito 03 — Layouts (3:30 – 4:00)

**Mostrar na tela:** abrir `layouts/main.php` e `partials/navbar.php`.

**Falar:**
> "Todas as páginas do sistema reutilizam o mesmo layout, definido em `layouts/main.php`, incluindo o menu superior e o rodapé como partials. Isso evita repetição de código e padroniza a aparência do sistema."

---

## 6. Requisito 04 — Framework front-end (4:00 – 4:20)

**Mostrar na tela:** qualquer tela do sistema, apontando para os componentes visuais (botões, tabelas, alertas).

**Falar:**
> "Para a interface, usamos o Bootstrap 5, junto com Bootstrap Icons e Bootstrap Table, o que nos deu componentes prontos como estes botões, tabelas paginadas e alertas de sucesso e erro."

---

## 7. Requisito 05 — Boas práticas de usabilidade (4:20 – 4:50)

**Mostrar na tela:** um formulário sendo preenchido incorretamente (ex.: e-mail inválido no login), mostrando a mensagem de erro em vermelho ao lado do campo.

**Falar:**
> "O sistema informa claramente os erros de validação, campo a campo, além de mensagens de sucesso após cada ação. Os menus são organizados por módulo — Espécies, Raças, Pets e Consultas — facilitando a navegação."

---

## 8. Requisito 06 — Páginas públicas (4:50 – 5:20)

**Mostrar na tela:** acessar `/` e `/login` sem estar autenticado (deslogado).

**Falar:**
> "O sistema tem mais de duas páginas públicas: a página inicial, a página de login, a de cadastro de novo veterinário e a de recuperação de senha, todas acessíveis sem login."

---

## 9. Requisito 07 — Área restrita (5:20 – 6:00)

**Mostrar na tela:** tentar acessar diretamente uma URL protegida (ex.: `/pets`) sem estar logado, e mostrar o redirecionamento automático para o login **com a mensagem de erro aparecendo** (a correção que vocês fizeram no `AuthFilter`).

**Falar:**
> "Se um usuário não autenticado tentar acessar qualquer página da área restrita, o filtro de autenticação — o `AuthFilter` — intercepta a requisição e redireciona para o login, exibindo esta mensagem."

---

## 10. Requisito 08 e 09 — CRUD e relacionamento 1:N (6:00 – 8:30)

**Mostrar na tela (em sequência, de forma ágil):**
1. Fazer login.
2. CRUD de **Espécies**: criar uma nova espécie, editar, mostrar a listagem.
3. CRUD de **Raças**: criar uma raça vinculada a uma espécie, mostrando o select de espécies.
4. CRUD de **Pets**: cadastrar um pet — aqui já aproveitar para mostrar o requisito 12 (ver próxima seção).
5. CRUD de **Consultas**: cadastrar uma consulta vinculada a um pet e ao veterinário logado.
6. Editar e excluir um registro de qualquer um dos módulos, para mostrar o CRUD completo.

**Falar:**
> "Temos quatro módulos completos de CRUD: Espécies, Raças, Pets e Consultas. Aqui vemos o relacionamento 1:N entre Espécies e Raças — uma espécie pode ter várias raças — e entre Pets e Consultas — um pet pode ter várias consultas. Esses relacionamentos aparecem, por exemplo, na tela de consultas, que combina dados do pet, do tutor e do veterinário responsável."

---

## 11. Requisito 12 — AJAX (integrado à seção anterior, 1:30 aprox.)

**Mostrar na tela:** no cadastro de pet, selecionar uma espécie e mostrar o campo de raças sendo preenchido **sem recarregar a página**. Abrir rapidamente as ferramentas de desenvolvedor do navegador (aba Network) para mostrar a requisição `GET /breeds/specie/{id}` sendo feita.

**Falar:**
> "Ao selecionar a espécie, o formulário dispara uma requisição AJAX para o servidor, que retorna em JSON apenas as raças daquela espécie, populando o campo dinamicamente, sem recarregar a página."

---

## 12. Requisito 10 — Exportação em PDF (8:30 – 9:15)

**Mostrar na tela:** na listagem de consultas, clicar no botão de impressão de uma consulta e mostrar o PDF gerado abrindo em uma nova aba.

**Falar:**
> "Cada consulta pode ser exportada em PDF, gerado com a biblioteca Dompdf, contendo os dados do pet, do tutor, do veterinário e as informações clínicas da consulta — motivo, diagnóstico, prescrição e anotações."

---

## 13. Requisito 11 — Login, logout e recuperação de senha (9:15 – 10:30)

**Mostrar na tela:**
1. Fazer logout.
2. Ir em "Esqueci a senha", digitar o e-mail cadastrado.
3. Mostrar o e-mail recebido (pode ser em uma caixa de e-mail de teste, ou mostrar o Mailtrap/log, se usarem algo assim).
4. Clicar no link do e-mail, definir uma nova senha.
5. Fazer login novamente com a nova senha.

**Falar:**
> "O sistema permite login e logout, além de recuperação de senha por e-mail. Ao solicitar a redefinição, um token é gerado com validade de apenas 5 minutos e enviado por e-mail. Após acessar o link e definir a nova senha, já conseguimos fazer login normalmente."

---

## 14. Requisito 13 — Proteção CSRF (10:30 – 11:00)

**Mostrar na tela:** abrir o "Inspecionar elemento" do navegador em qualquer formulário e apontar para o campo hidden do token CSRF.

**Falar:**
> "Todos os formulários de escrita — criação, edição e exclusão — possuem um token CSRF gerado pelo CodeIgniter, visível aqui como um campo oculto. As rotas correspondentes exigem esse filtro, garantindo que apenas requisições legítimas, originadas da própria aplicação, sejam aceitas."

---

## 15. Requisito 14 — Página de erro 404 personalizada (11:00 – 11:20)

**Mostrar na tela:** digitar uma URL inexistente (ex.: `/pagina-que-nao-existe`).

**Falar:**
> "E, caso o usuário acesse uma rota que não existe, o sistema exibe esta página de erro 404 personalizada, mantendo a identidade visual do sistema."

---

## 16. Extra — Proteção contra XSS (11:20 – 11:50)

**Mostrar na tela:** abrir uma view de listagem (ex.: `appointments/list.php`) apontando para o uso de `esc()` nos campos.

**Falar:**
> "Além dos requisitos pedidos, também implementamos proteção contra XSS, utilizando a função `esc()` do CodeIgniter para escapar todos os dados exibidos nas listagens e nos formulários, evitando que um usuário consiga injetar scripts maliciosos através de campos de texto livre, como anotações ou diagnóstico."

---

## 17. Encerramento — requisitos atendidos e limitações (11:50 – 13:00)

**Mostrar na tela:** pode voltar para a página inicial, ou ficar em tela neutra enquanto fala.

**Falar:**
> "Resumindo: os 14 requisitos do trabalho foram atendidos. Também vale destacar alguns pontos que ficaram como limitação ou não foram implementados: o uso de AJAX ficou concentrado nesse fluxo de raças por espécie, não há um painel de indicadores da clínica, o cadastro de pet não permite envio de foto, não há diferenciação de papéis entre usuários — todo veterinário tem as mesmas permissões — e a paginação das listagens é feita no lado do cliente, não no servidor. Essas melhorias ficam como sugestão de trabalho futuro."

> "Isso conclui a apresentação do Faro Animal. Obrigada!"

---

## Resumo de tempos (referência rápida)

| Bloco | Tempo aprox. |
|---|---|
| Abertura | 0:40 |
| Visão geral | 1:20 |
| Requisitos 1–5 | 2:30 |
| Requisitos 6–7 | 1:10 |
| Requisitos 8, 9 e 12 (CRUD + AJAX) | 4:00 |
| Requisito 10 (PDF) | 0:45 |
| Requisito 11 (login/recuperação) | 1:15 |
| Requisito 13 (CSRF) | 0:30 |
| Requisito 14 (404) | 0:20 |
| Extra (XSS) | 0:30 |
| Encerramento | 1:10 |
| **Total** | **~14:10** |

Se o vídeo ficar longo demais, os blocos mais fáceis de encurtar são o CRUD de Espécies e Raças (podem ser mostrados de forma mais rápida, já que Pets e Consultas cobrem o mesmo conceito com o relacionamento 1:N mais evidente).
