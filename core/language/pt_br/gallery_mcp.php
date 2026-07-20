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
	'CHOOSE_ACTION'             => 'Selecionar ação pretendida',
	'GALLERY_MCP_MAIN'          => 'Principal',
	'GALLERY_MCP_OVERVIEW'      => 'Visão Geral',
	'GALLERY_MCP_QUEUE'         => 'Fila de Imagens',
	'GALLERY_MCP_QUEUE_DETAIL'  => 'Detalhes da Fila de Imagens',
	'GALLERY_MCP_REPORTED'      => 'Imagens Reportadas',
	'GALLERY_MCP_REPO_DONE'     => 'Reportes Fechados',
	'GALLERY_MCP_REPO_DETAIL'   => 'Detalhes do Reporte',
	'GALLERY_MCP_REPO_OPEN'     => 'Reportes Abertos',
	'GALLERY_MCP_UNAPPROVED'    => 'Imagens por aprovar',
	'GALLERY_MCP_APPROVED'      => 'Imagens aprovadas',
	'GALLERY_MCP_LOCKED'        => 'Imagens bloqueadas',
	'GALLERY_MCP_VIEWALBUM'     => 'Ir para o Álbum',
	'IMAGE_REPORTED_UNAPPROVED' => 'Infelizmente a imagem que procura não existe de momento na Base de Dados. Pode ter sido apagada por razões como (Tamanho não Aconselhável, Erros nas Imagens, Falta de Dados de Título, Formato Destruído e Errado ou Arquivo Vazio). O mais provável foi ainda não ter sido sequer aprovada ou ainda ter sido bloqueada, o que o impede de a visualizar.',
	'NO_REPORT_SELECTED'        => 'Por favor, selecione um ou vários reportes a ser trabalhados pela administração.',
	'REPORT_A_CLOSE'            => 'Fechar Reporte',
	'REPORT_A_CLOSE_CONFIRM'    => 'Tem a certeza que quer fechar este reporte de imagem?',
	'REPORT_A_DELETE'           => 'Apagar o Reporte',
	'REPORT_A_DELETE_CONFIRM'   => 'Tem a certeza que quer apagar definitivamente o reporte selecionado?',
	'REPORT_A_OPEN'             => 'Abrir Reporte',
	'REPORT_A_OPEN_CONFIRM'     => 'Tem a certeza que deseja efetuar esta acção (Abir um/uns Reporte(s)?',
	'REPORT_NOT_FOUND'          => 'De momento não existem dados sobre este reporte, pode já não existir na base de dados.',
	'REPORT_STATUS_1'           => 'A Moderação do Fórum deve proceder à Revisão do Reporte, visto este a exigi-lo.',
	'REPORT_STATUS_2'           => 'O Reporte indicado está fechado e já não é possível aceder-lhe ou alterá-lo.',
	'REPORTS_A_CLOSE'           => 'Fechar Reportes',
	'REPORTS_A_CLOSE2'          => 'Deseja Fechar Reportes?',
	'REPORTS_A_CLOSE2_CONFIRM'  => 'Tem a certeza que quer fechar este(s) reporte(s) de imagem?',
	'REPORTS_A_DELETE'          => 'Apagar Reportes',
	'REPORTS_A_DELETE2'         => 'Deseja Apagar Reportes?',
	'REPORTS_A_DELETE2_CONFIRM' => 'Tem a certeza que deseja excluir/apagar este(s) reporte(s)?',
	'REPORTS_A_OPEN'            => 'Abrir Reportes',
	'REPORTS_A_OPEN2'           => 'Deseja Abrir Reportes?',
	'REPORTS_A_OPEN2_CONFIRM'   => 'Tem a certeza que deseja efetuar a acção (Abir O(s) Reporte(s)?)',
	'REPORT_MOD'                => 'Editado e Retificado Por',
	'REPORT_CLOSED_BY'          => 'Reporte Fechado E Oculto Por',
	'REPORTED_IMAGES'           => 'Reportar Imagens',
	'REPORTER'                  => 'Usuário do Fórum ou Sistema Reportado(a)',
	'REPORTER_AND_ALBUM'        => 'Reportes & Álbuns',
	'WAITING_APPROVED_IMAGE'    => [
		0 => 'Infelizmente de momento não há nenhuma imagem nas nossas listas prestes a serem aprovadas.',
		1 => 'No Total da Galeria já foi <strong>Aprovada e Vista 1 Imagem</strong>.',
		2 => 'No Total já foram Aprovadas, revistas e validadas <strong>%s Imagens</strong>.',
	],
	'WAITING_DISAPPROVED_IMAGE' => [
		0 => 'Sem imagens Desaprovadas.',
		1 => 'No Total e de acordo com as restrições foi <strong>1 Imagem</strong> Desaprovada.',
		2 => 'No Total e de acordo com as restrições foram <strong>%s Imagens</strong> Desaprovadas.',
	],
	'WAITING_LOCKED_IMAGE' => [
		0 => 'Sem Imagens bloqueadas.',
		1 => 'No Total está bloqueada temporariamente, em processo ou mesmo reprovada <strong>1 Imagem</strong>.',
		2 => 'No Total estão Bloqueadas, em processo de Moderação, ou Reprovadas <strong>%s Imagens</strong>.',
	],
	'WAITING_REPORTED_DONE' => [
		0 => 'Sem Reportes efetuados a serem Revistos.',
		1 => 'Temos a totalidade em estatística já de <strong>1 Reporte Totalmente Revisto</strong>.',
		2 => 'A totalidade dos Reportes e revisões que até ao momento foram resolvidos foi de <strong>%s</strong>.',
	],
	'WAITING_REPORTED_IMAGE' => [
		0 => 'De Momento não há nenhum reporte válido ou necessitado de ser avaliado.',
		1 => 'O nosso sistema encontrou por avaliar e de modo urgente <strong>1 Reporte Novo de Imagem</strong>.',
		2 => 'O sistema encontrou um número igual a <strong>%s Reportes a Avaliar</strong>.',
	],
	'WAITING_UNAPPROVED_IMAGE' => [
		0 => 'Não existem neste momento imagens nas listas a necessitar avaliação ou revisão e assim ser aprovadas/reprovadas.',
		1 => 'Foi requerida e pedida Avaliação para Revisão na Lista da Equipa de Moderação a um número de <strong>1 Imagem</strong>.',
		2 => 'Foi requerida avaliação para a lista de imagens a uma quantia de <strong>%s</strong>, aguarde por moderação.',
	],
	'DELETED_IMAGES' => [
		0 => 'Sem imagens excluídas.',
		1 => 'No Total há apenas registro de exclusão ou arquivo apagado respeitante a <strong>1 Imagem</strong>.',
		2 => 'No Total existe já na nossa base e em registro um número correspondente a <strong>%s Imagens e Arquivos Excluídos</strong>.',
	],
	'MOVED_IMAGES' => [
		0 => 'Nenhum arquivo foi de momento movido.',
		1 => 'A Equipa moveu na Totalidade das estatísticas relativas a Imagens o Correspondente a <strong>1 Imagem e Arquivo Original</strong>.',
		2 => 'As acções da equipa indicam que se moveram dos seus locais correspondentes até hoje um total de <strong>%s Imagens</strong>.',
	],
	'NO_WAITING_UNAPPROVED_IMAGE' => 'Não existem imagens em lista para verificação e não há nada aguardar.',
]);
