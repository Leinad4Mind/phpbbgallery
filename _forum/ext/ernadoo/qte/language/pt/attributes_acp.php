<?php

/**
 * @package Quick Title Edition Extension for phpBB.
 * @copyright (c) 2015 ABDev
 * @copyright (c) 2015 PastisD
 * @copyright (c) 2015 Geolim4 <http://geolim4.com>
 * @copyright (c) 2015 Zoddo <zoddo.ino@gmail.com>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

// ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

// init lang ary, if it doesn't !
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// administration
$lang = array_merge($lang, [
	'QTE_ADD'          => 'Adicionar um novo atributo',
	'QTE_ADD_EXPLAIN'  => 'Aqui podes definir os novos campos de atributos.',
	'QTE_EDIT'         => 'Editar atributo',
	'QTE_EDIT_EXPLAIN' => 'Aqui podes modificar os campos do atributo selecionado.',

	'QTE_FIELDS'              => 'Campos de atributo',
	'QTE_TYPE'                => 'Tipo de atributo',
	'QTE_TYPE_TXT'            => 'Texto',
	'QTE_TYPE_IMG'            => 'Imagem',
	'QTE_NAME'                => 'Nome do atributo',
	'QTE_NAME_EXPLAIN'        => '- Usa a constante de idioma se o nome for exibido a partir do ficheiro de idioma, ou insere diretamente o nome do atributo.<br /> - Insere <strong>%%mod%%</strong>: irá exibir o nome de utilizador que aplicou o atributo.<br /> - Insere <strong>%%date%%</strong>: irá exibir a data do dia em que o atributo foi aplicado.<br /><br /> - Exemplo: <strong>[Resolvido por %%mod%%]</strong> exibirá <strong>[Resolvido por %s]</strong>',
	'QTE_DESC'                => 'Descrição do atributo',
	'QTE_DESC_EXPLAIN'        => 'Podes inserir um breve comentário, que será usado para diferenciar teus atributos se alguns precisarem ter o mesmo nome.',
	'QTE_IMG'                 => 'Imagem do atributo',
	'QTE_IMG_EXPLAIN'         => 'Podes usar o nome da imagem se estiver guardado no imageset, ou aproveitar o caminho relativo da imagem.',
	'QTE_DATE'                => 'Formato da data do atributo',
	'QTE_DATE_EXPLAIN'        => 'A sintaxe utilizada é idêntica à função PHP <a href="http://www.php.net/date">date()</a>.',
	'QTE_COLOUR'              => 'Cor do atributo',
	'QTE_COLOUR_EXPLAIN'      => 'Seleciona um valor do <strong>seletor de cores</strong>, ou insere-o diretamente.',
	'QTE_USER_COLOUR'         => 'Cor do nome de utilizador, que aplicou o atributo',
	'QTE_USER_COLOUR_EXPLAIN' => 'Se usares o argumento <strong>%mod%</strong> e essa opção estiver ativa, a cor do grupo de utilizadores será aplicada.',
	'QTE_COPY_AUTHS'          => 'Copiar permissões de',
	'QTE_COPY_AUTHS_EXPLAIN'  => 'Se optares por copiar permissões, o atributo terá as mesmas permissões que as que selecionaste aqui. Isso substituirá todas as permissões que definiste anteriormente para esse atributo pelas permissões do atributo que selecionaste aqui. Se a opção <strong>Personalizada</strong> for selecionada, as permissões atuais serão mantidas.',

	'QTE_ALLOWED_GROUPS'           => 'Grupos permitidos',
	'QTE_ALLOWED_GROUPS_EXPLAIN'   => 'Grupos, que são autorizados a usar esse atributo.<br /> Seleciona vários grupos segurando <samp>CTRL</samp> ou <samp>COMANDO</samp> e clicando sobre.',
	'QTE_ALLOWED_AUTHOR'           => 'Permitir que o autor do tópico use esse atributo nos fóruns selecionados',
	'QTE_ALLOWED_AUTHOR_EXPLAIN'   => 'Se essa opção estiver ativada, o autor do tópico poderá usar esse atributo, mesmo que ele não seja um membro dos grupos selecionados.',
	'QTE_COPY_PERMISSIONS'         => 'Copiar permissões de atributos',
	'QTE_COPY_PERMISSIONS_EXPLAIN' => 'Quando criado, o fórum terá as mesmas permissões de atributos que as que selecionaste. Se nenhum fórum for selecionado, os atributos não serão exibidos enquanto as tuas permissões não forem definidas.',

	'QTE_AUTH_ADD'            => 'Adicionar uma permissão',
	'QTE_AUTH_REMOVE'         => 'Remover essa permissão',
	'QTE_AUTH_NO_PERMISSIONS' => 'Não copiar permissões',

	'QTE_ATTRIBUTE'  => 'Atributo',
	'QTE_ATTRIBUTES' => 'Atributos',
	'QTE_USAGE'      => 'Uso',

	'QTE_CSS'  => 'Provavelmente gerido pelo CSS',
	'QTE_NONE' => 'N/D',

	'QTE_MUST_SELECT'         => 'Deves selecionar um atributo.',
	'QTE_NAME_ERROR'          => 'O campo "Nome do atributo" parece estar vazio.',
	'QTE_DESC_ERROR'          => 'O campo "Descrição do atributo" parece ser muito longo.',
	'QTE_COLOUR_ERROR'        => 'O campo "Cor do atributo" parece conter um erro.',
	'QTE_DATE_ARGUMENT_ERROR' => 'Definiste um formato de data. Mas não definiste o argumento <strong>%date%</strong> dentro do teu atributo.',
	'QTE_DATE_FORMAT_ERROR'   => 'Definiste o argumento <strong>%date%</strong> dentro do teu atributo. Mas não definiste o formato da data.',
	'QTE_USER_COLOUR_ERROR'   => 'Ativaste a opção que garante a cor do nome de utilizador. Mas não definiste o argumento <strong>%mod%</strong> dentro do teu atributo.',
	'QTE_FORUM_ERROR'         => 'Não podes especificar uma categoria ou um link do fórum.',

	'QTE_ADDED'   => 'Um novo atributo foi adicionado.',
	'QTE_UPDATED' => 'O atributo selecionado foi atualizado.',
	'QTE_REMOVED' => 'O atributo selecionado foi eliminado.',

	'QTE_MIGRATIONS_OUTDATED' => 'A tua base de dados não está atualizada.<br />Desativa e reativa a extensão para a atualizar.<br /><br />Versão da base de dados: %1$s<br />Versão dos ficheiros: %2$s',
]);

// forums
$lang = array_merge($lang, [
	'QTE_TOPICS_ATTR_SETTINGS' => 'Configurações dos atributos do tópico',

	'QTE_DEFAULT_ATTR'         => 'Atributo padrão do fórum',
	'QTE_DEFAULT_ATTR_EXPLAIN' => 'O atributo selecionado será aplicado quando um novo tópico for criado, independentemente das permissões do utilizador.',
	'QTE_FORCE_USERS'          => 'Forçar utilizadores a aplicar um atributo ao tópico',
	'QTE_FORCE_USERS_EXPLAIN'  => 'Se ativado, os utilizadores terão que selecionar um atributo para o tópico nesse fórum.',
]);
