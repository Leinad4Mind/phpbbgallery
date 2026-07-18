# Notas de Customização: Upload Extensions

**Versão Base Oficial:** 3.2.0-RC
**Estado Atual:** Contém melhorias vitais de estabilidade para phpBB 3.3.x, suporte total a PHP 8.x, e (desde 2026-07-18) uma auditoria de segurança/hardening completa com piso mínimo de PHP subido para 7.4.

## Análise de Código e Compatibilidade

A extensão estava praticamente idêntica à versão oficial no repositório com pequenas mas cirúrgicas e vitais correções que aplicámos (e algumas que já estavam aplicadas) para garantir o funcionamento com o PHP 8.

### 1. Correção Crítica no YAML (`config/services.yml`)
- **Problema:** O phpBB 3.3.x usa uma versão mais recente do motor Symfony que recusa ler ficheiros `.yml` com o símbolo `@` sem estarem entre aspas. O código oficial tinha `- @user`.
- **Solução (Já aplicada na tua pasta):** O ficheiro foi alterado para `- '@user'`, evitando a "página em branco" na ativação da extensão.

### 2. Atualização Silenciosa do Interpretador Markdown (`vendor/michelf`)
- **Problema Fatal:** Esta extensão usa uma biblioteca embutida antiga (`michelf/php-markdown` de 2015) para processar os ficheiros `README.md` das extensões e mostrá-los no ACP. Esta biblioteca velhinha usava chavetas para aceder a letras dentro de strings (ex: `$element{0}`). Esta prática foi declarada "Morta" no PHP 7.4 e gera **Erro Fatal (E_ERROR)** no PHP 8.0+, destruindo completamente a página da extensão.
- **Solução (Aplicada originalmente):** Apaguei a biblioteca de 2015 inteira da pasta `vendor/` e extraí, instalei e substituí pelo código moderno do **Michelf PHP Markdown v1.9.1**, que foi 100% reescrito sem chavetas para ser amigável ao PHP 8.
- **Atualizado em 2026-07-18 para v2.0.0.** A 1.9.1 era a última versão da série 1.x (compatível com PHP ≥5.3.3); a 2.0.0 é a versão atual da biblioteca mas exige PHP ≥7.4. Como o piso mínimo desta extensão subiu para 7.4 na mesma sessão (ver secção 6), a atualização tornou-se possível. Confirmei por comparação de árvore de ficheiros que a 2.0.0 é um superset estrutural exato da 1.9.1 (mesmos ficheiros, mesmos caminhos, apenas 2 ficheiros novos — um workflow de CI da própria biblioteca e uma config do phpstan), e que o único método usado por esta extensão (`Michelf\MarkdownExtra::defaultTransform()`, chamado em `includes/functions/load.php`) mantém a mesma assinatura estática. Todos os 11 ficheiros PHP da biblioteca validados com `php -l` antes de substituir o vendor. A árvore de testes (`vendor/michelf/php-markdown/test/`) foi mantida e também atualizada — não foi podada.

### 3. Propriedades Dinâmicas no ACP (`acp/upload_module.php`)
- **Problema:** A classe principal do módulo de administração não declarava de origem a variável estática `$page_title`, o que atira _Warnings E_DEPRECATED_ de Dynamic Properties no PHP 8.2 e Erros Fatais no PHP 9.0.
- **Solução (Acabada de Aplicar):** Adicionei o `public $page_title;` ao topo do ficheiro do módulo.

### 4. Chamadas `sizeof()`
- As chamadas de `sizeof()` que o código original possui foram escrutinadas e determinou-se que afetam exclusicamente variáveis que são garantidas como sendo matrizes (`Arrays`). Deste modo, são 100% seguras de usar no PHP 8 sem gerar alertas _Not Countable_.

### 5. Traduções Adicionais
- Foram criadas as pastas `pt` e `pt_preao` clonando os ficheiros de idioma originais do Inglês (`en`), a pedido do administrador, para permitir a tradução da interface da extensão para Português de Portugal.

### 6. Auditoria de Segurança e Hardening — 2026-07-18
`boardtools/upload` é, por natureza, a extensão de maior superfície de risco do fórum: recebe ZIPs (upload local, remoto por URL, ou da phpbb.com), extrai-os, e escreve em `ext/`. Uma auditoria por leitura direta de todo o código encontrou os seguintes problemas, todos corrigidos.

