# Auditoria e Alterações - canidev/quickmod

## 1. Resumo da Auditoria
Após a análise das diferenças entre a versão instalada no fórum e a versão original (`differences.md`), concluiu-se que **não existem modificações de código significativas ou traduções adicionais**.

- A versão presente no fórum é a **1.1.6**, que é a **mesma versão** (1.1.6) do repositório limpo (original).
- O código base e a lógica da extensão são idênticos, com apenas uma correção invisível de formatação (remoção de um espaço em branco no final de uma linha em `event/listener.php`).
- Não existem ficheiros de tradução em PT ou PT-preAO.

## 2. Alterações de Ficheiros
A única diferença real encontrada diz respeito à **remoção de ficheiros do tema BBOOTS**.

No fórum, a pasta `styles/BBOOTS/` foi **completamente eliminada**, incluindo:
- `styles/BBOOTS/template/components/service_loader.html`
- `styles/BBOOTS/template/event/overall_header_head_append.html`
- `styles/BBOOTS/theme/bboots.css`

## 3. Veredicto e Procedimento de Atualização
A extensão pode ser considerada **standard**. A única alteração foi a limpeza de ficheiros de um tema (BBOOTS) que provavelmente não estava a ser utilizado neste contexto.
Se pretenderes reinstalar a extensão original limpa (1.1.6 ou superior), podes fazê-lo sem qualquer problema, ficando a teu critério se apagas novamente a pasta `styles/BBOOTS` ou não (mantê-la não prejudicará o fórum, visto que os estilos só são carregados se esse tema estiver ativo).
