<?php

/**
 * @package BBrandom for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'ALLOW_RGRAVATAR'           => 'Permitir Gravatares Aleatórios',
	'DEFAULT_RGRAVATAR'         => 'Definir Gravatar Aleatório por padrão para novos usuários',
	'DEFAULT_RGRAVATAR_EXPLAIN' => 'Isso vai atribuir um Gravatar aleatório aos Usuários Recém-Registrados<br />Esta opção também estará disponível em UCP &#62; Perfil &#62; Editar avatar',
	'DEFAULT_CUAVATAR'          => 'Definir Avatar Personalizado por padrão para novos usuários',
	'DEFAULT_CUAVATAR_EXPLAIN'  => 'Envie as imagens que você deseja usar como avatares aleatórios para <strong>root/images/avatars/random/</strong> antes de usar esta função!<br /> Isso é apenas para os Usuários Recém-Registrados e não estará disponível em UCP &#62; Perfil &#62; Editar avatar',
	'DEFAULT_RGRAVATAR_STYLE'   => 'Estilo padrão do Gravatar Aleatório',

	'SS_HELPER_NOTY'     => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBRANDOM_NOTICE'    => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se em <strong> ACP &#62; Configuração do fórum &#62; Configurações de avatar</strong> <br>Também em: <strong>ACP &#62; Usuários e grupos &#62; Gerenciar Usuários &#62; Administração de usuários &#62;</strong> Selecione o usuário e envie, depois no menu suspenso clique em "avatar".<br />Cada usuário também pode escolher se deseja usar um avatar aleatório em <strong>UCP &#62; Perfil &#62; Editar avatar</strong>. As imagens de avatar personalizadas devem ser enviadas para <strong>root/images/avatars/random/</strong></p></div>',
	'BBRANDOM_SITESPLAT' => '<i class="icon fa fa-info-circle"></i>Extensão de Avatares Aleatórios por <a href="https://sitesplat.com" title="Professional Web Development"><strong>SiteSplat.com</strong></a> desenvolvida para os <a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="Professional Premium Themes"><strong>Temas da SiteSplat</strong></a>',
]);

// Description of extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details' => [
		'details' => [
			'DESCRIPTION_1' => 'Gravatares Aleatórios',
			'DESCRIPTION_2' => 'Para cada usuário',
			'DESCRIPTION_3' => 'Hospedado em gravatar.com',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para o phpBB 3.2'
		]
	]
]);
