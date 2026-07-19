# Regras e Diretrizes para Agentes de Desenvolvimento do phpBB (gold-phpbb-ext)

Este documento dita as regras e diretrizes comportamentais e estruturais que qualquer Agente de IA deve seguir ao criar, editar, rever ou formatar código dentro deste projeto (`gold-phpbb-ext`). 

## 1. Regras Fundamentais (Strict PHPBB Guidelines)
- **Não usar notação húngara**; usar *snake_case* para variáveis/funções PHP e *camelCase* em JavaScript. 
- **Indentação e Ficheiros**:
  - Utilizar **Tabs (4 espaços)** para identação (e não espaços propriamente ditos).
  - Terminar ficheiros com uma nova linha UNIX (LF).
  - Omitir o fecho de tag `?>` no final de ficheiros que contenham apenas código PHP.
- **Aspas simples vs duplas**: Usar sempre aspas simples (`'`) para strings que não requerem interpolação de variáveis. Aspas duplas (`"`) apenas quando estritamente necessário.
- **Chavetas (Braces)**:
  - Em PHP, a chaveta de abertura DEVE estar sempre na sua **própria linha**, assim como a de fecho (estilo Allman). Além disso, a chaveta de fecho deve estar sempre na mesma coluna da chaveta de abertura.
  - Mesmo para condições com uma só instrução (ex: if de uma linha), as chavetas são **Obrigatórias**.
  - Em JavaScript as chavetas de abertura ficam na mesma linha que a instrução.
- **Tipagem (Type Declarations - PHP 8+)**:
  - É obrigatório o uso de type hints para argumentos, propriedades e tipos de retorno.
  - Não deixar espaço antes dos dois pontos `:`, mas colocar um espaço depois (ex: `function do_stuff(string $input): string`).
  - Em **Union Types**, se houver múltiplos tipos ou valores nulos permitidos, o tipo `null` DEVE ser o último. Ex: `string|int|null`.
- **Classes e Visibilidade**:
  - Usar os qualificadores explícitos `public`, `protected` ou `private` em vez de `var`.
  - O qualificador `static` deve vir **depois** da visibilidade (ex: `private static function f()`).
  - Os nomes das classes/namespaces devem refletir exatamente a localização da diretoria onde se encontram.
- **Formatação e Lógica de Código**:
  - Deixar **um espaço** entre tokens, variáveis e operadores (ex: `$i = 0;` em vez de `$i=0;` ou `if ($i < 7)` em vez de `if($i<7)`).
  - Usar parenteses para definir a precedência exata de operadores complexos.
  - Omitir o uso de operadores de atalho embutidos em expressões (ex: errado: `$array[++$i] = $j;` correto: `$i++; $array[$i] = $j;`).
  - Condicionais em linha (`? :`) devem ser usadas unicamente para atribuições simples, nunca para invocar funções ou lógicas complexas.
  - **Switch statements**: os `case` e `break` e os códigos internos devem manter a coerência de tabulações. Um bloco `default:` deve sempre estar presente, nem que seja vazio ou com um comentário.
  - Nunca usar variáveis não-inicializadas. Prever a sua existência com `isset()` ou `empty()`.
  - Preferir constantes de classe em vez de `define()` globais.

## 2. Nomenclatura de Extensões
- **Vendor/Ext**: Todos os nomes de `vendor` e de extensões `ext` devem conter EXCLUSIVAMENTE caracteres alfanuméricos em **letras minúsculas** (para compatibilidade com phpBB 4.0).
- Exemplo: `vendor/ext`, nunca `Vendor/Ext` ou `vendor_name/ext-name`.

## 3. Segurança e Manipulação de Dados
- **Nunca confiar no input do utilizador**: Os dados (incluindo GET/POST/Cookies/SERVER) devem ser sempre acedidos através do método `$request->variable('nome_var', default_val);` com o tipo deduzido do `default_val`. (Nunca aceder diretamente a `$_GET` ou `$_POST`).
- **Operações Sensíveis / Formulários**: 
  - Formulários de operações que alterem o estado da BD devem sempre incluir a variável de template `{{ S_FORM_TOKEN }}`.
  - No backend, deve-se gerar e verificar o token do form com `add_form_key('nome')` e `check_form_key('nome')`.
  - Proibido o uso de `eval()`, `create_function()`, `goto` ou `preg_replace` com o modificador `/e`.

## 4. Base de Dados, Queries e Otimização
- É proibido usar syntax específica de base de dados para garantir compatibilidade multiplataforma (MySQL, PostgreSQL, Oracle, SQLite, etc.). Ex: Usar `<>` em vez de `!=`.
- **Prevenir SQL Injections**: Usar sempre `$db->sql_escape()` se lidar com strings nas queries.
- **Limites e Inserções Multiplas**:
  - Em vez de cláusulas `LIMIT`, usar `$db->sql_query_limit($sql, $total, $offset)`.
  - Para `INSERT` ou `UPDATE` usar `$db->sql_build_array('INSERT', $array)`.
  - Para múltiplas inserções usar `$db->sql_multi_insert($table, $array)`.
  - Para IN() ou NOT IN() usar `$db->sql_in_set()`.
- **Otimização de Loops e Arrays**:
  - Evitar colocar `count()` na condição do loop. Atribuir primeiro a uma variável (ex: `for ($i = 0, $size = count($data); $i < $size; $i++)`).
  - Evitar usar `in_array()` em arrays enormes (especialmente dentro de loops). Em vez disso, restruturar os arrays para usar as chaves e testar com `isset()`.

