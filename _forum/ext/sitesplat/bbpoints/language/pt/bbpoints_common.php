<?php
/**
*
* BBpoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if ( empty($lang) || !is_array($lang) )
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'BBPOINTS'						=> 'Pontos', // This is the forum point name. You can edit it to reflect your own point name.
	'YOUR_BBPOINTS'					=> 'Os Teus Pontos',
	'BB_AMOUNT'			    		=> 'Montante',
	'BB_PAID_UP'			    	=> 'PontosGold',
	'TOPIC_HIDDEN'					=> 'Tópico Oculto. Requer Pontos.',
	'WAS_HIDDEN'					=> 'Este tópico requer uma troca de pontos',
	'BBPOINTS_HIDE_TOPIC'	        => 'Pontos Min.',
	'BBPOINTS_HIDE_TOPIC_EXPLAIN'	=> 'Enter the Minimum Points required for the next user to read this topic. <br />(The points will be transfered to your account)',
	'TRANSFER_NOTI'					=> 'Recebeu um donativo de %1$s Pontos por %2$s',

	'NOTIFICATION_TYPE_BBPOINTS_TRANSFER' => 'Alguém te transferiu Pontos',
));
