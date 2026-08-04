<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
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

$lang = array_merge($lang, [
	'CHOOSE_ACTION'                => 'Selecionar a ação desejada',
	'RENAME_IMAGES'                => 'Renomear imagens selecionadas',
	'GALLERY_MCP_MAIN'             => 'Principal',
	'GALLERY_MCP_OVERVIEW'         => 'Visão Geral',
	'GALLERY_MCP_QUEUE'            => 'Fila de Imagens',
	'GALLERY_MCP_QUEUE_DETAIL'     => 'Detalhes da Fila de Imagens',
	'GALLERY_MCP_REPORTED'         => 'Imagens Reportadas',
	'GALLERY_MCP_REPO_DONE'        => 'Denúncias Fechadas',
	'GALLERY_MCP_REPO_OPEN'        => 'Denúncias Abertas',
	'GALLERY_MCP_REPO_DETAIL'      => 'Detalhes da Denúncia',
	'GALLERY_MCP_UNAPPROVED'       => 'Imagens por aprovar',
	'GALLERY_MCP_APPROVED'         => 'Imagens aprovadas',
	'GALLERY_MCP_LOCKED'           => 'Imagens bloqueadas',
	'GALLERY_MCP_VIEWALBUM'        => 'Ir para o Álbum',
	'GALLERY_MCP_ALBUM_OVERVIEW'   => 'Moderar álbum',
	'IMAGE_REPORTED'               => 'A imagem foi denunciada.',
	'IMAGE_UNAPPROVED'             => 'A imagem aguarda aprovação.',
	'MODERATE_ALBUM'               => 'Moderar álbum',
	'LATEST_IMAGES_REPORTED'       => 'Últimas 5 imagens denunciadas',
	'LATEST_IMAGES_UNAPPROVED'     => 'Últimas 5 imagens aguardando aprovação',
	'QUEUE_A_APPROVE'              => 'Aprovar imagem',
	'QUEUE_A_APPROVE2'             => 'Aprovar imagem?',
	'QUEUE_A_APPROVE2_CONFIRM'     => 'Tem certeza de que deseja aprovar esta imagem?',
	'QUEUE_A_DELETE'               => 'Excluir imagem',
	'QUEUE_A_DELETE2'              => 'Excluir imagem?',
	'QUEUE_A_DELETE2_CONFIRM'      => 'Tem certeza de que deseja excluir esta imagem?',
	'QUEUE_A_LOCK'                 => 'Bloquear comentários da imagem',
	'QUEUE_A_LOCK2'                => 'Aprovar e bloquear os comentários da imagem?',
	'QUEUE_A_LOCK2_CONFIRM'        => 'Tem certeza de que deseja aprovar e bloquear os comentários desta imagem?',
	'QUEUE_A_MOVE'                 => 'Mover imagem',
	'QUEUE_A_UNAPPROVE'            => 'Desaprovar imagem',
	'QUEUE_A_UNAPPROVE2'           => 'Desaprovar imagem?',
	'QUEUE_A_UNAPPROVE2_CONFIRM'   => 'Tem certeza de que deseja desaprovar esta imagem?',
	'QUEUE_STATUS_0'               => 'A imagem aguarda aprovação.',
	'QUEUE_STATUS_1'               => 'A imagem está aprovada.',
	'QUEUE_STATUS_2'               => 'A imagem está bloqueada.',
	'QUEUES_A_APPROVE'             => 'Aprovar imagens',
	'QUEUES_A_APPROVE2'            => 'Aprovar imagens?',
	'QUEUES_A_APPROVE2_CONFIRM'    => 'Tem certeza de que deseja aprovar estas imagens?',
	'QUEUES_A_DELETE'              => 'Excluir imagens',
	'QUEUES_A_DELETE2'             => 'Excluir imagens?',
	'QUEUES_A_DELETE2_CONFIRM'     => 'Tem certeza de que deseja excluir estas imagens?',
	'QUEUES_A_LOCK'                => 'Bloquear imagens',
	'QUEUES_A_LOCK2'               => 'Bloquear imagens?',
	'QUEUES_A_LOCK2_CONFIRM'       => 'Tem certeza de que deseja bloquear estas imagens?',
	'QUEUES_A_MOVE'                => 'Mover imagens',
	'QUEUES_A_UNAPPROVE'           => 'Desaprovar imagens',
	'QUEUES_A_UNAPPROVE2'          => 'Desaprovar imagens?',
	'QUEUES_A_UNAPPROVE2_CONFIRM'  => 'Tem certeza de que deseja desaprovar estas imagens?',
	'QUEUES_A_DISAPPROVE2_CONFIRM' => 'Tem certeza de que deseja desaprovar estas imagens?',
	'REPORT_A_CLOSE'               => 'Fechar denúncia',
	'REPORT_A_CLOSE2'              => 'Fechar denúncia?',
	'REPORT_A_CLOSE2_CONFIRM'      => 'Tem certeza de que deseja fechar esta denúncia?',
	'REPORT_A_DELETE'              => 'Excluir denúncia',
	'REPORT_A_DELETE2'             => 'Excluir denúncia?',
	'REPORT_A_DELETE2_CONFIRM'     => 'Tem certeza de que deseja excluir esta denúncia?',
	'REPORT_A_OPEN'                => 'Abrir denúncia',
	'REPORT_A_OPEN2'               => 'Abrir denúncia?',
	'REPORT_A_OPEN2_CONFIRM'       => 'Tem certeza de que deseja abrir esta denúncia?',
	'REPORT_NOT_FOUND'             => 'Não há dados sobre esta denúncia; talvez ela já tenha sido excluída do banco de dados.',
	'REPORT_STATUS_1'              => 'A denúncia precisa ser analisada.',
	'REPORT_STATUS_2'              => 'A denúncia está fechada.',
	'REPORTS_A_CLOSE'              => 'Fechar Denúncias',
	'REPORTS_A_CLOSE2'             => 'Deseja Fechar Denúncias?',
	'REPORTS_A_CLOSE2_CONFIRM'     => 'Tem certeza de que deseja fechar estas denúncias de imagem?',
	'REPORTS_A_DELETE'             => 'Excluir Denúncias',
	'REPORTS_A_DELETE2'            => 'Deseja Excluir Denúncias?',
	'REPORTS_A_DELETE2_CONFIRM'    => 'Tem certeza de que deseja excluir estas denúncias?',
	'REPORTS_A_OPEN'               => 'Abrir Denúncias',
	'REPORTS_A_OPEN2'              => 'Deseja Abrir Denúncias?',
	'REPORTS_A_OPEN2_CONFIRM'      => 'Tem certeza de que deseja abrir estas denúncias?',
	'REPORT_MOD'                   => 'Editado por',
	'REPORT_CLOSED_BY'             => 'Denúncia fechada por',
	'REPORTED_IMAGES'              => 'Imagens denunciadas',
	'REPORTER'                     => 'Usuário denunciante',
	'REPORTER_AND_ALBUM'           => 'Denunciante e álbum',
	'WAITING_APPROVED_IMAGE'       => [
		'Nenhuma imagem aprovada.',
		'No total, há <strong>1 imagem aprovada</strong>.',
		'No total, há <strong>%s imagens aprovadas</strong>.',
	],
	'WAITING_DISAPPROVED_IMAGE' => [
		'Nenhuma imagem reprovada.',
		'No total, há <strong>1 imagem reprovada</strong>.',
		'No total, há <strong>%s imagens reprovadas</strong>.',
	],
	'WAITING_LOCKED_IMAGE' => [
		'Nenhuma imagem bloqueada.',
		'No total, há <strong>1 imagem bloqueada</strong>.',
		'No total, há <strong>%s imagens bloqueadas</strong>.',
	],
	'WAITING_REPORTED_DONE' => [
		'Nenhuma denúncia analisada.',
		'No total, há <strong>1 denúncia analisada</strong>.',
		'No total, há <strong>%s denúncias analisadas</strong>.',
	],
	'WAITING_REPORTED_IMAGE' => [
		'Não há denúncias aguardando análise.',
		'No total, há <strong>1 denúncia aguardando análise</strong>.',
		'No total, há <strong>%s denúncias aguardando análise</strong>.',
	],
	'WAITING_UNAPPROVED_IMAGE' => [
		'Não há imagens aguardando aprovação.',
		'No total, há <strong>1 imagem aguardando aprovação</strong>.',
		'No total, há <strong>%s imagens aguardando aprovação</strong>.',
	],
	'DELETED_IMAGES' => [
		'Nenhuma imagem foi excluída.',
		'No total, <strong>1 imagem foi excluída</strong>.',
		'No total, <strong>%s imagens foram excluídas</strong>.',
	],
	'MOVED_IMAGES' => [
		'Nenhuma imagem foi movida.',
		'No total, <strong>1 imagem foi movida</strong>.',
		'No total, <strong>%s imagens foram movidas</strong>.',
	],
	'NO_WAITING_UNAPPROVED_IMAGE' => 'Não há imagens aguardando aprovação.',
	'GALLERY_MCP_DELETE_REQUESTS' => 'Solicitações de exclusão de imagens',
	'LATEST_IMAGE_DELETE_REQUESTS' => 'Solicitações mais recentes de exclusão de imagens',
	'DELETE_REQUEST_RESTORE_CONFIRM' => 'Tem certeza de que deseja restaurar as imagens selecionadas?',
	'QUEUE_STATUS_4' => 'Exclusão solicitada',
	'WAITING_DELETE_REQUESTS' => [
		0 => 'Não há solicitações de exclusão de imagens aguardando moderação.',
		1 => 'Há <span style="font-weight: bold;">1</span> solicitação de exclusão de imagem aguardando moderação.',
		2 => 'Há <span style="font-weight: bold;">%s</span> solicitações de exclusão de imagens aguardando moderação.',
	],
	'RESTORED_IMAGES' => [
		0 => 'Nenhuma imagem foi restaurada.',
		1 => 'Foi restaurada <span style="font-weight: bold;">1</span> imagem.',
		2 => 'Foram restauradas <span style="font-weight: bold;">%s</span> imagens.',
	],
	'NO_WAITING_DELETE_REQUESTS' => 'Não há solicitações de exclusão de imagens aguardando moderação.',
]);
