<?php

/**
 * BBOAuth
 * @copyright (c) 2018 SiteSplat All rights reserved
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
	'ACP_BBOAUTH'    => 'BBoauth',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBOAUTH_NOTICE' => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Seleciona "Oauth" e, em seguida, adiciona as chaves apropriadas para cada provedor a fim de as ativares.<br />Os grupos automáticos e outras opções estão em: <strong>ACP &#187; Configuração do Fórum &#187; Configuração de registo de utilizador &#187; BBoauth.<br />Cria a aplicação Oauth através destes provedores: <a href="https://www.coinbase.com/settings/api" target="_blank">Coinbase</a>, <a href="https://discordapp.com/developers/applications/#top" target="_blank">Discord</a>, <a href="https://www.dropbox.com/developers/apps" target="_blank">Dropbox</a>, <a href="https://developer.github.com/apps/building-oauth-apps/creating-an-oauth-app/" target="_blank">Github</a>, <a href="https://www.instagram.com/developer/" target="_blank">instagram</a>, <a href="https://api.slack.com/apps" target="_blank">Slack</a>, <a href="https://api.razer.com/projects/" target="_blank">Razer ID</a>, <a href="https://console.developers.google.com/apis/credentials" target="_blank">Google</a></strong></p></div>',

	'BBOAUTH_AUTOREGISTER'         => 'Registo automático com o OAuth',
	'BBOAUTH_AUTOREGISTER_EXPLAIN' => 'Define como "Sim" para pular/ultrapassar o processo de registo quando um utilizador tenta fazer o login (iniciar sessão) usando o serviço OAuth. O BBoauth vai puxar e obter todas as informações necessárias do serviço OAuth (nome de utilizador e email) e gerar uma palavra-passe aleatória para o utilizador. Um e-mail de boas-vindas com a palavra-passe também será enviado ao utilizador.<br/> NOTA: Alguns provedores não liberam as informações relacionadas ao utilizador que tenta efetuar o registo. Se o e-mail ou nome de utilizador não for fornecido, o registo automático não será possível. No entanto, em tais casos, o BBoauth pré-preencherá qualquer informação disponível na fase de registo para facilitar ao utilizador. O novo utilizador também entrará automaticamente se a "Ativação de Conta" estiver definida como: "Nenhuma (acesso imediato)", que é o método recomendado, já que assumimos que o utilizador não é um Bot, porque se tratava da própria conta de rede social da pessoa.',
	'BBOAUTH_GROUP'                => 'Grupo para os utilizadores do OAuth',
	'BBOAUTH_GROUP_EXPLAIN'        => 'Os utilizadores que usarem a função de login através do OAuth serão automaticamente adicionados ao grupo selecionado escolhido aqui.',
]);
