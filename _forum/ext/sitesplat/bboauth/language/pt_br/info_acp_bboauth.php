<?php

/**
 * BBOAuth
 * @copyright (c) 2018 SiteSplat All rights reserved
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
	'ACP_BBOAUTH'    => 'BBoauth',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBOAUTH_NOTICE' => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Selecione "Oauth" e, em seguida, adicione as chaves apropriadas para cada provedor a fim de ativá-las.<br />Os grupos automáticos e outras opções estão em: <strong>ACP &#187; Configuração do Fórum &#187; Configuração de registro de usuário &#187; BBoauth.<br />Crie a aplicação Oauth através destes provedores: <a href="https://www.coinbase.com/settings/api" target="_blank">Coinbase</a>, <a href="https://discordapp.com/developers/applications/#top" target="_blank">Discord</a>, <a href="https://www.dropbox.com/developers/apps" target="_blank">Dropbox</a>, <a href="https://developer.github.com/apps/building-oauth-apps/creating-an-oauth-app/" target="_blank">Github</a>, <a href="https://www.instagram.com/developer/" target="_blank">instagram</a>, <a href="https://api.slack.com/apps" target="_blank">Slack</a>, <a href="https://api.razer.com/projects/" target="_blank">Razer ID</a>, <a href="https://console.developers.google.com/apis/credentials" target="_blank">Google</a></strong></p></div>',

	'BBOAUTH_AUTOREGISTER'         => 'Registro automático com o OAuth',
	'BBOAUTH_AUTOREGISTER_EXPLAIN' => 'Defina como "Sim" para pular/ultrapassar o processo de registro quando um usuário tenta fazer o login (iniciar sessão) usando o serviço OAuth. O BBoauth vai puxar e obter todas as informações necessárias do serviço OAuth (nome de usuário e email) e gerar uma senha aleatória para o usuário. Um e-mail de boas-vindas com a senha também será enviado ao usuário.<br/> NOTA: Alguns provedores não liberam as informações relacionadas ao usuário que tenta efetuar o registro. Se o e-mail ou nome de usuário não for fornecido, o registro automático não será possível. No entanto, em tais casos, o BBoauth pré-preencherá qualquer informação disponível na fase de registro para facilitar ao usuário. O novo usuário também entrará automaticamente se a "Habilitação de Conta" estiver definida como: "Nenhuma (acesso imediato)", que é o método recomendado, já que assumimos que o usuário não é um Bot, porque se tratava da própria conta de rede social da pessoa.',
	'BBOAUTH_GROUP'                => 'Grupo para os usuários do OAuth',
	'BBOAUTH_GROUP_EXPLAIN'        => 'Os usuários que usarem a função de login através do OAuth serão automaticamente adicionados ao grupo selecionado escolhido aqui.',
]);