## 5. Sistema de Templates (Twig e phpBB 4.0+)
- Usar **exclusivamente a sintaxe Twig**: O sistema de tags baseadas em comentários html (`<!-- BEGIN -->`, `<!-- IF -->`) está depreciado e será removido.
  - Variáveis: `{{ VARIAVEL }}`.
  - Chaves de Língua: `{{ lang('CHAVE') }}` (Escapadas para JS usando helper: `{{ lang_js('CHAVE') }}` ou a pipeline `|e('js')`).
  - Lógica IF: `{% if condition %} ... {% elseif other %} ... {% endif %}`.
  - Ciclos FOR: `{% for item in loopname %} ... {% else %} ... {% endfor %}`.
  - Includes: `{% include 'nome.html' %}`.
  - Extensões css/js: `{% INCLUDECSS '@vendor_ext/style.css' %}`.

## 6. Arrays e Ficheiros de Tradução (Language Files)
- **Short Array Syntax**: As arrays DEVEM usar sempre o novo estilo `[]` e nunca o `array()`. Deve ter uma vírgula terminal no último elemento em caso de arrays multilinha.
- Ao manipular as traduções para a língua portuguesa ou atualizar extensões, respeitar **rigorosamente** as quebras de linha e estrutura:
  ```php
  if (!defined('IN_PHPBB'))
  {
      exit;
  }

  if (empty($lang) || !is_array($lang))
  {
      $lang = [];
  }
  ```
- Todas as aspas simples (`'`) dentro do valor de uma tradução **DEVEM** ser devidamente escapadas (`\'`) para não quebrarem a array PHP. O código nunca deve ter Syntax Errors e deve passar limpo no `php -l ficheiro.php`.

## 7. Convenções de Tradução para Português (pt, pt_preao, pt_br)
Existem três variantes da língua portuguesa nestas extensões, cada uma com uma identidade distinta:
- **`pt`** — Português de Portugal (Português Europeu), grafia pós-Acordo Ortográfico de 1990 (AO90). Ex: "aspeto", "efetuar" (sem 'c' mudo).
- **`pt_preao`** — Português de Portugal (Português Europeu), grafia pré-Acordo Ortográfico (pré-AO90) — a grafia clássica/etimológica. Ex: "aspecto", "efectuar" (com 'c' mudo).
- **`pt_br`** — Português do Brasil.

Diretrizes de estilo de tradução:
- **Gerúndio**: `pt` e `pt_preao` nunca devem usar construções de gerúndio para rótulos/ações — devem ser sempre evitadas. Ex: "Gerando" → "Criar" ou "Gerar"; "Gerenciar" → "Gerir". `pt_br` pode manter o gerúndio (ex: "Gerando", "Gerenciando").
- **Tratamento (Forma de Tratamento)**: `pt` E `pt_preao` usam a forma informal **tu** (tu/teu/tua/contigo/ti, verbos como "tiveres", "podes", "vês", imperativos como "define"). `pt_br` usa a forma **você/seu** (você, seu/sua, verbos como "tiver", "pode", "vê").
- **Ortografia**: `pt` elimina consoantes mudas/etimológicas de acordo com o AO90 (aspeto, efetuar, ação, direção, objetivo); `pt_preao` mantém-nas conforme a norma europeia pré-1990 (aspecto, efectuar, acção, direcção, objectivo). Não aplicar grafia AO90 em ficheiros `pt_preao`, nem grafia pré-AO90 em `pt`.
- **Aspeto Progressivo ("a + infinitivo" vs gerúndio)**: `pt`/`pt_preao` usam a perífrase europeia "a + infinitivo" (ex: "A executar...", "A carregar..."). `pt_br` deve usar o gerúndio (ex: "Executando...", "Carregando...").
- **Vocabulário (Lexical)**: `pt`/`pt_preao` usam **ficheiro(s)** para "file(s)" — nunca "arquivo(s)". `pt_br` usa **arquivo(s)**. Outros pares conhecidos: "utilizador" (pt) vs "usuário" (pt_br); "ecrã" (pt) vs "tela" (pt_br); "telemóvel" (pt) vs "celular" (pt_br).
- **Termos de Upload/Download**: `pt`/`pt_preao` usam **"fazer upload"** para o verbo upload (não "carregar") e **"transferir"** para download (não "descarregar"/"baixar"). Para rótulos curtos, botões ou títulos, usar **"Upload"** como substantivo (ex: "Upload de Extensões"). Para prosa longa, usar "fazer upload de X". `pt_br` mantém "carregar"/"baixar".
- **Possessivos na segunda pessoa (tu) — preferir teu/tua**: em `pt`/`pt_preao`, preferir sempre **teu/tua** em vez de "seu/sua" para consistência e evitar ambiguidade (já que "seu/sua" soa a tratamento formal). Ex: "se o seu alternador estiver vermelho" → "se o teu alternador estiver vermelho" (tratar o utilizador por "tu").
- **Não traduzir siglas do phpBB**: As siglas ACP, MCP e UCP não devem ser traduzidas/localizadas em nenhuma variante (ex: não usar "PCA").

## Documentação de Referência
Sempre que o Agente tiver dúvidas aprofundadas sobre um destes tópicos, deve ler e referenciar-se nos ficheiros gerados anteriormente:
- `phpbb_coding_guidelines.md` (Guias oficias de estrutura de código, sql, otimizações).
- `phpbb_extension_rules.md` e `phpbb_docs_extensions.md` (Guias oficiais sobre Twig, extensões e migrações).
