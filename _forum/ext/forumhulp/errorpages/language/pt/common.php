<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ERRORPAGES_BAD_REQUEST' => 'Pedido inválido',
	'ERRORPAGES_BAD_REQUEST_EXPLAIN' => 'Não foi possível interpretar o pedido porque contém uma sintaxe inválida.',
	'ERRORPAGES_AUTH_REQUIRED' => 'Autorização necessária',
	'ERRORPAGES_AUTH_REQUIRED_EXPLAIN' => 'Tens de iniciar sessão antes de aceder a este recurso.',
	'ERRORPAGES_FORBIDDEN' => 'Acesso proibido',
	'ERRORPAGES_FORBIDDEN_EXPLAIN' => 'Não tens permissão para aceder a este recurso.',
	'ERRORPAGES_NOT_FOUND' => 'Página não encontrada',
	'ERRORPAGES_NOT_FOUND_EXPLAIN' => 'A página solicitada pode estar indisponível, ter sido movida ou já não existir.',
	'ERRORPAGES_METHOD_NOT_ALLOWED' => 'Método não permitido',
	'ERRORPAGES_METHOD_NOT_ALLOWED_EXPLAIN' => 'O método utilizado no pedido não é suportado por este recurso.',
	'ERRORPAGES_NOT_ACCEPTABLE' => 'Não aceitável',
	'ERRORPAGES_NOT_ACCEPTABLE_EXPLAIN' => 'O recurso solicitado não consegue produzir uma resposta aceitável para o cliente.',
	'ERRORPAGES_PROXY_AUTHENTICATION_REQUIRED' => 'Autenticação no proxy necessária',
	'ERRORPAGES_PROXY_AUTHENTICATION_REQUIRED_EXPLAIN' => 'O cliente tem de se autenticar primeiro no proxy.',
	'ERRORPAGES_REQUEST_TIMED_OUT' => 'Tempo limite do pedido esgotado',
	'ERRORPAGES_REQUEST_TIMED_OUT_EXPLAIN' => 'O servidor esgotou o tempo de espera pelo pedido.',
	'ERRORPAGES_CONFLICTING_REQUEST' => 'Conflito',
	'ERRORPAGES_CONFLICTING_REQUEST_EXPLAIN' => 'Não foi possível concluir o pedido devido a um conflito com o estado atual do recurso.',
	'ERRORPAGES_GONE' => 'Recurso removido',
	'ERRORPAGES_GONE_EXPLAIN' => 'O recurso solicitado já não está disponível e não deverá voltar a estar disponível.',
	'ERRORPAGES_CONTENT_LENGTH_REQUIRED' => 'Comprimento do conteúdo necessário',
	'ERRORPAGES_CONTENT_LENGTH_REQUIRED_EXPLAIN' => 'O pedido não indicou o comprimento do conteúdo exigido.',
	'ERRORPAGES_PRECONDITION_FAILED' => 'Falha na pré-condição',
	'ERRORPAGES_PRECONDITION_FAILED_EXPLAIN' => 'Não foi possível satisfazer uma condição fornecida com o pedido.',
	'ERRORPAGES_REQUEST_ENTITY_TOO_LONG' => 'Conteúdo demasiado grande',
	'ERRORPAGES_REQUEST_ENTITY_TOO_LONG_EXPLAIN' => 'O pedido é maior do que o servidor está disposto ou consegue processar.',
	'ERRORPAGES_REQUEST_URI_TOO_LONG' => 'URI demasiado longo',
	'ERRORPAGES_REQUEST_URI_TOO_LONG_EXPLAIN' => 'O URI fornecido é demasiado longo para o servidor processar.',
	'ERRORPAGES_UNSUPPORTED_MEDIA_TYPE' => 'Tipo de conteúdo não suportado',
	'ERRORPAGES_UNSUPPORTED_MEDIA_TYPE_EXPLAIN' => 'O servidor não suporta o tipo de conteúdo utilizado pelo pedido.',
	'ERRORPAGES_TEAPOT' => 'Sou um bule de chá',
	'ERRORPAGES_TEAPOT_EXPLAIN' => 'O servidor recusa-se a preparar café porque é, permanentemente, um bule de chá.',
	'ERRORPAGES_INTERNAL_SERVER_ERROR' => 'Erro interno do servidor',
	'ERRORPAGES_INTERNAL_SERVER_ERROR_EXPLAIN' => 'O servidor encontrou uma condição inesperada e não conseguiu concluir o pedido.',
	'ERRORPAGES_NOT_IMPLEMENTED' => 'Não implementado',
	'ERRORPAGES_NOT_IMPLEMENTED_EXPLAIN' => 'O servidor não suporta a funcionalidade necessária para concluir o pedido.',
	'ERRORPAGES_BAD_GATEWAY' => 'Gateway inválido',
	'ERRORPAGES_BAD_GATEWAY_EXPLAIN' => 'O servidor recebeu uma resposta inválida de um servidor a montante.',
	'ERRORPAGES_SERVICE_UNAVAILABLE' => 'Serviço indisponível',
	'ERRORPAGES_SERVICE_UNAVAILABLE_EXPLAIN' => 'O servidor não consegue processar o pedido temporariamente. Tenta novamente mais tarde.',
	'ERRORPAGES_GATEWAY_TIMEOUT' => 'Tempo limite do gateway esgotado',
	'ERRORPAGES_GATEWAY_TIMEOUT_EXPLAIN' => 'O servidor não recebeu atempadamente uma resposta de um servidor a montante.',
	'ERRORPAGES_HTTP_VERSION_NOT_SUPPORTED' => 'Versão HTTP não suportada',
	'ERRORPAGES_HTTP_VERSION_NOT_SUPPORTED_EXPLAIN' => 'O servidor não suporta a versão do protocolo HTTP utilizada pelo pedido.',
	'ERRORPAGES_UNKNOWN' => 'Erro desconhecido no pedido',
	'ERRORPAGES_UNKNOWN_EXPLAIN' => 'Não foi possível concluir o pedido.',
]);
