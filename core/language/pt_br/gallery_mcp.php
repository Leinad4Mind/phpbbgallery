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
	'CHOOSE_ACTION' => 'Selecionar ação pretendida',
	'GALLERY_MCP_MAIN' => 'Principal',
	'GALLERY_MCP_OVERVIEW' => 'Visão Geral',
	'GALLERY_MCP_QUEUE' => 'Fila de Imagens',
	'GALLERY_MCP_QUEUE_DETAIL' => 'Detalhes da Fila de Imagens',
	'GALLERY_MCP_REPORTED' => 'Imagens Reportadas',
	'GALLERY_MCP_REPO_DONE' => 'Reportes Fechados',
	'GALLERY_MCP_REPO_OPEN' => 'Reportes Abertos',
	'GALLERY_MCP_REPO_DETAIL' => 'Detalhes do Reporte',
	'GALLERY_MCP_UNAPPROVED' => 'Imagens por aprovar',
	'GALLERY_MCP_APPROVED' => 'Imagens aprovadas',
	'GALLERY_MCP_LOCKED' => 'Imagens bloqueadas',
	'GALLERY_MCP_VIEWALBUM' => 'Ir para o Álbum',
	'GALLERY_MCP_ALBUM_OVERVIEW' => 'Moderar álbum',
	'IMAGE_REPORTED' => 'A imagem foi denunciada.',
	'IMAGE_UNAPPROVED' => 'A imagem aguarda aprovação.',
	'MODERATE_ALBUM' => 'Moderar álbum',
	'LATEST_IMAGES_REPORTED' => 'Últimas 5 imagens denunciadas',
	'LATEST_IMAGES_UNAPPROVED' => 'Últimas 5 imagens a aguardar aprovação',
	'QUEUE_A_APPROVE' => 'Aprovar imagem',
	'QUEUE_A_APPROVE2' => 'Aprovar imagem?',
	'QUEUE_A_APPROVE2_CONFIRM' => 'Tem certeza de que deseja aprovar esta imagem?',
	'QUEUE_A_DELETE' => 'Excluir imagem',
	'QUEUE_A_DELETE2' => 'Excluir imagem?',
	'QUEUE_A_DELETE2_CONFIRM' => 'Tem certeza de que deseja excluir esta imagem?',
	'QUEUE_A_LOCK' => 'Bloquear comentários da imagem',
	'QUEUE_A_LOCK2' => 'Aprovar e bloquear os comentários da imagem?',
	'QUEUE_A_LOCK2_CONFIRM' => 'Tem certeza de que deseja aprovar e bloquear os comentários desta imagem?',
	'QUEUE_A_MOVE' => 'Mover imagem',
	'QUEUE_A_UNAPPROVE' => 'Desaprovar imagem',
	'QUEUE_A_UNAPPROVE2' => 'Desaprovar imagem?',
	'QUEUE_A_UNAPPROVE2_CONFIRM' => 'Tem certeza de que deseja desaprovar esta imagem?',
	'QUEUE_STATUS_0' => 'A imagem aguarda aprovação.',
	'QUEUE_STATUS_1' => 'A imagem está aprovada.',
	'QUEUE_STATUS_2' => 'A imagem está bloqueada.',
	'QUEUES_A_APPROVE' => 'Aprovar imagens',
	'QUEUES_A_APPROVE2' => 'Aprovar imagens?',
	'QUEUES_A_APPROVE2_CONFIRM' => 'Tem certeza de que deseja aprovar estas imagens?',
	'QUEUES_A_DELETE' => 'Excluir imagens',
	'QUEUES_A_DELETE2' => 'Excluir imagens?',
	'QUEUES_A_DELETE2_CONFIRM' => 'Tem certeza de que deseja excluir estas imagens?',
	'QUEUES_A_LOCK' => 'Bloquear imagens',
	'QUEUES_A_LOCK2' => 'Bloquear imagens?',
	'QUEUES_A_LOCK2_CONFIRM' => 'Tem certeza de que deseja bloquear estas imagens?',
	'QUEUES_A_MOVE' => 'Mover imagens',
	'QUEUES_A_UNAPPROVE' => 'Desaprovar imagens',
	'QUEUES_A_UNAPPROVE2' => 'Desaprovar imagens?',
	'QUEUES_A_UNAPPROVE2_CONFIRM' => 'Tem certeza de que deseja desaprovar estas imagens?',
	'QUEUES_A_DISAPPROVE2_CONFIRM' => 'Tem certeza de que deseja desaprovar estas imagens?',
	'REPORT_A_CLOSE' => 'Fechar Reporte',
	'REPORT_A_CLOSE2' => 'Fechar denúncia?',
	'REPORT_A_CLOSE2_CONFIRM' => 'Tem certeza de que deseja fechar esta denúncia?',
	'REPORT_A_DELETE' => 'Apagar o Reporte',
	'REPORT_A_DELETE2' => 'Excluir denúncia?',
	'REPORT_A_DELETE2_CONFIRM' => 'Tem certeza de que deseja excluir esta denúncia?',
	'REPORT_A_OPEN' => 'Abrir Reporte',
	'REPORT_A_OPEN2' => 'Abrir denúncia?',
	'REPORT_A_OPEN2_CONFIRM' => 'Tem certeza de que deseja abrir esta denúncia?',
	'REPORT_NOT_FOUND' => 'De momento não existem dados sobre este reporte, pode já não existir na base de dados.',
	'REPORT_STATUS_1' => 'A Moderação do Fórum deve proceder à Revisão do Reporte, visto este a exigi-lo.',
	'REPORT_STATUS_2' => 'O Reporte indicado está fechado e já não é possível aceder-lhe ou alterá-lo.',
	'REPORTS_A_CLOSE' => 'Fechar Reportes',
	'REPORTS_A_CLOSE2' => 'Deseja Fechar Reportes?',
	'REPORTS_A_CLOSE2_CONFIRM' => 'Tem a certeza que quer fechar este(s) reporte(s) de imagem?',
	'REPORTS_A_DELETE' => 'Apagar Reportes',
	'REPORTS_A_DELETE2' => 'Deseja Apagar Reportes?',
	'REPORTS_A_DELETE2_CONFIRM' => 'Tem a certeza que deseja excluir/apagar este(s) reporte(s)?',
	'REPORTS_A_OPEN' => 'Abrir Reportes',
	'REPORTS_A_OPEN2' => 'Deseja Abrir Reportes?',
	'REPORTS_A_OPEN2_CONFIRM' => 'Tem certeza de que deseja abrir estas denúncias?',
	'REPORT_MOD' => 'Editado e Retificado Por',
	'REPORT_CLOSED_BY' => 'Reporte Fechado E Oculto Por',
	'REPORTED_IMAGES' => 'Reportar Imagens',
	'REPORTER' => 'Usuário do Fórum ou Sistema Reportado(a)',
	'REPORTER_AND_ALBUM' => 'Reportes & Álbuns',
	'WAITING_APPROVED_IMAGE' => [
		'Infelizmente de momento não há nenhuma imagem nas nossas listas prestes a serem aprovadas.',
		'No Total da Galeria já foi <strong>Aprovada e Vista 1 Imagem</strong>.',
		'No Total já foram Aprovadas, revistas e validadas <strong>%s Imagens</strong>.',
	],
	'WAITING_DISAPPROVED_IMAGE' => [
		'Sem imagens Desaprovadas.',
		'No Total e de acordo com as restrições foi <strong>1 Imagem</strong> Desaprovada.',
		'No Total e de acordo com as restrições foram <strong>%s Imagens</strong> Desaprovadas.',
	],
	'WAITING_LOCKED_IMAGE' => [
		'Sem Imagens bloqueadas.',
		'No Total está bloqueada temporariamente, em processo ou mesmo reprovada <strong>1 Imagem</strong>.',
		'No Total estão Bloqueadas, em processo de Moderação, ou Reprovadas <strong>%s Imagens</strong>.',
	],
	'WAITING_REPORTED_DONE' => [
		'Sem Reportes efetuados a serem Revistos.',
		'Temos a totalidade em estatística já de <strong>1 Reporte Totalmente Revisto</strong>.',
		'A totalidade dos Reportes e revisões que até ao momento foram resolvidos foi de <strong>%s</strong>.',
	],
	'WAITING_REPORTED_IMAGE' => [
		'De Momento não há nenhum reporte válido ou necessitado de ser avaliado.',
		'O nosso sistema encontrou por avaliar e de modo urgente <strong>1 Reporte Novo de Imagem</strong>.',
		'O sistema encontrou um número igual a <strong>%s Reportes a Avaliar</strong>.',
	],
	'WAITING_UNAPPROVED_IMAGE' => [
		'Não existem neste momento imagens nas listas a necessitar avaliação ou revisão e assim ser aprovadas/reprovadas.',
		'Foi requerida e pedida Avaliação para Revisão na Lista da Equipa de Moderação a um número de <strong>1 Imagem</strong>.',
		'Foi requerida avaliação para a lista de imagens a uma quantia de <strong>%s</strong>, aguarde por moderação.',
	],
	'DELETED_IMAGES' => [
		'Sem imagens excluídas.',
		'No Total há apenas registro de exclusão ou arquivo apagado respeitante a <strong>1 Imagem</strong>.',
		'No Total existe já na nossa base e em registro um número correspondente a <strong>%s Imagens e Arquivos Excluídos</strong>.',
	],
	'MOVED_IMAGES' => [
		'Nenhum arquivo foi de momento movido.',
		'A Equipa moveu na Totalidade das estatísticas relativas a Imagens o Correspondente a <strong>1 Imagem e Arquivo Original</strong>.',
		'As acções da equipa indicam que se moveram dos seus locais correspondentes até hoje um total de <strong>%s Imagens</strong>.',
	],
	'NO_WAITING_UNAPPROVED_IMAGE' => 'Não existem imagens em lista para verificação e não há nada aguardar.',
]);
