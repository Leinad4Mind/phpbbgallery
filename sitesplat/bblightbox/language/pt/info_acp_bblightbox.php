<?php

/**
 * BBlightbox
 * @copyright (c) 2017 sitesplat.com All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_BBLIGHTBOX_EXPLAIN' => 'Bem-vindo à nova página de configurações do addon Lightbox. A partir daqui podes alterar as configurações consoante o plugin escolhido. Existem quatro plugins no total. Dois são desenvolvidos em JavaScript puro e dois dependem do jQuery. <br />Escolhe aquele que melhor se adequa às tuas necessidades!',
	'ACP_SETTINGS'           => 'Configurações',

	// General settings
	'ACP_BBLIGHTBOX_GENERAL_OPTIONS' => 'Configurações Gerais',
	'ACP_BBLIGHTBOX_ALLOW'           => 'Permitir BBlightBox',
	'ACP_BBLIGHTBOX_BBCODE_ALLOW'    => 'BBlightBox para BBcodes [IMG]',
	'ACP_BBLIGHTBOX_BBCODE_EXPLAIN'  => 'Permite o BBlightBox para imagens publicadas através do BBcode padrão IMG',
	'BBLIGHTBOX_CAPTIONS'            => 'Legendas',
	'BBLIGHTBOX_CAPTIONS_EXPLAIN'    => 'Permite legendas ou comentários nas imagens sempre que possível',
	'BBLIGHTBOX_SLIDE'               => 'Apresentação de diapositivos entre imagens',
	'BBLIGHTBOX_SLIDE_EXPLAIN'       => 'Permite criar uma apresentação de diapositivos para os anexos (BBCode [IMG] incluído) sempre que possível. <br />Isto depende do plugin escolhido e irá apresentar em diapositivos grupos de imagens, por exemplo as de XX publicação ou todas as imagens contidas em XX tópico.',
	'QUOTED_IMAGES'                  => 'Redimensionar BBcode IMG citado',
	'QUOTED_IMAGES_EXPLAIN'          => 'Permite redimensionar imagens citadas (dentro de uma citação de publicação) publicadas através do BBcode IMG',
	'RESIZED_IMAGES'                 => 'Redimensionar imagens do BBcode IMG',
	'RESIZED_IMAGES_EXPLAIN'         => 'Redimensiona as imagens do BBcode IMG padrão para xx pixels. Usa 0 para desativar',
	'ACP_BBLIGHTBOX_LAYOUT_PREVIEW'  => 'Disposição dos anexos',
	'COLUMN_LAYOUT'                  => 'Disposição dos anexos',
	'COLUMN_LAYOUT_EXPLAIN'          => 'Permite escolher uma disposição predefinida para os anexos das publicações, criando um formato mais moderno e visualmente agradável. Os BBcodes [IMG] e os anexos em linha não são afetados por esta opção, propositadamente.<small style="margin-top:-4px;margin-bottom: 14px;display: block;"><br /><strong>Disposição padrão:</strong> padrão do tema. As imagens são exibidas "tal como são". Podem ocupar até à largura total da publicação.<br /><strong>Coluna:</strong> As imagens são organizadas de forma ordenada numa coluna completa e todas com o mesmo tamanho.<br /><strong>Agrupada (média):</strong> as imagens são agrupadas em tamanho médio, com um posicionamento tipo mosaico (masonry).<br /><strong>Agrupada (pequena):</strong> As imagens são posicionadas da mesma forma que na disposição agrupada média, mas com um tamanho menor.</small>',
	'1COLLUMS'                       => 'Disposição padrão',
	'2COLLUMS'                       => 'coluna',
	'3COLLUMS'                       => 'agrupada (média)',
	'4COLLUMS'                       => 'agrupada (pequena)',

	// Plugins
	'ACP_BBLIGHTBOX_PLUGINS'        => 'Plugins',
	'ACP_BBLIGHTBOX_PLUGIN'         => 'Plugin principal da LightBox',
	'ACP_BBLIGHTBOX_PLUGIN_EXPLAIN' => 'Escolhe qual plugin desejas usar como lightbox principal. Consulta mais detalhes sobre os plugins aqui:<br /><a href="https://github.com/feimosi/baguetteBox.js" target="blank" title="">BaguetteBox (JavaScript puro)</a><br /><a href="http://fancyapps.com/fancybox/3/" target="blank" title="">Fancybox (jQuery)</a><br /><a href="https://github.com/nicolas-t/Chocolat/" target="blank" title="">Chocolat (jQuery)</a><br /><a href="http://jslightbox.felixhagspiel.de/" target="blank" title="">jsOnlyLightbox (JavaScript puro)</a><br /><a href="https://sachinchoolur.github.io/lightgallery.js/" target="blank" title="">lightgallery.js (JavaScript puro)</a>',

	// baguetteBox
	'BAGUETTEBOX_ANIMATION' => 'Animação',
	'SLIDEIN'               => 'slideIn',
	'FADEIN'                => 'fadeIn',
	'ZOOM'                  => 'Zoom',
	'ZOOM_IN_OUT'           => 'Zoom in-out',
	'NONE'                  => 'nenhuma',

	// fancybox
	'FANCYBOX_PROTECT'                 => 'Proteger imagens contra transferência',
	'FANCYBOX_PROTECT_EXLPLAIN'        => 'Impede a transferência das imagens anexadas, sempre que possível',
	'FANCYBOX_ANIMATIONEFFECT'         => 'Efeito de animação',
	'FANCYBOX_ANIMATIONEFFECT_EXPLAIN' => 'Permite um efeito de animação quando suportado',

	// Chocolat
	'CHOCOLAT_ENABLEZOOM'         => 'Ativar funcionalidade de zoom',
	'CHOCOLAT_ENABLEZOOM_EXPLAIN' => 'Permite a funcionalidade de zoom nas imagens, sempre que possível. Suporta ecrã tátil.',

	// misc stuff ext detail etc
	'BBLIGHTBOX_DESCRIPTION' => 'Um sistema LightBox moderno e poderoso para as imagens das publicações do teu fórum',
	'BBLIGHTBOX_DEVELOPERS'  => 'Programadores',
	'BBLIGHTBOX_TASKS_1'     => 'Suporte a ecrã tátil, navegação por teclado, responsivo e muito mais',
	'BBLIGHTBOX_TASKS_2'     => 'Apresentação de diapositivos',
	'BBLIGHTBOX_TASKS_3'     => 'Suporte a múltiplas LightBox',
	'BBLIGHTBOX_TASKS_4'     => 'Pronto para páginas comuns como UCP, MCP, Publicação, leitura de tópicos, etc.',
	'BBLIGHTBOX_TASKS_5'     => 'Consulta as outras extensões premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBLIGHTBOX_TASKS_6'     => 'Muito mais..!',

	'SITESPLAT_COM'               => 'https://sitesplat.com',
	'SITESPLAT_COPY'              => '&#169; SiteSplat',
	'LICENSE_INFO'                => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'         => 'Programador',
	'ACP_BBLIGHTBOX_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBLIGHTBOX_VERSION' => '1.0.6',
	'ACP_LOADING'            => 'Aguarda. A carregar...',

	// Error/success messages
	'ACP_BBLIGHTBOX_SETTING_SAVED'      => 'As configurações da BBlightBox foram guardadas',
	'SS_HELPER_NOTY'                    => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBLIGHTBOX_NOTICE'                 => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'ACP_BBLIGHTBOX_INLINE_REMOVED'     => 'Todos os anexos em linha foram movidos para a caixa de anexos padrão, por baixo da publicação.',
	'ACP_BBLIGHTBOX_THUMBNAILS_REMOVED' => 'Todas as miniaturas foram removidas. Todas as imagens são agora exibidas em tamanho real.',
	'ACP_BBLIGHTBOX_THUMBS_REASSIGNED'  => 'Todas as miniaturas foram reatribuídas. Todas as imagens que cumprem as configurações de miniatura nas configurações de anexos são agora exibidas em modo de miniatura.',

	'BBLIGHTBOX_OPTIONS'                => 'Opções de Sincronização de Anexos',
	'REMOVE_INLINE_ATTACHMENTS'         => 'Remover anexos em linha',
	'REMOVE_INLINE_ATTACHMENTS_EXPLAIN' => 'Remove todos os anexos em linha em todos os tópicos. Isto NÃO remove os anexos, apenas os move de volta para a caixa de anexos padrão, por baixo da publicação.',
	'BBLIGHTBOX_PROGRESS'               => 'Progresso: %d de %d.',
	'REMOVE_THUMBNAILS'                 => 'Remover miniaturas',
	'REMOVE_THUMBNAILS_EXPLAIN'         => 'Remove todas as miniaturas, para que quaisquer imagens existentes deixem de estar em miniatura.',
	'REASSIGN_THUMBNAILS'               => 'Reatribuir miniaturas (thumbnails)',
	'REASSIGN_THUMBNAILS_EXPLAIN'       => 'Regenerar e recriar todas as miniaturas (thumbnails).',
]);

// Description of Upload extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota de extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Até 4 diferentes lightboxes',
			'DESCRIPTION_2' => 'Apresentação de diapositivos (Slideshow)',
			'DESCRIPTION_3' => 'Legendas',
		],
		'note' => [
			'NOTICE_1' => 'pronta a atuar sobre as principais secções gerais como UCP, MCP, Publicação/Mensagem, leitura de tópicos (viewtopic) etc.',
			'NOTICE_2' => 'phpBB 3.2 pronta e compatível.',
		]
	]
]);
