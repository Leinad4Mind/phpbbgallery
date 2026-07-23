<?php

/**
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
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
	'ACP_BBREACTION'         => 'BBReaction',
	'ACP_BBREACTION_EXPLAIN' => 'Gerencie seus tipos de reação. Escolha entre o tipo multivoto e/ou porcentagem. Mova para cima e/ou para baixo para ordenar seus tipos de reação. Depois que um tipo recebeu votos, você não pode excluí-lo até desativar esse tipo de reação. <br />Excluir um tipo de reação também vai excluir todos os votos. Se quiser manter os votos, basta desativar o tipo. Os tipos desativados não serão contabilizados no resultado das estatísticas',
	'ACP_BBREACTION_MANAGE'  => 'Gerenciar BBReaction',

	'BBREACTION_META_DESCRIPTION' => 'Premia usuários com emblemas com base em regras personalizadas e padrão',
	'BBREACTION_META_DEVELOPERS'  => 'Desenvolvedores',
	'BBREACTION_META_TASKS_1'     => 'Torna os usuários silenciosos úteis para algo e dá a eles um meio de interação',
	'BBREACTION_META_TASKS_2'     => 'Melhora a qualidade das postagens (os autores querem evitar avaliações negativas)',
	'BBREACTION_META_TASKS_3'     => 'Facilita obter reações à postagem, sem o trabalho de escrever um comentário inteiro',
	'BBREACTION_META_TASKS_4'     => 'Compatível com a extensão <a href="https://sitesplat.com/phpBB3/marketplace.php">BBAwards</a>, que permite conceder emblemas personalizados',
	'BBREACTION_META_TASKS_5'     => 'Botões configuráveis (quantos, qual texto, ícones, negativos ou positivos, animação, etc.)',
	'BBREACTION_META_TASKS_6'     => 'Muito mais..!',

	'ACP_BBREACTION_VERSION'   => '1.3.0',
	'ACP_BBREACTION'           => 'BBReaction',
	'ACP_LOADING'              => 'Aguarde. Carregando...',
	'ACP_SIDEBAR_NOTICE_CLOSE' => 'Fechar',

	'SITESPLAT_COM'       => 'https://sitesplat.com',
	'SITESPLAT_COPY'      => '&#169; SiteSplat',
	'LICENSE_INFO'        => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER' => 'Desenvolvedor',

	'NOTICE_BBEMOJI'              => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=29"><strong>BBEmoji</strong></a> não está instalada, você NÃO pode usar os Emojis como reações.',
	'ACP_BBREACTION_DELETE_LOG'   => 'Tipo de reação excluído',
	'ACP_BBREACTION_ACTIVE_LOG'   => 'A reação %s está %s',
	'ACP_ACTIVE'                  => 'ativada',
	'ACP_DO_ACTIVATE'             => 'Ativar',
	'ACP_DEACTIVE'                => 'desativada',
	'ACP_DO_DEACTIVATE'           => 'Desativar',
	'ACP_MULTIVOTE'               => 'Multivoto',
	'ACP_PERCENT'                 => 'Porcentagem / #',
	'ACP_PROGRESSBAR'             => 'Barra de progresso',
	'ACP_MEMBERLIST_STAT'         => 'Estatísticas na Lista de Membros',
	'ACP_DISPLAY_TOP_SHOW'        => 'Mostrar estatísticas do Tópico',
	'ACP_DISPLAY_TOP_POSITION'    => 'Posição das estatísticas do tópico',
	'ACP_BBREACTION_SAVE_GENERAL' => 'Salvar opções',
	'ACP_BBREACTION_CREATE_TYPE'  => 'Criar tipo de reação',
	'ACP_BBREACTION_STATISTICS'   => 'Estatísticas do BBReaction',

	'ACP_ALLOW_LOCKED' => 'Permitir em tópicos trancados',
	'ACP_ALLOW_GLOBAL' => 'Permitir em anúncios globais',

	'ACP_BBREACTION_ADD'                 => 'Adicionar tipo de reação',
	'ACP_BBREACTION_EDIT'                => 'Editar tipo de reação',
	'ACP_BBREACTION_DELETE_CONFIRM'      => 'Excluir o tipo de reação e todos os seus votos?',
	'ACP_BBREACTION_NAME'                => 'Nome da reação',
	'ACP_BBREACTION_NAME_EXPLAIN'        => 'Indique um nome curto para explicar o tipo desta reação',
	'ACP_BBREACTION_DESCRIPTION'         => 'Descrição',
	'ACP_BBREACTION_DESCRIPTION_EXPLAIN' => 'Descrição do tipo, apenas para uso interno',
	'ACP_BBREACTION_SYMBOL'              => 'Ícone Glyph',
	'ACP_BBREACTION_SYMBOL_EXPLAIN'      => 'Ícone Glyph do Font Awesome no botão de reação. Adicione um segundo parâmetro para a animação giratória. <br />Por exemplo <strong>fa-spin</strong>. Mais informações em <a href="https://fortawesome.github.io/Font-Awesome/examples/#animated">Ícones Animados</a>',
	'ACP_BBREACTION_NEGATIVE'            => 'Reação negativa',
	'ACP_BBREACTION_NEGATIVE_EXPLAIN'    => 'Marque este tipo de reação como Positiva ou Negativa. A positiva terá uma cor verde e a negativa terá vermelha.',

	'ACP_BBREACTION_SEPARATOR'         => 'Separador',
	'ACP_BBREACTION_SEPARATOR_EXPLAIN' => 'Desenha uma linha separadora à esquerda deste botão',
	'ACP_BBREACTION_NOTIFY'            => 'Notificar',
	'ACP_BBREACTION_NOTIFY_EXPLAIN'    => 'Envia uma notificação ao autor quando há uma nova reação',

	'ACP_BBREACTION_NAME_USED'      => 'Nome já em uso',
	'ACP_BBREACTION_SAVED_LOG'      => 'Tipo de reação salvo',
	'ACP_BBREACTION_SAVED_LOG'      => 'Tipo de reação adicionado',
	'ACP_BBREACTION_SUBMIT_SUCCESS' => 'Tipo de reação salvo',
	'ACP_BBREACTION_DELETE_SUCCESS' => 'Tipo de reação e votos excluídos com sucesso',
	'ACP_BBREACTION_DELETE_LOG'     => 'Tipo de reação %s e votos excluídos com sucesso',

	'ACP_BBREACTION_USED'  => 'Votado',
	'ACP_REACTIONS'        => 'BBReaction',
	'ACP_BBREACTION_EMPTY' => 'Nenhum registro de BBReaction',

	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBREACTION_NOTICE' => '<div style="width:auto;margin:20px auto;"><p>As configurações para esta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Certifique-se de verificar a Permissão de Grupo e ajustá-la conforme necessário. As reações padrão já têm a notificação ao usuário ativada.</p></div>',

	'BBREACTION_OVERVIEW_FORUM' => 'Visão geral do fórum',
	'BBREACTION_OVERVIEW_TOPIC' => 'Visão geral do tópico',
	'BBREACTION_OVERVIEW_POSTS' => 'Visão geral das mensagens',
	'BBREACTION_OVERVIEW_USER'  => 'Visão geral do usuário',

	'ACP_BUTTON_POSITION'                       => 'Posição do botão',
	'ACP_BUTTON_POSITION_ALL'                   => 'Todas as postagens',
	'ACP_BUTTON_POSITION_FIRST_POST_ONLY'       => 'Apenas a primeira postagem',
	'ACP_BUTTON_POSITION_ALL_EXCEPT_FIRST_POST' => 'Todas exceto a primeira postagem',

	// BBEmoji
	'ACP_BBREACTION_EMOJI'         => 'BBEmoji',
	'ACP_BBREACTION_EMOJI_EXPLAIN' => 'Escolha um BBEmoji como ícone. Comece digitando :.',
	'ACP_BBREACTION_MIXED_CASE'    => 'O Multivoto não suporta uma mistura de emojis e ícones, por favor use apenas emojis ou apenas ícones, caso contrário não será exibido corretamente na página do tópico.'
]);
