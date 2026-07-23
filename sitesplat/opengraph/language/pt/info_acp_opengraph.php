<?php

/**
 * BBopengraph
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
	'OPENGRAPH_TITLE'            => 'Definições do BBopengraph',
	'OPENGRAPH_FB_ID'            => 'ID do Facebook',
	'OPENGRAPH_FB_ID_EXPLAIN'    => 'Podes recuperar esta informação ao ver o url da tua foto de perfil no Facebook.<br />Vê este exemplo: <a href="http://i.gyazo.com/6b666b008dd0d45694e873689257fec2.png" target="blank">http://i.gyazo.com/6b666b008dd0d45694e873689257fec2.png</a>',
	'OPENGRAPH_FB_APPID'         => 'ID de aplicação (App ID) do Facebook',
	'OPENGRAPH_FB_APPID_EXPLAIN' => 'Introduz o teu App ID do Facebook SDK. Podes criar uma nova aplicação (App) através deste link: <a href="https://developers.facebook.com/docs/opengraph/getting-started" target="blank">https://developers.facebook.com/docs/opengraph/</a> ou este: <a href="https://developers.facebook.com/apps/" target="blank">https://developers.facebook.com/apps/</a> <br />O APP ID assemelha-se a isto: <a href="https://gyazo.com/f953cc65232d4aeafcf28a6d07c4eb34.png" target="blank">https://gyazo.com/f953cc65232d4aeafcf28a6d07c4eb34.png</a> <br />Se o App ID for introduzido, o script será injetado após a tag body do fórum.<br />A configuração do SDK pode ser utilizada para executar tarefas comuns, tais como o botão Gosto (Like Button), comentários de mural, etc.<br /> Configura e adiciona plugins externos do Facebook por aqui: <a href="https://developers.facebook.com/docs/plugins/" target="blank">https://developers.facebook.com/docs/plugins/</a>',
	'OPENGRAPH_TW_ID'            => 'ID do Twitter',
	'OPENGRAPH_TW_ID_EXPLAIN'    => 'Este é o teu identificador do Twitter (NÃO adiciones o símbolo &#64;). Se for introduzido, serão criadas etiquetas (tags) do Twitter e do Open Graph para definir um cartão de resumo quando o conteúdo for partilhado. Vê: <a href="https://developer.twitter.com/en/docs/tweets/optimize-with-cards/guides/getting-started#opengraph" target="blank">Opengraph Twitter Summary Cards</a>',
	'OPENGRAPH_IMAGE'            => 'Caminho da imagem',
	'OPENGRAPH_IMAGE_EXPLAIN'    => 'Caminho relativo (a partir da raiz do phpbb, ex. images/spacer.gif) para a tua imagem; se não for encontrado nenhum anexo de tópico, será usado o espaço reservado fornecido no tópico. Isto também é necessário para a tua página de índice. <br /> Requisitos de tamanho da imagem: <a href="https://developers.facebook.com/docs/sharing/best-practices#images" target="blank">https://developers.facebook.com/docs/sharing/best-practices#images</a>',

	'OPENGRAPH_NOTICE' => '<div class="phpinfo"><p>As definições desta extensão encontram-se em %1$s &#187; %2$s &#187; %3$s.</p></div>',
	'SS_HELPER_NOTY'   => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
]);
