# Auditoria e Alterações - canidev/chat

## 1. Resumo da Auditoria
Após a análise das diferenças entre a versão instalada no fórum e a versão original (`differences.md`), concluiu-se que **não existem customizações** nesta extensão.

- A versão instalada no fórum é a **1.2.6** (01/07/2024).
- A versão "limpa" (original) fornecida no repositório é a **1.2.7** (07/03/2025).

As únicas diferenças encontradas são referentes à atualização da versão 1.2.6 para a 1.2.7, nomeadamente:
- Alteração das strings de versão e copyright em todos os cabeçalhos PHP.
- Uma ligeira correção no `admin_controller_rooms.php` para evitar avisos de array index (`empty() ? '' : ...`).
- Atualização da prioridade num event listener (`event/listener.php`).
- Re-minificação do ficheiro `jchat-acp.js`.

## 2. Traduções e Integrações
Ao contrário da extensão `blockgets`, a extensão `chat`:
- **Não possui** ficheiros de tradução para Português (`pt` ou `pt_preao`). Apenas tem `en` e `es`.
- **Não possui** integração com `brunoais/readotherstopics`.
- **Não possui** integração com `BBPrefix` ou outras extensões.
- **Não possui** modificações aos templates.

## 3. Veredicto
A extensão encontra-se **pura e inalterada**, sendo apenas uma versão mais antiga. Pode ser atualizada para a versão 1.2.7 (substituindo os ficheiros) com total segurança, sem perda de trabalho.
