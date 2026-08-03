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
	'BBTAGS_TAG_EXISTS_USE_MERGE' => 'Essa tag já existe. Use a ferramenta de mesclagem para combinar as duas tags.',
	'ACP_BBTAGS_MERGE' => 'Mesclar tags',
	'ACP_BBTAGS_MERGE_EXPLAIN' => 'Transfere todos os relacionamentos de uma tag de origem para uma tag de destino existente. O nome, a route e a política do destino são mantidos.',
	'BBTAGS_MERGE_SOURCE' => 'Tag de origem',
	'BBTAGS_MERGE_SOURCE_EXPLAIN' => 'Esta tag será removida depois que os relacionamentos forem transferidos.',
	'BBTAGS_MERGE_DESTINATION' => 'Tag de destino',
	'BBTAGS_MERGE_DESTINATION_EXPLAIN' => 'Esta tag e sua política atual serão mantidas.',
	'BBTAGS_MERGE_SUBMIT' => 'Mesclar tags',
	'BBTAGS_MERGE_INVALID' => 'As tags de origem e destino devem ser diferentes.',
	'BBTAGS_MERGE_CONFIRM' => 'Tem certeza de que deseja mesclar “%1$s” em “%2$s”? Esta operação não pode ser desfeita.',
	'BBTAGS_MERGE_EXTERNAL_PROVIDER' => 'A tag de origem não pode ser mesclada porque está sendo usada ativamente pelos seguintes providers externos: %s.',
	'BBTAGS_MERGE_FAILED' => 'Não foi possível mesclar as tags. Nenhuma alteração foi confirmada.',
	'BBTAGS_MERGE_SUCCESS' => 'As tags foram mescladas com sucesso.',

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBTAGS_NOTICE'  => '<div class="phpinfo"><p>As configurações da extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />Não se esqueça de revisar/ajustar as <strong>Funções de Permissão de Usuário</strong> em <strong>Permissões &#187; Funções de permissão &#187; Funções de Usuário (Selecione a Função e clique em editar) &#187; Diversos (aba): "Pode Gerenciar BBtags"</strong>.</p></div>',

	'ACP_BBTAGS_MANAGE'         => 'Gerenciar as tags dos tópicos atuais',
	'ACP_BBTAGS_MANAGE_EXPLAIN' => 'Usando este formulário você pode adicionar, editar, ver e excluir tags',

	'ACP_BBTAGS_POLICY'                    => 'Política por fórum',
	'ACP_BBTAGS_POLICY_EXPLAIN'            => 'Configure onde a tag "%s" está disponível nos tópicos.',
	'ACP_BBTAGS_POLICY_PROVIDER'           => 'Disponibilidade da tag nos tópicos',
	'ACP_BBTAGS_POLICY_ENABLED'            => 'Ativar para tópicos',
	'ACP_BBTAGS_POLICY_ENABLED_EXPLAIN'    => 'Desativa esta tag no provedor forum_topics sem removê-la do catálogo compartilhado.',
	'ACP_BBTAGS_POLICY_MODE'               => 'Disponibilidade padrão',
	'ACP_BBTAGS_POLICY_MODE_EXPLAIN'       => 'Global disponibiliza a tag, exceto nos ramos negados. Restrito exige uma regra explícita de permissão.',
	'ACP_BBTAGS_POLICY_MODE_GLOBAL'        => 'Disponível em todos os fóruns',
	'ACP_BBTAGS_POLICY_MODE_RESTRICTED'    => 'Disponível apenas nos fóruns permitidos',
	'ACP_BBTAGS_POLICY_FORUM_RULES'        => 'Hierarquia de fóruns',
	'ACP_BBTAGS_POLICY_FORUM_RULES_EXPLAIN'=> 'Uma regra se aplica ao fórum selecionado e aos seus descendentes, exceto quando um descendente tem uma regra mais próxima. Herdar usa a regra do ancestral mais próximo ou a disponibilidade padrão.',
	'ACP_BBTAGS_POLICY_FORUM'              => 'Fórum',
	'ACP_BBTAGS_POLICY_RULE'               => 'Regra',
	'ACP_BBTAGS_POLICY_RULE_INHERIT'       => 'Herdar',
	'ACP_BBTAGS_POLICY_RULE_ALLOW'         => 'Permitir',
	'ACP_BBTAGS_POLICY_RULE_DENY'          => 'Negar',
	'ACP_BBTAGS_POLICY_NO_FORUMS'          => 'Não há fóruns para configurar.',
	'ACP_BBTAGS_POLICY_SAVED'              => 'A política por fórum foi salva com sucesso.',
	'ACP_BBTAGS_POLICY_SAVE_FAILED'        => 'Não foi possível salvar a política por fórum.',
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

	'ACP_LOADING'        => 'Aguarde. Carregando...',
]);
