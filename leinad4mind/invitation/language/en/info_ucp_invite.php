<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
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
	'POST_CONFIRM_EXPLAIN'					=> 'Typing the code prevents the automatic invitation of bots. You can find the code in the following picture. If you cannot read the code because of visual or other problems please contact the %sforum administrator%s.',

	'UCP_CAT_INVITE'						=> 'phpBB Invite',
	'UCP_INVITE'							=> 'Invitation',
	'UCP_INVITE_DATA'						=> 'Invitation details',
	'UCP_INVITE_BACK'						=> '<br /><br />%sBack to the user control panel%s',
	'UCP_INVITE_DAYF'						=> 'Invitations sent today',
	'UCP_INVITE_DAYF_EXPLAIN'				=> 'The number of invitations that you sent today.',
	'UCP_INVITE_DAY_OFF'					=> 'We are not sending out any more invitations today!',
	'UCP_INVITE_DB'							=> '<b>%s invitation(s).</b>',
	'UCP_INVITE_DB_SEND'					=> 'Daily invitation limit',
	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Maximum number of invitations per day you can send out.',
	'UCP_INVITE_DB_MAX'						=> '<span class="meghivo_tred">Unlimited!</span>',
	'UCP_INVITE_DB_PENDING'					=> 'Pending invitations',
	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'The number of users you invited who have not yet registered.',
	'UCP_INVITE_DB_NUMBER'					=> 'Number of invitations',
	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'Your Remaining Invitation Limit',
	'UCP_INVITE_DB_USER'					=> 'Invited user',
	'UCP_INVITE_DB_USERS'					=> 'Invited users',
	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Members you have invited.',
	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Member you have invited.',
	'UCP_INVITE_DELETE'						=> 'Delete invitation',
	'UCP_INVITE_DELETE_EXPLAIN'				=> 'If you sent any invitations to the wrong addresses, you may revoke those invitations here.<br /><em>This is only possible to do within %s minutes of having sent an invitation.</em>',
	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'The deletion was not confirmed!',
	'UCP_INVITE_DELETE_SUCCESS'				=> 'The invitation has successfully been deleted.',
	'UCP_INVITE_DISABLED'					=> '%sThe invitation system has been disabled!%s',
	'UCP_INVITE_DUP'						=> 'The e-mail address has already been sent out an invitation. -> %s',
	'UCP_INVITE_EDUP'						=> 'An e-mail address repeatedly entered. -> %s',
	'UCP_INVITE_EMAILS_SENT'				=> 'The invitations has been successfully sent!',
	'UCP_INVITE_EMAIL_LANG'					=> 'E-mail language',
	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Reason for requested invitations.',
	'UCP_INVITE_EMAIL_SELECT'				=> 'Invitation selection',
	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Choose the one you want to delete from your recipients.',
	'UCP_INVITE_EMAIL_SENT'					=> 'The invitation has been successfully sent!',
	'UCP_INVITE_FLOOD_LIMIT'				=> 'You can not send any more invitations. Please try again later.',
	'UCP_INVITE_FRIEND'						=> 'Add a friend',
	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'The invited user will be added to your friends list.',
	'UCP_INVITE_DEP_LIMIT'					=> 'Only %s invitations can be sent out today. However you listed %s recipients.',
	'UCP_INVITE_REQUEST'					=> 'Invitation request',
	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'You successfully purchased invitations.',
	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Minimum (1) invitation to be purchased!',
	'UCP_INVITE_REQUEST_BUY_NO'				=> 'You have not got enough %s to purchase this amount of invitations! You have got %s %s currently.',
	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Buy',
	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Invitations you want to buy',
	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Type the number of invitations you want to buy. Invitation price is <b>%s %s</b>.<br />You take responsibility for your invited user(s) if the invited user(s) causes inappropriate incidents.',
	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'Invitation purchase was successful.',
	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Buy Invitation.',
	'UCP_INVITE_REQUEST_DISABLED'			=> 'The request is switched off!',
	'UCP_INVITE_REQUEST_MAX'				=> 'Maximum number of requests: (%s) invite(s)!',
	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>No! There was no need.</em>',
	'UCP_INVITE_REQUEST_MIN'				=> 'Minimum number of requested invitations: (1)',
	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'You did not write a message! Without an explanation you can not claim so many invitations.',
	'UCP_INVITE_REQUEST_OFF'				=> 'Your invitation request is pending. When an administrator/moderator evaluates your request, you will receive a notification.',
	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'When sending more than <b>(%s)</b> requests, an explanation to the admin is necessary. Please explain why you need so many invitations.<br />If we think your request is acceptable, we will give the invitations to you. If we encounter abuse, it can be a reason to ban your account.',
	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Send request',
	'UCP_INVITE_REQUEST_SUCC'				=> 'The invitation request has been successfully sent!',
	'UCP_INVITE_REQUEST_SUCCS'				=> 'The invitation requests have been successfully sent!',
	'UCP_INVITE_REQUEST_TITLE'				=> 'Required invitations',
	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Enter the number of invitations you want to request. There is a maximum of <b>(%s)</b> invitation(s) available.<br />You take full responsibility for your invited user(s) if they behave inappropriately.',
	'UCP_INVITE_SEND'						=> 'Send invitation',
	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Maximum %s e-mail addresses can be used. However you listed %s!',
	'UCP_INVITE_SEND_MAX'					=> '<span class="meghivo_tred">Currently there is no limit!</span>',
	'UCP_INVITE_LAST_ACTIVE'				=> 'Last active',
	'UCP_INVITE_MAX_ERROR'					=> 'Currently you have unlimited invitations.',
	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Type all addresses in a new line!<br />Maximum number of recipients',
	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Write a few lines telling them why they should join.',
	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'There is no invitation to delete!',
	'UCP_INVITE_NOT_LANGUAGE'				=> 'Non-existent language file: %s',
	'UCP_INVITE_NO_EMAIL'					=> 'You have not provided an e-mail address!',
	'UCP_INVITE_NO_INVITE_USERS'			=> 'You have not yet invited anyone, or they have not yet registered.',
	'UCP_INVITE_NO_LOGIN'					=> 'He/she has not registered at this site.',
	'UCP_INVITE_NO_PERM'					=> 'You are not authorized to send invitations!',
	'UCP_INVITE_NO_PERM_EMAIL'				=> 'You are not authorized to send e-mail!',
	'UCP_INVITE_NO_REG'						=> 'Nobody has been invited by you.',
	'UCP_INVITE_NULL'						=> 'You don’t have any invitations! <em>Why not buy some?</em>',
	'UCP_INVITE_POINTS_AMOUNT'				=> 'Gift',
	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Amount of points user will receive when he has invited somebody and if this invited person becomes a registered member.',
	'UCP_INVITE_POINTS_COST'				=> 'Invitation price',
	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'The Cost of Sending an Invitation.',
	'UCP_INVITE_POST_LIMIT'					=> 'You must have a minimum of %s post(s) in order to send invitations!',
	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Invitation request',
	'UCP_INVITE_SDB'						=> 'invitation(s).',
	'UCP_INVITE_SEND_OFF'					=> 'Sending invitations is currently turned off!',
	'UCP_INVITE_SEND_SUBMIT'				=> 'Send invitation',
	'UCP_INVITE_TIME_END'					=> 'Expiration time',
	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'The invited user will have to register during this time.',
	'UCP_INVITE_USER'						=> 'Invited users',
	'UCP_INVITE_USERS_COUNT'				=> 'Invited users (%s)',
	'UCP_INVITE_USER_OK'					=> 'Invitation accepted',
	'UCP_INVITE_LU_REG'						=> 'Last user',
	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'Last user from your invitations.',
	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> registered %s',

	'WEEKS'									=> 'Weeks',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'You receive invitations for your birthday',
	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'You receive invitations after you successfully invited a user',
	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'You receive an answer to an invitation request',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'A user you invited has registered an account',
));
