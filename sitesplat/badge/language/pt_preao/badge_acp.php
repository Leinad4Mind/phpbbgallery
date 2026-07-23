<?php

/**
 * Badge Award extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
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
	'ACP_BADGE_MANAGE'                => 'Gerir Sistema de Medalhas',
	'ACP_BADGE_MANAGE_EXPLAIN'        => 'Bem-vindo ao Sistema de Medalhas "BBAwards". No formulário abaixo poderás adicionar, editar, ver e remover Regras de Medalhas. <br />Poderás também enviar novas medalhas directamente para o servidor para que possam ser usadas na configuração das regras.',
	'ACP_BADGE_MANAGE_LEGEND_TITLE'   => 'Notas de Utilização',
	'ACP_BADGE_MANAGE_LEGEND_EXPLAIN' => 'As regras de medalhas do utilizador são automaticamente sincronizadas a cada 24h pelo sistema especial de Cron (Podes monitorizar os Crons via extensão <a href="https://github.com/ForumHulp/cronstatus">Cron Status</a>) Serve para ficarmos de olho no load do servidor. <br />Algumas regras são ganhas instantaneamente de acordo com critérios, tal como as regras de "mensagens", "avisos", "dias de registo", "gostos", "customizado" e "donativos".<br />Podes editar, remover e sincronizar manualmente as regras nas opções da coluna "Acções". A opção de sincronização <i class="fa fa-refresh fa-lg"></i> é para executar manualmente a regra X instantaneamente. A regra "Customizada" não precisa de ser sincronizada, pois ela já se encontra sincronizada ao atribuírmos o utilizador à regra.',

	'BADGE_DESCRIPTION' => 'Premeia utilizadores com medalhas baseado em regras pré-definidas ou customizadas',
	'BADGE_DEVELOPERS'  => 'Desenvolvedores',
	'BADGE_TASKS_1'     => 'Combinações de regras ilimitadas',
	'BADGE_TASKS_2'     => 'Regras customizáveis ilimitadas',
	'BADGE_TASKS_3'     => 'Mais medalhas por regra',
	'BADGE_TASKS_4'     => 'Sincronização com tarefas cron e compatível com a extensão <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
	'BADGE_TASKS_5'     => 'Expansível com funções AutoGroup e muitas Regras Premium. Consulta as regras premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BADGE_TASKS_6'     => 'Muito mais...!',

	'SITESPLAT_COM'            => 'https://sitesplat.com',
	'SITESPLAT_COPY'           => '&#169; SiteSplat',
	'LICENSE_INFO'             => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'      => 'Desenvolvedor',
	'ACP_SIDEBAR_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBAWARDS_VERSION' => '1.4.10',
	'ACP_BBAWARDS'         => 'BBAwards',
	'ACP_LOADING'          => 'Aguarde. A Carregar...',

	'ACP_BADGE_ADD'  => 'Adicionar Medalha',
	'ACP_BADGE_EDIT' => 'Editar Medalha',
	'ACP_BADGE_DELL' => 'Remover',

	'AVATAR_EXPLAIN'        => 'Atribui uma medalha aos membros que têm avatar. Isto incentiva o utilizador a preencher o perfil.',
	'BADGES_EXPLAIN'        => 'Atribui medalhas extra aos membros que já tenham alcançado X outras medalhas.',
	'BIRTHDAYS_EXPLAIN'     => 'Atribui medalhas aos membros no dia de aniversário',
	'CUSTOM_EXPLAIN'        => 'Atribui medalhas personalizadas aos membros. Pode ser o que quiseres, por exemplo um concurso do fórum ou talvez algum tipo de sorteio? Sê criativo!',
	'DONATIONS_EXPLAIN'     => 'Atribui medalhas aos doadores do fórum',
	'LIKEDD_EXPLAIN'        => 'Atribui medalhas aos membros com gostos/não gostos dados ou recebidos',
	'MEMBERSHIP_EXPLAIN'    => 'Atribui medalhas aos membros pelas suas adesões subscritas/compradas',
	'POSTS_EXPLAIN'         => 'Atribui medalhas aos membros com X mensagens',
	'PROFILEWALL_EXPLAIN'   => 'Atribui medalhas aos membros por comentários no perfil',
	'SIGNATURE_EXPLAIN'     => 'Atribui medalhas aos membros que têm assinatura',
	'WARNINGS_EXPLAIN'      => 'Atribui medalhas aos membros com avisos',
	'ZEBRA.FOES_EXPLAIN'    => 'Atribui medalhas aos membros com inimigo(s)',
	'ZEBRA.FRIENDS_EXPLAIN' => 'Atribui medalhas aos membros com amigo(s)',

	'ACP_BADGE_OPTIONS'                  => 'Opções',
	'ACP_BADGE_AVAILABLE'                => 'Medalhas disponíveis',
	'ACP_BADGE_AVAILABLE_EXPLAIN'        => 'Estas são as medalhas disponíveis na pasta de medalhas do teu servidor. Poderão ser seleccionadas na opção acima "Criar nova Medalha"<br />Nota: para eliminar uma medalha, selecciona-a e depois clica no botão de envio. Se a marca de verificação não estiver visível, significa que a medalha já está em uso e não pode ser eliminada. Isto previne eliminações acidentais e, consequentemente, imagens quebradas.',
	'ACP_BADGE_RULE_NAME'                => 'Título da regra da medalha',
	'ACP_BADGE_RULE_NAME_EXPLAIN'        => 'Nome para esta regra de atribuição de medalha. <br />Será visível publicamente para os utilizadores',
	'ACP_BADGE_RULE_DESCRIPTION'         => 'Descrição da regra de atribuição',
	'ACP_BADGE_RULE_DESCRIPTION_EXPLAIN' => 'Descrição desta regra de atribuição. <br />Será visível publicamente para os utilizadores',
	'ACP_BADGE_IMAGE'                    => 'Imagem da medalha',
	'ACP_BADGE_IMAGE_EXPLAIN'            => 'Seleciona a imagem da medalha para esta regra. <br />Será visível publicamente para os utilizadores',
	'ACP_BADGE_CONDITION_NAME'           => 'Tipo de atribuição de medalha (regra)',
	'ACP_BADGE_CONDITION_NAME_EXPLAIN'   => 'Escolhe o tipo de condição (regra) segundo a qual os utilizadores receberão esta medalha.',
	'ACP_BADGE_USERLIST'                 => 'Seleciona o(s) utilizador(es) para esta medalha',
	'ACP_BADGE_USERLIST_EXPLAIN'         => 'Seleciona vários utilizadores mantendo premida a tecla <samp>CTRL</samp> e clicando.',
	'ACP_BADGE_MIN_VALUE'                => 'Valor mín.',
	'ACP_BADGE_MIN_VALUE_EXPLAIN'        => 'Os utilizadores receberão esta medalha se excederem o valor mínimo.',
	'ACP_BADGE_MAX_VALUE'                => 'Valor máx.',
	'ACP_BADGE_MAX_VALUE_EXPLAIN'        => 'Os utilizadores perderão esta medalha se excederem o valor máximo. Deixa este campo vazio se não quiseres isto.',
	'ACP_BADGE_VALUE'                    => 'Valor Mín-Máx, Booleano',
	'ACP_BADGE_LIKE_DISLIKE'             => 'Atribuição por Gosto/Não Gosto',
	'ACP_BADGE_LIKE_DISLIKE_EXPLAIN'     => 'Escolhe se pretendes contar gostos ou não-gostos',
	'ACP_BADGE_LIKE'                     => 'Gostos',
	'ACP_BADGE_DISLIKE'                  => 'Não-gostos',
	'ACP_BADGE_GIVEN'                    => 'Dados',
	'ACP_BADGE_RECIEVED'                 => 'Recebidos',
	'ACP_BADGE_PROFILEWALL'              => 'Mural de Perfil',
	'ACP_BADGE_PROFILEWALL_EXPLAIN'      => 'Escolhe se pretendes contar comentários e respostas ou gostos do mural de perfil',
	'ACP_BADGE_COMMENTS_REPLIES'         => 'Comentários e Respostas',
	'ACP_BADGE_LIKES'                    => 'Gostos do Mural de Perfil',

	'ACP_BADGE_NOTIFY'         => 'Notificar utilizador',
	'ACP_BADGE_NOTIFY_EXPLAIN' => 'Mostra uma notificação especial do fórum aos utilizadores depois de lhes ser atribuída uma medalha.',
	'ACP_BADGE_NOTICE_CLOSE'   => 'Fechar notificação',

	'ACP_BADGE_UPLOAD'         => 'Upload de Nova Medalha',
	'ACP_BADGE_UPLOAD_EXPLAIN' => 'Faz upload de uma nova imagem de medalha. O tipo de imagem deve ser um dos seguintes: jpg, jpeg, gif, png ou svg.',
	'ACP_BADGE_RANDOM'         => 'Medalhas de perfil aleatórias',
	'ACP_BADGE_RANDOM_EXPLAIN' => 'Randomiza as medalhas na vista de tópico e de perfil',
	'ACP_BADGE_AMOUNT'         => 'Medalhas de perfil',
	'ACP_BADGE_AMOUNT_EXPLAIN' => 'Define a quantidade de medalhas mostradas no perfil antes de activar a hiperligação "+ Mais".',


	'ACP_BADGE_CREATE_RULE'    => 'Criar nova Atribuição de Medalha',
	'ACP_BADGE_SUBMIT_SUCCESS' => 'Atribuição de Medalha configurada com sucesso.',
	'ACP_BADGE_DELETE_CONFIRM' => 'Tens a certeza de que queres eliminar esta configuração de Atribuição de Medalha?',
	'ACP_BADGE_DELETE_SUCCESS' => 'Atribuição de Medalha eliminada com sucesso.',
	'ACP_BADGE_EMPTY'          => 'Não existem atribuições de medalhas.',
	'ACP_BADGE_NO_IMAGE'       => 'Nenhuma medalha disponível',
	'ACP_BADGE_INVALID_VALUE'  => 'O valor máximo é inferior ao valor mínimo!',
	'ACP_BADGE_NAME_USED'      => 'O nome da regra já está em uso ou está vazio!',
	'NOTICE_LIKEDD'            => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> não está instalada, não podes usar a regra do tipo LikeBB.',
	'NOTICE_DONATIONS'         => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=44"><strong>Forum Donation</strong></a> não está instalada, não podes usar a regra do tipo donativo.',
	'NOTICE_PROFILEWALL'       => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=13"><strong>Profile Wall</strong></a> não está instalada, não podes usar a regra do tipo mural de perfil.',
	'NOTICE_PREMIUM'           => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=25"><strong>Premium Rules</strong></a> não está instalada, não podes usar as regras extra do tipo premium.',
]);
