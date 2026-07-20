<?php

/**
 * @package Errorpages for phpBB.
 * @copyright (c) 2014 ForumHulp.com
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
* DO NOT CHANGE!
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

// Custom error pages
$lang = array_merge($lang, [
	'ERRORPAGESERROR'                   => 'Páginas de erro',
	'ERRORPAGES_LOG'                    => 'Registar Páginas de Erro',
	'ERRORPAGES_LOG_EXPLAIN'            => 'Registar todas as Páginas de Erro no Registro de Erros no Separador Manutenção',
	'ERRORPAGES_EXPLAIN'                => 'Explicar Páginas de Erro',
	'ERRORPAGES_EXPLAIN_EXPLAIN'        => 'Explicar erro na apresentação da mensagem',
	'ERRORPAGE_NOTICE'                  => '<div class="phpinfo"><p>As definições de configuração estão em <strong>%1$s » %2$s » %3$s.</strong></p></div>',
	'ERROR_BAD_REQUEST'                 => 'Pedido Inválido (Bad Request)',
	'ERROR_BAD_REQUESTEXPA'             => 'O pedido tinha sintaxe inválida ou era inerentemente impossível de ser concluído.',
	'ERROR_AUTH_REQUIRED'               => 'Permissão Necessária (Authorization Required)',
	'ERROR_AUTH_REQUIREDEXPA'           => 'Isto significa que a página requer que os visitantes se autentiquem com o seu nome de usuário e senha. Se falharem nisso, o servidor retorna esta mensagem de erro.',
	'ERROR_FORBIDDEN'                   => 'Proibido (Forbidden)',
	'ERROR_FORBIDDENEXPA'               => 'Isto significa que o acesso à página que o visitante está a solicitar não é permitido. Isto pode dever-se a uma regra especial na configuração do servidor web, ou às permissões específicas do sistema de arquivos do arquivo.',
	'ERROR_NOT_FOUND'                   => '<span class="error"><i></i></span>OOPS! Página Não Encontrada',
	'ERROR_NOT_FOUNDEXPA'               => 'Infelizmente a página que procurava não pôde ser encontrada. Pode estar temporariamente indisponível, ter sido movida ou já não existir.<br /><br />Verifique o URL que introduziu para detetar eventuais erros e tente novamente.',
	'PRECONDITION_FAILED'               => 'Falha na Pré-condição (Precondition Failed)',
	'PRECONDITION_FAILEDEXPA'           => 'O erro significa que o pedido acionou uma proteção mod_security do nosso lado.',
	'METHOD_NOT_ALLOWED'                => 'Método Não Permitido (Method Not Allowed)',
	'METHOD_NOT_ALLOWEDEXPA'            => 'Foi feito um pedido de um recurso usando um método de pedido não suportado por esse recurso; por exemplo, usar GET num formulário que requer que os dados sejam apresentados via POST, ou usar PUT num recurso apenas de leitura.',
	'NOT_ACCEPTABLE'                    => 'Não Aceitável (codificação) (Not Acceptable)',
	'NOT_ACCEPTABLEEXPA'                => 'O recurso solicitado só é capaz de gerar conteúdo não aceitável de acordo com os cabeçalhos Accept enviados no pedido.',
	'PROXY_AUTHENTICATION_REQUIRED'     => 'Autenticação Proxy Necessária (Proxy Authentication Required)',
	'PROXY_AUTHENTICATION_REQUIREDexpa' => 'O cliente deve primeiro autenticar-se com o proxy.',
	'REQUEST_TIMED_OUT'                 => 'Tempo Limite do Pedido Esgotado (Request Timed Out)',
	'REQUEST_TIMED_OUTEXPA'             => 'O servidor esgotou o tempo de espera pelo pedido. De acordo com as especificações HTTP: "O cliente não produziu um pedido dentro do tempo que o servidor estava preparado para esperar. O cliente PODE repetir o pedido sem modificações a qualquer momento posterior."',
	'CONFLICTING_REQUEST'               => 'Pedido Conflituoso (Conflicting Request)',
	'CONFLICTING_REQUESTEXPA'           => 'Indica que o pedido não pôde ser processado devido a um conflito no pedido, como um conflito de edição no caso de atualizações múltiplas',
	'GONE'                              => 'Desapareceu (Gone)',
	'GONEEXPA'                          => 'Indica que o recurso solicitado já não está disponível e não voltará a estar disponível. Isto deve ser usado quando um recurso foi intencionalmente removido e o recurso deve ser purgado. Ao receber um código de estado 410, o cliente não deve solicitar o recurso novamente no futuro. Clientes como motores de busca devem remover o recurso dos seus índices. A maioria dos casos de uso não exige que clientes e motores de busca purguem o recurso, e um "404 Not Found" pode ser usado em vez disso.',
	'CONTENT_LENGTH_REQUIRED'           => 'Comprimento do Conteúdo Necessário (Content Length Required)',
	'CONTENT_LENGTH_REQUIREDexpa'       => 'O pedido não especificou o comprimento do seu conteúdo, o que é requerido pelo recurso solicitado',
	'REQUEST_ENTITY_TOO_LONG'           => 'Entidade do Pedido Demasiado Longa (Request Entity Too Long)',
	'REQUEST_ENTITY_TOO_LONGEXPA'       => 'O pedido é maior do que o servidor está disposto ou capaz de processar.',
	'REQUEST_URI_TOO_LONG'              => 'URI do Pedido Demasiado Longo (Request URI Too Long)',
	'REQUEST_URI_TOO_LONGEXPA'          => 'O URI fornecido era demasiado longo para o servidor processar. Frequentemente o resultado de demasiados dados sendo codificados como uma query-string de um pedido GET, caso em que deve ser convertido num pedido POST.',
	'UNSUPPORTED_MEDIA_TYPE'            => 'Tipo de Media Não Suportado (Unsupported Media Type)',
	'UNSUPPORTED_MEDIA_TYPEEXPA'        => 'A entidade do pedido tem um tipo de media que o servidor ou recurso não suporta. Por exemplo, o cliente carrega uma imagem como image/svg+xml, mas o servidor requer que as imagens usem um formato diferente.',
	'TEAPOT'                            => 'Eu sou um bule de chá (I\'m a teapot) (RFC 2324)',
	'TEAPOTEXPA'                        => 'Este código foi definido em 1998 como uma das tradicionais piadas de 1 de Abril da IETF, no RFC 2324, Hyper Text Coffee Pot Control Protocol, e não se espera que seja implementado por servidores HTTP reais.',
	'INTERNAL_SERVER_ERROR'             => 'Erro Interno do Servidor (Internal Server Error)',
	'INTERNAL_SERVER_ERROREXPA'         => 'O servidor encontrou uma condição inesperada que o impediu de cumprir o pedido.',
	'NOT_IMPLEMENTED'                   => 'Não implementado (Not implemented)',
	'NOT_IMPLEMENTEDEXPA'               => 'O servidor não suporta a facilidade requerida.',
	'BAD_GATEWAY'                       => 'Gateway Inválido (Bad Gateway)',
	'BAD_GATEWAYEXPA'                   => 'O servidor estava a atuar como um gateway ou proxy e recebeu uma resposta inválida do servidor upstream.',
	'SERVICE_UNAVAILABLE'               => 'Serviço Indisponível (Service Unavailable)',
	'SERVICE_UNAVAILABLEEXPA'           => 'O servidor está temporariamente incapaz de atender o seu pedido devido a paragem para manutenção ou problemas de capacidade. Por favor, tente novamente mais tarde.',
	'GATEWAY_TIMOUT'                    => 'Tempo Limite do Gateway Esgotado (Gateway Timeout)',
	'GATEWAY_TIMOUTEXPA'                => 'O servidor estava a atuar como um gateway ou proxy e não recebeu uma resposta atempada do servidor upstream.',
	'HTTP_VERSION_NOT_SUPPORTED'        => 'Versão HTTP Não Suportada (HTTP Version Not Supported)',
	'HTTP_VERSION_NOT_SUPPORTEDEXPA'    => 'O servidor não suporta a versão do protocolo HTTP usada no pedido.',
	'ERROR_UNKNOWN'                     => 'Erro de Servidor Desconhecido',
	'ERROR_UNKNOWNEXPA'                 => '',
	'FH_HELPER_NOTICE'                  => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
]);
