<?php

/**
 * @package BBfront for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'ACP_BBFRONT'                          => 'BBfront Advanced',
	'ACP_BBFRONT_EXPLAIN'                  => 'Bem-vindo à página de configurações do BBfront Advanced. Reserve um momento para verificar algumas opções, fóruns e permissões. <br />Não se esqueça de selecionar os tópicos a publicar na sua página BBfront, seja no modo de edição de postagem ou na visualização da postagem através do botão Ajax.<br /> Os embeds do YouTube, Twitch, Vimeo, Medium e Twitter Media são incorporados automaticamente se o BBembed estiver instalado :-)',
	'ACP_BBFRONT_FORUMS'                   => 'Fóruns do BBfront',
	'ACP_BBFRONT_FORUMS_EXPLAIN'           => 'Selecione os fóruns que o BBfront Advanced pode usar, deve existir pelo menos um fórum, caso contrário o BBfront não funcionará.',
	'ACP_BBFRONT_GROUPS'                   => 'Grupos do BBfront',
	'ACP_BBFRONT_GROUPS_EXPLAIN'           => 'Selecione os grupos dos quais um usuário deve ser membro, para poder publicar na página BBfront',
	'ACP_BBFRONT_NAME'                     => 'Nome da página BBfront',
	'ACP_BBFRONT_NAME_EXPLAIN'             => 'Digite o nome da sua página BBfront',
	'ACP_BBFRONT_CHARS'                    => 'Número máximo de caracteres',
	'ACP_BBFRONT_CHARS_EXPLAIN'            => 'Caracteres no bloco da postagem antes de o texto ser truncado',
	'ACP_BBFRONT_PAGES'                    => 'Cartões por página no carregamento inicial da página',
	'ACP_BBFRONT_PAGES_EXPLAIN'            => 'Defina a quantidade de cartões no carregamento inicial da página',
	'ACP_BBFRONT_PAGES_LOAD'               => 'Cartões por página ao carregar mais cartões',
	'ACP_BBFRONT_PAGES_LOAD_EXPLAIN'       => 'Cartões por página depois de o botão "carregar mais" ou a rolagem infinita ser acionada',
	'USE_AVATAR'                           => 'Usar avatar na página BBfront',
	'BBFRONT_GRID_LAYOUT'                  => 'Layout da grade',
	'BBFRONT_GRID_LAYOUT_EXPLAIN'          => 'Selecione o layout de cartões preferido',
	'BBFRONT_GRID_LAYOUT_4L'               => '4 colunas, espaçamento largo',
	'BBFRONT_GRID_LAYOUT_5S'               => '5 colunas, espaçamento pequeno',
	'BBFRONT_GRID_LAYOUT_4S'               => '4 colunas, espaçamento pequeno',
	'BBFRONT_GRID_FX_FIRST'                => 'Efeito da grade no carregamento da página',
	'BBFRONT_GRID_FX_FIRST_EXPLAIN'        => 'Selecione a animação inicial de quando os cartões carregam pela primeira vez',
	'BBFRONT_GRID_FX_LOAD'                 => 'Efeito da grade ao carregar mais cartões',
	'BBFRONT_GRID_FX_LOAD_EXPLAIN'         => 'Selecione uma animação para quando os cartões carregam ao clicar ou quando a rolagem infinita é acionada',
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
	'ACP_BBFRONT_INFINITE_SCROLL'          => 'Usar rolagem infinita',
	'ACP_BBFRONT_INFINITE_SCROLL_EXPLAIN'  => 'Ative ou desative o efeito de rolagem infinita. Quando ativado, os cartões serão carregados automaticamente à medida que o usuário rolar a página para ver mais cartões.',
	'ACP_BBFRONT_AJAX_NEW_POSTS'           => 'Carregar novas postagens sem recarregar a página',
	'ACP_BBFRONT_AD_FREQUENCY'             => 'Frequência do cartão de publicidade',
	'ACP_BBFRONT_AD_FREQUENCY_EXPLAIN'     => 'Selecione a frequência com que a publicidade ou código personalizado é exibido entre os cartões. Recomenda-se um número relativamente alto',
	'ACP_BBFRONT_AD_CONTENT'               => 'Código do anúncio',
	'ACP_BBFRONT_AD_CONTENT_EXPLAIN'       => 'Adicione seu código de publicidade ou código personalizado. O HTML está ativado.',

	'SITESPLAT_COM'         => 'https://sitesplat.com',
	'SITESPLAT_COPY'        => '&#169; SiteSplat',
	'LICENSE_INFO'          => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'   => 'Desenvolvedor',
	'ACP_NOTICE_CLOSE'      => 'Fechar',
	'ACP_BBFRONT_VERSION'   => '3.0.0',
	'ACP_LOADING'           => 'Carregando... Aguarde',

	'EXT_BBF_DESCRIPTION_PAGE' => 'Uma página inicial moderna, estilo WordPress, para o seu fórum',
	'EXT_BBF_TASKS_1'          => 'Permissões especiais de Grupo',
	'EXT_BBF_TASKS_2'          => 'Escolha o que publicar e o formato',
	'EXT_BBF_TASKS_3'          => 'Confira os outros addons premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'EXT_BBF_TASKS_4'          => 'Suporta incorporação de vídeo com a extensão premium BBembed',
	'EXT_BBF_TASKS_5'          => 'Layout dinâmico em Masonry',
	'EXT_BBF_TASKS_6'          => 'Pronto para o phpBB 3.2',

	'ACP_BBTAGS_NOTICE_CLOSE' => 'Fechar',
	'NOTICE_BBTAGS'           => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=36"><strong>BBtags</strong></a> não está instalada, você NÃO pode usar as Tags nos blocos publicados',
	'BBNOTICE_EMBED'          => 'A extensão <a href="https://www.phpbb.com/customise/db/extension/mediaembed"><strong>phpBB Media Embed</strong></a> não está instalada, você NÃO pode usar os Cartões Media Rich nos blocos publicados',
	'NOTICE_LIKEBB'           => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> não está instalada, você NÃO pode usar o sistema de Curtir/Não Curtir nos blocos publicados',
	'SS_HELPER_NOTY'          => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBFRONT_NOTICE'          => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br/>Você pode adicionar cartões à página inicial ao compor uma postagem e/ou também através do pin rápido via ajax diretamente na página de visualização do tópico.</p></div>',
]);

// Description of Donations extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details' => [
		'details' => [
			'DESCRIPTION_1' => 'Fóruns selecionáveis',
			'DESCRIPTION_2' => 'Grupos selecionáveis',
			'DESCRIPTION_3' => 'Nome da página inicial',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para o phpBB 3.3',
		],
	],
]);
