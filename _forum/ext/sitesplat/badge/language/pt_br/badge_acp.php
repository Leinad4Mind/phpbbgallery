<?php

/**
 * Badge Award extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACP_BADGE_MANAGE'                => 'Gerenciar Sistema de Medalhas',
	'ACP_BADGE_MANAGE_EXPLAIN'        => 'Bem-vindo ao Sistema de Medalhas "BBAwards". No formulário abaixo você poderá adicionar, editar, ver e remover Regras de Medalhas. <br />Você também poderá enviar novas medalhas diretamente para o servidor para que possam ser usadas na configuração das regras.',
	'ACP_BADGE_MANAGE_LEGEND_TITLE'   => 'Notas de Utilização',
	'ACP_BADGE_MANAGE_LEGEND_EXPLAIN' => 'As regras de medalhas do usuário são automaticamente sincronizadas a cada 24h pelo sistema especial de Cron (Você pode monitorar os Crons via extensão <a href="https://github.com/ForumHulp/cronstatus">Cron Status</a>) Serve para ficarmos de olho na carga do servidor. <br />Algumas regras são concedidas instantaneamente de acordo com critérios, tais como as regras de "mensagens", "avisos", "dias de cadastro", "gostos", "personalizado" e "doações".<br />Você pode editar, remover e sincronizar manualmente as regras nas opções da coluna "Ações". A opção de sincronização <i class="fa fa-refresh fa-lg"></i> serve para executar manualmente a regra X instantaneamente. A regra "Personalizada" não precisa ser sincronizada, pois ela já está sincronizada ao atribuirmos o usuário à regra.',

	'BADGE_DESCRIPTION' => 'Premia usuários com medalhas baseado em regras pré-definidas ou personalizadas',
	'BADGE_DEVELOPERS'  => 'Desenvolvedores',
	'BADGE_TASKS_1'     => 'Combinações de regras ilimitadas',
	'BADGE_TASKS_2'     => 'Regras personalizáveis ilimitadas',
	'BADGE_TASKS_3'     => 'Mais medalhas por regra',
	'BADGE_TASKS_4'     => 'Sincronização com tarefas cron e compatível com a extensão <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
	'BADGE_TASKS_5'     => 'Expansível com funções AutoGroup e muitas Regras Premium. Confira as regras premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BADGE_TASKS_6'     => 'Muito mais...!',

	'SITESPLAT_COM'            => 'https://sitesplat.com',
	'SITESPLAT_COPY'           => '&#169; SiteSplat',
	'LICENSE_INFO'             => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'      => 'Desenvolvedor',
	'ACP_SIDEBAR_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBAWARDS_VERSION' => '1.4.10',
	'ACP_BBAWARDS'         => 'BBAwards',
	'ACP_LOADING'          => 'Aguarde. Carregando...',

	'ACP_BADGE_ADD'  => 'Adicionar Medalha',
	'ACP_BADGE_EDIT' => 'Editar Medalha',
	'ACP_BADGE_DELL' => 'Remover',

	'AVATAR_EXPLAIN'        => 'Atribui uma medalha aos membros que têm avatar. Isto incentiva o usuário a preencher o perfil.',
	'BADGES_EXPLAIN'        => 'Atribui medalhas extras aos membros que já tenham alcançado X outras medalhas.',
	'BIRTHDAYS_EXPLAIN'     => 'Atribui medalhas aos membros no dia do aniversário',
	'CUSTOM_EXPLAIN'        => 'Atribui medalhas personalizadas aos membros. Pode ser o que você quiser, por exemplo um concurso do fórum ou talvez algum tipo de sorteio? Seja criativo!',
	'DONATIONS_EXPLAIN'     => 'Atribui medalhas aos doadores do fórum',
	'LIKEDD_EXPLAIN'        => 'Atribui medalhas aos membros com gostos/não gostos dados ou recebidos',
	'MEMBERSHIP_EXPLAIN'    => 'Atribui medalhas aos membros por suas assinaturas/associações compradas',
	'POSTS_EXPLAIN'         => 'Atribui medalhas aos membros com X posts',
	'PROFILEWALL_EXPLAIN'   => 'Atribui medalhas aos membros por comentários no perfil',
	'SIGNATURE_EXPLAIN'     => 'Atribui medalhas aos membros que têm assinatura',
	'WARNINGS_EXPLAIN'      => 'Atribui medalhas aos membros com avisos',
	'ZEBRA.FOES_EXPLAIN'    => 'Atribui medalhas aos membros com inimigo(s)',
	'ZEBRA.FRIENDS_EXPLAIN' => 'Atribui medalhas aos membros com amigo(s)',

	'ACP_BADGE_OPTIONS'                  => 'Opções',
	'ACP_BADGE_AVAILABLE'                => 'Medalhas disponíveis',
	'ACP_BADGE_AVAILABLE_EXPLAIN'        => 'Estas são as medalhas disponíveis na pasta de medalhas do seu servidor. Poderão ser selecionadas na opção acima "Criar nova Medalha"<br />Observação: para excluir uma medalha, selecione-a e depois clique no botão de envio. Se a marca de seleção não estiver visível, significa que a medalha já está em uso e não pode ser excluída. Isto evita exclusões acidentais e, consequentemente, imagens quebradas.',
	'ACP_BADGE_RULE_NAME'                => 'Título da regra da medalha',
	'ACP_BADGE_RULE_NAME_EXPLAIN'        => 'Nome para esta regra de atribuição de medalha. <br />Será visível publicamente para os usuários',
	'ACP_BADGE_RULE_DESCRIPTION'         => 'Descrição da regra de atribuição',
	'ACP_BADGE_RULE_DESCRIPTION_EXPLAIN' => 'Descrição desta regra de atribuição. <br />Será visível publicamente para os usuários',
	'ACP_BADGE_IMAGE'                    => 'Imagem da medalha',
	'ACP_BADGE_IMAGE_EXPLAIN'            => 'Selecione a imagem da medalha para esta regra. <br />Será visível publicamente para os usuários',
	'ACP_BADGE_CONDITION_NAME'           => 'Tipo de atribuição de medalha (regra)',
	'ACP_BADGE_CONDITION_NAME_EXPLAIN'   => 'Escolha o tipo de condição (regra) segundo a qual os usuários receberão esta medalha.',
	'ACP_BADGE_USERLIST'                 => 'Selecione o(s) usuário(s) para esta medalha',
	'ACP_BADGE_USERLIST_EXPLAIN'         => 'Selecione vários usuários mantendo pressionada a tecla <samp>CTRL</samp> e clicando.',
	'ACP_BADGE_MIN_VALUE'                => 'Valor mín.',
	'ACP_BADGE_MIN_VALUE_EXPLAIN'        => 'Os usuários receberão esta medalha se excederem o valor mínimo.',
	'ACP_BADGE_MAX_VALUE'                => 'Valor máx.',
	'ACP_BADGE_MAX_VALUE_EXPLAIN'        => 'Os usuários perderão esta medalha se excederem o valor máximo. Deixe este campo vazio se não quiser isto.',
	'ACP_BADGE_VALUE'                    => 'Valor Mín-Máx, Booleano',
	'ACP_BADGE_LIKE_DISLIKE'             => 'Atribuição por Gosto/Não Gosto',
	'ACP_BADGE_LIKE_DISLIKE_EXPLAIN'     => 'Escolha se deseja contar gostos ou não-gostos',
	'ACP_BADGE_LIKE'                     => 'Gostos',
	'ACP_BADGE_DISLIKE'                  => 'Não-gostos',
	'ACP_BADGE_GIVEN'                    => 'Dados',
	'ACP_BADGE_RECIEVED'                 => 'Recebidos',
	'ACP_BADGE_PROFILEWALL'              => 'Mural de Perfil',
	'ACP_BADGE_PROFILEWALL_EXPLAIN'      => 'Escolha se deseja contar comentários e respostas ou gostos do mural de perfil',
	'ACP_BADGE_COMMENTS_REPLIES'         => 'Comentários e Respostas',
	'ACP_BADGE_LIKES'                    => 'Gostos do Mural de Perfil',

	'ACP_BADGE_NOTIFY'         => 'Notificar usuário',
	'ACP_BADGE_NOTIFY_EXPLAIN' => 'Mostra uma notificação especial do fórum aos usuários depois de receberem uma medalha.',
	'ACP_BADGE_NOTICE_CLOSE'   => 'Fechar notificação',

	'ACP_BADGE_UPLOAD'         => 'Enviar nova medalha',
	'ACP_BADGE_UPLOAD_EXPLAIN' => 'Envie uma nova imagem de medalha. O tipo de imagem deve ser um dos seguintes: jpg, jpeg, gif, png ou svg.',
	'ACP_BADGE_RANDOM'         => 'Medalhas de perfil aleatórias',
	'ACP_BADGE_RANDOM_EXPLAIN' => 'Randomiza as medalhas na visualização de tópico e perfil',
	'ACP_BADGE_AMOUNT'         => 'Medalhas de perfil',
	'ACP_BADGE_AMOUNT_EXPLAIN' => 'Defina a quantidade de medalhas mostradas no perfil antes de ativar o link "+ Mais".',


	'ACP_BADGE_CREATE_RULE'    => 'Criar nova Atribuição de Medalha',
	'ACP_BADGE_SUBMIT_SUCCESS' => 'Atribuição de Medalha configurada com sucesso.',
	'ACP_BADGE_DELETE_CONFIRM' => 'Tem certeza de que deseja excluir esta configuração de Atribuição de Medalha?',
	'ACP_BADGE_DELETE_SUCCESS' => 'Atribuição de Medalha excluída com sucesso.',
	'ACP_BADGE_EMPTY'          => 'Não existem atribuições de medalhas.',
	'ACP_BADGE_NO_IMAGE'       => 'Nenhuma medalha disponível',
	'ACP_BADGE_INVALID_VALUE'  => 'O valor máximo é inferior ao valor mínimo!',
	'ACP_BADGE_NAME_USED'      => 'O nome da regra já está em uso ou está vazio!',
	'NOTICE_LIKEDD'            => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> não está instalada, você não pode usar a regra do tipo LikeBB.',
	'NOTICE_DONATIONS'         => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=44"><strong>Forum Donation</strong></a> não está instalada, você não pode usar a regra do tipo doação.',
	'NOTICE_PROFILEWALL'       => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=13"><strong>Profile Wall</strong></a> não está instalada, você não pode usar a regra do tipo mural de perfil.',
	'NOTICE_PREMIUM'           => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=25"><strong>Premium Rules</strong></a> não está instalada, você não pode usar as regras extras do tipo premium.',
]);
