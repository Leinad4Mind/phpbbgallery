<?php

/**
 * Badge Award extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACP_BADGE_MANAGE'     => 'Gerir Sistema de Medalhas',
	'BADGE_TYPE_NOT_EXIST' => 'O tipo de Medalha `%1$s` não existe.',
	'BADGE_NOTICE'         => '<div class="phpinfo"><p>As configurações desta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br /><strong>Nota:</strong> Donativos PayPal, Sistema de Gostos (LikeBB) e muitos outros suportados. Regras da Extensão Premium <strong>apenas</strong> estarão disponíveis se essas extensões estiveram ativas!</p></div>',
	'SS_HELPER_NOTY'       => 'O Sistema Core SiteSplat (BBcore) não se encontra instalado!<br /> Transfere o <a href="https://sitesplat.com" target="_blank">BBCore</a> e copia a pasta BBcore para dentro da pasta de extensões sitesplat.',
	'ERROR_BADGE_DISABLE'  => 'Não você pode desactivar o Sistema de Medalhas por teres outras extensões com dependências:<br /><div class="phpinfo">» %s</div>',

	// Logs
	'ACP_BADGE_SAVED_LOG'      => '<strong>Configuração de Medalhas foi guardada com sucesso</strong>',
	'ACP_BADGE_ADD_LOG'        => '<strong>Configuração de Medalhas Adicionada</strong>',
	'ACP_BADGE_DELETE_LOG'     => '<strong>Configuração de Medalhas apagada com sucesso</strong>',
	'ACP_BADGE_IMG_DELETE_LOG' => '<strong>A imagem da Medalha foi removida</strong>',
	'ACP_BADGE_IMG_UPLOAD_LOG' => '<strong>Foi submetida uma nova Medalha</strong>',
]);
