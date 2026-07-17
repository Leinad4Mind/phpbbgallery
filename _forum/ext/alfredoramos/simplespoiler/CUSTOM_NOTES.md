# Notas de Customização: Simple Spoiler

**Versão Base Oficial:** 2.3.2 (A mais recente)
**Estado Atual:** Esta extensão encontra-se na sua versão mais recente, no entanto, contém **modificações cruciais feitas especificamente para este fórum**. Não deve ser substituída pelos ficheiros originais do autor sem antes se portarem estas modificações.

## Melhorias e Alterações Feitas sobre a Versão Oficial

### 1. Compatibilidade com phpBB 3.3.x e FontAwesome
- **`composer.json`**:
  - Exigência do phpBB atualizada para `"phpbb/phpbb": "~3.3.0"`.
  - Servidor de verificação de atualizações (`version-check`) corrigido do site pessoal do autor (`alfredoramos.mx`) para a base de dados oficial do phpBB.com (`/customise/db/extension/simple_spoiler_bbcode`), garantindo a validação correta.
- **Ícones**:
  - Adicionada a classe `fa` nos templates (ex: `spoiler_button.html` e `spoiler.xsl`) junto às classes `fa-fw` e `fa-eye` para garantir a exibição perfeita dos ícones na nova versão da biblioteca FontAwesome usada pelo phpBB 3.3.

### 2. Suporte para Temas Customizados
- **Pastas Adicionadas**: Foram criadas de raiz as pastas de integração `styles/BBOOTS/` e `styles/FLATBOOTS/`.
- Estes diretórios contêm todo o código HTML (templates), CSS e Javascript necessários para que os botões e a interface do spoiler se integrem nativamente nos temas BBOOTS e FLATBOOTS.

### 3. Otimização de Performance
- Foram introduzidas versões **minificadas** dos ficheiros de estilo (`colors.min.css`, `style.min.css`) em todas as pastas de estilos (`all/`, `prosilver/`, `FLATBOOTS/`, `BBOOTS/`).
- Os templates em HTML (`overall_header_head_append.html` e `overall_footer_body_after.html`) foram reescritos para carregar sempre as versões `.min` mais leves, reduzindo o tempo de carregamento das páginas.

### 4. Remoção do `spoiler.js`
- O ficheiro `styles/all/theme/js/spoiler.js` (e o seu `.min.js`) do upstream foi **removido**. A única função do script era trocar o ícone `fa-eye`/`fa-eye-slash` consoante o `<details>` estava aberto ou fechado — isto passou a ser feito em CSS puro, sem JS, através da regra `.spoiler[open] > .spoiler-header .spoiler-status > .icon::before { content: '\f070'; }` em `styles/all/theme/css/common.css`/`common.min.css`.
- Isto poupa um pedido HTTP por página e funciona mesmo com JavaScript desativado. O `INCLUDEJS` correspondente foi removido dos três `overall_footer_body_after.html` (`all/`, `FLATBOOTS/`, `BBOOTS/`); o polyfill do `<details>` foi mantido.

> **Aviso para o Futuro:** Caso saia uma versão 2.3.3 ou 3.0 no futuro, devem-se retirar os ficheiros `.bak`, fazer o update com cuidado e **manter** ou **reaplicar** sempre as pastas do `FLATBOOTS` e `BBOOTS`, bem como a remoção do `spoiler.js` (ponto 4) e o fix do `substring` em `spoiler.xsl` (índice 1-based em XPath).
