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
	'BBTAGS_TAG_EXISTS_USE_MERGE' => 'Essa tag já existe. Usa a ferramenta de fusão para combinar ambas as tags.',
	'ACP_BBTAGS_MERGE' => 'Fundir tags',
	'ACP_BBTAGS_MERGE_EXPLAIN' => 'Transfere todas as relações de uma tag de origem para uma tag de destino existente. O nome, a route e a política do destino são mantidos.',
	'BBTAGS_MERGE_SOURCE' => 'Tag de origem',
	'BBTAGS_MERGE_SOURCE_EXPLAIN' => 'Esta tag será removida depois de as relações serem transferidas.',
	'BBTAGS_MERGE_DESTINATION' => 'Tag de destino',
	'BBTAGS_MERGE_DESTINATION_EXPLAIN' => 'Esta tag e a respetiva política atual serão mantidas.',
	'BBTAGS_MERGE_SUBMIT' => 'Fundir tags',
	'BBTAGS_MERGE_INVALID' => 'As tags de origem e destino têm de ser diferentes.',
	'BBTAGS_MERGE_CONFIRM' => 'Tens a certeza de que pretendes fundir “%1$s” em “%2$s”? Esta operação não pode ser anulada.',
	'BBTAGS_MERGE_EXTERNAL_PROVIDER' => 'A tag de origem não pode ser fundida porque está a ser usada ativamente pelos seguintes providers externos: %s.',
	'BBTAGS_MERGE_FAILED' => 'Não foi possível fundir as tags. Nenhuma alteração foi confirmada.',
	'BBTAGS_MERGE_SUCCESS' => 'As tags foram fundidas com sucesso.',

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBTAGS_NOTICE'  => '<div class="phpinfo"><p>As configurações da extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />Não te esqueças de rever/ajustar as <strong>Funções de Permissão de Utilizador</strong> em <strong>Permissões &#187; Funções de permissão &#187; Funções de Utilizador (Seleciona a Função e clica em editar) &#187; Diversos (aba): "Pode Gerir BBtags"</strong>.</p></div>',

	'ACP_BBTAGS_MANAGE'         => 'Gerir as tags dos tópicos atuais',
	'ACP_BBTAGS_MANAGE_EXPLAIN' => 'Usando este formulário podes adicionar, editar, ver e eliminar tags',

	'ACP_BBTAGS_POLICY'                    => 'Política por fórum',
	'ACP_BBTAGS_POLICY_EXPLAIN'            => 'Configura onde a tag "%s" está disponível nos tópicos.',
	'ACP_BBTAGS_POLICY_PROVIDER'           => 'Disponibilidade da tag nos tópicos',
	'ACP_BBTAGS_POLICY_ENABLED'            => 'Ativar para tópicos',
	'ACP_BBTAGS_POLICY_ENABLED_EXPLAIN'    => 'Desativa esta tag no fornecedor forum_topics sem a remover do catálogo partilhado.',
	'ACP_BBTAGS_POLICY_MODE'               => 'Disponibilidade predefinida',
	'ACP_BBTAGS_POLICY_MODE_EXPLAIN'       => 'Global disponibiliza a tag, exceto nos ramos negados. Restrito exige uma regra explícita de permissão.',
	'ACP_BBTAGS_POLICY_MODE_GLOBAL'        => 'Disponível em todos os fóruns',
	'ACP_BBTAGS_POLICY_MODE_RESTRICTED'    => 'Disponível apenas nos fóruns permitidos',
	'ACP_BBTAGS_POLICY_FORUM_RULES'        => 'Hierarquia de fóruns',
	'ACP_BBTAGS_POLICY_FORUM_RULES_EXPLAIN'=> 'Uma regra aplica-se ao fórum selecionado e aos seus descendentes, exceto se um descendente tiver uma regra mais próxima. Herdar utiliza a regra do antepassado mais próximo ou a disponibilidade predefinida.',
	'ACP_BBTAGS_POLICY_FORUM'              => 'Fórum',
	'ACP_BBTAGS_POLICY_RULE'               => 'Regra',
	'ACP_BBTAGS_POLICY_RULE_INHERIT'       => 'Herdar',
	'ACP_BBTAGS_POLICY_RULE_ALLOW'         => 'Permitir',
	'ACP_BBTAGS_POLICY_RULE_DENY'          => 'Negar',
	'ACP_BBTAGS_POLICY_NO_FORUMS'          => 'Não existem fóruns para configurar.',
	'ACP_BBTAGS_POLICY_SAVED'              => 'A política por fórum foi guardada com sucesso.',
	'ACP_BBTAGS_POLICY_SAVE_FAILED'        => 'Não foi possível guardar a política por fórum.',
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

	'ACP_LOADING'        => 'Aguarda. A carregar...',
]);
