<?php

/**
 * @package BBfront for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_BBFRONT'                          => 'BBfront Advanced',
	'ACP_BBFRONT_EXPLAIN'                  => 'Bem-vindo à página de configurações do BBfront Advanced. Reserva um momento para verificar algumas opções, fóruns e permissões. <br />Não te esqueças de seleccionar os tópicos a publicar na tua página BBfront, seja no modo de edição de publicação ou na vista da publicação através do botão Ajax.<br /> Os embeds do YouTube, Twitch, Vimeo, Medium e Twitter Media são incorporados automaticamente se o BBembed estiver instalado :-)',
	'ACP_BBFRONT_FORUMS'                   => 'Fóruns do BBfront',
	'ACP_BBFRONT_FORUMS_EXPLAIN'           => 'Selecciona os fóruns que o BBfront Advanced pode usar, deve existir pelo menos um fórum, caso contrário o BBfront não funcionará.',
	'ACP_BBFRONT_GROUPS'                   => 'Grupos do BBfront',
	'ACP_BBFRONT_GROUPS_EXPLAIN'           => 'Selecciona os grupos dos quais um utilizador deve ser membro, para poder publicar na página BBfront',
	'ACP_BBFRONT_NAME'                     => 'Nome da página BBfront',
	'ACP_BBFRONT_NAME_EXPLAIN'             => 'Introduz o nome da tua página BBfront',
	'ACP_BBFRONT_CHARS'                    => 'Número máximo de caracteres',
	'ACP_BBFRONT_CHARS_EXPLAIN'            => 'Caracteres no bloco da publicação antes de o texto ser truncado',
	'ACP_BBFRONT_PAGES'                    => 'Cartões por página no carregamento inicial da página',
	'ACP_BBFRONT_PAGES_EXPLAIN'            => 'Define a quantidade de cartões no carregamento inicial da página',
	'ACP_BBFRONT_PAGES_LOAD'               => 'Cartões por página ao carregar mais cartões',
	'ACP_BBFRONT_PAGES_LOAD_EXPLAIN'       => 'Cartões por página depois de o botão "carregar mais" ou o scroll infinito ser acionado',
	'USE_AVATAR'                           => 'Usar avatar na página BBfront',
	'BBFRONT_GRID_LAYOUT'                  => 'Disposição da grelha',
	'BBFRONT_GRID_LAYOUT_EXPLAIN'          => 'Selecciona a disposição de cartões preferida',
	'BBFRONT_GRID_LAYOUT_4L'               => '4 colunas, espaçamento largo',
	'BBFRONT_GRID_LAYOUT_5S'               => '5 colunas, espaçamento pequeno',
	'BBFRONT_GRID_LAYOUT_4S'               => '4 colunas, espaçamento pequeno',
	'BBFRONT_GRID_FX_FIRST'                => 'Efeito da grelha no carregamento da página',
	'BBFRONT_GRID_FX_FIRST_EXPLAIN'        => 'Selecciona a animação inicial quando os cartões carregam pela primeira vez',
	'BBFRONT_GRID_FX_LOAD'                 => 'Efeito da grelha ao carregar mais cartões',
	'BBFRONT_GRID_FX_LOAD_EXPLAIN'         => 'Selecciona uma animação para quando os cartões carregam ao clicar ou quando o scroll infinito é acionado',
	'BBFRONT_GRID_FX_HAPI'                 => 'Hapi',
	'BBFRONT_GRID_FX_AMUN'                 => 'Amun',
	'BBFRONT_GRID_FX_KEK'                  => 'Kek',
	'BBFRONT_GRID_FX_ISIS'                 => 'Isis',
	'BBFRONT_GRID_FX_MONTU'                => 'Montu',
	'BBFRONT_GRID_FX_OSIRIS'               => 'Osiris',
	'BBFRONT_GRID_FX_SATET'                => 'Satet',
	'BBFRONT_GRID_FX_ATUM'                 => 'Atum',
	'BBFRONT_GRID_FX_RA'                   => 'Ra',
	'BBFRONT_GRID_FX_SOBEK'                => 'Sobek',
	'BBFRONT_GRID_FX_PTAH'                 => 'Ptah',
	'BBFRONT_GRID_FX_BES'                  => 'Bes',
	'BBFRONT_GRID_FX_SEKER'                => 'Seker',
	'BBFRONT_GRID_FX_NUT'                  => 'Nut',
	'BBFRONT_GRID_FX_SHU'                  => 'Shu',
	'ACP_BBFRONT_INFINITE_SCROLL'          => 'Usar scroll infinito',
	'ACP_BBFRONT_INFINITE_SCROLL_EXPLAIN'  => 'Activa ou desactiva o efeito de scroll infinito. Quando activado, os cartões serão carregados automaticamente à medida que o utilizador percorrer a página para ver mais cartões.',
	'ACP_BBFRONT_AJAX_NEW_POSTS'           => 'Carregar novas publicações sem recarregar a página',
	'ACP_BBFRONT_AD_FREQUENCY'             => 'Frequência do cartão de publicidade',
	'ACP_BBFRONT_AD_FREQUENCY_EXPLAIN'     => 'Selecciona a frequência com que a publicidade ou código personalizado é exibido entre os cartões. Recomenda-se um número relativamente alto',
	'ACP_BBFRONT_AD_CONTENT'               => 'Código do anúncio',
	'ACP_BBFRONT_AD_CONTENT_EXPLAIN'       => 'Adiciona o teu código de publicidade ou código personalizado. O HTML está activado.',

	'SITESPLAT_COM'         => 'https://sitesplat.com',
	'SITESPLAT_COPY'        => '&#169; SiteSplat',
	'LICENSE_INFO'          => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'   => 'Programador',
	'ACP_NOTICE_CLOSE'      => 'Fechar',
	'ACP_BBFRONT_VERSION'   => '3.0.0',
	'ACP_LOADING'           => 'A carregar... Aguarda',

	'EXT_BBF_DESCRIPTION_PAGE' => 'Uma página inicial moderna, estilo WordPress, para o teu fórum',
	'EXT_BBF_TASKS_1'          => 'Permissões especiais de Grupo',
	'EXT_BBF_TASKS_2'          => 'Escolhe o que publicar e o formato',
	'EXT_BBF_TASKS_3'          => 'Consulta os outros addons premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'EXT_BBF_TASKS_4'          => 'Suporta incorporação de vídeo com a extensão premium BBembed',
	'EXT_BBF_TASKS_5'          => 'Disposição dinâmica em Masonry',
	'EXT_BBF_TASKS_6'          => 'Pronto para o phpBB 3.2',

	'ACP_BBTAGS_NOTICE_CLOSE' => 'Fechar',
	'NOTICE_BBTAGS'           => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=36"><strong>BBtags</strong></a> não está instalada, NÃO podes usar as Tags nos blocos publicados',
	'BBNOTICE_EMBED'          => 'A extensão <a href="https://www.phpbb.com/customise/db/extension/mediaembed"><strong>phpBB Media Embed</strong></a> não está instalada, NÃO podes usar os Cartões Media Rich nos blocos publicados',
	'NOTICE_LIKEBB'           => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> não está instalada, NÃO podes usar o sistema de Gosto/Não Gosto nos blocos publicados',
	'SS_HELPER_NOTY'          => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBFRONT_NOTICE'          => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br/>Podes adicionar cartões à página inicial ao compor uma publicação e/ou também através do pin rápido via ajax diretamente na página de visualização do tópico.</p></div>',
]);

// Description of Donations extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details' => [
		'details' => [
			'DESCRIPTION_1' => 'Fóruns seleccionáveis',
			'DESCRIPTION_2' => 'Grupos seleccionáveis',
			'DESCRIPTION_3' => 'Nome da página inicial',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para o phpBB 3.3',
		],
	],
]);
