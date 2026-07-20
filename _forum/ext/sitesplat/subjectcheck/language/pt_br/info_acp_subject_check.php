<?php

/**
 * Subject Check. An extension for the phpBB Forum Software package.
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	// ACP labels
	'ACP_SUBJECT_CHECK_TITLE'      => 'Verificação de Títulos/Assuntos',
	'SUBJECT_CHECK_ENABLE'         => 'Habilitar a verificação de títulos/assuntos',
	'SUBJECT_CHECK_ENABLE_EXPLAIN' => 'Desligar esta funcionalidade irá desativá-la em todos os fóruns.',
	'SUBJECT_CHECK_BYPASS'         => 'Permitir ignorar',
	'SUBJECT_CHECK_BYPASS_EXPLAIN' => 'Ignorar (bypassing) permite que uma pessoa publique o seu tópico mesmo depois de lhe ter sido apresentada uma lista de tópicos semelhantes.',
	'SUBJECT_CHECK_STRICT'         => 'Habilitar o modo estrito',
	'SUBJECT_CHECK_STRICT_EXPLAIN' => 'Verifica apenas se existem tópicos que tenham títulos/assuntos idênticos.',
	'SUBJECT_CHECK_AJAX'           => 'Habilitar o modo AJAX',
	'SUBJECT_CHECK_AJAX_EXPLAIN'   => 'Exibe resultados sem exigir um carregamento de página em separado.',
	'SUBJECT_CHECK_LOCKED'         => 'Verificar tópicos trancados',
	'SUBJECT_CHECK_LOCKED_EXPLAIN' => 'Verifique os tópicos trancados ao verificar títulos/assuntos.',
	'SUBJECT_CHECK_POP'            => 'Abrir links de tópicos numa nova janela',
	'SUBJECT_CHECK_POP_EXPLAIN'    => 'Abre os links dos tópicos listados numa nova janela do navegador (browser).',
	'SUBJECT_CHECK_ADMIN'          => 'Substituição (Override) de administrador',
	'SUBJECT_CHECK_ADMIN_EXPLAIN'  => 'Permitir que os administradores publiquem sem verificarem os títulos/assuntos.',
	'SUBJECT_CHECK_MOD'            => 'Substituição (Override) de moderador',
	'SUBJECT_CHECK_MOD_EXPLAIN'    => 'Permitir que os moderadores publiquem sem verificarem os títulos/assuntos.',
	'SUBJECT_CHECK_COMMON'         => 'Verificar palavras comuns',
	'SUBJECT_CHECK_COMMON_EXPLAIN' => 'Palavras comuns são normalmente ignoradas ao comparar assuntos/títulos.',
	'SUBJECT_CHECK_FORUMS'         => 'Verificar todos os fóruns',
	'SUBJECT_CHECK_FORUMS_EXPLAIN' => 'Verificar todos os fóruns em vez de apenas aquele onde se está a publicar.',
	'SUBJECT_CHECK_FNAMES'         => 'Apresentar nomes dos fóruns',
	'SUBJECT_CHECK_FNAMES_EXPLAIN' => 'Apresenta os nomes dos fóruns antes de cada tópico que é encontrado.',
	'SUBJECT_CHECK_LIMIT'          => 'Número máximo de tópicos a exibir',
	'SUBJECT_CHECK_LIMIT_EXPLAIN'  => 'Defina como 0 para tópicos ilimitados.',
	'SUBJECT_CHECK_ACTIVE'         => 'Verificar os tópicos ativos nestes dias',
	'SUBJECT_CHECK_ACTIVE_EXPLAIN' => 'Verificar apenas os tópicos que tiveram atividade neste número de dias. Defina como 0 para ilimitado.',
	'SUBJECT_CHECK_COUNT'          => 'Contagem de Publicações',
	'SUBJECT_CHECK_COUNT_EXPLAIN'  => 'Os tópicos de usuários acima desta contagem de publicações não serão verificados quanto a tópicos semelhantes. Introduza 0 para desabilitar.',
	'SUBJECT_CHECK_BYPASS_EXACT'   => 'Se não existir correspondência exata',

	'ACP_SUBJECT_CHECK_SETTING_SAVED' => 'As configurações da Verificação de Títulos/Assuntos foram guardadas.',

	'ACP_SUBCHECK_SETTINGS' => 'Configurações',
	'ACP_SUBCHECK'          => 'Verificação de Títulos/Assuntos',
	'SS_HELPER_NOTY'        => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'SUBCHECK_NOTICE'       => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Não se esqueça de verificar/definir a permissão para cada fórum, caso seja necessário. <strong>ACP &#187; FÓRUNS &#187; Editar fórum &#187; Habilitar verificação de título/assunto</strong></p></div>',

	// ACP labels for individual forums
	'SUBJECT_CHECK_FORUM'         => 'Habilitar a verificação de títulos/assuntos',
	'SUBJECT_CHECK_FORUM_EXPLAIN' => 'Verifica os títulos/assuntos dos novos tópicos face aos tópicos existentes.',
]);
