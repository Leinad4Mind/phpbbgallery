<?php

/**
 * phpBB Ajax likeBB.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
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
	'LIKEBB_NOTICE'                                => '<div style="width:auto;margin:20px auto;"><p>A configuração desta extensão está em <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Certifique-se de verificar as permissões de Grupo e ajustá-las conforme necessário. Por padrão, o grupo de Usuários Registrados pode gostar e desgostar de postagens.</p></div>',
	'ACP_LIKEBB_TITLE'                             => 'phpBB Ajax likeBB',
	'LIKEBB_DISLIKE_OFF'                           => 'Desabilitar a função de Desgostar',
	'LIKEBB_DISLIKE_OFF_EXPLAIN'                   => 'Ativa/desativa todo o sistema de desgostos. <br />OBSERVAÇÃO: É possível uma permissão granular com a "Permissão de Grupo", já que você pode definir a permissão de gostar/desgostar para cada Grupo.<br /> ACP > Usuários e Grupos > Permissão de Grupo "selecione o Grupo" e depois escolha "Pode gostar de postagens" e "Pode desgostar de postagens".',
	'LIKEBB_LIKE_STYLE'                            => 'Cores dos botões de gostar/desgostar',
	'LIKEBB_LIKE_STYLE_EXPLAIN'                    => 'Selecione uma classe CSS a ser aplicada aos botões de gostar/desgostar<br /> OBSERVAÇÃO: A classe <strong>btn-l-cst</strong> permite que você defina o seu próprio CSS personalizado.<br /> Certifique-se de adicioná-la na sua folha de estilos custom.css',
	'LIKEBB_LIKE_ICON'                             => 'Seletor de ícone para gostar/desgostar',
	'LIKEBB_LIKE_ICON_EXPLAIN'                     => 'Escolha o ícone para os seus botões de gostar/desgostar',
	'LIKEBB_LIKE_LIST'                             => 'Lista de quem gostou no tópico',
	'LIKEBB_LIKE_LIST_EXPLAIN'                     => 'Ativa/desativa a lista de usuários que gostaram na visualização do tópico',
	'LIKEBB_MAX_DISLIKES'                          => 'Máx. de desgostos',
	'LIKEBB_MAX_DISLIKES_EXPLAIN'                  => 'Número máx. de desgostos até a postagem ser ocultada da visualização. 0 desativa a função',
	'LIKEBB_LIKE_GLOBAL'                           => 'Gostar/desgostar de Anúncios Globais',
	'LIKEBB_LIKE_GLOBAL_EXPLAIN'                   => 'Ativa/desativa gostar/desgostar em Anúncios Globais',
	'LIKEBB_LIKE_LOCKED'                           => 'Gostar/desgostar de tópicos bloqueados',
	'LIKEBB_LIKE_LOCKED_EXPLAIN'                   => 'Ativa/desativa gostar/desgostar em tópicos bloqueados',
	'ACL_U_LIKEBB'                                 => 'Pode usar o módulo UCP do LikeBB e a página Top 10 do LikeBB',
	'SS_HELPER_NOTY'                               => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'LIKEBB_BUTTON_POSITION'                       => 'Posição do botão',
	'LIKEBB_BUTTON_POSITION_EXPLAIN'               => 'Onde mostrar o botão de gostar/desgostar',
	'LIKEBB_BUTTON_POSITION_ALL'                   => 'Todas as postagens',
	'LIKEBB_BUTTON_POSITION_FIRST_POST_ONLY'       => 'Apenas na primeira postagem',
	'LIKEBB_BUTTON_POSITION_ALL_EXCEPT_FIRST_POST' => 'Todas exceto a primeira postagem',
]);
