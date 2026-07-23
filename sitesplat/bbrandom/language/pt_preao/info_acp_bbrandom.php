<?php

/**
 * @package BBrandom for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ALLOW_RGRAVATAR'           => 'Permitir Gravatares Aleatórios',
	'DEFAULT_RGRAVATAR'         => 'Definir Gravatar Aleatório por padrão para novos utilizadores',
	'DEFAULT_RGRAVATAR_EXPLAIN' => 'Isto irá atribuir um Gravatar aleatório aos Utilizadores Recém-Registados<br />Esta opção também estará disponível em UCP &#62; Perfil &#62; Editar avatar',
	'DEFAULT_CUAVATAR'          => 'Definir Avatar Personalizado por padrão para novos utilizadores',
	'DEFAULT_CUAVATAR_EXPLAIN'  => 'Carrega as imagens que desejas usar como avatares aleatórios para <strong>root/images/avatars/random/</strong> antes de usares esta função!<br /> Isto é apenas para os Utilizadores Recém-Registados e não estará disponível em UCP &#62; Perfil &#62; Editar avatar',
	'DEFAULT_RGRAVATAR_STYLE'   => 'Estilo padrão do Gravatar Aleatório',

	'SS_HELPER_NOTY'     => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBRANDOM_NOTICE'    => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong> ACP &#62; Configuração do fórum &#62; Configurações de avatar</strong> <br>Também em: <strong>ACP &#62; Utilizadores e grupos &#62; Gerir Utilizadores &#62; Administração de utilizadores &#62;</strong> Selecciona o utilizador e submete, depois no menu suspenso clica em "avatar".<br />Cada utilizador também pode escolher se deseja usar um avatar aleatório em <strong>UCP &#62; Perfil &#62; Editar avatar</strong>. As imagens de avatar personalizadas devem ser carregadas em <strong>root/images/avatars/random/</strong></p></div>',
	'BBRANDOM_SITESPLAT' => '<i class="icon fa fa-info-circle"></i>Extensão de Avatares Aleatórios por <a href="https://sitesplat.com" title="Professional Web Development"><strong>SiteSplat.com</strong></a> desenvolvida para os <a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="Professional Premium Themes"><strong>Temas da SiteSplat</strong></a>',
]);

// Description of extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details' => [
		'details' => [
			'DESCRIPTION_1' => 'Gravatares Aleatórios',
			'DESCRIPTION_2' => 'Para cada utilizador',
			'DESCRIPTION_3' => 'Alojado em gravatar.com',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para o phpBB 3.2'
		]
	]
]);
