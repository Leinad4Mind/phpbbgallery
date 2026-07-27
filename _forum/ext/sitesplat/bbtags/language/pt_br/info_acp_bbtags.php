<?php

/**
 * BBtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACP_BBTAGS_EXPLAIN'        => 'Gerencie suas tags<br />Exclua ou edite tags dos tópicos atuais. Gerencie suas pré-tags para a sugestão automática no tópico.',
	'BBTAGS_MIN_LENGTH'         => 'Comprimento mín. da Tag',
	'BBTAGS_MIN_LENGTH_EXPLAIN' => 'Defina o comprimento mín. de caracteres por Tag',
	'BBTAGS_MAX_TAGS'           => 'Quantidade máx. de tags por tópico',
	'BBTAGS_MAX_TAGS_EXPLAIN'   => 'Defina a quantidade máxima de Tags por tópico.',
	'BBTAGS_CLOUD_LIMIT'        => 'Quantidade máx. de Tags na nuvem',
	'BBTAGS_CLOUD_LIMIT_EXPLAIN' => 'Defina a quantidade máxima de Tags na nuvem.',
	'BBTAGS_ON_INDEX'           => 'Nuvem de BBtags',
	'BBTAGS_ON_INDEX_EXPLAIN'   => 'Exibe uma nuvem de tags',
	'INDEX_ONLY'                => 'Apenas no índice',
	'PRE_BBTAGS'                => 'Pré BBtags',
	'PRE_BBTAGS_EXPLAIN'        => 'Exibe a sugestão automática de tags quando o usuário começa a digitar',
	'SAVE'                      => 'Salvar',

	'TAG'             => 'Tag',
	'QTY'             => 'Qtd.',
	'PAGEBACK'        => 'Página anterior',
	'PAGEFURTHER'     => 'Próxima página',
	'BBTAGS_NO_TAGS'          => 'Nenhuma BBtag encontrada',
	'BBTAGS_SETTINGS_SAVED'   => 'As configurações do BBTags foram salvas com sucesso.',
	'BBTAGS_TAG_DELETED'      => 'A tag foi excluída com sucesso.',
	'BBTAGS_TAG_NOT_FOUND'    => 'A tag solicitada não existe.',
	'BBTAGS_TAG_UPDATED'      => 'A tag foi atualizada com sucesso.',
	'BBTAGS_TAG_UPDATE_FAILED'=> 'Não foi possível atualizar a tag. O nome pode já estar em uso.',

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBTAGS_NOTICE'  => '<div class="phpinfo"><p>As configurações da extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />Não se esqueça de revisar/ajustar as <strong>Funções de Permissão de Usuário</strong> em <strong>Permissões &#187; Funções de permissão &#187; Funções de Usuário (Selecione a Função e clique em editar) &#187; Diversos (aba): "Pode Gerenciar BBtags"</strong>.</p></div>',

	'ACP_BBTAGS_MANAGE'         => 'Gerenciar as tags dos tópicos atuais',
	'ACP_BBTAGS_MANAGE_EXPLAIN' => 'Usando este formulário você pode adicionar, editar, ver e excluir tags',

	'BBTAGS_DESCRIPTION' => 'O próximo nível de originalidade e um passo mais perto do WordPress com as clássicas Tags',
	'BBTAGS_DEVELOPERS'  => 'Desenvolvedores',
	'BBTAGS_TASKS_1'     => 'Permissões de Grupo',
	'BBTAGS_TASKS_2'     => 'Configurações de Tags Mín. e Máx.',
	'BBTAGS_TASKS_3'     => 'Módulo ACP para gerenciar suas tags e configurações',
	'BBTAGS_TASKS_4'     => 'Nuvem de Tags',
	'BBTAGS_TASKS_5'     => 'Suporte integrado para a extensão BBPreview <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBTAGS_TASKS_6'     => 'Muito mais..!',

	'SITESPLAT_COM'           => 'https://sitesplat.com/',
	'SITESPLAT_COPY'          => '&#169; SiteSplat',
	'LICENSE_INFO'            => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'     => 'Desenvolvedor',
	'ACP_BBTAGS_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBTAGS_VERSION' => '1.1.3',
	'ACP_LOADING'        => 'Aguarde. Carregando...',
]);
