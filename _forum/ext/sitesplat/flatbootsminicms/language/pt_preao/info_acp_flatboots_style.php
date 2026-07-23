<?php

/**
 * @package language for phpBB.
 * common [English]
 * @version 1.0.1
 * @copyright (c) 2013 SiteSplat, (c) ThemeSplat
 * @license htp://www.sitesplat.com/
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'TRANSLATION_INFO' => 'Traduzido por <a href="https://sitesplat.com/">ThemeSplat</a>.',

	'ABOUT_US_TITLE'        => 'Título da secção Quem Somos (About us)',
	'ABOUT_US'              => 'Corpo do texto da secção Quem Somos (About us)',
	'TEASER_TITLE'          => 'Título do teaser',
	'TEASER_TEXT'           => 'Texto do teaser',
	'GOOGLE_ANALYTICS'      => 'Google Analytics',
	'TWITTER_SCREEN_NAME'   => 'Nome de utilizador (screen name) do Twitter',
	'TWITTER_ID'            => 'Twitter ID',
	'ADSENSE_HEADER'        => 'Adsense Cabeçalho (Header)',
	'ADSENSE_FOOTER'        => 'Adsense Rodapé (Footer)',
	'ADSENSE_TOPIC'         => 'Adsense Tópico (Topic)',
	'LOGO_TEXT'             => 'Texto do Logótipo',
	'HIDE_HEADER'           => 'Ocultar Sub-cabeçalho',
	'HIDE_FOOTER'           => 'Ocultar Rodapé',
	'ENABLE_POPUP_LOGIN'    => 'Activar Login Modal',
	'AVATAR_EFFECT'         => 'Efeitos de Avatar no Tópico',
	'MINI_PROFILE_POSITION' => 'Posição do Mini Perfil do Utilizador',

	'CALL_ENABLED'         => 'Activar barra de Chamada para Acção (CtA)',
	'CALL_ONLY_REGISTERED' => 'Exibir a barra CtA apenas para utilizadores registados',
	'CALL_TEXT'            => 'Texto da CtA',
	'CALL_BUTTON_TEXT'     => 'Texto do botão da CtA',
	'CALL_LINK'            => 'URL do botão da CtA',

	// Descriptions for Config page
	'ABOUT_US_TITLE_EXPLAIN'        => 'Introduz o título do bloco Quem Somos.',
	'ABOUT_US_EXPLAIN'              => 'Introduz o texto do corpo do bloco Quem Somos. É aceite HTML básico.',
	'TEASER_TITLE_EXPLAIN'          => 'Introduz o texto do título do teaser exibido no cabeçalho do fórum. Deixa em branco para usar o título padrão. Nota que só é permitido texto simples.',
	'TEASER_TEXT_EXPLAIN'           => 'Introduz o texto do teaser exibido no cabeçalho do fórum. Deixa em branco para usar o texto padrão. Nota que só é permitido texto simples.',
	'GOOGLE_ANALYTICS_EXPLAIN'      => 'Introduz o código completo do Google Analytics, incluindo as tags de script.',
	'TWITTER_SCREEN_NAME_EXPLAIN'   => 'Introduz o teu nome de utilizador (screen name) do Twitter.',
	'TWITTER_ID_EXPLAIN'            => 'Introduz o número da tua ID do Twitter. Consulta a documentação para saberes como o obter.',
	'ADSENSE_HEADER_EXPLAIN'        => 'Introduz o teu código do Google Adsense ou o código HTML do teu banner. Será exibido na secção do cabeçalho do fórum.',
	'ADSENSE_FOOTER_EXPLAIN'        => 'Introduz o teu código do Google Adsense ou o código HTML do teu banner. Será exibido na secção do rodapé do fórum.',
	'ADSENSE_TOPIC_EXPLAIN'         => 'Introduz o teu código do Google Adsense ou o código HTML do teu banner. Será exibido a seguir à primeira publicação na página do tópico.',
	'LOGO_TEXT_EXPLAIN'             => 'Introduz o texto do teu logótipo.',
	'HIDE_HEADER_EXPLAIN'           => 'Oculta a secção do sub-cabeçalho onde é exibida a barra de pesquisa.',
	'HIDE_FOOTER_EXPLAIN'           => 'Oculta o bloco do rodapé e todos os elementos que contém.',
	'ENABLE_POPUP_LOGIN_EXPLAIN'    => 'Activa o login em modo modal no fórum.',
	'AVATAR_EFFECT_EXPLAIN'         => 'Altera o estilo da moldura do avatar.',
	'MINI_PROFILE_POSITION_EXPLAIN' => 'Altera a posição do mini perfil do utilizador nos tópicos.',

	'FLATBOOTS_STYLE_TITLE'   => 'FLATBOOTS Mini CMS',
	'FLATBOOTS_STYLE_CONFIG'  => 'Configuração Geral',
	'FLATBOOTS_STYLE_BUTTONS' => 'Configurações do Menu do Cabeçalho',
	'FLATBOOTS_STYLE_UPLOAD'  => 'Logótipo & Imagem de Fundo',
	'FLATBOOTS_STYLE_LINKS'   => 'Ligações Favoritas',
	'FLATBOOTS_STYLE_SOCIAL'  => 'Redes Sociais',
	'FLATBOOTS_STYLE_CSS'     => 'CSS Personalizado',

	'FLATBOOTS_STYLE_ADD_BUTTON'  => 'Adicionar Novo Botão',
	'FLATBOOTS_STYLE_EDIT_BUTTON' => 'Editar Botão',
	'MENU_BUTTON_NAME'            => 'Nome do Botão',
	'MENU_BUTTON_NAME_EXPLAIN'    => 'Podes usar texto simples ou uma variável de idioma, como por exemplo {L_PRIVATE_MESSAGES}',
	'MENU_BUTTON_DESC'            => 'Descrição do Botão',
	'MENU_BUTTON_DESC_EXPLAIN'    => 'Texto exibido por baixo do título do botão',
	'MENU_BUTTON_URL'             => 'URL',
	'MENU_BUTTON_ICON_EXPLAIN'    => 'Só é usado se o botão/ligação fizer parte de um botão principal',
	'MENU_BUTTON_URL_EXPLAIN'     => 'Podes usar um endereço URL, incluindo o protocolo https://, ou uma variável de template, como por exemplo {U_PRIVATEMSGS}. Podes encontrar as variáveis de template disponíveis no ficheiro includes/functions.php, por volta da linha 4545',
	'MENU_DISPLAY'                => 'Exibir o Botão',
	'MENU_EXTERNAL'               => 'A ligação irá abrir numa nova janela',
	'MENU_ONLY_REGISTERED'        => 'Exibir apenas para Utilizadores Registados',
	'MENU_ONLY_GUEST'             => 'Exibir apenas para Visitantes',
	'MENU_BUTTON_PARENT'          => 'Botão Principal',
	'MENU_BUTTON_PARENT_EXPLAIN'  => 'Selecciona o botão principal se quiseres criar uma secção em menu suspenso',
	'MOVE_BUTTON_WITH_SUBS'       => 'Este botão não pode ser um sub-botão porque já contém sub-botões.',
	'MENU_NAV'                    => 'Menu',
	'MENU_ICON'                   => 'Ícone',
	'DELETE_BUTTON_CONFIRM'       => 'Tens a certeza de que queres eliminar este Botão?',
	'DELETE_SUBBUTTONS_CONFIRM'   => 'Tens a certeza de que queres eliminar este Botão e todos os seus sub-botões?',
	'NO_BUTTONS'                  => 'Não existe nenhum Botão para gerir',
	'NO_SUBBUTTONS'               => 'Não existe nenhum sub-botão para gerir',
	'BUTTON_UPDATED'              => 'O Botão foi actualizado com sucesso',
	'BUTTON_ADDED'                => 'O novo botão foi adicionado com sucesso',

	'ENABLE_CUSTOM_LINKS'         => 'Activar Botão de Extensões Padrão no Menu',
	'ENABLE_CUSTOM_LINKS_EXPLAIN' => 'Esta opção activa ou desativa o botão do menu principal onde são normalmente adicionadas todas as ligações de extensões padrão através do sistema de eventos do phpBB.',
	'CONFIGURATION_UPDATED'       => 'Configuração actualizada com sucesso.',

	'IMG_UPLOADED'       => 'Imagem enviada com sucesso',
	'SELECT_IMAGE'       => 'Seleccionar Imagem',
	'IMG_UPLOAD_EXPLAIN' => 'As extensões permitidas são png, jpg, svg, jpeg e gif.',
	'IMG_UPLOAD_ERROR'   => 'Apenas são permitidas as extensões png, jpg, jpeg, svg e gif.',

	'IMAGE_LOGO'         => 'Logótipo do site',
	'IMAGE_BG'           => 'Imagem de fundo do fórum',
	'CHECK_TO_DELETE'    => 'Assinala para eliminar e depois clica no botão de eliminar',
	'IMAGE_DELETED'      => 'Imagem eliminada com sucesso',
	'CHECK_TO_UPLOAD_BG' => 'Assinala apenas para enviar a imagem de fundo do fórum (não necessário para o logótipo do site)',

	'FLATBOOTS_STYLE_ADD_LINK'  => 'Adicionar ligação',
	'FLATBOOTS_STYLE_EDIT_LINK' => 'Editar ligação',
	'MENU_LINK_NAME'            => 'Nome da ligação',
	'MENU_LINK_NAME_EXPLAIN'    => 'Podes usar texto simples ou uma variável de idioma, como por exemplo {L_PRIVATE_MESSAGES}',
	'MENU_LINK_URL'             => 'URL',
	'MENU_LINK_URL_EXPLAIN'     => 'Podes usar um endereço URL, incluindo o protocolo https://, ou uma variável de template, como por exemplo {U_PRIVATEMSGS}. Podes encontrar as variáveis de template disponíveis no ficheiro includes/functions.php, por volta da linha 4545',
	'MENU_LINK_DISPLAY'         => 'Exibir a ligação',
	'MENU_LINK_EXTERNAL'        => 'A ligação irá abrir numa nova janela',
	'MENU_LINK_ONLY_REGISTERED' => 'Exibir apenas para utilizadores registados',
	'MENU_LINK_ONLY_GUEST'      => 'Exibir apenas para visitantes',
	'MENU_LINK_NAV'             => 'Ligações',
	'MENU_LINK_ICON'            => 'Ícone',
	'DELETE_LINK_CONFIRM'       => 'Tens a certeza de que queres eliminar esta Ligação?',
	'NO_LINKS'                  => 'Não existe nenhuma ligação para gerir',
	'LINK_UPDATED'              => 'Ligação actualizada com sucesso',
	'LINK_ADDED'                => 'Nova ligação adicionada com sucesso',

	'FLATBOOTS_STYLE_ADD_SOCIAL'  => 'Adicionar Rede Social',
	'FLATBOOTS_STYLE_EDIT_SOCIAL' => 'Editar Rede Social',
	'MENU_SOCIAL_NAME'            => 'Nome da Rede Social',
	'MENU_SOCIAL_NAME_EXPLAIN'    => 'Podes usar texto simples ou uma variável de idioma, como por exemplo {L_PRIVATE_MESSAGES}',
	'MENU_SOCIAL_URL'             => 'URL',
	'MENU_SOCIAL_URL_EXPLAIN'     => 'Podes usar um endereço URL, incluindo o protocolo https://, ou uma variável de template, como por exemplo {U_PRIVATEMSGS}. Podes encontrar as variáveis de template disponíveis no ficheiro includes/functions.php, por volta da linha 4545',
	'MENU_SOCIAL_DISPLAY'         => 'Exibir a rede social',
	'MENU_SOCIAL_ONLY_REGISTERED' => 'Exibir apenas para Utilizadores Registados',
	'MENU_SOCIAL_ONLY_GUEST'      => 'Exibir apenas para Visitantes',
	'MENU_SOCIAL_NAV'             => 'Redes Sociais',
	'DELETE_SOCIAL_CONFIRM'       => 'Tens a certeza de que queres eliminar esta Rede Social?',
	'NO_SOCIALS'                  => 'Não existe nenhuma rede social para gerir',
	'SOCIAL_UPDATED'              => 'Rede social actualizada com sucesso',
	'SOCIAL_ADDED'                => 'Nova rede social adicionada com sucesso',

	'ENABLE_CUSTOM_CSS'         => 'Activar CSS personalizado',
	'ENABLE_CUSTOM_CSS_EXPLAIN' => 'Selecciona "Sim" para activar o uso do ficheiro custom.css.',
	'SELECTED_FILE'             => 'Ficheiro seleccionado',
	'SELECTED_FILE_EXPLAIN'     => 'Nota que submeter este formulário pode alterar o teu ficheiro custom.css de forma inesperada. Devido a limitações de processamento, todas as barras invertidas serão removidas e os caracteres especiais de HTML (como &amp;nbsp; e semelhantes) serão substituídos pelo seu carácter original. Se precisares de uma edição mais avançada, usa FTP para editar o ficheiro diretamente. Podes encontrar o ficheiro em styles/FLATBOOTS/theme/custom.css.',
	'CSS_UPDATED'               => 'CSS actualizado com sucesso.',
]);
