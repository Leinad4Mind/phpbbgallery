# Auditoria e Alterações - canidev/core

## 1. Resumo da Auditoria
Ao contrário do `canidev/chat`, a extensão `canidev/core` apresenta **modificações customizadas** que devem ser preservadas caso exista uma atualização.

- A versão instalada no fórum é a **1.1.9** (01/06/2022).
- A versão original mais recente é a **1.1.10** (07/03/2025).

## 2. Ficheiros Customizados (Adicionados)
Foi criado um plugin específico para integração com a extensão `vse/topicimagepreview` (Topic Image Preview). Este ficheiro **não existe na versão original** e tem de ser mantido:
- `plugins/blockgets/topicimagepreview.php`

## 3. Alterações de CSS e Tema
O ficheiro base de estilos `styles/all/theme/cbbcore.css` foi alterado visualmente para combinar com o tema do fórum:
- Remoção do uso de variáveis CSS `--cbb-btn-border-radius` sendo o valor de `2px` fixado (hardcoded) nas classes.
- Tamanho de letra nos diálogos (modais) reduzido de `12px` para `11px`.
- Cor de hover nos menus alterada de `#f3f5f6` para `#EFEFEF`.

## 4. Atualização de versão (1.1.9 -> 1.1.10)
A atualização oficial para 1.1.10 inclui as seguintes melhorias que explicam as outras diferenças no diff:
- **Remoção de ficheiros duplicados / deprecated:** A versão 1.1.9 no fórum mantinha ficheiros em duplicado por motivos de compatibilidade (ex: `acp.php` vs `Acp.php`, `bbcode_manager.php` vs `BBcodeManager.php`, `json_response.php`, `image_parser.php`, `dummy_array.php`). A versão 1.1.10 oficial apagou os ficheiros em snake_case obsoletos.
- **Novo Tema:** A versão 1.1.10 adiciona suporte ao tema `zeina` (`styles/zeina/theme/zeina.css`).

## 5. Veredicto e Procedimento de Atualização
Caso se decida atualizar o `canidev/core` para a versão 1.1.10:
1. Copiar a versão 1.1.10 para o fórum.
2. Reaplicar as modificações de CSS no ficheiro `cbbcore.css`.
3. Voltar a colocar o ficheiro `plugins/blockgets/topicimagepreview.php` no seu devido lugar.
4. (Opcional) Eliminar do fórum os ficheiros PHP obsoletos descritos acima (snake_case) que já não são necessários.
