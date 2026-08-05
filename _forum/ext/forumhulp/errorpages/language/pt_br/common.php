<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 *
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
	'ERRORPAGES_RETURN_INDEX' => 'Voltar à página inicial',
	'ERRORPAGES_BAD_REQUEST' => 'Requisição inválida',
	'ERRORPAGES_BAD_REQUEST_EXPLAIN' => 'Não foi possível interpretar a requisição porque ela contém uma sintaxe inválida.',
	'ERRORPAGES_AUTH_REQUIRED' => 'Autorização necessária',
	'ERRORPAGES_AUTH_REQUIRED_EXPLAIN' => 'Você precisa entrar antes de acessar este recurso.',
	'ERRORPAGES_FORBIDDEN' => 'Acesso proibido',
	'ERRORPAGES_FORBIDDEN_EXPLAIN' => 'Você não tem permissão para acessar este recurso.',
	'ERRORPAGES_NOT_FOUND' => 'Página não encontrada',
	'ERRORPAGES_NOT_FOUND_EXPLAIN' => 'A página solicitada pode estar indisponível, ter sido movida ou não existir mais.',
	'ERRORPAGES_METHOD_NOT_ALLOWED' => 'Método não permitido',
	'ERRORPAGES_METHOD_NOT_ALLOWED_EXPLAIN' => 'O método usado na requisição não é compatível com este recurso.',
	'ERRORPAGES_NOT_ACCEPTABLE' => 'Não aceitável',
	'ERRORPAGES_NOT_ACCEPTABLE_EXPLAIN' => 'O recurso solicitado não consegue produzir uma resposta aceitável para o cliente.',
	'ERRORPAGES_PROXY_AUTHENTICATION_REQUIRED' => 'Autenticação no proxy necessária',
	'ERRORPAGES_PROXY_AUTHENTICATION_REQUIRED_EXPLAIN' => 'O cliente precisa primeiro se autenticar no proxy.',
	'ERRORPAGES_REQUEST_TIMED_OUT' => 'Tempo limite da requisição esgotado',
	'ERRORPAGES_REQUEST_TIMED_OUT_EXPLAIN' => 'O servidor esgotou o tempo de espera pela requisição.',
	'ERRORPAGES_CONFLICTING_REQUEST' => 'Conflito',
	'ERRORPAGES_CONFLICTING_REQUEST_EXPLAIN' => 'Não foi possível concluir a requisição devido a um conflito com o estado atual do recurso.',
	'ERRORPAGES_GONE' => 'Recurso removido',
	'ERRORPAGES_GONE_EXPLAIN' => 'O recurso solicitado não está mais disponível e não deverá voltar a ficar disponível.',
	'ERRORPAGES_CONTENT_LENGTH_REQUIRED' => 'Comprimento do conteúdo necessário',
	'ERRORPAGES_CONTENT_LENGTH_REQUIRED_EXPLAIN' => 'A requisição não informou o comprimento de conteúdo exigido.',
	'ERRORPAGES_PRECONDITION_FAILED' => 'Falha na pré-condição',
	'ERRORPAGES_PRECONDITION_FAILED_EXPLAIN' => 'Não foi possível satisfazer uma condição fornecida com a requisição.',
	'ERRORPAGES_REQUEST_ENTITY_TOO_LONG' => 'Conteúdo grande demais',
	'ERRORPAGES_REQUEST_ENTITY_TOO_LONG_EXPLAIN' => 'A requisição é maior do que o servidor aceita ou consegue processar.',
	'ERRORPAGES_REQUEST_URI_TOO_LONG' => 'URI longa demais',
	'ERRORPAGES_REQUEST_URI_TOO_LONG_EXPLAIN' => 'A URI fornecida é longa demais para o servidor processar.',
	'ERRORPAGES_UNSUPPORTED_MEDIA_TYPE' => 'Tipo de conteúdo não suportado',
	'ERRORPAGES_UNSUPPORTED_MEDIA_TYPE_EXPLAIN' => 'O servidor não aceita o tipo de conteúdo usado pela requisição.',
	'ERRORPAGES_TEAPOT' => 'Sou um bule de chá',
	'ERRORPAGES_TEAPOT_EXPLAIN' => 'O servidor se recusa a preparar café porque é, permanentemente, um bule de chá.',
	'ERRORPAGES_INTERNAL_SERVER_ERROR' => 'Erro interno do servidor',
	'ERRORPAGES_INTERNAL_SERVER_ERROR_EXPLAIN' => 'O servidor encontrou uma condição inesperada e não conseguiu concluir a requisição.',
	'ERRORPAGES_NOT_IMPLEMENTED' => 'Não implementado',
	'ERRORPAGES_NOT_IMPLEMENTED_EXPLAIN' => 'O servidor não oferece a funcionalidade necessária para concluir a requisição.',
	'ERRORPAGES_BAD_GATEWAY' => 'Gateway inválido',
	'ERRORPAGES_BAD_GATEWAY_EXPLAIN' => 'O servidor recebeu uma resposta inválida de um servidor upstream.',
	'ERRORPAGES_SERVICE_UNAVAILABLE' => 'Serviço indisponível',
	'ERRORPAGES_SERVICE_UNAVAILABLE_EXPLAIN' => 'O servidor não consegue processar a requisição no momento. Tente novamente mais tarde.',
	'ERRORPAGES_GATEWAY_TIMEOUT' => 'Tempo limite do gateway esgotado',
	'ERRORPAGES_GATEWAY_TIMEOUT_EXPLAIN' => 'O servidor não recebeu a tempo uma resposta de um servidor upstream.',
	'ERRORPAGES_HTTP_VERSION_NOT_SUPPORTED' => 'Versão HTTP não suportada',
	'ERRORPAGES_HTTP_VERSION_NOT_SUPPORTED_EXPLAIN' => 'O servidor não aceita a versão do protocolo HTTP usada pela requisição.',
	'ERRORPAGES_UNKNOWN' => 'Erro desconhecido na requisição',
	'ERRORPAGES_UNKNOWN_EXPLAIN' => 'Não foi possível concluir a requisição.',
]);
