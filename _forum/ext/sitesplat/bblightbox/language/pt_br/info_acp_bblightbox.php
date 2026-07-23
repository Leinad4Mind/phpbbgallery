<?php

/**
 * BBlightbox
 * @copyright (c) 2017 sitesplat.com All rights reserved
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
	// Titles
	'ACP_BBLIGHTBOX'         => 'BBlightBox',
	'ACP_BBLIGHTBOX_TITLE'   => 'BBlightBox',
	'ACP_BBLIGHTBOX_EXPLAIN' => 'Bem-vindo à nova página de configurações do addon Lightbox. A partir daqui você pode alterar as configurações de acordo com o plugin escolhido. Existem quatro plugins no total. Dois são desenvolvidos em JavaScript puro e dois dependem do jQuery. <br />Escolha aquele que melhor se adequa às suas necessidades!',
	'ACP_SETTINGS'           => 'Configurações',

	// General settings
	'ACP_BBLIGHTBOX_GENERAL_OPTIONS' => 'Configurações Gerais',
	'ACP_BBLIGHTBOX_ALLOW'           => 'Permitir BBlightBox',
	'ACP_BBLIGHTBOX_BBCODE_ALLOW'    => 'BBlightBox para BBcodes [IMG]',
	'ACP_BBLIGHTBOX_BBCODE_EXPLAIN'  => 'Permite o BBlightBox para imagens postadas através do BBcode padrão IMG',
	'BBLIGHTBOX_CAPTIONS'            => 'Legendas',
	'BBLIGHTBOX_CAPTIONS_EXPLAIN'    => 'Permite legendas ou comentários nas imagens sempre que possível',
	'BBLIGHTBOX_SLIDE'               => 'Slideshow entre imagens',
	'BBLIGHTBOX_SLIDE_EXPLAIN'       => 'Permite criar um slideshow para os anexos (BBCode [IMG] incluído) sempre que possível. <br />Isso depende do plugin escolhido e vai exibir em slideshow grupos de imagens, por exemplo as da postagem XX ou todas as imagens contidas no tópico XX.',
	'QUOTED_IMAGES'                  => 'Redimensionar BBcode IMG citado',
	'QUOTED_IMAGES_EXPLAIN'          => 'Permite redimensionar imagens citadas (dentro de uma citação de postagem) postadas através do BBcode IMG',
	'RESIZED_IMAGES'                 => 'Redimensionar imagens do BBcode IMG',
	'RESIZED_IMAGES_EXPLAIN'         => 'Redimensiona as imagens do BBcode IMG padrão para xx pixels. Use 0 para desativar',
	'ACP_BBLIGHTBOX_LAYOUT_PREVIEW'  => 'Layout dos anexos',
	'COLUMN_LAYOUT'                  => 'Layout dos anexos',
	'COLUMN_LAYOUT_EXPLAIN'          => 'Permite escolher um layout predefinido para os anexos das postagens, criando um formato mais moderno e visualmente agradável. Os BBcodes [IMG] e os anexos em linha não são afetados por essa opção, propositalmente.<small style="margin-top:-4px;margin-bottom: 14px;display: block;"><br /><strong>Layout padrão:</strong> padrão do tema. As imagens são exibidas "como estão". Podem ocupar até a largura total da postagem.<br /><strong>Coluna:</strong> As imagens são organizadas de forma ordenada em uma coluna completa e todas do mesmo tamanho.<br /><strong>Agrupada (média):</strong> as imagens são agrupadas em tamanho médio, com um posicionamento tipo mosaico (masonry).<br /><strong>Agrupada (pequena):</strong> As imagens são posicionadas da mesma forma que no layout agrupado médio, mas com tamanho menor.</small>',
	'1COLLUMS'                       => 'Layout padrão',
	'2COLLUMS'                       => 'coluna',
	'3COLLUMS'                       => 'agrupada (média)',
	'4COLLUMS'                       => 'agrupada (pequena)',

	// Plugins
	'ACP_BBLIGHTBOX_PLUGINS'        => 'Plugins',
	'ACP_BBLIGHTBOX_PLUGIN'         => 'Plugin principal da LightBox',
	'ACP_BBLIGHTBOX_PLUGIN_EXPLAIN' => 'Escolha qual plugin você deseja usar como lightbox principal. Veja mais detalhes sobre os plugins aqui:<br /><a href="https://github.com/feimosi/baguetteBox.js" target="blank" title="">BaguetteBox (JavaScript puro)</a><br /><a href="http://fancyapps.com/fancybox/3/" target="blank" title="">Fancybox (jQuery)</a><br /><a href="https://github.com/nicolas-t/Chocolat/" target="blank" title="">Chocolat (jQuery)</a><br /><a href="http://jslightbox.felixhagspiel.de/" target="blank" title="">jsOnlyLightbox (JavaScript puro)</a><br /><a href="https://sachinchoolur.github.io/lightgallery.js/" target="blank" title="">lightgallery.js (JavaScript puro)</a>',

	// baguetteBox
	'BAGUETTEBOX_ANIMATION' => 'Animação',
	'SLIDEIN'               => 'slideIn',
	'FADEIN'                => 'fadeIn',
	'ZOOM'                  => 'Zoom',
	'ZOOM_IN_OUT'           => 'Zoom in-out',
	'NONE'                  => 'nenhuma',

	// fancybox
	'FANCYBOX_PROTECT'                 => 'Proteger imagens contra download',
	'FANCYBOX_PROTECT_EXLPLAIN'        => 'Impede o download das imagens anexadas, sempre que possível',
	'FANCYBOX_ANIMATIONEFFECT'         => 'Efeito de animação',
	'FANCYBOX_ANIMATIONEFFECT_EXPLAIN' => 'Permite um efeito de animação quando suportado',

	// Chocolat
	'CHOCOLAT_ENABLEZOOM'         => 'Ativar funcionalidade de zoom',
	'CHOCOLAT_ENABLEZOOM_EXPLAIN' => 'Permite a funcionalidade de zoom nas imagens, sempre que possível. Suporta tela sensível ao toque.',

	// misc stuff ext detail etc
	'BBLIGHTBOX_DESCRIPTION' => 'Um sistema LightBox moderno e poderoso para as imagens das postagens do seu fórum',
	'BBLIGHTBOX_DEVELOPERS'  => 'Desenvolvedores',
	'BBLIGHTBOX_TASKS_1'     => 'Suporte a tela sensível ao toque, navegação por teclado, responsivo e muito mais',
	'BBLIGHTBOX_TASKS_2'     => 'Slideshow',
	'BBLIGHTBOX_TASKS_3'     => 'Suporte a múltiplas LightBox',
	'BBLIGHTBOX_TASKS_4'     => 'Pronto para páginas comuns como UCP, MCP, Postagem, leitura de tópicos, etc.',
	'BBLIGHTBOX_TASKS_5'     => 'Confira as outras extensões premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBLIGHTBOX_TASKS_6'     => 'Muito mais..!',

	'SITESPLAT_COM'               => 'https://sitesplat.com',
	'SITESPLAT_COPY'              => '&#169; SiteSplat',
	'LICENSE_INFO'                => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'         => 'Desenvolvedor',
	'ACP_BBLIGHTBOX_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBLIGHTBOX_VERSION' => '1.0.6',
	'ACP_LOADING'            => 'Aguarde. Carregando...',

	// Error/success messages
	'ACP_BBLIGHTBOX_SETTING_SAVED'      => 'As configurações da BBlightBox foram salvas',
	'SS_HELPER_NOTY'                    => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBLIGHTBOX_NOTICE'                 => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'ACP_BBLIGHTBOX_INLINE_REMOVED'     => 'Todos os anexos em linha foram movidos para a caixa de anexos padrão, abaixo da postagem.',
	'ACP_BBLIGHTBOX_THUMBNAILS_REMOVED' => 'Todas as miniaturas foram removidas. Todas as imagens são exibidas em tamanho real agora.',
	'ACP_BBLIGHTBOX_THUMBS_REASSIGNED'  => 'Todas as miniaturas foram reatribuídas. Todas as imagens que atendem às configurações de miniatura nas configurações de anexos agora são exibidas em modo de miniatura.',

	'BBLIGHTBOX_OPTIONS'                => 'Opções de Sincronização de Anexos',
	'REMOVE_INLINE_ATTACHMENTS'         => 'Remover anexos em linha',
	'REMOVE_INLINE_ATTACHMENTS_EXPLAIN' => 'Remove todos os anexos em linha em todos os tópicos. Isso NÃO remove os anexos, apenas os move de volta para a caixa de anexos padrão, abaixo da postagem.',
	'BBLIGHTBOX_PROGRESS'               => 'Progresso: %d de %d.',
	'REMOVE_THUMBNAILS'                 => 'Remover miniaturas',
	'REMOVE_THUMBNAILS_EXPLAIN'         => 'Remove todas as miniaturas, para que quaisquer imagens existentes deixem de ser miniaturas.',
	'REASSIGN_THUMBNAILS'               => 'Reatribuir miniaturas (thumbnails)',
	'REASSIGN_THUMBNAILS_EXPLAIN'       => 'Regenerar e recriar todas as miniaturas (thumbnails).',
]);

// Description of Upload extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota de extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Até 4 lightboxes diferentes',
			'DESCRIPTION_2' => 'Slideshow',
			'DESCRIPTION_3' => 'Legendas',
		],
		'note' => [
			'NOTICE_1' => 'pronta para atuar nas principais seções gerais como UCP, MCP, Postagem/Mensagem, leitura de tópicos (viewtopic), etc.',
			'NOTICE_2' => 'pronta e compatível com o phpBB 3.2.',
		]
	]
]);
