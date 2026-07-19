# Regras e Diretrizes para Extensões phpBB

Este documento serve como um guia essencial e compilação de regras que devem ser seguidas ao desenvolver, atualizar e manter extensões para o phpBB.

## 1. Nomenclatura e Políticas de Extensão (Vendor / Ext)
- **Caracteres Permitidos:** Apenas são permitidos caracteres alfanuméricos em letras minúsculas para o `vendor` (autor) e `ext` (nome da extensão). Exemplo: `vendor/ext`.
- **Validação no CDB (Customisation Database):** 
  - **Novas extensões:** Submissões que utilizem qualquer coisa diferente de caracteres alfanuméricos minúsculos serão imediatamente rejeitadas.
  - **Extensões existentes:** Se a sua extensão já estiver aprovada na base de dados com caracteres inválidos (ex: `Vendor/Ext`), pode continuar a submeter novas atualizações, contudo, **NÃO PODE alterar** o nome do `vendor` ou da extensão sob qualquer pretexto nesta mesma contribuição.
- **Transição para phpBB 4.0:** 
  - O phpBB 4.0 exigirá o uso **exclusivo** de caracteres alfanuméricos em letras minúsculas. 
  - **Não será possível** migrar de um nome como `Vendor/Ext` para `vendor/ext`.
  - Será obrigatório criar uma nova contribuição (do zero) no CDB para as extensões compatíveis com phpBB 4.0. Não será permitida a migração de dados de extensões com a nomenclatura antiga para a nova.

