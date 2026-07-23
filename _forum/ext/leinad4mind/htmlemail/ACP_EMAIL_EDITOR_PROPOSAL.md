# Proposta de Melhoria: Gestor e Editor de Modelos de E-mail HTML no ACP

## 1. Visão Geral e Objetivos

Esta proposta detalha a especificação técnica e funcional para a implementação de um **Módulo de Administração (ACP)** na extensão `forumhulp/htmlemail` para phpBB 3.3+.

O objetivo principal é dotar os administradores do fórum de uma interface gráfica centralizada no ACP para:
1. **Mapear e Listar** todos os ficheiros de modelos de e-mail (`.txt`) presentes quer no **phpBB Core** (`language/{lang}/email/`), quer nas **Extensões instaladas** (`ext/{vendor}/{ext}/language/{lang}/email/`).
2. **Detetar e Classificar** automaticamente quais modelos já contêm código **HTML** e quais permanecem em **Texto Simples (Plain Text)**.
3. **Editar e Personalizar** o código HTML dos e-mails diretamente no ACP, eliminando a necessidade de editar manualmente ficheiros no servidor via FTP/SSH.
4. **Pré-visualizar em tempo real** a renderização do e-mail em HTML antes de guardar as alterações.

---

## 2. Funcionalidades Principais

### 2.1. Painel de Controlo & Lista de Modelos (Dashboard)
* **Tabela de Modelos de E-mail**:
  * **Nome do Ficheiro**: Ex: `topic_notify.txt`, `user_welcome.txt`, `privmsg_notify.txt`.
  * **Origem**: Distinção clara entre `phpBB Core` ou `Extensão` (ex: `sitesplat/newsletter`).
  * **Idioma**: Seletor/Filtro por idioma instalado (`pt`, `pt_preao`, `pt_br`, `en`, etc.).
  * **Estado de Formato**:
    * 🟢 **HTML**: O modelo já contém tags HTML (`<div>`, `<p>`, `<table>`, `<b>`, `<a href>`, etc.).
    * 🟡 **Texto Simples**: O modelo contém apenas texto sem formatação HTML.
  * **Ações**: Botões de `Editar`, `Pré-visualizar` e `Restaurar Original`.

### 2.2. Editor de Código de E-mail no ACP
* **Editor com Highlight de Sintaxe**: Integração de um editor leve (ex: CodeMirror) com realce de sintaxe HTML e suporte a marcadores/variáveis do phpBB (ex: `{USERNAME}`, `{U_TOPIC}`, `{SITENAME}`).
* **Painel de Variáveis Disponíveis**: Lista lateral ou tooltip com as variáveis dinâmicas disponíveis no modelo que está a ser editado.
* **Pré-visualização Interativa (Live Preview)**: Tab ou modal de pré-visualização que simula a visualização real do e-mail numa caixa de entrada (com suporte a *Desktop* e *Mobile*).
* **Gestão de Backups**: Criação automática de uma cópia de segurança (`.txt.bak`) antes da primeira edição para permitir a restauração ao estado original com 1 clique.

---

## 3. Arquitetura Técnica & Estrutura de Código

### 3.1. Novos Ficheiros e Componentes

```
forumhulp/htmlemail/
├── acp/
│   └── htmlemail_module.php           # Classe de registo do módulo no ACP
├── adm/
│   └── style/
│       ├── acp_htmlemail.html         # Template Twig da interface do ACP
│       └── acp_htmlemail.css          # Estilos para badges e editor
├── controller/
│   └── admin_controller.php           # Controller do ACP para manusear requisições
├── service/
│   ├── template_finder.php            # Scanner de modelos (.txt) no Core e Extensões
│   ├── html_detector.php              # Analisador sintático de tags HTML
│   └── template_editor.php            # Leitor/Gravador seguro de ficheiros no disco
├── config/
│   └── services.yml                   # Registo de serviços da extensão
└── migrations/
    └── v33x/
        └── m2_acp_module.php          # Migration para adicionar o módulo à tabela de ACP
```

### 3.2. Serviços Propostos

#### A. `template_finder` (Localizador de Modelos)
Percorre recursivamente:
- `phpbb_root_path + 'language/' + lang + '/email/'`
- `phpbb_root_path + 'ext/*/*/language/' + lang + '/email/'`

Retorna um array estruturado com o caminho absoluto, caminho relativo, nome do ficheiro, tipo de origem e idioma.

#### B. `html_detector` (Detetor de Formato HTML)
Utiliza uma expressão regular e validação sintática para verificar a presença de elementos HTML característicos:
```php
public function is_html(string $content): bool
{
    // Verifica a presença de tags HTML estruturais ou de formatação
    return (bool) preg_match('/<\s*(html|body|div|p|span|a|table|tr|td|b|i|strong|em|br|img|h[1-6])\b[^>]*>/i', $content);
}
```

#### C. `template_editor` (Gestor de Leitura/Escrita)
- **Segurança Traversal**: Valida o caminho do ficheiro usando `realpath()` para garantir que apenas ficheiros dentro das diretorias `/email/` autorizadas podem ser lidos ou gravados.
- **Escrita de Ficheiros**: Escreve o conteúdo atualizado com tratamento de permissões e codificação UTF-8 (sem BOM).

