<?php

/**
 * HTML email extension for the phpBB Forum Software package.
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'HTML_EMAIL_NOTICE'             => '<div class="phpinfo"><p class="entry">A configuração desta extensão não é necessária.<br />Após a sua activação, todos os e-mails enviados pelo fórum passam automaticamente a ser transmitidos em formato HTML. Podes actualizar os teus modelos de e-mail como desejares.</p></div>',
	'ACP_HTMLEMAIL_TITLE'           => 'Editor de E-mails HTML',
	'ACP_HTMLEMAIL_EXPLAIN'         => 'Aqui podes ver e editar todos os modelos de e-mail (.txt) do núcleo do phpBB e extensões. Podes inserir código HTML directamente nestes ficheiros.',
	'ACP_HTMLEMAIL_OVERVIEW'        => 'Visão Geral',
	'ACP_HTMLEMAIL_FILTER'          => 'Filtrar modelos...',
	'ACP_HTMLEMAIL_FILENAME'        => 'Nome do ficheiro',
	'ACP_HTMLEMAIL_ORIGIN'          => 'Origem',
	'ACP_HTMLEMAIL_LANGUAGE'        => 'Idioma',
	'ACP_HTMLEMAIL_STATUS'          => 'Formato',
	'ACP_HTMLEMAIL_NO_TEMPLATES'    => 'Não foram encontrados modelos de e-mail.',
	'ACP_HTMLEMAIL_EDIT'            => 'Editar Modelo',
	'ACP_HTMLEMAIL_PATH'            => 'Caminho Absoluto',
	'ACP_HTMLEMAIL_RESTORE'         => 'Restaurar Backup Original',
	'ACP_HTMLEMAIL_RESTORE_CONFIRM' => 'Tens a certeza que queres restaurar o backup original? Todas as alterações serão perdidas.',
	'ACP_HTMLEMAIL_NOT_FOUND'       => 'O modelo solicitado não foi encontrado.',
	'ACP_HTMLEMAIL_SAVED'           => 'Modelo guardado com sucesso.',
	'ACP_HTMLEMAIL_SAVE_ERROR'      => 'Erro ao guardar o modelo. Por favor, verifica as permissões do ficheiro.',
	'ACP_HTMLEMAIL_RESTORED'        => 'Modelo original restaurado com sucesso.',
	'ACP_HTMLEMAIL_RESTORE_ERROR'   => 'Erro ao restaurar o modelo. O backup pode não existir ou o ficheiro não ter permissões de escrita.',
	'ACP_HTMLEMAIL_TAB_EDITOR'      => 'Editor',
	'ACP_HTMLEMAIL_TAB_PREVIEW'     => 'Pré-visualização',
	'ACP_HTMLEMAIL_TAB_SPLIT'       => 'Vista Dividida',
	'ACP_HTMLEMAIL_PREVIEW'         => 'Pré-visualização',
	'ACP_HTMLEMAIL_FULLSCREEN'      => 'Pré-visualização em Ecrã Inteiro',
]);
