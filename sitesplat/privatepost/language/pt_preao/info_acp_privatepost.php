<?php

/**
 * Private Post
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'PRIVATEPOST_NOTICE'          => '<div class="phpinfo"><p><br />A configuração para esta extensão encontra-se em <strong>%1$s » %2$s » %3$s</strong>.<br />A permissão é baseada no fórum. Isto significa que precisas de seleccionar um grupo E um fórum aos quais pretendes conceder a permissão.<br /> Se quiseres tornar isto mais rápido, navega até <strong>Funções de Permissões -> Funções de Fórum -> Acesso Total</strong> e define a permissão aí (para cada função). Isto irá actualizar automaticamente todos os grupos que usam a função de Acesso Total (ou quaisquer outras funções que ajustares) em todo o fórum.<br /><br /> <strong>AVISO</strong>: Nota que, devido à natureza desta extensão, todas as mensagens marcadas como ocultas serão eliminadas com "Eliminação Suave" quando a extensão for desactivada. <br />As mensagens ou tópicos eliminados suavemente podem ser encontrados no Painel de Controlo de Moderação. (MCP)</p></div>',
	'ACP_PRIVATEPOST_PERMISSIONS' => 'selecciona o Grupo e o fórum e depois "Permissões Avançadas" » Separador Conteúdo "Pode ler mensagens ocultas"',
	'SS_HELPER_NOTY'              => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
]);
