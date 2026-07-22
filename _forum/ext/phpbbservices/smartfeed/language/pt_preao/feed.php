<?php

/**
 * @package phpBB Extension - Smartfeed for phpBB.
 * @copyright (c) 2020 Mark D. Hamill (mark@phpbbservices.com)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'SMARTFEED_APACHE_AUTHENTICATION_WARNING_REG'    => 'Smartfeed não pode ser utilizado neste fórum. Contacta o Administrador do Fórum para mais informações.',
	'SMARTFEED_ATOM_10'                              => 'Atom 1.0',
	'SMARTFEED_BAD_BOOKMARKS_VALUE'                  => 'O parâmetro dos favoritos (b), se utilizado, só pode ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_BAD_MARK_PRIVATE_MESSAGES_READ_ERROR' => 'Se presente, o parâmetro para marcar mensagens privadas como lidas (k) tem de ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_BAD_PASSWORD_ERROR'                   => 'Falha na autenticação. O parâmetro &ldquo;e&rdquo; com valor &ldquo;%s&rdquo; é inválido com o parâmetro &ldquo;u&rdquo; com valor de &ldquo;%s&rdquo;. Este erro pode ter sido causado por uma alteração na tua palavra-passe phpBB, ou devido a uma atualização neste software Smartfeed. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_BAD_PMS_VALUE'                        => 'Se presente, o parâmetro mostrar mensagens privadas (m) tem de ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_BOARD_DISABLED'                       => 'Este fórum encontra-se desligado neste momento. Consequentemente, a funcionalidade do feed de notícias foi desactivada. Quando o fórum voltar a estar online, poderás aceder aos feeds de notícias novamente.',
	'SMARTFEED_DELIMITER'                            => ' :: ',
	'SMARTFEED_EXTERNAL_ITEM'                        => 'Item externo',
	'SMARTFEED_ERROR'                                => 'Erro Smartfeed',
	'SMARTFEED_FEED'                                 => 'Feed de notícias Smartfeed',
	'SMARTFEED_FEED_TYPE_ERROR'                      => 'Smartfeed não aceita o valor do parâmetro do tipo de feed y=%s. Valores aceitáveis são 0 (Atom), 1 (RSS 1.0) e 2 (RSS 2.0).',
	'SMARTFEED_FILTER_FOES_ERROR'                    => 'O valor do parâmetro filtrar ignorados (ff) é inválido. Se presente, só deve ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_FIRST_POST_ONLY_ERROR'                => 'O valor do parâmetro apenas a primeira mensagem (fp) é inválido. Se presente, só deve ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_GLOBAL_ANNOUNCEMENT'                  => 'ANÚNCIO GLOBAL',
	'SMARTFEED_IP_AUTH_ERROR'                        => 'O endereço de Protocolo de Internet (IP) do cliente que está a fazer o pedido Smartfeed não tem autorização para aceder ao feed porque não passou a credencial adequada. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_IP_RANGE_ERROR'                       => 'O teu IP de %s é inválido.',
	'SMARTFEED_LASTVISIT_ERROR'                      => 'O valor do parâmetro da última visita (l) especificado é inválido. Se presente, tem de ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_LAST_POST_ONLY_ERROR'                 => 'O valor do parâmetro apenas a última mensagem (lp) é inválido. Se presente, só deve ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_LIMIT_FORMAT_ERROR'                   => 'O parâmetro do limite de tempo (t) não tem um valor permitido. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_MAX_ITEMS_ERROR'                      => 'Se especificado, o valor do parâmetro de itens máximos (x) tem de ser um número inteiro superior a 0. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_MAX_WORD_SIZE_ERROR'                  => 'O valor do parâmetro de palavras máximas numa mensagem (w) é inválido. Se utilizado, tem de ser um número inteiro. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_MAX_WORDS_NOTIFIER'                   => ' ...',
	'SMARTFEED_MIN_WORD_SIZE_ERROR'                  => 'O valor do parâmetro de tamanho mínimo de palavras (i) é inválido. Tem de ser um número inteiro. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_NEW_PMS_NOTIFICATIONS_ONLY'           => 'Tens novas mensagens privadas. Por favor, inicia sessão no fórum para as ler.',
	'SMARTFEED_NEW_PMS_NOTIFICATIONS_SHORT'          => 'Tens novas mensagens privadas',
	'SMARTFEED_NEW_POST_NOTIFICATION'                => 'Existem novas mensagens neste tópico. Por favor, inicia sessão no fórum para as ler.',
	'SMARTFEED_NEW_TOPIC_NOTIFICATION'               => 'Este é um tópico novo. Por favor, inicia sessão no fórum para o ler.',
	'SMARTFEED_NO_ACCESSIBLE_FORUMS'                 => 'Não tens permissão para aceder a nenhum fórum neste site. Se estás registado neste site, podes precisar que o administrador te dê privilégios para ler os fóruns ou para te restabelecer como membro activo.',
	'SMARTFEED_NO_BOOKMARKS'                         => 'Não tens nenhum tópico nos favoritos, mas pediste para mostrar apenas os tópicos nos favoritos. Consequentemente, não há mensagens no feed. Se desejares utilizar os favoritos com o Smartfeed, por favor visita o fórum e adiciona um ou mais tópicos aos favoritos.',
	'SMARTFEED_NO_FORUMS_ACCESSIBLE'                 => 'Desculpa, devido às exclusões do fórum Smartfeed e aos teus privilégios de acesso ao fórum, não podes aceder a nenhum fórum',
	'SMARTFEED_NO_E_ARGUMENT'                        => 'Para autenticar um membro, o parâmetro &ldquo;e&rdquo; tem de ser utilizado com o parâmetro &ldquo;u&rdquo;. O parâmetro &ldquo;u&rdquo; está presente mas o parâmetro &ldquo;e&rdquo; não está. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_NO_OPENSSL_MODULE'                    => 'Smartfeed não pode suportar autenticação de utilizador porque o fórum não suporta o módulo openssl do PHP. Por favor, executa novamente o Smartfeed no fórum com sessão terminada para adquirires um URI válido para o Smartfeed.',
	'SMARTFEED_NO_U_ARGUMENT'                        => 'Para autenticar um membro, o parâmetro &ldquo;u&rdquo; tem de ser utilizado com o parâmetro &ldquo;e&rdquo;. O parâmetro &ldquo;e&rdquo; está presente mas o parâmetro &ldquo;u&rdquo; não está. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_POST_IMAGE_TEXT'                      => '<br>(Clica na imagem para ver no tamanho original.)',
	'SMARTFEED_POST_SIGNATURE_DELIMITER'             => '<br>____________________<br>',
	'SMARTFEED_REMOVE_MINE_ERROR'                    => 'O valor do parâmetro remover as minhas mensagens (r) é inválido. Se presente, só deve ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_REPLY'                                => 'Resposta',
	'SMARTFEED_REPLY_BY'                             => 'Responder por',
	'SMARTFEED_SHOW_TOPIC_TITLES_ERROR'              => 'O valor do parâmetro mostrar títulos dos tópicos (tt) especificado é inválido. Se presente, tem de ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_SORT_BY_ERROR'                        => 'Smartfeed não pode aceitar o valor do parâmetro de ordenar por (s). Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_STYLE_ERROR'                          => 'O parâmetro de estilo não é um dos valores permitidos, ou está ausente. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_SUPPRESS_FORUM_NAMES_ERROR'           => 'O valor do parâmetro ocultar nomes dos fóruns (fn) especificado é inválido. Se presente, tem de ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_SUPPRESS_USERNAMES_ERROR'             => 'O valor do parâmetro ocultar nomes de utilizador (un) especificado é inválido. Se presente, tem de ter o valor de 1. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
	'SMARTFEED_USER_ID_DOES_NOT_EXIST'               => 'O ID de utilizador identificado pelo parâmetro &ldquo;u&rdquo; não existe ou não tem permissão para aceder a um feed. Por favor, executa novamente o Smartfeed no fórum para gerares um URL de feed correcto.',
]);
