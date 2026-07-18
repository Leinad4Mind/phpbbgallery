# Notas de Customização: Cron Status

**Versão Base Oficial:** 3.3.0
**Estado Atual:** Extensão com correções de segurança e robustez aplicadas em 2026-07-18, e traduções `pt`/`pt_preao` adicionadas nativamente (não vêm com a extensão original).

## Análise de Código e Compatibilidade

### 1. Auditoria de Segurança e Bugfixes — 2026-07-18
Uma segunda auditoria (mais aprofundada que a análise inicial) encontrou e corrigiu os seguintes problemas:

- **XSS refletido/persistente no ACP (`acp/cronstatus_module.php`) — CORRIGIDO**: os parâmetros `sk`/`sd` (ordenação da tabela) eram lidos do request, **gravados diretamente na config** `cronstatus_default_sort` sem validação, e depois reinjetados sem escape em URLs (`meta_refresh`, links `CRON_TASK_RUN`). Um único clique num link malicioso por um administrador tornava a injeção persistente para todos os admins que visitassem a página depois. Corrigido com uma whitelist estrita (`sk` só pode ser `display_name`/`task_date`/`new_date`; `sd` só `a`/`d`) aplicada tanto ao valor da config como ao do request.
  - Adicionalmente, `cron_type` (usado para montar um `<img src="cron.php?cron_type=...">`) também era refletido sem escape. Corrigido validando `cron_type` contra a lista real de tarefas Cron registadas (`cron.manager->get_tasks()`) e aplicando `htmlspecialchars()` ao URL final.
- **`explode()` sem proteção (`acp/cronstatus_module.php:54`) — CORRIGIDO**: se `cronstatus_default_sort` estivesse vazia ou corrompida (sem `|`), `list($sk_config, $sd_config) = explode(...)` gerava `Undefined array key 1` em PHP 8. Corrigido com `array_pad(..., 2, '')`, resolvido no mesmo local que a whitelist do XSS acima.
- **`strpos()` usado como booleano (`acp/cronstatus_helper.php:143,148`) — CORRIGIDO**: `strpos($name, 'prune_notifications')` e `strpos($name, 'queue')` eram testados sem `!== false`. Funcionava por sorte porque as tarefas nativas do phpBB nunca têm esse texto na posição 0, mas uma tarefa de terceiros cujo nome começasse exatamente por essas strings seria mal classificada (silenciosamente, sem erro). Corrigido com `!== false` explícito em ambos.
- **Variável global implícita (`adm/style/js/cronstatus.js:81`) — CORRIGIDO**: `cron_run = this;` dentro de `run_cron()` faltava o `var`, criando uma variável global no `window`. A variável nem sequer era usada depois. Corrigido para `var cron_run = this;`.
- **`.travis.yml` — REMOVIDO**: CI morto (travis-ci.org descontinuado em 2021). Seguindo o mesmo critério já aplicado noutras extensões deste fórum.
- **`differences.md` — REGENERADO**: o ficheiro tinha 2309 linhas por ter capturado recursivamente os seus próprios ficheiros temporários (`diff_full.tmp`, `diff_nospace.tmp` de execuções anteriores do processo de diff). A diferença real entre a base oficial e a versão instalada é uma só: presença de `.github/workflows/tests.yml` (inofensivo, não corre em produção). Ficheiro reduzido para o essencial.

### 2. Compatibilidade com PHP 8.x
- Todas as propriedades de classe nos _listeners_ e módulos do ACP estão corretamente declaradas (`public $tpl_name`, `protected $config`, etc.), evitando qualquer `E_DEPRECATED` por propriedades dinâmicas.

### 3. Traduções Adicionais — 2026-07-18
- Adicionadas as pastas `language/pt/` e `language/pt_preao/` (português europeu, pós- e pré-Acordo Ortográfico), que não vêm de origem com a extensão — seguindo o mesmo padrão já aplicado na `anavaro/pmsearch`.

### 4. Diferenças entre Root e Fórum
- Ver `differences.md` (regenerado). Nenhum ficheiro HTML, CSS ou template original foi alterado, apenas os PHP/JS listados acima e os novos ficheiros de idioma.

### 5. Integração de Temas
- Esta extensão atua estritamente na Área de Administração (ACP), onde as tarefas _Cron_ correm e são mostradas. Como tal, não necessita de ficheiros ou templates adicionais para suporte a BBOOTS ou FLATBOOTS.

> **Aviso para o Futuro:** Em caso de lançamento de uma versão superior no GitHub do autor (`BoardTools/cronstatus`), ao atualizar é necessário reaplicar manualmente os fixes de segurança da secção 1 (`acp/cronstatus_module.php`, `acp/cronstatus_helper.php`, `adm/style/js/cronstatus.js`) e voltar a copiar as pastas `language/pt/` e `language/pt_preao/`, que não existem no upstream.
