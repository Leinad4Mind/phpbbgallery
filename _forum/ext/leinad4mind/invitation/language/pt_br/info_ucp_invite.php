<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
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
// Some characters you may want to copy&paste: ’ « » „ “ ” …

$lang = array_merge($lang, array(
	'POST_CONFIRM_EXPLAIN'					=> 'Digitar o código evita o convite automático de bots. Você pode encontrar o código na figura a seguir. Se você não puder ler o código devido a problemas visuais ou outros, entre em contato com o %sforum administrator%s.',

	'UCP_CAT_INVITE'						=> 'phpBB Invite',
	'UCP_INVITE'							=> 'Convites',
	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!

Esperamos que se divirta e que a animação nunca deixe de fazer parte da sua vida.',
	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controle do usuário%s',
	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
	'UCP_INVITE_DAYF_EXPLAIN'				=> 'O número de convites que você enviou hoje.',
	'UCP_INVITE_DAY_OFF'					=> 'Não estamos enviando mais convites hoje!',
	'UCP_INVITE_DB'							=> '<b>%s convite(s).</b>',
	'UCP_INVITE_DB_SEND'					=> 'Limite de convite diário',
	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Número máximo de convites por dia que você pode enviar.',
	'UCP_INVITE_DB_MAX'						=> '<span class="invitation_tred">Ilimitado!</span>',
	'UCP_INVITE_DB_PENDING'					=> 'Convites pendentes',
	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'O número de usuários que você convidou e ainda não registrou.',
	'UCP_INVITE_DB_NUMBER'					=> 'Número de convites',
	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'Seu limite de convite restante',
	'UCP_INVITE_DB_USER'					=> 'Usuário convidado',
	'UCP_INVITE_DB_USERS'					=> 'Usuários convidados',
	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Membros que você convidou.',
	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Membro que você convidou.',
	'UCP_INVITE_DELETE'						=> 'Excluir convite',
	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Se você enviou convites para os endereços errados, poderá revogar esses convites aqui.<br /><em>Isso só é possível dentro de %s minutos após o envio do convite.</em>',	
	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'A exclusão não foi confirmada!',
	'UCP_INVITE_DELETE_SUCCESS'				=> 'O convite foi excluído com sucesso.',
	'UCP_INVITE_DISABLED'					=> '%sO sistema de convites está desativado!%s',
	'UCP_INVITE_DUP'						=> 'O endereço de e-mail já foi enviado um convite: %s',
	'UCP_INVITE_EDUP'						=> 'Um endereço de e-mail inserido repetidamente: %s',
	'UCP_INVITE_EMAILS_SENT'				=> 'Os convites foram enviados com sucesso!',
	'UCP_INVITE_EMAIL_LANG'					=> 'Idioma do e-mail',
	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Razão para a solicitação de convites.',
	'UCP_INVITE_EMAIL_SELECT'				=> 'Seleção de convite',
	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Escolha qual dos seus destinatários você deseja excluir.',
	'UCP_INVITE_EMAIL_SENT'					=> 'O convite foi enviado com sucesso!',
	'UCP_INVITE_FLOOD_LIMIT'				=> 'Você não pode enviar mais convites. Por favor, tente novamente mais tarde.',
	'UCP_INVITE_FRIEND'						=> 'Adicionar um amigo',
	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'O usuário convidado será adicionado à sua lista de amigos.',
	'UCP_INVITE_DEP_LIMIT'					=> 'Apenas %s convites podem ser enviados hoje. No entanto, você listou %s destinatários.', 
	'UCP_INVITE_REQUEST'					=> 'Solicitação de convites',
	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'Você comprou convites com sucesso.',
	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Mínimo (1) convite a ser comprado!',
	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Você não tem %s suficiente para comprar essa quantidade de convites! Você tem %s %s atualmente.',
	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Comprar',
	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Convites que você deseja comprar',
	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digite o número de convites que você deseja comprar. O preço do convite é <b>%s %s</b>.<br />Você assume a responsabilidade por seu(s) usuário(s) convidado(s) se o(s) usuário(s) convidado(s) causar incidentes inapropriados.',	
	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desativadas!',
	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Você não escreveu uma mensagem! Sem uma explicação você não pode reivindicar tantos convites.',
	'UCP_INVITE_REQUEST_OFF'				=> 'Sua solicitação de convite está pendente. Quando um administrador/moderador avaliar sua solicitação, você receberá uma notificação.',
	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'Ao enviar mais de <b>(%s)</b> pedidos, é necessária uma explicação para o administrador. Por favor, explique por que você precisa de tantos convites.<br />Se acharmos que seu pedido é aceitável, nós lhe enviaremos os convites. Se encontrarmos abuso, pode ser um motivo para banir sua conta.',	
	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digite o número de convites que você deseja solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
	'UCP_INVITE_SEND'						=> 'Enviar convite',
	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Você assume parte da responsabilidade dos usuários convidados caso eles se comportarem de maneira inapropriada.</div>',
	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, você listou %s!', 
	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Atualmente não há limite!</span>',
	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
	'UCP_INVITE_MAX_ERROR'					=> 'Atualmente você tem convites ilimitados.',
	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Digite todos os endereços em uma nova linha! <br /> Número máximo de destinatários',
	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Escreva algumas linhas dizendo-lhes por que deveriam participar.',
	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Não há convite para excluir!',
	'UCP_INVITE_NOT_LANGUAGE'				=> 'Arquivo de idioma inexistente: %s',
	'UCP_INVITE_NO_EMAIL'					=> 'Você não forneceu um endereço de e-mail!',
	'UCP_INVITE_NO_INVITE_USERS'			=> 'Você ainda não convidou ninguém ou ainda não se registrou.',
	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registrou neste site.',
	'UCP_INVITE_NO_PERM'					=> 'Você não está autorizado a enviar convites!',
	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Você não está autorizado a enviar e-mail!',
	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A sua conta tem de ter pelo menos %1$d dias antes que possa fazer uso do sistema de convite. Poderá utilizar a partir de %2$s.',
	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por você.',
	'UCP_INVITE_NULL'						=> 'Você não tem convites!  <em>Porque não comprar alguns?</em>', 
	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Quantidade de pontos que o usuário receberá quando ele convidar alguém e se essa pessoa convidada se tornar um membro registrado.',
	'UCP_INVITE_POINTS_COST'				=> 'Preço do convite',
	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'O custo do envio de um convite.',
	'UCP_INVITE_POST_LIMIT'					=> 'Você deve ter um mínimo de %s post(s), para enviar convites!', 
	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Pedido de convite',
	'UCP_INVITE_SDB'						=> 'convite(s).',
	'UCP_INVITE_SEND_OFF'					=> 'O envio de convites está desativado no momento!',
	'UCP_INVITE_SEND_SUBMIT'				=> 'Enviar convite',
	'UCP_INVITE_TIME_END'					=> 'Data de expiração',
	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'O usuário convidado terá que se registrar durante esse período.',
	'UCP_INVITE_USER'						=> 'Usuários convidados',
	'UCP_INVITE_USERS_COUNT'				=> 'Usuários convidados (%s)',
	'UCP_INVITE_USER_OK'					=> 'Convite aceito',
	'UCP_INVITE_LU_REG'						=> 'Último usuário',
	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'Último usuário dos seus convites.',
	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> registrado %s',

	'WEEKS'									=> 'Semanas',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'Você recebeu convites para o seu aniversário',
	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'Você recebeu convites depois de convidar um usuário com sucesso',
	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'Você recebeu uma resposta de uma solicitação de convite',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'Você recebeu uma solicitação de convite',
	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'Um usuário que você convidou registrou uma conta',
));