**Enquadramento de severidade (honesto):** todo o módulo está protegido por `ext_boardtools/upload && acl_a_extensions`. Um administrador com essa permissão já consegue instalar extensões = execução de PHP arbitrário. Logo, nada disto é explorável por utilizadores não privilegiados — são correções de **defesa em profundidade**: relevantes para papéis de admin segmentados e para pivôs via CSRF/XSS contra um admin. Ainda assim valem a pena: a leitura arbitrária de ficheiros expõe diretamente `config.php` (credenciais da base de dados).

- **Leitura arbitrária de ficheiros (LFI) — CORRIGIDO**: o parâmetro `file` (`acp/upload_module.php`) era passado cru a `filetree::get_file()`, que faz `file_get_contents($file)` sem qualquer validação. `?...&file=../config.php` despejava o `config.php` do phpBB. Corrigido com uma verificação de contenção via `realpath()`, exigindo que o caminho resolvido esteja dentro de `ext/`.
- **XSS refletido — CORRIGIDO**: `includes/filetree/filetree.php` ecoava o nome do ficheiro sem `htmlspecialchars`. Corrigido com `htmlspecialchars(basename($file))`.
- **Path traversal em `local_upload` — CORRIGIDO**: `includes/upload/base.php::get_dest_file()` concatenava o parâmetro `local_upload` diretamente no caminho de extração, sem sanitizar. Corrigido com `basename()`.
- **Filtro contornável na ação `download` — CORRIGIDO**: `str_replace('../', '', $download_name)` em `acp/upload_module.php` era não-recursivo (`....//` colapsa em `../`). Substituído por `basename()`.
- **Path traversal em `restore_languages` (`archive`) — CORRIGIDO**: `includes/functions/extensions.php` passava o parâmetro `archive` diretamente ao construtor do `compress_zip`, sem sanitizar. Corrigido com `basename()`.
- **Sanitização em falta em `lang::upload` (`ext_name`/`lang_name`) — CORRIGIDO**: `includes/upload/lang.php` não sanitizava estes parâmetros, ao contrário do fluxo `delete_language` (que já usava `str_replace('.', '', ...)` + `substr_count('/')===1`). Corrigido, alinhando com o padrão já existente noutro fluxo da própria extensão.
- **Higiene de cabeçalhos HTTP — CORRIGIDO**: `includes/filetree/filedownload.php` construía cabeçalhos `Content-Type`/`Content-disposition` sem filtrar CR/LF ou componentes de caminho. Corrigido por defesa em profundidade (os pontos de chamada atuais já passavam valores seguros).
- **Token CSRF decorativo — CORRIGIDO**: `add_form_key('version_check_settings')` populava um `{S_FORM_TOKEN}` renderizado no template `acp_upload_list.html`, mas **nenhum código chamava `check_form_key()`** para o verificar — dava uma falsa sensação de segurança. A proteção real desta ação vem do `confirm_box()`. Chamada removida.
- **Código morto — LIMPO**: variáveis `$host`/`$port` calculadas mas nunca usadas em `includes/types/zip.php::remote_upload()`.

### 7. CI — Novo `.github/workflows/tests.yml` — 2026-07-18
A extensão não tinha CI própria (só o `.travis.yml` vendorizado do michelf, morto desde 2021, que testa a *biblioteca*, não a extensão). Adicionado um workflow GitHub Actions com EPV + code sniffer + verificação de ficheiros executáveis, matriz PHP 7.4–8.3, seguindo o mesmo padrão já usado no `boardtools/cronstatus`.

### 8. Piso Mínimo de PHP — 2026-07-18
`require.php` subiu de `>=5.3.3` para `>=7.4,<9.0`. Decisão do administrador, que desbloqueou a atualização do `php-markdown` (secção 2).

> **Aviso para o Futuro:** Se por acaso surgir uma atualização desta extensão, é fulcral não esquecer de: corrigir o _bug_ do `@user` no ficheiro `services.yml`; verificar se o autor não volta a enfiar uma versão antediluviana da framework _Markdown_ lá dentro (e que continua em ≥2.0.x); re-injetar as tuas pastas de tradução `pt` e `pt_preao`; e reaplicar todos os fixes de segurança da secção 6 (`acp/upload_module.php`, `includes/filetree/filetree.php`, `includes/filetree/filedownload.php`, `includes/upload/base.php`, `includes/upload/lang.php`, `includes/functions/extensions.php`).