---

## 4. Segurança e Permissões

1. **Permissões ACP (`acl_a_board` / `acl_a_email`)**:
   * O acesso ao módulo exige permissões administrativas explícitas no ACP.
2. **Proteção contra Directory Traversal**:
   * Validação estrita de caminhos de ficheiro antes de efetuar operações de leitura ou gravação.
3. **Validação CSRF**:
   * Todos os formulários de gravação e reposição utilizam os tokens de formulário do phpBB (`add_form_key` e `check_form_key`).

---

## 5. Plano de Implementação por Fases

* **Fase 1: Scanner e Detetor HTML**
  * Desenvolver os serviços `template_finder` e `html_detector`.
  * Criar a migration `m2_acp_module.php` e a estrutura base do módulo no ACP.
* **Fase 2: Interface ACP e Listagem**
  * Desenvolver o template `acp_htmlemail.html` com filtros por idioma, origem (Core vs Extensão) e formato (HTML vs Plain Text).
* **Fase 3: Editor e Gravação**
  * Integrar o editor de texto no ACP com suporte a gravação segura e cópia de segurança (`.bak`).
* **Fase 4: Pré-visualização e Polimento**
  * Implementar a pré-visualização renderizada com substituição de variáveis de teste.

---
*Proposta elaborada para a extensão `forumhulp/htmlemail` no projeto `gold-phpbb-ext`.*


# Implementação: Gestor e Editor de E-mails HTML no ACP

Este plano descreve passo a passo como implementar a funcionalidade de gestão e edição de modelos de e-mail diretamente no painel de administração (ACP) do phpBB 3.3, para a extensão `forumhulp/htmlemail`.

## Estado da Implementação

> [!NOTE]
> **Concluído**
>
> Todas as fases do plano foram executadas com sucesso. A extensão tem agora o sistema de gestão completo, live preview e CodeMirror integrados no painel ACP.

## Alterações Implementadas

### 1. Registo e Configuração do Módulo ACP

#### [NEW] [m2_acp_module.php](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/migrations/v33x/m2_acp_module.php)
- Criada migração para adicionar o módulo à base de dados do phpBB, inserindo-o no painel ACP.
- Modificadores estáticos corrigidos (`public static`) de acordo com as diretrizes do phpBB.

#### [NEW] [info_acp_htmlemail.php](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/acp/htmlemail_info.php)
- Criado o ficheiro de informação do módulo (`acp/htmlemail_info.php`), definindo o nome, modos (ex: `overview`, `edit`) e permissões do módulo.

#### [NEW] [htmlemail_module.php](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/acp/htmlemail_module.php)
- Criada a classe principal do módulo (`acp/htmlemail_module.php`) que interliga a interface do ACP com os controladores da extensão.

### 2. Serviços de Leitura e Deteção (Services)

#### [MODIFY] [services.yml](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/config/services.yml)
- Registados os novos serviços: `template_finder`, `html_detector`, `template_editor`, e o próprio `admin_controller`.

#### [NEW] [template_finder.php](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/service/template_finder.php)
- Criado serviço PHP (com type hints Strict PHP 8+) para procurar recursivamente ficheiros `.txt` nos diretórios de idiomas.

#### [NEW] [html_detector.php](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/service/html_detector.php)
- Criado serviço estrito para ler os ficheiros e usar `preg_match` para detetar a presença de tags HTML.

#### [NEW] [template_editor.php](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/service/template_editor.php)
- Criado serviço responsável pela leitura segura, escrita de dados e proteção contra *Directory Traversal* via `realpath()`.

### 3. Controlador e Interface (Backend & Frontend)

#### [NEW] [admin_controller.php](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/controller/admin_controller.php)
- Lógica principal do backend do módulo ACP com cache em memória para prevenir leituras excessivas do disco.
- Tratamento de CSRF (`add_form_key` e `check_form_key`).

#### [NEW] [acp_htmlemail.html](file:///c:/Users/Leinad4Mind/Documents/GitHub/gold-phpbb-ext/_forum/ext/forumhulp/htmlemail/adm/style/acp_htmlemail.html)
- Template Twig do painel ACP.
- Contém a tabela de listagem de e-mails, filtros por idioma/origem, indicadores de estado (HTML vs Plain Text).
- Inclui CodeMirror (via CDN) com funcionalidade de **Pré-visualização Ao Vivo (Live Preview)** com suporte a Vista Dividida (Split View) e Ecrã Inteiro (Fullscreen). Escape Twig aplicado (`|e`).

### 4. Idiomas Globais

#### [MODIFY] Ficheiros de Idioma
- Adicionadas as chaves de tradução necessárias para o painel de administração aos idiomas: **Inglês (EN), Português (PT), Português (Pré-AO), Português do Brasil (PT_BR), Espanhol (ES) e Francês (FR)**.

## Plano de Verificação

A implementação foi validada via CLI usando o linter oficial do PHP (`php -l`), passando sem erros de sintaxe em 100% dos ficheiros desenvolvidos. O fluxo do ACP deve agora ser validado localmente na instalação destino.
