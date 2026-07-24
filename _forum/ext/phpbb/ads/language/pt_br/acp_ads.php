<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'ADD_AD'                    => 'Adicionar anúncio',
	'BACK_TO_ADS'               => 'Voltar a gerir anúncios',
	'OWNER'                     => 'Proprietário',
	'VIEWS'                     => 'Visualizações',
	'CLICKS'                    => 'Cliques',
	'VIEWS_LIMIT'               => 'Limite de visualizações',
	'CLICKS_LIMIT'              => 'Limite de cliques',
	'START_DATE'                => 'Data de início',
	'END_DATE'                  => 'Data de fim',
	'PRIORITY'                  => 'Prioridade',
	'PRIORITY_EXPLAIN'          => 'Prioridade superior significa maior probabilidade de ser exibido (dependendo também de quantos anúncios existem no mesmo local com a mesma prioridade). Numa escala de 1 a 10.',
	'AD_ADDED'                  => 'O anúncio foi adicionado com sucesso.',
	'AD_EDITED'                 => 'O anúncio foi modificado com sucesso.',
	'AD_DELETED'                => 'O anúncio foi eliminado com sucesso.',
	'ENABLE_VISUAL_DEMO'        => 'Habilitar demonstração visual dos locais',
	'BASIC_SETTINGS'            => 'Configurações Básicas',
	'AD_NAME'                   => 'Nome do anúncio',
	'AD_CODE'                   => 'Código do anúncio',
	'AD_CODE_EXPLAIN'           => 'Pode usar o código <code>{BOARD_URL}</code> no URL do link. Para contar cliques (se ativado nas configurações), adicione a classe <code>phpbb-ads-link</code> ou o atributo especial <code>data-phpbb-ads-link</code> nas suas tags <code>&lt;a&gt;</code>.<br /><br />Para o AdSense e scripts semelhantes não precisa de contar os cliques desta forma. Adicione <code>&lt;script ...&gt;</code> como habitualmente.<br /><br />Nota: Se o código do seu anúncio colocar cookies, coletar dados do usuário ou rastrear o comportamento do usuário (por exemplo, anúncios do Google AdSense ou outras redes publicitárias de terceiros), você deve habilitar a <strong>Divulgação de Publicidade</strong> no painel <strong>Configurações de Gestão de Anúncios</strong> para garantir a conformidade. Em caso de dúvida, recomenda-se habilitá-la.',
	'AD_NOTE'                   => 'Nota',
	'AD_NOTE_EXPLAIN'           => 'Opcionalmente pode adicionar uma nota. Visível apenas no ACP.',
	'AD_ENABLED'                => 'Anúncio ativado',
	'DISPLAY_SETTINGS'          => 'Configurações de Exibição',
	'AD_OWNER'                  => 'Proprietário do anúncio',
	'AD_OWNER_EXPLAIN'          => 'Insira o nome de usuário se este anúncio pertencer a alguém. O proprietário poderá ver as estatísticas deste anúncio no UCP.',
	'AD_LOCATIONS'              => 'Locais do anúncio',
	'AD_LOCATIONS_EXPLAIN'      => 'Selecione os locais onde este anúncio deve ser exibido. Use CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar mais do que um local.',
	'DISPLAY_GROUPS'            => 'Mostrar apenas a grupos',
	'DISPLAY_GROUPS_EXPLAIN'    => 'Anúncio será mostrado apenas a membros dos grupos selecionados. Deixe vazio para mostrar a todos. Use CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar/desselecionar mais do que um.',
	'DISPLAY_FORUMS'            => 'Mostrar apenas nos fóruns',
	'DISPLAY_FORUMS_EXPLAIN'    => 'Anúncio será mostrado apenas nos fóruns selecionados. Deixe vazio para mostrar em todos. Use CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar/desselecionar mais do que um.',
	'AD_GROUPS_EXCLUDE'         => 'Inverter seleção de grupos',
	'AD_FORUMS_EXCLUDE'         => 'Inverter seleção de fóruns',
	'AD_LIMITS'                 => 'Limites do Anúncio',
	'AD_VIEWS_LIMIT'            => 'Limite de visualizações',
	'AD_VIEWS_LIMIT_EXPLAIN'    => 'O anúncio ficará automaticamente inativo após atingir este número de visualizações. Insira 0 para desabilitar o limite.',
	'AD_CLICKS_LIMIT'           => 'Limite de cliques',
	'AD_CLICKS_LIMIT_EXPLAIN'   => 'O anúncio ficará automaticamente inativo após atingir este número de cliques. Insira 0 para desabilitar o limite. Atenção, isto não afeta o AdSense e scripts semelhantes!',
	'AD_START_DATE'             => 'Data de Início',
	'AD_START_DATE_EXPLAIN'     => 'Defina a data a partir da qual o anúncio pode começar a ser exibido (a partir das 00:00). O anúncio ainda precisa ser ativado manualmente para aparecer. Se nenhuma data for definida, o anúncio pode ser exibido assim que for ativado.',
	'AD_END_DATE'               => 'Data de Fim',
	'AD_END_DATE_EXPLAIN'       => 'Defina a data em que o anúncio deixará de ser exibido automaticamente (às 00:00). Se nenhuma data for definida, o anúncio permanecerá ativo até ser desativado manualmente.',
	'AD_CENTERING'              => 'Anúncio centrado',
	'AD_CENTERING_EXPLAIN'      => 'Alinhar este anúncio ao centro do espaço disponível.',
	'NO_AD_NAME'                => 'Tem de especificar um nome para o anúncio.',
	'NO_AD_CODE'                => 'Tem de fornecer o código do anúncio.',
	'NO_AD_LOCATIONS'           => 'Tem de selecionar pelo menos um local para o anúncio.',
	'INVALID_OWNER'             => 'Não existe nenhum usuário com esse nome.',
	'CAT_TOP_OF_PAGE'           => 'Topo da página',
	'CAT_BOTTOM_OF_PAGE'        => 'Fundo da página',
	'CAT_IN_POSTS'              => 'Nas mensagens',
	'CAT_OTHER'                 => 'Outro',
	'CAT_INTERACTIVE'           => 'Interativo',
	'CAT_SPECIAL'               => 'Especial',
	'ADBLOCKER_LEGEND'          => 'Bloqueadores de Anúncios',
	'ADBLOCKER_MESSAGE'         => 'Mensagem de bloqueador detetado',
	'ADBLOCKER_MESSAGE_EXPLAIN' => 'Mostra uma mensagem a visitantes usando bloqueadores, pedindo ou exigindo que os desativem. Se exigir, eles não poderão usar o fórum até o desativarem.',
	'ADBLOCKER_MODES'           => [
		0 => 'Permitir bloqueadores de anúncios',
		1 => 'Pedir aos visitantes para desativarem bloqueadores',
		2 => 'Exigir que os visitantes desativem bloqueadores',
	],
	'CLICKS_VIEWS_LEGEND'   => 'Estatísticas e Rastreio',
	'ENABLE_VIEWS'          => 'Contar visualizações',
	'ENABLE_VIEWS_EXPLAIN'  => 'Permite contar quantas vezes o anúncio foi exibido. Adiciona carga extra ao servidor, se não precisar, desative.',
	'ENABLE_CLICKS'         => 'Contar cliques',
	'ENABLE_CLICKS_EXPLAIN' => 'Permite contar quantas vezes o anúncio foi clicado. Adiciona carga extra ao servidor, se não precisar, desative.',
	'HIDE_GROUPS'           => 'Ocultar anúncios para grupos',
	'HIDE_GROUPS_EXPLAIN'   => 'Membros dos grupos selecionados não verão o anúncio. Use CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar mais do que um grupo.',
	'SHOW_AGREEMENT'        => 'Divulgação de publicidade',
	'SHOW_AGREEMENT_EXPLAIN' => 'Mostra detalhes na Política de Privacidade sobre como as tecnologias de publicidade e rastreamento de terceiros são utilizadas neste fórum. Esta divulgação deve ser habilitada se os anúncios do seu fórum coletarem ou rastrearem informações dos usuários.',
	'ACP_AD_SETTINGS_SAVED' => 'Configurações de gestão de anúncios guardadas.',
]);
