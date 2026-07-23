<?php

/**
 * phpBB Ajax likeBB.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'LIKEBB_NOTICE'                                => '<div style="width:auto;margin:20px auto;"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Certifica-te de verificar as permissões de Grupo e ajustá-las conforme necessário. Por predefinição, o grupo de Utilizadores Registados pode gostar e desgostar de mensagens.</p></div>',
	'ACP_LIKEBB_TITLE'                             => 'phpBB Ajax likeBB',
	'LIKEBB_DISLIKE_OFF'                           => 'Desativar a função de Desgostar',
	'LIKEBB_DISLIKE_OFF_EXPLAIN'                   => 'Ativa/desativa todo o sistema de desgostos. <br />NOTA: É possível uma permissão granular com a "Permissão de Grupo", já que podes definir a permissão de gostar/desgostar para cada Grupo.<br /> ACP > Utilizadores e Grupos > Permissão de Grupo "seleciona o Grupo" e depois escolhe "Pode gostar de mensagens" e "Pode desgostar de mensagens".',
	'LIKEBB_LIKE_STYLE'                            => 'Cores dos botões de gostar/desgostar',
	'LIKEBB_LIKE_STYLE_EXPLAIN'                    => 'Seleciona uma classe CSS a aplicar aos botões de gostar/desgostar<br /> NOTA: A classe <strong>btn-l-cst</strong> permite-te definir o teu próprio CSS personalizado.<br /> Certifica-te de o adicionares à tua folha de estilos custom.css',
	'LIKEBB_LIKE_ICON'                             => 'Seletor de ícone para gostar/desgostar',
	'LIKEBB_LIKE_ICON_EXPLAIN'                     => 'Escolhe o ícone para os teus botões de gostar/desgostar',
	'LIKEBB_LIKE_LIST'                             => 'Lista de quem gostou no tópico',
	'LIKEBB_LIKE_LIST_EXPLAIN'                     => 'Ativa/desativa a lista de utilizadores que gostaram na visualização do tópico',
	'LIKEBB_MAX_DISLIKES'                          => 'Máx. de desgostos',
	'LIKEBB_MAX_DISLIKES_EXPLAIN'                  => 'Número máx. de desgostos até a mensagem ser ocultada da visualização. 0 desativa a função',
	'LIKEBB_LIKE_GLOBAL'                           => 'Gostar/desgostar de Anúncios Globais',
	'LIKEBB_LIKE_GLOBAL_EXPLAIN'                   => 'Ativa/desativa gostar/desgostar em Anúncios Globais',
	'LIKEBB_LIKE_LOCKED'                           => 'Gostar/desgostar de tópicos bloqueados',
	'LIKEBB_LIKE_LOCKED_EXPLAIN'                   => 'Ativa/desativa gostar/desgostar em tópicos bloqueados',
	'ACL_U_LIKEBB'                                 => 'Pode utilizar o módulo UCP do LikeBB e a página Top 10 do LikeBB',
	'SS_HELPER_NOTY'                               => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'LIKEBB_BUTTON_POSITION'                       => 'Posição do botão',
	'LIKEBB_BUTTON_POSITION_EXPLAIN'               => 'Onde mostrar o botão de gostar/desgostar',
	'LIKEBB_BUTTON_POSITION_ALL'                   => 'Todas as mensagens',
	'LIKEBB_BUTTON_POSITION_FIRST_POST_ONLY'       => 'Apenas na primeira mensagem',
	'LIKEBB_BUTTON_POSITION_ALL_EXCEPT_FIRST_POST' => 'Todas exceto a primeira mensagem',
]);
