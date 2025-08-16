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
	'POST_CONFIRM_EXPLAIN'					=> 'Digitar o código evita o convite automático de bots. Podes encontrar o código na imagem. Se não fores capaz de ler o código devido a problemas visuais ou outros, entra em contacto com o %sadministrador%s.',

	'UCP_CAT_INVITE'						=> 'phpBB Invite',
	'UCP_INVITE'							=> 'Convites',
	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controlo do utilizador%s',
	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
	'UCP_INVITE_DAYF_EXPLAIN'				=> 'O número de convites que enviaste hoje.',
	'UCP_INVITE_DAY_OFF'					=> 'Não estamos a aceitar mais convites hoje!',
	'UCP_INVITE_DB'							=> '<b>%s convite(s).</b>',
	'UCP_INVITE_DB_SEND'					=> 'Limite de convite diário',
	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Número máximo de convites por dia que podes enviar.',
	'UCP_INVITE_DB_MAX'						=> '<span class="invitation_tred">Ilimitado!</span>',
	'UCP_INVITE_DB_PENDING'					=> 'Convites pendentes',
	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'O número de utilizadores que convidaste e ainda não se registou.',
	'UCP_INVITE_DB_NUMBER'					=> 'Número de convites',
	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'O teu limite de convites restante',
	'UCP_INVITE_DB_USER'					=> 'Utilizador convidado',
	'UCP_INVITE_DB_USERS'					=> 'Utilizadores convidados',
	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Membros que convidaste.',
	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Membro que convidaste.',
	'UCP_INVITE_DELETE'						=> 'Apagar convite',
	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Se enviaste convites para os endereços errados, poderás revogar os mesmos aqui.<br /><em>Isso só é possível dentro de %s minutos após o envio do convite.</em>',	
	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'A remoção não foi confirmada!',
	'UCP_INVITE_DELETE_SUCCESS'				=> 'O convite foi apagado com sucesso.',
	'UCP_INVITE_DISABLED'					=> '%sO sistema de convites está desactivado!%s',
	'UCP_INVITE_DUP'						=> 'Já foi enviado um convite para o endereço de e-mail: %s',
	'UCP_INVITE_EDUP'						=> 'Endereço de e-mail inserido repetidamente: %s',
	'UCP_INVITE_EMAILS_SENT'				=> 'Os convites foram enviados com sucesso!',
	'UCP_INVITE_EMAIL_LANG'					=> 'Idioma do e-mail',
	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Razão para a solicitação de convites.',
	'UCP_INVITE_EMAIL_SELECT'				=> 'Selecção de convite',
	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Escolhe qual dos destinatários desejas excluir.',
	'UCP_INVITE_EMAIL_SENT'					=> 'O convite foi enviado com sucesso!',
	'UCP_INVITE_FLOOD_LIMIT'				=> 'Não podes enviar mais convites. Por favor, tenta novamente mais tarde.',
	'UCP_INVITE_FRIEND'						=> 'Adicionar um amigo',
	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'O utilizador convidado será adicionado à tua lista de amigos.',
	'UCP_INVITE_DEP_LIMIT'					=> 'Apenas %s convites podem ser enviados hoje. No entanto, listaste %s destinatários.', 
	'UCP_INVITE_REQUEST'					=> 'Solicitação de convites',
	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'Compraste convites com sucesso.',
	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Mínimo (1) convite a ser comprado!',
	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Não tens %s suficiente para comprar essa quantidade de convites! Tens %s %s atualmente.',
	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Comprar',
	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Convites que desejas comprar',
	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digita o número de convites que desejas comprar. O preço do convite é <b>%s %s</b>.<br />Assumes a responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se o(s) utilizador(es) convidado(s) causar(em) incidentes inapropriados.',
	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitacões de convites estão desactivadas!',
	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Não escreveste uma mensagem! Sem uma explicação não podes reivindicar tantos convites.',
	'UCP_INVITE_REQUEST_OFF'				=> 'A tua solicitação de convite está pendente. Quando um administrador/moderador avaliar a tua solicitação, receberás uma notificação.',
	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'Ao enviar mais de <b>(%s)</b> pedidos, é necessária uma explicação para o administrador. Por favor, explica por que precisas de tantos convites.<br />Se acharmos que o teu pedido é aceitável, nós enviamos os convites. Se for um abuso, pode ser motivo para banir a tua conta.',	
	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
	'UCP_INVITE_REQUEST_TITLE'				=> 'Convites requisitados',
	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.<br />Assumes total responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se eles se comportarem de maneira inapropriada.',
	'UCP_INVITE_SEND'						=> 'Enviar convite',
	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, listaste %s!', 
	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Actualmente não há limite!</span>',
	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
	'UCP_INVITE_MAX_ERROR'					=> 'Actualmente tens convites ilimitados.',
	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Digita todos os endereços numa nova linha! <br /> Número máximo de destinatários',
	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Escreve algumas linhas a explicar por que deveriam participar.',
	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Não há convites para apagar!',
	'UCP_INVITE_NOT_LANGUAGE'				=> 'Ficheiro de idioma inexistente: %s',
	'UCP_INVITE_NO_EMAIL'					=> 'Não forneceste um endereço de e-mail!',
	'UCP_INVITE_NO_INVITE_USERS'			=> 'Ainda não convidaste ninguém ou ainda não se registaram.',
	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registou neste site.',
	'UCP_INVITE_NO_PERM'					=> 'Não está autorizado a enviar convites!',
	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Não está autorizado a enviar e-mail!',
	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por ti.',
	'UCP_INVITE_NULL'						=> 'Não tem convites! <em>Porque não comprar alguns?</em>', 
	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Quantidade de pontos que o utilizador receberá quando ele convidar alguém e se essa pessoa convidada se tornar um membro registado.',
	'UCP_INVITE_POINTS_COST'				=> 'Preço do convite',
	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'O custo do envio de um convite.',
	'UCP_INVITE_POST_LIMIT'					=> 'Deves ter um mínimo de %s mensagens, para enviar convites!', 
	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Pedido de convite',
	'UCP_INVITE_SDB'						=> 'convite(s).',
	'UCP_INVITE_SEND_OFF'					=> 'O envio de convites está, de momento, desactivado!',
	'UCP_INVITE_SEND_SUBMIT'				=> 'Enviar convite',
	'UCP_INVITE_TIME_END'					=> 'Data de expiração',
	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'O utilizador convidado terá que se registar durante esse período.',
	'UCP_INVITE_USER'						=> 'Utilizadores convidados',
	'UCP_INVITE_USERS_COUNT'				=> 'Utilizadores convidados (%s)',
	'UCP_INVITE_USER_OK'					=> 'Convite aceite',
	'UCP_INVITE_LU_REG'						=> 'Último utilizador',
	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'Último utilizador dos seus convites.',
	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> registado %s',

	'WEEKS'									=> 'Semanas',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'Recebeste convites para o teu aniversário',
	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'Recebeste convites depois de convidar um utilizador com sucesso',
	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'Recebeste uma resposta de uma solicitação de convite',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'Recebeste uma solicitação de convite',
	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'Um utilizador que convidaste criou uma conta',
));
