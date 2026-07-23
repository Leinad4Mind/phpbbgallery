<?php

/**
 * @package BBprefix for phpBB.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
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
	'ACP_BBPREFIX_MANAGEMENT' => 'Gerenciamento do BBprefix',
	'ACP_BBPREFIX_MANAGE'     => 'Gerenciar BBprefix',

	'ACP_BBPREFIX_MANAGE_EXPLAIN' => 'Nesta página, você pode gerenciar os prefixos de tópico do seu fórum. É possível usar variáveis no seu prefixo. BBcodes personalizados também são suportados, para que você possa criar prefixos divertidos e flexíveis. <br />Você também pode excluir fóruns e excluir grupos do uso de prefixos. Divirta-se!!!',
	'BBPREFIX_MANAGE_EXONE'       => '<h3>Um ícone Font Awesome pode ser:</h3> <br /><br /><strong>Uso do BBCode:</strong> <code>[fa-bug][/fa-bug]</code> <br /><strong>Substituição em HTML</strong> <code>&lt;i class=&quot;fa fa-bug&quot;&gt;&lt;/i&gt;</code> <br /><strong>Uso no prefixo:</strong> <code>[fa-bug][/fa-bug]</code>',
	'BBPREFIX_MANAGE_EXTWO'       => '<h3>Etiquetas Bootstrap podem ser:</h3> <br /><br /><strong>Uso do BBCode:</strong> <code>[label-warning][/label-warning]</code> <br /><strong>Substituição em HTML</strong> <code>&lt;span class=&quot;label label-warning&quot;&gt;MyTextHere&lt;/span&gt;</code> <br /><strong>Uso no prefixo:</strong> <code>[label-warning][/label-warning]</code> ',
	'BBPREFIX_MANAGE_EXTHREE'     => '<h3>Um bbcode baseado em imagem pode ser:</h3> <br /><br /><strong>Uso do BBCode:</strong> <code>[img-owl][/img-owl]</code> <br /><strong>Substituição em HTML</strong> <code>&lt;img class="bbprefix-index-tag" src=&quot;https://cdn2.iconfinder.com/data/icons/thesquid-ink-40-free-flat-icon-pack/64/owl-20.png&quot; alt=""&gt;</code> <br /><strong>Uso no prefixo:</strong> <code>[img-owl][/img-owl]</code><br />**<small>Observe que a classe class="bbprefix-index-tag" nas imagens é necessária para garantir que o tamanho máximo correto seja aplicado na página do índice.</small>',


	'TITLE_EXPLAIN_TIPS'         => 'Dicas e Utilização:',
	'TITLE_EXPLAIN_TIPS_EXPLAIN' => 'As variáveis atualmente permitidas são: (<strong>{DATE}</strong>, <strong>{POSTER}</strong> e <strong>{USERNAME}</strong>)<br /> Os BBcodes personalizados precisam ser criados <strong>primeiro</strong> e só depois podem ser usados no BBprefix, por exemplo assim:',
	'TITLE_EXPLAIN_TIPS_STAR'    => '<small>**Crie primeiro o seu BBcode personalizado em ACP > POSTAGEM > Mensagens > BBcodes e só depois crie a sua entrada no BBprefix.</small>',

	'BBPREFIX_NOTICE' => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'  => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',

	'ACP_BBPREFIX'  => 'Prefixos de Tópico',
	'PREFIX_NAME'   => 'Nome do prefixo',
	'PREFIX_PARSED' => 'Prefixo',
	'EX_FORUMS'     => 'Fóruns excluídos',
	'USED'          => 'Usado',
	'ADD_PREFIX'    => 'Novo Prefixo',

	'BBPREFIX_TITLE'            => 'Prefixo',
	'BBPREFIX_TITLE_EXPLAIN'    => 'Isto é o que será efetivamente exibido antes do título do tópico. BBCode é suportado. <br />Podem ser usadas certas variáveis, que serão substituídas por dados reais quando o prefixo for aplicado. <br />Consulte <strong>Uso no prefixo</strong> abaixo, em <strong>Dicas e Utilização</strong>, sobre como usar o prefixo criado a partir do BBcode',
	'BBPREFIX_NAME'             => 'Nome do prefixo',
	'BBPREFIX_NAME_EXPLAIN'     => 'Este é um identificador único para ajudar você a diferenciar entre prefixos.',
	'BBPREFIX_ON_INDEX'         => 'Prefixo na lista de tópicos',
	'BBPREFIX_ON_INDEX_EXPLAIN' => 'Exibe os prefixos nas páginas de índice e de fórum. Se um prefixo não tiver permissão para ser exibido, não haverá prefixo nessas páginas onde os títulos dos tópicos são exibidos.<br />Isso é particularmente útil quando há muitos prefixos em uso e, por isso, poderiam sobrecarregar visualmente a lista de tópicos.<br /><br />',
	'BBPREFIX_FORUMS'           => 'Excluir fóruns',
	'BBPREFIX_FORUMS_EXPLAIN'   => 'Especifique quais fóruns são excluídos do uso deste prefixo.',
	'BBPREFIX_GROUPS'           => 'Grupos',
	'BBPREFIX_GROUPS_EXPLAIN'   => 'Especifique quais grupos podem aplicar este prefixo.',

	'DELETE_PREFIX'         => 'Tem certeza de que quer excluir o prefixo especificado?',
	'DELETE_PREFIX_CONFIRM' => 'O prefixo e todas as suas instâncias serão excluídos. Esta ação não pode ser desfeita.',

	'BBPREFIX_EMPTY_ERROR' => 'Nome e/ou prefixo vazios',
	'BBPREFIX_NAME_ERROR'  => 'Este ID de BBprefix já está sendo usado',
	'BBPREFIX_TITLE_ERROR' => 'Este prefixo já existe',

	'PREFIX_ADDED_SUCCESS'   => 'O prefixo foi adicionado com sucesso.',
	'PREFIX_EDITED_SUCCESS'  => 'O prefixo foi atualizado com sucesso.',
	'PREFIX_DELETED_SUCCESS' => 'O prefixo foi excluído com sucesso.',
	'NO_PREFIX_ID_SPECIFIED' => 'Você precisa especificar um ID de prefixo válido.',

	'BBPREFIX_DESCRIPTION' => 'Adiciona prefixos poderosos e estilosos aos tópicos do fórum',
	'BBPREFIX_DEVELOPERS'  => 'Desenvolvedores',
	'BBPREFIX_TASKS_1'     => 'Opções inteligentes',
	'BBPREFIX_TASKS_2'     => 'Suporte a BBcode',
	'BBPREFIX_TASKS_3'     => 'Suporta imagens, texto, etiquetas, tudo o que você puder colocar em um BBcode',
	'BBPREFIX_TASKS_4'     => 'Exclusão de fóruns',
	'BBPREFIX_TASKS_5'     => 'Exclusão de grupos',
	'BBPREFIX_TASKS_6'     => 'Muito mais..!',

	'SITESPLAT_COM'             => 'https://sitesplat.com',
	'SITESPLAT_COPY'            => '&#169; SiteSplat',
	'LICENSE_INFO'              => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'       => 'Desenvolvedor',
	'ACP_BBPREFIX_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBPREFIX_VERSION' => '1.0.10',
	'ACP_BBPREFIX'         => 'BBprefix',
	'ACP_LOADING'          => 'Aguarde. Carregando...'
]);

// Description misc
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Múltiplos prefixos',
			'DESCRIPTION_2' => 'Limitado por grupo e/ou por fórum',
			'DESCRIPTION_3' => 'Uso de variáveis',
			'DESCRIPTION_4' => 'Estatísticas',
		],
		'note' => [
			'NOTICE_1' => 'versão do php > 5.4',
			'NOTICE_2' => 'pronto para o phpBB 3.2'
		]
	]
]);
