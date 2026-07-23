<?php

/**
 * BBbbprofile. An extension for the phpBB Forum Software package.
 * @copyright (c) 2016, SiteSplat
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
	'COMPLETE_PROFILE_TITLE' => 'Complete o seu perfil',
	'COMPLETED_PERCENTAGE'   => '%d%% completo',

	'BBPROFILE_BIRTHDATE_TEXT'   => 'Deixe seus amigos goldtuganianos desejarem a você um feliz aniversário.',
	'BBPROFILE_BIRTHDATE_BUTTON' => 'Adicione a data',
	'BBPROFILE_SIGNATURE_TEXT'   => 'Use para promover seus projetos e suas ideias!',
	'BBPROFILE_SIGNATURE_BUTTON' => 'Adicione uma assinatura',
	'BBPROFILE_AVATAR_TEXT'      => 'Expresse-se e mostre para nós quem você é e qual é a sua personalidade!',
	'BBPROFILE_AVATAR_BUTTON'    => 'Adicione um avatar',

	'BBPROFILE_INTERESTS_TEXT'    => 'Vamos lá, deixe de ser reservado e compartilhe com os seus amigos os seus interesses',
	'BBPROFILE_INTERESTS_BUTTON'  => 'Adicione seus interesses',
	'BBPROFILE_OCCUPATION_TEXT'   => 'O que você realmente faz? Não diga "PLEASE"! Já basta o Barney Stinson!',
	'BBPROFILE_OCCUPATION_BUTTON' => 'Adicione seus hobbies',
	'BBPROFILE_WEBSITE_TEXT'      => 'Você tem algum site ou blog seu?',
	'BBPROFILE_WEBSITE_BUTTON'    => 'Divulgue o que é seu, tenha orgulho!',
	'BBPROFILE_LOCATION_TEXT'     => 'Quer compartilhar a sua localização? O quê, você nos chamou de stalkers?! Mas sempre aceita no Smartphone!',
	'BBPROFILE_LOCATION_BUTTON'   => 'Ok! Quero encontrar vizinhos nerds de qualquer jeito!',

	'BBPROFILE_FACEBOOK_TEXT'     => 'Faça novas amizades, mas não fale com estranhos (dica da Mamãe Siny).',
	'BBPROFILE_FACEBOOK_BUTTON'   => 'Adicione a sua conta do Facebook',
	'BBPROFILE_SKYPE_TEXT'        => 'Converse com outras pessoas.',
	'BBPROFILE_SKYPE_BUTTON'      => 'Adicione a sua conta do Skype',
	'BBPROFILE_TWITTER_TEXT'      => 'Deixe seus tweets serem ouvidos.',
	'BBPROFILE_TWITTER_BUTTON'    => 'Adicione a sua conta do Twitter',
	'BBPROFILE_YOUTUBE_TEXT'      => 'Torne seus vídeos populares.',
	'BBPROFILE_YOUTUBE_BUTTON'    => 'Adicione a sua conta do Youtube',
	'BBPROFILE_GOOGLEPLUS_TEXT'   => 'Faça novas amizades.',
	'BBPROFILE_GOOGLEPLUS_BUTTON' => 'Adicione a sua conta do Google+',

	'BBPROFILE_FIRST_POST_TEXT'   => 'Envolva-se na discussão. Selecione um fórum e crie um novo tópico!',
	'BBPROFILE_FIRST_POST_BUTTON' => 'Crie a sua primeira postagem.',

	'BBPROFILE_CPF_TEXT'      => 'Qual é o seu %s?',
	'BBPROFILE_CPF_BTN_LABEL' => 'Adicionar %s',
]);