## 2. Documentação Oficial e Ferramentas
- A documentação oficial de desenvolvimento para phpBB está agora centralizada em: [phpBB Extension Development Documentation](https://area51.phpbb.com/docs/dev/3.3.x/extensions/index.html).
- **Ferramentas e IDEs Recomendados:**
  - **IDEs:** VS Code, Geany, Notepad++, Atom, PhpStorm.
  - **Ambiente Local:** XAMPP, WAMP, MAMP, Docker, Vagrant, PHP development server.
  - **Controlo de Versões:** Git, GitHub Desktop, SmartGit, SourceTree.
  - **Ferramentas de Extensão Específicas:** [Reenable extensions](https://github.com/lavigor/reenable), Debug Tools Extension, Web Profiler Extension.

## 3. Templates e Conversão para Sintaxe Twig (phpBB 3.2+)
O uso da sintaxe antiga do phpBB é desencorajado. A transição para Twig é exigida e preferencial pelas razões de facilidade, segurança, e futuro do estilo core do phpBB.

### Exemplos de Conversão:
- **Variáveis:**
  - phpBB: `{FOO_BAR}`
  - Twig: `{{ FOO_BAR }}`
- **Chaves de Idioma (Language Keys):**
  - phpBB: `{L_FOO_BAR}`
  - Twig: `{{ lang('FOO_BAR') }}`
  - phpBB (Escapado para JS): `{LA_FOO_BAR}`
  - Twig (Escapado para JS): `{{ lang('FOO_BAR')|e('js') }}` ou `{{ lang('FOO_BAR')|addslashes }}`
- **Lógica e Condições:**
  - phpBB: `<!-- IF S_FOO -->...<!-- ELSE -->...<!-- ENDIF -->`
  - Twig: `{% if S_FOO %}...{% else %}...{% endif %}`
- **Ciclos (Loops):**
  - phpBB: `<!-- BEGIN users -->{users.VALUE}<!-- END users -->`
  - Twig (phpBB 3.1): `{% for user in loops.users %}{{ user.VALUE }}{% endfor %}`
  - Twig (phpBB 3.2+): O prefixo `loops.` deixou de ser obrigatório: `{% for user in users %}{{ user.VALUE }}{% endfor %}`
- **Inclusões (Includes):**
  - phpBB: `<!-- INCLUDE overall_header.html -->`
  - Twig: `{% include 'overall_header.html' %}`
  - CSS / JS (Use sempre o sufixo do vendor/extensão):
    - Twig: `{% INCLUDECSS '@Vendor_Ext/style.css' %}`
    - Twig: `{% INCLUDEJS '@Vendor_Ext/script.js' %}`
- **Eventos de Template:**
  - phpBB: `<!-- EVENT foo_location -->`
  - Twig: `{% EVENT foo_location %}`
- **Comentários:**
  - phpBB: `<!-- Comentário -->`
  - Twig: `{# Comentário #}`

> [!CAUTION]
> **Atenção aos Caminhos de Ficheiros no Twig:** Começando com o Twig do phpBB 3.3.9, tentar incluir ficheiros fora da estrutura correta sem usar o namespace da extensão causará erros fatais. Utilize sempre o prefixo com a "arrobaz" associada à extensão. Ex: `@Vendor_ExtName/foobar.css`.

## 4. Atualizações de Compatibilidade (Upgrade Notes) para phpBB 3.2+

- **Serviços (services.yml):** 
  - Variáveis que chamam serviços (prefixadas com `@` e `%`) têm de ser colocadas entre aspas simples: ex: `'- @dbal.conn'`.
  - A scope "prototype" está descontinuada. Se usava `scope: prototype`, substitua por `shared: false`.
- **Classe de Language (PHP):** O idioma foi desvinculado do objeto do utilizador. O `$user->lang` e o `$user->add_lang_ext()` estão obsoletos. 
  - Utilize `$language->add_lang('ficheiro', 'vendor/ext')` e `$language->lang('CHAVE')`.
- **Classe Notificações (PHP):** Os métodos `find_users_for_notification` e `create_insert_array` sofreram alterações nos seus parentes/construtores de base. 
- **BBCode Engine:** O sistema mudou e passou a ser gerido via `s9e/textformatter`. Adicione reparsers (re-analisadores) sempre que seja necessário tratar BBCodes já guardados na BD da extensão.
- **Ícones Font Awesome:** O phpBB abandonou imagens de botões estáticos por base para usar classes do Font Awesome. Se a sua extensão contiver imagens hardcoded, converta para `<i class="icon fa-..."></i>`.

## 5. Como criar Pull Requests (PR) de Eventos para o Core

Se precisar de introduzir um Evento (Core ou Template) no código do próprio phpBB:
1. **Registar e bifurcar (fork):** Crie uma conta no GitHub e faça fork ao repositório oficial do phpBB.
2. **Criar Bilhete (Ticket):** Vá ao [phpBB Bug Tracker](https://tracker.phpbb.com/) e crie um ticket "Improvement", na componente "Events", listando as versões e a razão de precisar daquele evento. Guarde o ID criado (ex: `PHPBB3-13537`).
3. **Branch Local:** No seu clone local faça `git checkout 3.1.x` (ou a branch principal em questão) e crie uma nova branch associada ao ticket: `git checkout -b ticket/13537`.
4. **Programar o Evento:** Crie o evento nos ficheiros do phpBB com o docblock de acordo com as regras (`@since VERSION`, definição exata de variáveis exportadas, etc).
5. **Commit:** A mensagem de commit tem regras estritas:
   - **Título:** `[ticket/13537] Add core events on ...` (máximo 79 caracteres).
   - *[Linha em branco]*
   - **Descrição detalhada:** (máximo 79 caracteres por linha).
   - *[Linha em branco]*
   - **Tag do Bilhete:** `PHPBB3-13537`.
6. **PR e Patch:** Empurre (push) a branch, abra o Pull Request no repositório oficial do phpBB no Github, e ligue/comente no seu bilhete do Tracker com o link para a sua PR para a colocarem como "Awaiting Patch Review".

## 6. Testes Automatizados (GitHub Actions / CI)
As extensões devem validar a sua construção através da Integração Contínua (CI).
Para tal, o método obsoleto no Travis-CI e os antigos ficheiros estáticos `.github/workflows/tests.yml` deixaram de ser a norma.
Atualmente as validações em ambientes PHP/phpBB/Sniffer são efetuadas de forma centralizada.
Consulte a diretriz framework para o setup simplificado em: [https://github.com/phpbb-extensions/test-framework](https://github.com/phpbb-extensions/test-framework).
