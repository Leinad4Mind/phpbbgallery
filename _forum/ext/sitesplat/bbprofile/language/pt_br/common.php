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
	'COMPLETE_PROFILE_TITLE' => 'Completa o seu perfil',
	'COMPLETED_PERCENTAGE'   => '%d%% completo',

	'BBPROFILE_BIRTHDATE_TEXT'   => 'Deixa os seus amigos goldtuganianos desejarem-te um feliz aniversário.',
	'BBPROFILE_BIRTHDATE_BUTTON' => 'Adiciona lá a data',
	'BBPROFILE_SIGNATURE_TEXT'   => 'Usa para promover os seus projetos e as suas ideias!',
	'BBPROFILE_SIGNATURE_BUTTON' => 'Adiciona uma assinatura',
	'BBPROFILE_AVATAR_TEXT'      => 'Expressa-te e mostra-nos quem és e que personalidade é a sua!',
	'BBPROFILE_AVATAR_BUTTON'    => 'Adiciona um avatar',

	'BBPROFILE_INTERESTS_TEXT'    => 'Anda lá, deixa de ser cortes e partilha com os seus amigos os seus interesses',
	'BBPROFILE_INTERESTS_BUTTON'  => 'Adiciona os seus interesses',
	'BBPROFILE_OCCUPATION_TEXT'   => 'O que é que fazes mesmo? Não digas "PLEASE"! Basta-nos um Barney Stinson!',
	'BBPROFILE_OCCUPATION_BUTTON' => 'Adiciona os seus hobbies',
	'BBPROFILE_WEBSITE_TEXT'      => 'Tem algum site ou blog da sua autoria?',
	'BBPROFILE_WEBSITE_BUTTON'    => 'Promove o que é seu, orgulha-te!',
	'BBPROFILE_LOCATION_TEXT'     => 'Desejas partilhar a sua localização? O quê, chamaste-nos stalkers?! Mas você aceitas sempre no Smartphone!',
	'BBPROFILE_LOCATION_BUTTON'   => 'Ok! Quero encontrar vizinhos nerds!',

	'BBPROFILE_FACEBOOK_TEXT'     => 'Cria novas amizades, mas não fales com estranhos (Dica da mãezinha, Siny).',
	'BBPROFILE_FACEBOOK_BUTTON'   => 'Adiciona a sua conta Facebook',
	'BBPROFILE_SKYPE_TEXT'        => 'Se és daqueles que gosta de videochamadas em grupo e conhecer novas pessoas, partilha aí o skype.',
	'BBPROFILE_SKYPE_BUTTON'      => 'Adiciona a sua conta Skype',
	'BBPROFILE_TWITTER_TEXT'      => 'Faz ouvir os seus tweets.',
	'BBPROFILE_TWITTER_BUTTON'    => 'Adiciona a sua conta Twitter',
	'BBPROFILE_YOUTUBE_TEXT'      => 'Torna o seu canal mais popular ainda.',
	'BBPROFILE_YOUTUBE_BUTTON'    => 'Adiciona a sua conta YouTube',
	'BBPROFILE_GOOGLEPLUS_TEXT'   => 'Cria novas amizades.',
	'BBPROFILE_GOOGLEPLUS_BUTTON' => 'Adiciona a sua conta Google+',

	'BBPROFILE_FIRST_POST_TEXT'   => 'Envolve-te na comunidade e nas suas discussões e convívios. Seleciona um fórum e cria um tópico novo!',
	'BBPROFILE_FIRST_POST_BUTTON' => 'Cria a sua primeira mensagem! Apresenta-te!',

	'BBPROFILE_CPF_TEXT'      => 'Conta-nos mais sobre ti, %s, tem?',
	'BBPROFILE_CPF_BTN_LABEL' => 'Preenche o campo %s',
]);
