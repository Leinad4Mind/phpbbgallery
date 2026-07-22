<?php
/**
*
* Stop forum Spam extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
* @translation Leinad4Mind [Portuguese [pt]] (2026)
*
*/
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters for use
// ’ » “ ” …


$lang = array_merge($lang, [

	// ACP entries
	'SFS_SETTINGS'               => 'Configurações',
	'SFS_ENABLED'                => 'Ativar Stop Forum Spam',
	'SFS_ENABLED_EXPLAIN'        => 'Ativar ou desativar a extensão. Isto aplica-se tanto ao registo de utilizadores como às publicações de visitantes.',
	'SFS_THRESHOLD_SCORE'        => 'Limite do Stop Forum Spam',
	'SFS_THRESHOLD_SCORE_EXPLAIN' => 'A extensão irá verificar face a um limite (ex.: o número de vezes que um nome de utilizador, e-mail ou endereço IP é encontrado na base de dados do stop forum spam). Podes inserir qualquer número entre 1 e 99. Quanto menor o número, maior a possibilidade de um falso positivo.',
	'SFS_LOG_MESSAGE'            => 'Registar uma mensagem',
	'SFS_LOG_MESSAGE_EXPLAIN'    => 'Se definido como sim, as mensagens serão registadas na ACP, seja no registo de administrador ou de utilizador, indicando a ação realizada.',
	'SFS_BAN_IP'                 => 'Banir Utilizador',
	'SFS_BAN_IP_EXPLAIN'         => 'Se definido como sim, o IP ou nome de utilizador será banido de acordo com a definição “Duração do banimento”',
	'SFS_BAN_REASON'             => 'Mostrar razão se banido',
	'SFS_BAN_REASON_EXPLAIN'     => 'Se “Banir Utilizador” estiver definido como sim, podes escolher mostrar ou não uma mensagem ao utilizador banido.',
	'SFS_DOWN'                   => 'Permitir se o Stop Forum Spam estiver em baixo',
	'SFS_DOWN_EXPLAIN'           => 'O registo/publicação deve prosseguir se o site do stop forum spam estiver em baixo',
	'SFS_API_KEY'                => 'Chave API do Stop Forum Spam',
	'SFS_API_KEY_EXPLAIN'        => 'Se quiseres submeter spammers à base de dados do Stop Forum Spam, insere aqui a tua chave API de <a target="_blank" href="http://www.stopforumspam.com/keys" rel="noreferrer noopener">stop forum spam</a>. Tens de estar registado no site do SFS para obteres uma chave API',
	'SFS_NEED_CACHE'             => 'Existe uma chave API mas não foi criada nenhuma cache para administradores e moderadores. Por favor clica no botão para gerar a cache para administradores e moderadores, caso contrário podem ser denunciados.',
	'SFS_NOTIFY'                 => 'Notificação do Fórum',
	'SFS_NOTIFY_EXPLAIN'         => 'Se definido como sim e existir uma chave API definida acima, então as notificações do fórum também serão acionadas quando uma mensagem for denunciada ao stop forum spam',
	'SFS_CLEAR'                  => 'Repor mensagens denunciadas',
	'SFS_CLEAR_EXPLAIN'          => 'Irá repor todas as mensagens ( %1s no total ) e mensagens privadas ( %2s no total ) denunciadas ao stop forum spam',
	'SFS_CLEAR_SURE'             => 'Limpar denúncias do SFS',
	'SFS_CLEAR_SURE_CONFIRM'     => 'Tens a certeza de que queres limpar todas as mensagens e mensagens privadas denunciadas?',
	'SFS_BUILD' => 'Criar cache de Administradores e Moderadores',
	'SFS_BUILD_EXPLAIN' => 'Cria uma cache de Administradores e Moderadores Globais para uso ao denunciar ao SFS',
	'SFS_NEEDS_API' => 'Para criares a cache precisas de uma chave API do stop forum spam',
	// ACP messages
	'SFS_BY_NAME'   => 'Verificar pelo nome de utilizador',
	'SFS_BY_EMAIL'  => 'Verificar pelo e-mail',
	'SFS_BY_IP'     => 'Verificar pelo IP',
	'SFS_ALLOW_PM_REPORT'  => 'Permitir denúncia de MPs',
	'SFS_PM_REPORT_EXPLAIN'  => 'Se tiveres uma chave API e permitires isto, então qualquer utilizador pode denunciar uma MP ao stop forum spam. Os teus utilizadores podem ser “indiscriminados”, por isso pode ser melhor deixares isto definido como não.',
	'TOO_SMALL_SFS_THRESHOLD'  => 'O valor do limite é demasiado pequeno.',
	'TOO_LARGE_SFS_THRESHOLD'  => 'O valor do limite é demasiado grande.',
	'SFS_SETTINGS_ERROR'    => 'Ocorreu um erro ao guardar as tuas configurações. Por favor submete o back trace com o teu relatório de erro.',
	'SFS_SETTINGS_SUCCESS'    => 'As configurações foram guardadas com sucesso.',
	'SFS_REPORTED_CLEARED' => 'As mensagens e mensagens privadas denunciadas ao stop forum spam foram repostas.',
	//Donation
	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
	'PAYPAL_ALT'                => 'Doar através de PayPal',
	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
	'BUY_ME_A_BEER'				=> 'Oferece-me uma cerveja por criar esta extensão',
	'BUY_ME_A_BEER_SHORT'		=> 'Faz um donativo para esta extensão',
	'BUY_ME_A_BEER_EXPLAIN'		=> 'Esta extensão é completamente gratuita. É um projeto ao qual dedico o meu tempo, pelo gosto e para o uso da comunidade phpBB. Se gostas de usar esta extensão, ou se ela beneficiou o teu fórum, por favor considera <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">oferecer-me uma cerveja</a>. Seria muito apreciado. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
	'SFS_CONTACTADMIN_EXT'	=> 'Permitir na Extensão Contactadmin',
	'SFS_CONTACTADMIN_EXT_EXPLAIN'	=> 'Se definido como sim e a extensão contact admin estiver instalada, esta extensão irá integrar-se com a extensão contact admin.'
]);
