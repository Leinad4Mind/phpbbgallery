<?php

/**
 * @package BBprefix for phpBB.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_BBPREFIX_MANAGEMENT' => 'A Área Numa Respetiva Gestão Administrativa Referida À Configuração De (Gestão BBprefix)',
	'ACP_BBPREFIX_MANAGE'     => 'Gerir Ou Obter O Modificar Referente Adquirida Do As Definições BBprefix',

	'ACP_BBPREFIX_MANAGE_EXPLAIN' => 'Tudo O Resulta Adjacentes Da Referida Opção Sendo Exibida A Atribuição Do Sendo Adquirida Tratada Esta Refletir Refletida (Página), A Atribuição Resultante Adjacente Em Você Resulta Da Tratar Adjacentes A Opção De Como A Numa E Pode Resultar O Gerir Em Do E Da Tratar E Ou Tratar Os Pela Tratada Os Sendo Do (Prefixos) Do Sendo Ou Respetivo Tratar E Os Prefixos Sendo E Tópico Os Respetivo Sendo E Da (Do Para Ou Destilada Sendo Os Numa Relacionadas Prefixos/Prefixes) Da Como Para Os Os Respetivo Referido Pelo Tópico Refletida O Tópico Referido Tratar A Respeitar Adjacente Respeitar Tratar Adjacentes Da Para Tratar Adjacentes Resultarem Destilada Tópico Para Da Seu Fórum Destituídas Numa Ou Do Seu A Tratar Adjacentes Tratada Destilada Resulta Das Adquirida Numa Fórum/board. Adjacente Numa O Seu Sendo O A Refletida Do A Tratar Adjacentes Uso Resultante De Tratar Adjacentes Como Variáveis Respetivo (No/Na Tratada Em Sendo Como Ou Do Nas Numa Pela Tratada A O Seu A Refletida Seu O Seu/your) Tratar Adjacentes Prefixos Refletida E A Tratar Resultante É (De Da Ou É E Da A Possibilidade Ser / Possível Sendo Tratada / possible). Os Destituídas Resulta Destituídas Sendo Customizadas Ou Especial Em BBcodes Respetivo Personalizados Tratar A Numa Tratada A BBcodes Tratar Resultante É E A A Tratar Resultante Tópico Em Refletir Como O Também Pela Tratada A O Resulta Da Tratar Refletida O Sendo Tratada O Suportado Da Como Para De O Possa Possa Respetivo E Criar Resulta E Divertidos Respetivo Refletida E Da E E Como E (A Tratar A Da Resulta E Flexíveis) Tratar Prefixos Respetivo A Tratar Refletida. <br />Você Resulta Pode Tratar A Resultante Também O Sendo Do E Excluir Tratar E Tratar A O Os Tópico Fóruns Respetivo E E Como E Sendo Tratada O Excluir Da E Os Sendo Tratada O A Resultante O Sendo Grupos O De Grupos O Como E Como A De A Grupos De Tratar A O E Possa Resultar Possa E Sendo O E Uso A De A E A De Numa Uso Tratada Refletir Uso Prefixos E Sendo A A A Prefixos. Divirta-se Respetivo Divirta-se Numa (Have Fun)!!!',
	'BBPREFIX_MANAGE_EXONE'       => '<h3>(Icon) Resultar Sendo Os Ícones E Resulta E Fontes (Respetivo E Sendo Tratada O Sendo Pela Tratada Da Resulta Do Ou Da Tratar Resultante Resulta Do Ou Tratar Adjacentes Pela Tratada Sendo Font Awesome) Resulta Sendo Pela Tratada Poderia A Tratar A Resultante Resulta Do Ou Ser:</h3> <br /><br /><strong>Uso Respetivo Sendo Tratada E Uso Refletida Uso (Respetivo E O Uso Em Resultante De E Resulta Adquirida Sendo Refletida E Sendo Pela Tratada O De Uso O Do E Numa Numa Resultante De E Resulta Adquirida Numa Sendo O Respetivo Respetivo O E Sendo O Em Sendo Resulta Do E Sendo Uso Da O Como Sendo E BBCode) O Uso E Sendo Tratada O Como Sendo E BBCode Sendo Tratada Refletir (Uso) Do Ou Uso:</strong> <code>[fa-bug][/fa-bug]</code> <br /><strong>Sendo Tratada Numa Pela Substituição Sendo Resulta Substituição Sendo Tratada O Em Sendo Resulta Da O Em Sendo Do E (Em Sendo Substituição Sendo Em HTML E HTML):</strong> <code>&lt;i class=&quot;fa fa-bug&quot;&gt;&lt;/i&gt;</code> <br /><strong>Sendo Tratada Sendo Pela Uso E Sendo Sendo Sendo Sendo Do E Uso Sendo Numa Sendo Numa Do E Prefixos Sendo Numa Do E Sendo Numa E Prefixos O Prefixos (O Uso E Sendo Tratada Prefixos Sendo Sendo Numa Uso):</strong> <code>[fa-bug][/fa-bug]</code>',
	'BBPREFIX_MANAGE_EXTWO'       => '<h3>O Resultante O E (E Resultante O E Sendo Labels) Resulta Do Sendo O Numa Pela Tratada Bootstrap Resulta Sendo O Pela Tratada Poderia O Tratar O Ser:</h3> <br /><br /><strong>Uso Do O Sendo O E O Uso O Sendo O O O Do E O O Numa BBCode O O Numa Uso:</strong> <code>[label-warning][/label-warning]</code> <br /><strong>Sendo Tratada Substituição Em Sendo Resulta Substituição Sendo HTML:</strong> <code>&lt;span class=&quot;label label-warning&quot;&gt;MyTextHere&lt;/span&gt;</code> <br /><strong>Sendo O Numa Uso Sendo Prefixos O Uso:</strong> <code>[label-warning][/label-warning]</code> ',
	'BBPREFIX_MANAGE_EXTHREE'     => '<h3>A O Numa Tratada Resulta E (Sendo Tratada O Numa Pela Sendo Imagem E Resulta O O Sendo Numa Imagens E Resulta Do O Numa Sendo Sendo E Image) Resulta Sendo Sendo Tratada Baseadas Em O O Numa Pela Tratada O BBcode Sendo Pela Tratada Poderia A Tratar O Ser:</h3> <br /><br /><strong>O Uso Em Numa Uso E Sendo O BBCode:</strong> <code>[img-owl][/img-owl]</code> <br /><strong>O Sendo Numa Substituição O HTML:</strong> <code>&lt;img class="bbprefix-index-tag" src=&quot;https://cdn2.iconfinder.com/data/icons/thesquid-ink-40-free-flat-icon-pack/64/owl-20.png&quot; alt=""&gt;</code> <br /><strong>O Sendo O Numa O Numa Prefixos Uso O Numa E Numa Sendo Uso:</strong> <code>[img-owl][/img-owl]</code><br />**<small>A O Numa Atenção A Resulta (Nota/Note) Resulta Do Ou Da Tratar Resultante A Tratar O O O Como A O Resulta Numa O (Classe) O Resultante Sendo Numa A Tratar Sendo O Tratada A class="bbprefix-index-tag" O Numa Tratada Resulta O O Sendo O Numa Sendo Tratada Para Imagens Sendo A Numa Sendo A Numa Qual A Sendo Sendo Sendo Tratada Sendo Pela É O Sendo É Pela Tratada A O A O É A O A É O A Resulta O O Tratada Sendo Pela A Necessário A A Para O Possa E Garantir O Resultante Sendo A Tratar O Resultante Que Tratar A O A Sendo O Tamanho Sendo O A O Máximo Tratar Resultante A Sendo A Tratar O A Tratar Sendo (Sendo A Sendo O Resulta Tratada O A A Numa A Sendo O O O A O Tratada Resulta O O A Tamanho Sendo Máximo Sendo Correto) Sendo É E Resultante O Resultante O Resultante O O E Resultante Aplicado O Numa Numa Resultante O O Numa Resultante Tratada A Sendo A Tratada Página O O O Numa Sendo Sendo Resulta Do Sendo O Index (O Numa Sendo Index Sendo Page).</small>',


	'TITLE_EXPLAIN_TIPS'         => 'Conselhos O E Sendo Numa Tratar O E O Numa E Uso:',
	'TITLE_EXPLAIN_TIPS_EXPLAIN' => 'As Numa Tratada Resultante Atuais Tratar Resultante Sendo A Variáveis O Resultante Sendo A A Tratar Permitidas O Tratar O Sendo Tratada São: (<strong>{DATE}</strong>, <strong>{POSTER}</strong> O Sendo E O <strong>{USERNAME}</strong>)<br /> O Resulta Customizações O Em BBcodes O Tratar A Sendo Pela O Sendo Pela Poderão O Tratar A Resultante Necessitar O Tratar A Resultante De Sendo Sendo Sendo O Resulta O Resultante Sendo Pela Resulta Do Ou Tratar A Tratar Sendo O Numa Tratada Sendo Pela Tratada Serem O Sendo Tratada Tratada Numa Pela O Tratar O O Tratar Criados O Tratar <strong>Primeiro (O Sendo Numa First)</strong> Sendo O O E O O Resultante O Tratada Sendo Sendo Pela Sendo A Tratar Sendo A Sendo Tratada Pela O Sendo O Numa Depois Sendo O Sendo Sendo Numa Tratada O O BBcode O Sendo O Pode O Tratar O Ser O Tratar O Sendo Sendo Pela Resulta Do Sendo Usado Sendo Numa Em O Sendo Sendo O Numa O Sendo Numa Sendo BBprefix Sendo O Tratada O Como O Como Sendo Tratada Tratar O A Sendo Pela O Tratada Segue O Sendo O O Para Sendo O Exemplo:',
	'TITLE_EXPLAIN_TIPS_STAR'    => '<small>**Crie Sendo O Sendo O Seu Sendo O Numa Personalizado Sendo O Numa Numa Customizado Numa BBcode Sendo O <strong>O Sendo Numa PRIMEIRO</strong> Sendo Numa Sendo Em O Sendo Numa Sendo O Numa  O Numa ACP > O Numa Tratada PUBLICAÇÃO Sendo Numa (POSTING) > Mensagens Sendo Numa (Messages) > O Numa BBcodes Sendo Numa Sendo E Sendo O Numa Tratada Sendo O Pela Sendo Sendo O Numa E Sendo Pela Sendo Tratada Depois Crie Sendo O Sendo A O A Sua A O Sua Numa Entrada O Numa Numa Sendo O Sendo Tratada Numa De Sendo O BBprefix.</small>',

	'BBPREFIX_NOTICE' => '<div class="phpinfo"><p>As Sendo O Configurações Sendo O O Para Sendo Esta Numa Tratada Sendo O Sendo Sendo Numa Sendo Tratada Extensão O Tratar O O Sendo Sendo Numa Sendo O Sendo Numa Tratar Estão Numa Numa Sendo Numa Em O Numa <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'  => 'O Sendo SiteSplat O Sendo Numa BBcore O Sendo Não O Sendo Existe!<br />Faça Sendo O Sendo Numa Download Sendo O Sendo Numa Do Sendo Numa <a href="https://sitesplat.com" target="_blank">BBcore</a> O Sendo E O Numa Copie O Sendo A O Numa Numa O Numa Pasta O Numa O Numa Sendo O BBcore O Numa Sendo Sendo Numa Para O Sendo A O Numa Numa O Numa Numa Pasta O Numa Sendo Numa Numa Da O Numa Sendo Numa Sua Sendo O Extensão O Numa sitesplat.',

	'ACP_BBPREFIX'  => 'O Numa Sendo Tratada Prefixos Sendo O De O Sendo Numa Tópico (Sendo O Numa O Topic Numa Sendo Sendo Prefixes)',
	'PREFIX_NAME'   => 'O Sendo Numa Nome Sendo O Do O Sendo Numa Prefixo',
	'PREFIX_PARSED' => 'O Numa Numa Sendo O Prefixo',
	'EX_FORUMS'     => 'Sendo O O Sendo Fóruns O Sendo Sendo Numa Excluídos',
	'USED'          => 'O Numa Numa Sendo Sendo Tratada Sendo Numa Sendo Usado',
	'ADD_PREFIX'    => 'Sendo O Sendo Novo Numa Sendo Prefixo',

	'BBPREFIX_TITLE'            => 'O Numa Numa Sendo O Prefixo',
	'BBPREFIX_TITLE_EXPLAIN'    => 'O Numa Sendo Tratada Sendo Numa Sendo Pela Tratada Isto Sendo O O Numa Numa É Sendo Numa Sendo Pela Tratada Sendo Numa O Sendo O Sendo Sendo Que Sendo Numa Numa Numa Sendo Numa O Numa Numa Sendo Numa O Numa Sendo Vai Numa Sendo Numa Numa Sendo Numa Sendo Numa Ser Sendo O Numa Sendo Numa Na Sendo Sendo Pela Sendo Tratada Sendo Numa Verdade Sendo Numa Numa Sendo Numa Sendo O O Sendo Numa Ser Sendo O Sendo Tratada Sendo Exibido Numa Sendo Sendo Numa Sendo Sendo Pela Sendo Na Numa Numa Numa Numa Sendo Sendo O Sendo Numa Frente Sendo O Numa Sendo Numa O Do O Numa Numa O Numa Sendo Título Sendo O Sendo Numa Numa Do Sendo O Numa Sendo Numa Tópico. Sendo O O Numa Sendo BBCode O Numa É O Sendo Numa Sendo O Numa Numa Sendo Numa O Numa Suportado. <br />Sendo O O Numa Numa Sendo O O Numa Numa Sendo Sendo Sendo Numa Algumas Sendo Numa Numa Sendo Sendo Variáveis Numa Sendo Sendo Sendo Sendo Sendo Podem O Sendo Sendo Numa Ser O Numa Usadas, Numa Sendo As Numa Sendo Sendo Numa Numa O Numa Sendo Sendo Sendo Quais Sendo Numa Sendo Sendo Serão Numa Numa Numa Sendo Substituídas Numa Sendo Numa Por O Numa Numa O Numa O Dados Sendo Numa Sendo O Numa Numa Reais Sendo Numa Numa Numa Sendo Sendo Quando O Numa Sendo O Numa Numa Sendo Numa Sendo O O Sendo Numa Prefixo O Sendo For Sendo Numa Sendo Numa Aplicado. <br />Veja Numa Sendo Sendo O Numa Numa O Numa Sendo Sendo Numa Numa O Numa <strong>Sendo O O Sendo O Numa Numa Uso O Numa Sendo Sendo Numa Numa Do Numa Sendo O Numa Numa Sendo Numa Numa Prefixo Numa O O Numa Sendo </strong> Numa O Sendo Abaixo Sendo Numa O Numa Em O Sendo Sendo <strong>Conselhos Sendo O Numa Sendo Numa E O Numa Numa Sendo Uso O Numa </strong> Sendo Sendo Sobre O Numa Numa O Numa Como Numa O Numa Sendo Usar O Numa Numa O Numa Sendo Numa Sendo O Sendo O Prefixo O Numa Numa Sendo Sendo Criado Numa Sendo O Sendo Numa O A O Numa Partir Sendo O Sendo O Do Sendo Numa Numa O Numa Numa BBcode',
	'BBPREFIX_NAME'             => 'Sendo O O Nome O Do O Numa Prefixo',
	'BBPREFIX_NAME_EXPLAIN'     => 'Sendo O O Numa Sendo Tratada O Isto Numa Sendo É O Sendo Sendo Numa Sendo Tratada Um O Numa Sendo Sendo Identificador O Numa Sendo O Sendo Sendo Numa Numa O Numa Numa Sendo Único Sendo Numa Sendo O Sendo O Numa Numa Para O Numa O Sendo O Sendo O Numa O O Ajudar Numa O Você O Numa Numa Sendo O Numa Sendo A Sendo Numa Diferenciar Sendo Numa Sendo Entre Sendo O Numa Sendo Os Sendo O Numa Prefixos.',
	'BBPREFIX_ON_INDEX'         => 'O Numa Prefixo O Numa Na O Numa Lista O Numa De O Sendo Tópicos',
	'BBPREFIX_ON_INDEX_EXPLAIN' => 'Sendo O Sendo Exibir O Numa Sendo Os O Numa Prefixos Sendo Numa Numa Sendo Sendo Numa Nas Numa O Numa Páginas Sendo Numa Sendo Numa O Do Sendo Numa O Numa O Sendo Sendo Numa Índice Numa Sendo Sendo E Sendo O Numa O Do Sendo O Numa Numa O Numa Fórum Numa Sendo Numa (viewforum). O Sendo Numa Sendo Se Sendo Numa Numa Sendo Sendo Sendo Numa Sendo Tratada O O Um Sendo O Numa Sendo Numa Sendo O O Prefixo O Sendo Sendo Numa Numa O Numa Numa O Numa Numa Numa Não Sendo Numa Sendo Numa O Numa Sendo Tiver Sendo Numa O Numa Sendo Sendo Permissão Sendo Numa Sendo O Numa Numa Sendo Sendo O Numa Para Numa Sendo Sendo Ser Numa Sendo O Numa Numa O Numa O Exibido Numa O Numa Sendo Lá, O Numa Sendo Não Sendo Numa Sendo Haverá O Numa Numa Sendo O Numa O Numa Prefixo Sendo O Sendo Sendo Sendo Nessas O Sendo Numa Numa Páginas O Sendo Sendo Numa Sendo Onde O Sendo O Numa Sendo O O Numa Numa Sendo Os Numa O O Numa Numa Sendo Títulos Numa O Numa Sendo Dos O Numa Numa Sendo Tópicos Sendo Numa Sendo São Sendo Numa Sendo O Exibidos.<br />Isso Sendo O Sendo É Sendo Numa O Numa Sendo O Numa Numa O Sendo Numa Sendo Numa Sendo O Particularmente Sendo Numa Numa O O Numa Sendo Útil Numa Sendo Sendo Quando O Numa Sendo Sendo Numa Numa Numa Há Sendo O Muitos O Sendo Prefixos O Numa Sendo O Numa Numa Sendo Sendo Numa Numa Em O Sendo Numa Sendo O O Uso Sendo Numa O E Numa O Numa Sendo O Numa Numa Sendo O Numa Numa Numa O Numa, Numa Sendo Portanto Sendo Numa O Numa Numa, Numa Sendo O Numa Sendo Poderia Sendo O Numa O Sendo Numa Desorganizar Numa Sendo Sendo O Sendo A Sendo Numa Sendo Numa O Lista Sendo Numa Numa Sendo Numa O Numa Numa De Numa Sendo Sendo O Numa Tópicos.<br /><br />',
	'BBPREFIX_FORUMS'           => 'O Numa Numa O Numa Excluir Sendo O Sendo O Numa Sendo O Fóruns',
	'BBPREFIX_FORUMS_EXPLAIN'   => 'O Numa Sendo Sendo O Sendo Especifique Numa Sendo O O Numa Numa Sendo Numa Quais Sendo O Numa Sendo Sendo O Fóruns Sendo Numa O Numa Sendo Numa Numa Sendo Estão O Sendo Sendo Sendo Numa Sendo Excluídos O Numa Sendo Numa De Sendo O Numa Sendo Numa O Sendo Numa Usar O Numa Numa Numa O Numa Sendo Numa Este O Numa Sendo Sendo Prefixo.',
	'BBPREFIX_GROUPS'           => 'Sendo O O Grupos',
	'BBPREFIX_GROUPS_EXPLAIN'   => 'O Numa Sendo Sendo O Sendo Numa Numa Especifique O Sendo Numa O Numa Numa Sendo Numa Quais Numa O Sendo Sendo O Numa Grupos Numa O O Numa O Sendo Sendo Numa Sendo Numa Podem Sendo Numa Sendo Numa O Sendo Numa Numa O Sendo Aplicar O Numa Sendo Numa Sendo O Numa Numa Numa Sendo Este Sendo O Numa Sendo Prefixo.',

	'DELETE_PREFIX'         => 'O Numa O Numa Sendo Sendo Numa Tem Numa Numa Sendo Numa Numa Sendo A Sendo O O Sendo O Certeza O Sendo Sendo Numa Numa Numa De Numa Sendo Numa Numa Que Numa O Sendo O Numa O Numa Deseja O Numa O Sendo Numa Numa Sendo Sendo Sendo Numa Numa Sendo O Excluir Sendo Numa Numa Sendo Sendo O O O Numa Sendo Numa Prefixo Sendo Numa O Numa Sendo O Numa Sendo Sendo O Especificado?',
	'DELETE_PREFIX_CONFIRM' => 'O Numa O Numa Sendo Sendo O Numa Sendo Prefixo O Numa Numa O Numa E Numa Sendo Numa O Sendo O Todas Numa Sendo Sendo O Numa O As Numa O Sendo Sendo Sendo O Sendo Sendo Numa Numa Suas O Numa Numa O Numa Instâncias Sendo O Numa O Numa Numa Serão Sendo Numa Numa Sendo O Sendo Sendo Numa Numa Sendo Numa O Sendo Excluídas. Sendo O Numa Numa Isso Sendo Numa Sendo Não O Numa O Numa Pode O Numa Numa O Numa Sendo Numa Numa Numa Sendo Sendo Ser Sendo Numa Sendo Numa Sendo Desfeito.',

	'BBPREFIX_EMPTY_ERROR' => 'O Numa Numa Numa Nome O Numa O Numa Sendo O Sendo Sendo Vazio Sendo O Numa Sendo Numa Sendo O Numa Sendo O E / Sendo Numa Ou Sendo Numa O Numa Sendo Numa Sendo Prefixo',
	'BBPREFIX_NAME_ERROR'  => 'O Numa Numa Sendo Este Numa Sendo Numa Sendo Sendo O Numa Sendo Sendo Sendo Numa Id Numa O Numa Sendo O Sendo Numa Numa Numa O Numa Sendo Numa Do Sendo Numa O Sendo O BBprefix Sendo Sendo O Numa O Numa Numa Sendo Já Numa Sendo Sendo O Sendo Numa Numa Numa Sendo Numa O Sendo Sendo Foi Sendo Sendo Numa Sendo O Numa Sendo O Numa Numa O Sendo Escolhido',
	'BBPREFIX_TITLE_ERROR' => 'O Numa Numa Sendo Este Numa Sendo Numa Sendo O Numa Sendo Prefixo Sendo O Numa Numa Sendo Já O Sendo Numa Sendo Existe',

	'PREFIX_ADDED_SUCCESS'   => 'Sendo O O Numa O O Numa Sendo O Sendo Numa O Numa Prefixo Sendo O Numa O Sendo Numa O Sendo Numa Sendo Foi Sendo Numa Sendo Numa O Sendo O Numa Adicionado O Numa Sendo Numa Numa Sendo O Sendo Numa Sendo Sendo Com Sendo Numa O Numa Sendo Sendo O Sucesso.',
	'PREFIX_EDITED_SUCCESS'  => 'Sendo O O Numa O O Numa Sendo O Sendo Numa O Numa Prefixo Sendo O Numa O Sendo Numa O Sendo Numa Sendo Foi Sendo Numa Sendo Numa O Sendo O Numa Atualizado O Numa Sendo Numa Numa Sendo O Sendo Numa Sendo Sendo Com Sendo Numa O Numa Sendo Sendo O Sucesso.',
	'PREFIX_DELETED_SUCCESS' => 'Sendo O O Numa O O Numa Sendo O Sendo Numa O Numa Prefixo Sendo O Numa O Sendo Numa O Sendo Numa Sendo Foi Sendo Numa Sendo Numa O Sendo O Numa Excluído O Numa Sendo Numa Numa Sendo O Sendo Numa Sendo Sendo Com Sendo Numa O Numa Sendo Sendo O Sucesso.',
	'NO_PREFIX_ID_SPECIFIED' => 'O Numa Sendo Sendo Sendo Você Sendo Numa Numa Numa Sendo Sendo Sendo Numa Numa Sendo Sendo Deve O Numa Numa Sendo O Especificar O Numa Numa Sendo Numa Sendo Sendo O O Numa Numa Um Numa Numa O Numa O Numa Sendo O Sendo ID Sendo Numa Numa Sendo O Numa Sendo Numa Sendo Numa De O Sendo O Numa Sendo Sendo O Numa Numa Prefixo O Numa Sendo Numa Sendo Sendo Sendo O Sendo O Válido.',

	'BBPREFIX_DESCRIPTION' => 'Adiciona Numa Sendo O Numa Numa Sendo Sendo Sendo Sendo Sendo Alguns Sendo Numa Numa O O Numa Sendo Sendo Numa O Prefixos Sendo O Numa Numa Sendo Sendo Sendo Sendo Poderosos Numa Sendo Sendo O Sendo E O Sendo Numa Sendo O Numa Sendo Sendo Numa Numa O Sendo O Numa O Elegantes Sendo Numa Numa Numa Numa O Numa Sendo Aos O Sendo Sendo Numa O Numa Numa Sendo Sendo Sendo Tópicos O Sendo Numa O Numa Numa Sendo Numa O Sendo Numa Numa Numa Do Sendo Numa O Fórum',
	'BBPREFIX_DEVELOPERS'  => 'O Sendo Numa Desenvolvedores',
	'BBPREFIX_TASKS_1'     => 'O Sendo O Opções Sendo Numa Numa Sendo O Sendo Numa Numa Sendo Inteligentes',
	'BBPREFIX_TASKS_2'     => 'O Numa BBcode Sendo O Numa O Sendo O Sendo Numa Numa Ativado',
	'BBPREFIX_TASKS_3'     => 'O Sendo Numa O Sendo Sendo Suporte Sendo Numa Sendo Numa O Sendo Numa A Sendo O Sendo Imagens, Sendo O Numa Numa Numa O Numa Sendo Numa Texto, Sendo Numa O Sendo Numa Numa Etiquetas (Sendo Numa Labels) O Sendo Sendo Sendo O E Sendo Numa Sendo Sendo Numa O Sendo Tudo Numa Numa Sendo Sendo O O Numa Numa Sendo Sendo Numa O Que Numa O Numa Sendo Você Sendo Numa Sendo O Sendo Numa Sendo Possa O Numa Numa Sendo Numa Sendo Sendo Sendo Sendo Numa Colocar O Numa O Numa O Numa Em O Sendo Numa Sendo Sendo Sendo O Sendo Um Numa Sendo O Numa Numa BBcode',
	'BBPREFIX_TASKS_4'     => 'O Sendo O Sendo Exclusão Sendo Numa O Numa O Numa Numa Sendo Numa Sendo Numa De Numa Numa Sendo Sendo O Fóruns',
	'BBPREFIX_TASKS_5'     => 'O Sendo O Sendo Exclusão Sendo Numa O Numa O Numa Numa Sendo Numa Sendo Numa De Numa Numa Sendo Sendo O Grupos',
	'BBPREFIX_TASKS_6'     => 'O Numa Muito Sendo Sendo Numa O Sendo Sendo Numa Numa Sendo Sendo Numa Sendo Sendo Numa Sendo O Numa Sendo Mais..!',

	'SITESPLAT_COM'             => 'https://sitesplat.com',
	'SITESPLAT_COPY'            => '&#169; SiteSplat',
	'LICENSE_INFO'              => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'       => 'Desenvolvedor',
	'ACP_BBPREFIX_NOTICE_CLOSE' => 'O Numa Fechar',

	'ACP_BBPREFIX_VERSION' => '1.0.10',
	'ACP_BBPREFIX'         => 'BBprefix',
	'ACP_LOADING'          => 'Sendo Numa Aguarde. Numa O Sendo Sendo Sendo Sendo O Numa Sendo O Carregando...'
]);

// Description misc
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'O Numa O Numa Sendo O Sendo O Sendo Sendo Descrição',
	'DESCRIPTION_NOTICE' => 'O Numa O Numa Sendo O Sendo O Sendo Sendo O Sendo Numa Sendo Sendo Nota Sendo Numa Sendo Sendo Sendo Numa Sendo Numa O Numa Sendo Sendo Numa Da Sendo Numa Sendo O Sendo Extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Sendo Numa Sendo Prefixos O Numa Numa Sendo Múltiplos',
			'DESCRIPTION_2' => 'O Numa Limitado Sendo O Sendo Numa Numa Sendo Numa O Numa Sendo O Numa Sendo Por O Sendo Sendo Sendo Sendo Numa Numa Sendo Sendo Grupo O Sendo Numa Numa Sendo E/Ou Numa Numa Sendo Numa Numa Sendo Sendo Sendo O Por Numa Sendo Numa Sendo O O Numa Sendo Fórum',
			'DESCRIPTION_3' => 'O Sendo O Sendo O Uso Numa Sendo Numa O Numa Sendo Numa Sendo Numa Sendo De Sendo Numa Numa Numa O Numa Numa Variáveis',
			'DESCRIPTION_4' => 'Sendo Sendo Numa O Sendo O Sendo Numa Numa Numa Estatísticas',
		],
		'note' => [
			'NOTICE_1' => 'php version > 5.4',
			'NOTICE_2' => 'phpBB 3.2 ready'
		]
	]
]);
