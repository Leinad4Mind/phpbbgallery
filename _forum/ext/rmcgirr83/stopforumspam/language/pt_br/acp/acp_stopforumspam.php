<?php
/**
*
* Stop forum Spam extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
* @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'SFS_ENABLED'                => 'Habilitar Stop Forum Spam',
	'SFS_ENABLED_EXPLAIN'        => 'Habilite ou desabilite a extensão. Isso se aplica tanto ao registro de usuários quanto às postagens de visitantes.',
	'SFS_THRESHOLD_SCORE'        => 'Limite do Stop Forum Spam',
	'SFS_THRESHOLD_SCORE_EXPLAIN' => 'A extensão vai verificar em relação a um limite (ex.: o número de vezes que um nome de usuário, e-mail ou endereço IP é encontrado no banco de dados do stop forum spam). Você pode inserir qualquer número entre 1 e 99. Quanto menor o número, maior a possibilidade de um falso positivo.',
	'SFS_LOG_MESSAGE'            => 'Registrar uma mensagem',
	'SFS_LOG_MESSAGE_EXPLAIN'    => 'Se definido como sim, as mensagens serão registradas na ACP, seja no registro de administrador ou de usuário, indicando a ação realizada.',
	'SFS_BAN_IP'                 => 'Banir Usuário',
	'SFS_BAN_IP_EXPLAIN'         => 'Se definido como sim, o IP ou nome de usuário será banido de acordo com a configuração “Duração do banimento”',
	'SFS_BAN_REASON'             => 'Mostrar motivo se banido',
	'SFS_BAN_REASON_EXPLAIN'     => 'Se “Banir Usuário” estiver definido como sim, você pode escolher exibir ou não uma mensagem ao usuário banido.',
	'SFS_DOWN'                   => 'Permitir se o Stop Forum Spam estiver fora do ar',
	'SFS_DOWN_EXPLAIN'           => 'O registro/postagem deve prosseguir se o site do stop forum spam estiver fora do ar',
	'SFS_API_KEY'                => 'Chave API do Stop Forum Spam',
	'SFS_API_KEY_EXPLAIN'        => 'Se você quiser enviar spammers ao banco de dados do Stop Forum Spam, insira aqui sua chave API do <a target="_blank" href="http://www.stopforumspam.com/keys" rel="noreferrer noopener">stop forum spam</a>. Você precisa estar registrado no site do SFS para obter uma chave API',
	'SFS_NEED_CACHE'             => 'Existe uma chave API, mas não foi criado nenhum cache para administradores e moderadores. Por favor, clique no botão para gerar o cache para administradores e moderadores, caso contrário eles podem ser denunciados.',
	'SFS_NOTIFY'                 => 'Notificação do Fórum',
	'SFS_NOTIFY_EXPLAIN'         => 'Se definido como sim e houver uma chave API definida acima, então as notificações do fórum também serão acionadas quando uma mensagem for denunciada ao stop forum spam',
	'SFS_CLEAR'                  => 'Redefinir mensagens denunciadas',
	'SFS_CLEAR_EXPLAIN'          => 'Vai redefinir todas as mensagens ( %1s no total ) e mensagens privadas ( %2s no total ) denunciadas ao stop forum spam',
	'SFS_CLEAR_SURE'             => 'Limpar denúncias do SFS',
	'SFS_CLEAR_SURE_CONFIRM'     => 'Tem certeza de que deseja limpar todas as mensagens e mensagens privadas denunciadas?',
	'SFS_BUILD' => 'Criar cache de Administradores e Moderadores',
	'SFS_BUILD_EXPLAIN' => 'Cria um cache de Administradores e Moderadores Globais para uso ao denunciar ao SFS',
	'SFS_NEEDS_API' => 'Para criar o cache você precisa de uma chave API do stop forum spam',
	// ACP messages
	'SFS_BY_NAME'   => 'Verificar pelo nome de usuário',
	'SFS_BY_EMAIL'  => 'Verificar pelo e-mail',
	'SFS_BY_IP'     => 'Verificar pelo IP',
	'SFS_ALLOW_PM_REPORT'  => 'Permitir denúncia de MPs',
	'SFS_PM_REPORT_EXPLAIN'  => 'Se você tiver uma chave API e permitir isso, qualquer usuário poderá denunciar uma MP ao stop forum spam. Seus usuários podem ser “indiscriminados”, então talvez seja melhor deixar isso definido como não.',
	'TOO_SMALL_SFS_THRESHOLD'  => 'O valor do limite é muito pequeno.',
	'TOO_LARGE_SFS_THRESHOLD'  => 'O valor do limite é muito grande.',
	'SFS_SETTINGS_ERROR'    => 'Ocorreu um erro ao salvar suas configurações. Por favor, envie o back trace com seu relatório de erro.',
	'SFS_SETTINGS_SUCCESS'    => 'As configurações foram salvas com sucesso.',
	'SFS_REPORTED_CLEARED' => 'As mensagens e mensagens privadas denunciadas ao stop forum spam foram redefinidas.',
	//Donation
	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
	'PAYPAL_ALT'                => 'Doe através do PayPal',
	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
	'BUY_ME_A_BEER'				=> 'Me pague uma cerveja por criar esta extensão',
	'BUY_ME_A_BEER_SHORT'		=> 'Faça uma doação para esta extensão',
	'BUY_ME_A_BEER_EXPLAIN'		=> 'Esta extensão é completamente gratuita. É um projeto ao qual dedico meu tempo, pelo gosto e para o uso da comunidade phpBB. Se você gosta de usar esta extensão, ou se ela beneficiou seu fórum, por favor considere <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">me pagar uma cerveja</a>. Seria muito apreciado. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
	'SFS_CONTACTADMIN_EXT'	=> 'Permitir na Extensão Contactadmin',
	'SFS_CONTACTADMIN_EXT_EXPLAIN'	=> 'Se definido como sim e a extensão contact admin estiver instalada, esta extensão vai se integrar com a extensão contact admin.'
]);
