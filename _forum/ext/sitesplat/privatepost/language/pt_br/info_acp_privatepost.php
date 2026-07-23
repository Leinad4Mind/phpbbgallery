<?php

/**
 * Private Post
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'PRIVATEPOST_NOTICE'          => '<div class="phpinfo"><p><br />A configuração desta extensão está em <strong>%1$s » %2$s » %3$s</strong>.<br />A permissão é baseada no fórum. Isso significa que você precisa selecionar um grupo E um fórum aos quais deseja conceder a permissão.<br /> Se quiser tornar isso mais rápido, navegue até <strong>Funções de Permissões -> Funções de Fórum -> Acesso Total</strong> e defina a permissão lá (para cada função). Isso vai atualizar automaticamente todos os grupos que usam a função de Acesso Total (ou quaisquer outras funções que você ajustar) em todo o fórum.<br /><br /> <strong>AVISO</strong>: Observe que, devido à natureza desta extensão, todas as mensagens marcadas como ocultas serão excluídas como "Exclusão Suave" quando a extensão for desativada. <br />As mensagens ou tópicos excluídos suavemente podem ser encontrados no Painel de Controle de Moderação. (MCP)</p></div>',
	'ACP_PRIVATEPOST_PERMISSIONS' => 'selecione o Grupo e o fórum e depois "Permissões Avançadas" » Aba Conteúdo "Pode ler mensagens ocultas"',
	'SS_HELPER_NOTY'              => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
]);
