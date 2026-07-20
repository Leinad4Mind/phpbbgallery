<?php

/**
 * BBadblock extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'BBA_TITLE'           => 'BB Adblock',
	'BBA_EXPLAIN'         => 'Esta configuração permite-lhe exibir um aviso subtil aos utilizadores que utilizam o AdBlock, lembrando-os de o desativar se quiserem ver os anúncios.<br />Isto irá aumentar a sua taxa de cliques (CTR)!',
	'BBA_ENABLE'          => 'Ativar BB AdBlock',
	'BBA_ENABLE_EXPLAIN'  => 'Ligue e desligue globalmente as notificações do AdBlock.',
	'BBA_THEME'           => 'Tema e Estilo',
	'BBA_THEME_EXPLAIN'   => 'O Tema Light destina-se a temas baseados no estilo nativo.',
	'BBA_DARK'            => 'Tema Dark',
	'BBA_LIGHT'           => 'Tema Light',
	'BBA_COUNTER'         => 'AdBlock + Bloqueio de Publicações',
	'BBA_COUNTER_EXPLAIN' => 'Esta extensão possui um recurso escondido onde irá encobrir/esconder um tópico e a publicação se o Adblock do utilizador estiver ligado durante um certo número de páginas.<br />Note que esta opção obriga efetivamente os seus utilizadores a desativar o Adblock se quiserem continuar a ler no seu fórum.',
	'BBA_PAGE_NO'         => 'Frequência do Bloqueio de Tópico/Publicação (Contagem de visualizações de página)',
	'BBA_PAGE_NO_EXPLAIN' => 'Após quantas páginas deve a extensão bloquear o tópico e pedir para desativar o Adblock?',

	'ACP_BBA_SAVED'  => 'Configurações guardadas com sucesso',
	'ACP_BBA_NOTICE' => '<div class="phpinfo"><p>Aviso prévio, esta extensão <strong>NÃO</strong> é mágica. Nenhuma destas extensões pode impedir totalmente o adblock de bloquear coisas, mas isso fará a maioria dos utilizadores mais cautelosos quanto à visualização de páginas. Isto irá requerer que modifique os códigos dos seus anúncios, envolvendo-os numa tag DIV e adicionando as classes CSS "<strong>bb_ad</strong>" & "<strong>bbadblock_bg</strong>" nela, dependendo dos banners e das necessidades do seu site. Para que saiba como isto funciona: o JavaScript injetado cria um log e faz o ping se as classes carregarem na tag DIV, se o Adblock apagar as divs o plugin entende que o Adblock está ligado. Um exemplo do que precisa de ser feito:<br /><br />&#60;div class=&#34;bb_ad bbadblock_bg&#34;&#62;<br />O seu código de anúncio vai aqui.<br />&#60;/div&#62;<br /><br />Para os temas Base, insira o seu código em bb_ad.html no diretório template do fórum e chame com um simples include onde pretende exibir os seus banners. Se precisar pode contactar-nos no fórum. :-)</p></div>',
	'SS_HELPER_NOTY' => 'SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
]);
