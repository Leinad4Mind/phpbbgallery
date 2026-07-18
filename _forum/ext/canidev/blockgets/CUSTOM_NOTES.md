# Auditoria e Alterações - canidev/blockgets v2.0.7

## 1. Modificações ao Código (vs. versão original)

### blocks/gallery_block.php
- **BBCode `[img]` → `[album]`:** A pesquisa de imagens nos posts foi alterada de `[img]` para `[album]`, provavelmente para integração com a extensão phpBB Gallery (phpbbgallery).
- **Imagem SRC hardcoded:** O URL da imagem passou de `$match[1]` (genérico) para `/forum/gallery/image/{id}/mini` (caminho directo da galeria).
- **Integração com BBPrefix:** Foi adicionada lógica complexa para obter prefixos de tópicos (via `BBPREFIX_INSTANCES_TABLE` e `BBPREFIX_TABLE`), incluindo uma nova variável de template `PREFIX_STR` e array `prefix`. Isto exige a extensão BBPrefix instalada.
- **Reestruturação do loop:** O loop de parse de dados foi dividido em 2 passos: primeiro recolhe todos os rows, depois processa-os com prefixos.

### blocks/login_block.php
- **Ícones FontAwesome personalizados:**
  - `SEARCH_NEW`: `fa-file-o` → `fa-commenting icon-red`
  - `SEARCH_SELF`: `fa-file-o` → `fa-comment`
  - `MY_SUBSCRIBED`: `fa-bookmark-o` → `fa-eye`
  - Mensagens privadas: `fa-inbox` → `fa-envelope`

### blocks/news_block.php
- **Integração com brunoais/readotherstopics:** Adicionada verificação ACL `f_read_others_topics_brunoais` para filtrar fóruns onde o utilizador não pode ver tópicos de terceiros.
- **Ordenação alterada:** `topic_time DESC` → `topic_last_post_time DESC` (ordenar pela última resposta em vez da data de criação).
- **Novas variáveis de template:** `LAST_POST_TIME` e `LAST_POST_AUTHOR_FULL` foram adicionadas ao output.

### blocks/recent_topics_block.php
- **Integração com brunoais/readotherstopics:** Mesma verificação ACL `f_read_others_topics_brunoais` adicionada ao filtro de fóruns.
- **Lógica de tabs alterada:**
  - `TAB_TOPICS.where`: vazio → `AND t.topic_posts_approved >= 1)` (só mostra tópicos com pelo menos 1 post aprovado)
  - `TAB_ACTIVITY.where`: `AND t.topic_posts_approved > 1)` → `)` (mostra toda a actividade)
- **Nova variável de template:** `U_NEWEST_POST` adicionada.

### blocks/topic_index_block.php
- **Filtro por prefixo:** A pesquisa por primeira letra do tópico foi alterada para incluir um prefixo `[...] ` antes do título: `'[' + any_char + '] ' + first_char + any_char`. Isto adapta a pesquisa ao formato de títulos com prefixos BBPrefix.

### controller/calendar_controller.php
- **Filtro de utilizadores:** Adicionada condição `AND u.user_posts > 100` para mostrar apenas utilizadores com mais de 100 posts no calendário de aniversários.

## 2. Ficheiros Adicionados (novos)

### Traduções PT e PT-preAO
Foram criadas traduções completas para Português de Portugal:
- `language/pt/` — 7 ficheiros (acp.php, acp_blocks.php, chat_addon.php, email/contact_block.txt, info_acp_blockgets.php, installer.php, main.php)
- `language/pt_preao/` — mesmos 7 ficheiros com ortografia pré-acordo

### Ficheiros temporários
- `diff_full.tmp` e `diff_nospace.tmp` — ficheiros de diff temporários que **devem ser removidos** antes do deploy em produção.

## 3. Templates Modificados (styles/BBOOTS)
Vários templates HTML do tema BBOOTS foram personalizados com alterações visuais e de layout. Estas alterações são específicas ao tema em uso no fórum.

## 4. Dependências Externas
Esta extensão modificada depende de:
- **canidev/core** (≥1.1.6) — framework base de todas as extensões canidev
- **brunoais/readotherstopics** — para a verificação ACL `f_read_others_topics_brunoais`
- **BBPrefix** (extensão de prefixos de tópicos) — para as tabelas `BBPREFIX_INSTANCES_TABLE` e `BBPREFIX_TABLE`
- **phpbbgallery** — para os URLs de imagens `/forum/gallery/image/{id}/mini`

## 5. Considerações Futuras
- Se a extensão blockgets for atualizada oficialmente, todas as customizações acima terão de ser reaplicadas manualmente.
- Os ficheiros `.tmp` devem ser eliminados.
- A integração com BBPrefix assume que a extensão de prefixos está instalada — caso contrário, a gallery_block.php vai produzir erros de tabela inexistente.
