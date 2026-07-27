<?php

/**
 * BBtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_BBTAGS'                => 'BBtags',
	'ACP_BBTAGS_EXPLAIN'        => 'Gere as tuas tags<br />Elimina ou edita tags dos tópicos atuais. Gere as tuas pré-tags para a sugestão automática no tópico.',
	'BBTAGS_MIN_LENGTH'         => 'Comprimento mín. da Tag',
	'BBTAGS_MIN_LENGTH_EXPLAIN' => 'Define o comprimento mín. de caracteres por Tag',
	'BBTAGS_MAX_TAGS'           => 'Quantidade máx. de tags por tópico',
	'BBTAGS_MAX_TAGS_EXPLAIN'   => 'Define a quantidade máxima de Tags por tópico.',
	'BBTAGS_CLOUD_LIMIT'        => 'Quantidade máx. de Tags na nuvem',
	'BBTAGS_CLOUD_LIMIT_EXPLAIN' => 'Define a quantidade máxima de Tags na nuvem.',
	'BBTAGS_ON_INDEX'           => 'Nuvem de BBtags',
	'BBTAGS_ON_INDEX_EXPLAIN'   => 'Exibe uma nuvem de tags',
	'INDEX_ONLY'                => 'Apenas no índice',
	'PRE_BBTAGS'                => 'Pré BBtags',
	'PRE_BBTAGS_EXPLAIN'        => 'Exibe a sugestão automática de tags quando o utilizador começa a escrever',
	'SAVE'                      => 'Guardar',

	'TAG'             => 'Tag',
	'QTY'             => 'Qtd.',
	'PAGEBACK'        => 'Página anterior',
	'PAGEFURTHER'     => 'Página seguinte',
	'BBTAGS_NO_TAGS'          => 'Nenhuma BBtag encontrada',
	'BBTAGS_SETTINGS_SAVED'   => 'As definições do BBTags foram guardadas com sucesso.',
	'BBTAGS_TAG_DELETED'      => 'A tag foi eliminada com sucesso.',
	'BBTAGS_TAG_NOT_FOUND'    => 'A tag solicitada não existe.',
	'BBTAGS_TAG_UPDATED'      => 'A tag foi atualizada com sucesso.',
	'BBTAGS_TAG_UPDATE_FAILED'=> 'Não foi possível atualizar a tag. O nome poderá já estar a ser utilizado.',

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBTAGS_NOTICE'  => '<div class="phpinfo"><p>As configurações da extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />Não te esqueças de rever/ajustar as <strong>Funções de Permissão de Utilizador</strong> em <strong>Permissões &#187; Funções de permissão &#187; Funções de Utilizador (Seleciona a Função e clica em editar) &#187; Diversos (aba): "Pode Gerir BBtags"</strong>.</p></div>',

	'ACP_BBTAGS_MANAGE'         => 'Gerir as tags dos tópicos atuais',
	'ACP_BBTAGS_MANAGE_EXPLAIN' => 'Usando este formulário podes adicionar, editar, ver e eliminar tags',

	'BBTAGS_DESCRIPTION' => 'O próximo nível de originalidade e um passo mais perto do WordPress com as clássicas Tags',
	'BBTAGS_DEVELOPERS'  => 'Programadores',
	'BBTAGS_TASKS_1'     => 'Permissões de Grupo',
	'BBTAGS_TASKS_2'     => 'Configurações de Tags Mín. e Máx.',
	'BBTAGS_TASKS_3'     => 'Módulo ACP para gerires as tuas tags e configurações',
	'BBTAGS_TASKS_4'     => 'Nuvem de Tags',
	'BBTAGS_TASKS_5'     => 'Suporte integrado para a extensão BBPreview <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBTAGS_TASKS_6'     => 'Muito mais..!',

	'SITESPLAT_COM'           => 'https://sitesplat.com/',
	'SITESPLAT_COPY'          => '&#169; SiteSplat',
	'LICENSE_INFO'            => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'     => 'Programador',
	'ACP_BBTAGS_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBTAGS_VERSION' => '1.1.3',
	'ACP_LOADING'        => 'Aguarda. A carregar...',
]);
