<?php

/**
 * @package Dropbox Upload for phpBB.
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/// DEVELOPERS PLEASE NOTE
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'CREATE_NEW_APP'      => 'Criar uma nova aplicação na plataforma Dropbox',
	'CREATE_NEW_APP_TEXT' => '<strong>Para criar uma nova aplicação Dropbox precisa ter uma conta Dropbox.</strong><br>Depois vá para <a href="https://www.dropbox.com/developers/apps/create">https://www.dropbox.com/developers/apps/create</a> e inicie a sessão, se necessário.<br><br>- Selecione Dropbox API.<br>- Escolha o tipo de acesso que precisa = App folder.<br>- Introduza um nome para a sua aplicação.<br>- Clique em "Create app".<br><br>- Vá a Oauth2 e clique em "Generate access code"<br>- <strong>Tome nota dos detalhes nesta página e insira-os no formulário acima</strong> (pode voltar a esta página em qualquer altura).',

	'DROPBOX_UPLOAD_ENABLE'          => 'Ativar upload para o Dropbox',
	'DROPBOX_FOLDER'                 => 'Pasta Dropbox',
	'DROPBOX_FOLDER_EXPLAIN'         => 'A pasta Dropbox (dentro da pasta "Apps") para onde os backups serão carregados. Deixar isto em branco fará o upload dos backups para a pasta raiz da aplicação.<br>Qualquer pasta inserida aqui será criada automaticamente.',
	'DROPBOX_FOLDER_OPTIONS'         => 'Opções de pasta',
	'DROPBOX_FOLDER_OPTIONS_EXPLAIN' => 'Selecione a opção para criação "inteligente" de pastas.<br>A opção padrão usará o nome da pasta inserido acima, enquanto qualquer outra opção criará uma pasta baseada nas opções de data selecionadas.<br>Estas pastas serão criadas automaticamente.',
	'DROPBOX_FREQUENCY'              => 'Frequência de upload',
	'DROPBOX_FREQUENCY_EXPLAIN'      => 'Com que frequência o backup deve ser carregado para o Dropbox.<br>Definir isto como "1" resultará em todos os backups a serem carregados para o Dropbox - qualquer outro valor significará que cada <em>enésimo</em> backup será carregado.',
	'DROPBOX_KEY'                    => 'Chave Dropbox (App key)',
	'DROPBOX_KEY_EXPLAIN'            => 'A chave da aplicação Dropbox a partir da aplicação Dropbox.',
	'DROPBOX_SECRET'                 => 'Segredo Dropbox (App secret)',
	'DROPBOX_SECRET_EXPLAIN'         => 'A chave secreta da aplicação Dropbox a partir da aplicação Dropbox.',
	'DROPBOX_TOKEN'                  => 'Token de acesso Dropbox',
	'DROPBOX_TOKEN_EXPLAIN'          => 'O token de acesso do Dropbox a partir da aplicação Dropbox.',
	'DROPBOX_UPLOAD_EXPLAIN'         => 'Insira aqui os parâmetros necessários para permitir que ficheiros sejam carregados para a sua conta Dropbox.<br><br><strong>Nota: Esta extensão <em>NÃO</em> remove nenhuns ficheiros da conta Dropbox - isso terá de ser feito manualmente.</strong>',
	'DROPBOX_UPLOAD_OPTIONS'         => 'Opções de upload do Dropbox',

	'dbx_folder_opts' => [
		'DEFAULT'     => 'Padrão',
		'CURRENT_DAY' => 'Dia actual',
		'DAY_OF_WEEK' => 'Dia da semana',
		'WEEK_NO'     => 'Número da semana',
		'MONTH'       => 'Mês',
		'YEAR'        => 'Ano',
		'MONTH_YEAR'  => 'Mês/Ano',
	],
]);
