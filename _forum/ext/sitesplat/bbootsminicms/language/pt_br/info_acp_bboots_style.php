<?php

/**
 * @package language for phpBB.
 * common [English]
 * @version 1.0.1
 * @copyright (c) 2013 SiteSplat, (c) ThemeSplat
 * @license htp://www.sitesplat.com/
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
	'TRANSLATION_INFO' => 'Traduzido por <a href="https://sitesplat.com/">ThemeSplat</a>.',

	'ABOUT_US_TITLE'        => 'Título da seção Sobre Nós (About us)',
	'ABOUT_US'              => 'Corpo do texto da seção Sobre Nós (About us)',
	'TEASER_TITLE'          => 'Título do teaser',
	'TEASER_TEXT'           => 'Texto do teaser',
	'GOOGLE_ANALYTICS'      => 'Google Analytics',
	'TWITTER_SCREEN_NAME'   => 'Nome de usuário (screen name) do Twitter',
	'TWITTER_ID'            => 'Twitter ID',
	'ADSENSE_HEADER'        => 'Adsense Cabeçalho (Header)',
	'ADSENSE_FOOTER'        => 'Adsense Rodapé (Footer)',
	'ADSENSE_TOPIC'         => 'Adsense Tópico (Topic)',
	'LOGO_TEXT'             => 'Texto do Logotipo',
	'HIDE_HEADER'           => 'Ocultar Sub-cabeçalho',
	'HIDE_FOOTER'           => 'Ocultar Rodapé',
	'ENABLE_POPUP_LOGIN'    => 'Ativar Login Modal',
	'AVATAR_EFFECT'         => 'Efeitos de Avatar no Tópico',
	'MINI_PROFILE_POSITION' => 'Posição do Mini Perfil do Usuário',

	'CALL_ENABLED'         => 'Ativar barra de Chamada para Ação (CtA)',
	'CALL_ONLY_REGISTERED' => 'Exibir a barra CtA apenas para usuários registrados',
	'CALL_TEXT'            => 'Texto da CtA',
	'CALL_BUTTON_TEXT'     => 'Texto do botão da CtA',
	'CALL_LINK'            => 'URL do botão da CtA',

	// Descriptions for Config page
	'ABOUT_US_TITLE_EXPLAIN'        => 'Digite o título do bloco Sobre Nós.',
	'ABOUT_US_EXPLAIN'              => 'Digite o texto do corpo do bloco Sobre Nós. É aceito HTML básico.',
	'TEASER_TITLE_EXPLAIN'          => 'Digite o texto do título do teaser exibido no cabeçalho do fórum. Deixe em branco para usar o título padrão. Observe que só é permitido texto simples.',
	'TEASER_TEXT_EXPLAIN'           => 'Digite o texto do teaser exibido no cabeçalho do fórum. Deixe em branco para usar o texto padrão. Observe que só é permitido texto simples.',
	'GOOGLE_ANALYTICS_EXPLAIN'      => 'Digite o código completo do Google Analytics, incluindo as tags de script.',
	'TWITTER_SCREEN_NAME_EXPLAIN'   => 'Digite o seu nome de usuário (screen name) do Twitter.',
	'TWITTER_ID_EXPLAIN'            => 'Digite o número da sua ID do Twitter. Consulte a documentação para saber como obtê-lo.',
	'ADSENSE_HEADER_EXPLAIN'        => 'Digite o seu código do Google Adsense ou o código HTML do seu banner. Será exibido na seção do cabeçalho do fórum.',
	'ADSENSE_FOOTER_EXPLAIN'        => 'Digite o seu código do Google Adsense ou o código HTML do seu banner. Será exibido na seção do rodapé do fórum.',
	'ADSENSE_TOPIC_EXPLAIN'         => 'Digite o seu código do Google Adsense ou o código HTML do seu banner. Será exibido logo após a primeira postagem na página do tópico.',
	'LOGO_TEXT_EXPLAIN'             => 'Digite o texto do seu logotipo.',
	'HIDE_HEADER_EXPLAIN'           => 'Oculta a seção do sub-cabeçalho onde é exibida a barra de pesquisa.',
	'HIDE_FOOTER_EXPLAIN'           => 'Oculta o bloco do rodapé e todos os elementos que ele contém.',
	'ENABLE_POPUP_LOGIN_EXPLAIN'    => 'Ativa o login em modo modal no fórum.',
	'AVATAR_EFFECT_EXPLAIN'         => 'Altera o estilo da moldura do avatar.',
	'MINI_PROFILE_POSITION_EXPLAIN' => 'Altera a posição do mini perfil do usuário nos tópicos.',

	'BBOOTS_STYLE_TITLE'   => 'BBOOTS Mini CMS',
	'BBOOTS_STYLE_CONFIG'  => 'Configuração Geral',
	'BBOOTS_STYLE_BUTTONS' => 'Configurações do Menu do Cabeçalho',
	'BBOOTS_STYLE_UPLOAD'  => 'Logotipo & Imagem de Fundo',
	'BBOOTS_STYLE_LINKS'   => 'Links Favoritos',
	'BBOOTS_STYLE_SOCIAL'  => 'Redes Sociais',
	'BBOOTS_STYLE_CSS'     => 'CSS Personalizado',

	'BBOOTS_STYLE_ADD_BUTTON'    => 'Adicionar Novo Botão',
	'BBOOTS_STYLE_EDIT_BUTTON'   => 'Editar Botão',
	'MENU_BUTTON_NAME'           => 'Nome do Botão',
	'MENU_BUTTON_NAME_EXPLAIN'   => 'Você pode usar texto simples ou uma variável de idioma, como por exemplo {L_PRIVATE_MESSAGES}',
	'MENU_BUTTON_DESC'           => 'Descrição do Botão',
	'MENU_BUTTON_DESC_EXPLAIN'   => 'Texto exibido abaixo do título do botão',
	'MENU_BUTTON_URL'            => 'URL',
	'MENU_BUTTON_ICON_EXPLAIN'   => 'Só é usado se o botão/link fizer parte de um botão principal',
	'MENU_BUTTON_URL_EXPLAIN'    => 'Você pode usar um endereço URL, incluindo o protocolo https://, ou uma variável de template, como por exemplo {U_PRIVATEMSGS}. Você pode encontrar as variáveis de template disponíveis no arquivo includes/functions.php, por volta da linha 4545',
	'MENU_DISPLAY'               => 'Exibir o Botão',
	'MENU_EXTERNAL'              => 'O link será aberto em uma nova janela',
	'MENU_ONLY_REGISTERED'       => 'Exibir apenas para Usuários Registrados',
	'MENU_ONLY_GUEST'            => 'Exibir apenas para Visitantes',
	'MENU_BUTTON_PARENT'         => 'Botão Principal',
	'MENU_BUTTON_PARENT_EXPLAIN' => 'Selecione o botão principal se quiser criar uma seção em menu suspenso',
	'MOVE_BUTTON_WITH_SUBS'      => 'Este botão não pode ser um sub-botão porque já contém sub-botões.',
	'MENU_NAV'                   => 'Menu',
	'MENU_ICON'                  => 'Ícone',
	'DELETE_BUTTON_CONFIRM'      => 'Tem certeza de que quer excluir este Botão?',
	'DELETE_SUBBUTTONS_CONFIRM'  => 'Tem certeza de que quer excluir este Botão e todos os seus sub-botões?',
	'NO_BUTTONS'                 => 'Não existe nenhum Botão para gerenciar',
	'NO_SUBBUTTONS'              => 'Não existe nenhum sub-botão para gerenciar',
	'BUTTON_UPDATED'             => 'O Botão foi atualizado com sucesso',
	'BUTTON_ADDED'               => 'O novo botão foi adicionado com sucesso',

	'ENABLE_CUSTOM_LINKS'         => 'Ativar Botão de Extensões Padrão no Menu',
	'ENABLE_CUSTOM_LINKS_EXPLAIN' => 'Esta opção ativa ou desativa o botão do menu principal onde normalmente são adicionados todos os links de extensões padrão através do sistema de eventos do phpBB.',
	'CONFIGURATION_UPDATED'       => 'Configuração atualizada com sucesso.',

	'IMG_UPLOADED'       => 'Imagem enviada com sucesso',
	'SELECT_IMAGE'       => 'Selecionar Imagem',
	'IMG_UPLOAD_EXPLAIN' => 'As extensões permitidas são png, jpg, jpeg e gif.',
	'IMG_UPLOAD_ERROR'   => 'Somente são permitidas as extensões png, jpg, jpeg e gif.',

	'IMAGE_LOGO'         => 'Logotipo do site',
	'IMAGE_BG'           => 'Imagem de fundo do fórum',
	'CHECK_TO_DELETE'    => 'Marque para excluir e depois clique no botão de excluir',
	'IMAGE_DELETED'      => 'Imagem excluída com sucesso',
	'CHECK_TO_UPLOAD_BG' => 'Marque apenas para enviar a imagem de fundo do fórum (não necessário para o logotipo do site)',

	'BBOOTS_STYLE_ADD_LINK'     => 'Adicionar link',
	'BBOOTS_STYLE_EDIT_LINK'    => 'Editar link',
	'MENU_LINK_NAME'            => 'Nome do link',
	'MENU_LINK_NAME_EXPLAIN'    => 'Você pode usar texto simples ou uma variável de idioma, como por exemplo {L_PRIVATE_MESSAGES}',
	'MENU_LINK_URL'             => 'URL',
	'MENU_LINK_URL_EXPLAIN'     => 'Você pode usar um endereço URL, incluindo o protocolo https://, ou uma variável de template, como por exemplo {U_PRIVATEMSGS}. Você pode encontrar as variáveis de template disponíveis no arquivo includes/functions.php, por volta da linha 4545',
	'MENU_LINK_DISPLAY'         => 'Exibir o link',
	'MENU_LINK_EXTERNAL'        => 'O link será aberto em uma nova janela',
	'MENU_LINK_ONLY_REGISTERED' => 'Exibir apenas para usuários registrados',
	'MENU_LINK_ONLY_GUEST'      => 'Exibir apenas para visitantes',
	'MENU_LINK_NAV'             => 'Links',
	'MENU_LINK_ICON'            => 'Ícone',
	'DELETE_LINK_CONFIRM'       => 'Tem certeza de que quer excluir este Link?',
	'NO_LINKS'                  => 'Não existe nenhum link para gerenciar',
	'LINK_UPDATED'              => 'Link atualizado com sucesso',
	'LINK_ADDED'                => 'Novo link adicionado com sucesso',

	'BBOOTS_STYLE_ADD_SOCIAL'     => 'Adicionar Rede Social',
	'BBOOTS_STYLE_EDIT_SOCIAL'    => 'Editar Rede Social',
	'MENU_SOCIAL_NAME'            => 'Nome da Rede Social',
	'MENU_SOCIAL_NAME_EXPLAIN'    => 'Você pode usar texto simples ou uma variável de idioma, como por exemplo {L_PRIVATE_MESSAGES}',
	'MENU_SOCIAL_URL'             => 'URL',
	'MENU_SOCIAL_URL_EXPLAIN'     => 'Você pode usar um endereço URL, incluindo o protocolo https://, ou uma variável de template, como por exemplo {U_PRIVATEMSGS}. Você pode encontrar as variáveis de template disponíveis no arquivo includes/functions.php, por volta da linha 4545',
	'MENU_SOCIAL_DISPLAY'         => 'Exibir a rede social',
	'MENU_SOCIAL_ONLY_REGISTERED' => 'Exibir apenas para Usuários Registrados',
	'MENU_SOCIAL_ONLY_GUEST'      => 'Exibir apenas para Visitantes',
	'MENU_SOCIAL_NAV'             => 'Redes Sociais',
	'DELETE_SOCIAL_CONFIRM'       => 'Tem certeza de que quer excluir esta Rede Social?',
	'NO_SOCIALS'                  => 'Não existe nenhuma rede social para gerenciar',
	'SOCIAL_UPDATED'              => 'Rede social atualizada com sucesso',
	'SOCIAL_ADDED'                => 'Nova rede social adicionada com sucesso',

	'ENABLE_CUSTOM_CSS'         => 'Ativar CSS personalizado',
	'ENABLE_CUSTOM_CSS_EXPLAIN' => 'Selecione "Sim" para ativar o uso do arquivo custom.css.',
	'SELECTED_FILE'             => 'Arquivo selecionado',
	'SELECTED_FILE_EXPLAIN'     => 'Observe que enviar este formulário pode alterar o seu arquivo custom.css de forma inesperada. Devido a limitações de processamento, todas as barras invertidas serão removidas e os caracteres especiais de HTML (como &amp;nbsp; e semelhantes) serão substituídos pelo seu caractere original. Se precisar de uma edição mais avançada, use FTP para editar o arquivo diretamente. Você pode encontrar o arquivo em styles/BBOOTS/theme/custom.css.',
	'CSS_UPDATED'               => 'CSS atualizado com sucesso.',
]);
