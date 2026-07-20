<?php

/**
 * @package phpBB Extension - Smartfeed for phpBB.
 * @copyright (c) 2020 Mark D. Hamill (mark@phpbbservices.com)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

global $phpbb_container;

// Encapsulate certain phpBB objects inside this class to minimize security issues
$this->config = $phpbb_container->get('config');

$lang = array_merge($lang, [
	'SMARTFEED_ADDITIONAL_CRITERIA'                 => 'Critérios adicionais',
	'SMARTFEED_ALL_FORUMS'                          => 'Todos',
	'SMARTFEED_APACHE_AUTHENTICATION_WARNING_ADMIN' => 'Smartfeed não pode ser usado com a autenticação Apache até que o administrador ajuste o ficheiro .htaccess do fórum. O administrador deve ajustar o ficheiro .htaccess e alterar as configurações do Smartfeed no Painel de Administração.',
	'SMARTFEED_ATOM_10'                             => 'ATOM 1.0',
	'SMARTFEED_EXPLANATION'                         => 'Com o Smartfeed pode criar o seu próprio feed de notícias personalizado a partir das mensagens deste fórum e lê-las com o leitor de notícias da sua escolha. O Smartfeed suporta autenticação para membros registados, permitindo que leiam mensagens em fóruns que outros poderão não conseguir ler.<br><br>O Smartfeed também suporta feeds de tópicos. Precisa saber o número do tópico para usar esta opção e ela apenas pode ser usada para um único tópico. A forma mais fácil de obter a ligação de um feed para um tópico em particular, é visualizar a fonte da página na página do respetivo tópico. Irá encontrar o link na tag de formatação &lt;link&gt;. Irá parecer-se com algo deste género: /app.php/smartfeed/feed?tf=123. Copie esse link para o seu leitor de feeds.',
	'SMARTFEED_EXPLANATION_PUBLIC_ONLY'             => 'Com o Smartfeed pode criar o seu próprio feed de notícias personalizado a partir das mensagens deste fórum e lê-las com o leitor de notícias da sua escolha.<br><br>O Smartfeed também suporta feeds de tópicos. Precisa saber o número do tópico para usar esta opção e ela apenas pode ser usada para um único tópico. A forma mais fácil de obter a ligação de um feed para um tópico em particular, é visualizar a fonte da página na página do respetivo tópico. Irá encontrar o link na tag de formatação &lt;link&gt;. Irá parecer-se com algo deste género: /app.php/smartfeed/feed?tf=123. Copie esse link para o seu leitor de feeds.',
	'SMARTFEED_FEED_STYLING'                        => 'Formatação do feed de notícias',
	'SMARTFEED_FEED_STYLING_EXPLAIN'                => 'Tenha em atenção que a quantidade de estilos do feed efetivamente aplicada depende das capacidades do seu leitor de notícias. A maior parte dos leitores de notícias não irá aplicar todas as formatações em HTML. Deslize com o cursor do rato por cima da formatação de texto para aprender mais. <em>Aviso</em>: a formatação não se aplica a itens no feed que venham de feeds externos exigidos pelo administrador.',
	'SMARTFEED_FILTER_CRITERIA'                     => 'Filtros de mensagens',
	'SMARTFEED_FILTER_FOES'                         => 'Remover mensagens dos meus ignorados',
	'SMARTFEED_FORMAT_AND_ACCESS'                   => 'Controlo de formato e de acessos',
	'SMARTFEED_FORUM_SELECTION'                     => 'Seleção do fórum',
	'SMARTFEED_GENERATE_BUTTON'                     => 'Gerar o URL',
	'SMARTFEED_GENERATE_BUTTON_EXPLAIN'             => 'Para copiar, carregue no URL. Todo o texto irá ser automaticamente selecionado. Depois copie-o e cole no seu leitor de notícias.',
	'SMARTFEED_GENERATE_URL_TEXT'                   => 'Gerar',
	'SMARTFEED_IP_AUTH'                             => 'Autenticação de IP',
	'SMARTFEED_IP_AUTHENTICATION'                   => 'Autenticação de IP',
	'SMARTFEED_IP_AUTHENTICATION_EXPLAIN'           => 'O seu atual endereço de IP (Protocolo de Internet) é o %s. Se selecionar sim, o URL gerado apenas irá fazer o feed funcionar dentro desta amplitude de IP.',
	'SMARTFEED_LAST_1_HOURS'                        => 'Na Última Hora',
	'SMARTFEED_LAST_12_HOURS'                       => 'Nas Últimas 12 Horas',
	'SMARTFEED_LAST_15_MINUTES'                     => 'Nos Últimos 15 Minutos',
	'SMARTFEED_LAST_3_HOURS'                        => 'Nas Últimas 3 Horas',
	'SMARTFEED_LAST_30_MINUTES'                     => 'Nos Últimos 30 Minutos',
	'SMARTFEED_LAST_6_HOURS'                        => 'Nas Últimas 6 Horas',
	'SMARTFEED_LAST_DAY'                            => 'Nas Últimas 24 Horas',
	'SMARTFEED_LAST_MONTH'                          => 'Nos Últimos 30 Dias',
	'SMARTFEED_LAST_QUARTER'                        => 'Nos Últimos 90 Dias',
	'SMARTFEED_LAST_TWO_WEEKS'                      => 'Nos Últimos 14 Dias',
	'SMARTFEED_LAST_WEEK'                           => 'Nos Últimos 7 Dias',
	'SMARTFEED_LASTVISIT_RESET'                     => 'Reiniciar a minha data da última visita ao entrar no feed de notícias',
	'SMARTFEED_LIMIT'                               => 'Limite de tempo',
	'SMARTFEED_LIMIT_EXPLAIN'                       => 'Incluir mensagens contidas durante este espaço de tempo até ao presente momento no feed de notícias.',
	'SMARTFEED_LIMIT_SET_EXPLAIN'                   => 'Independentemente dos períodos de tempo ilustrados, este fórum tem um tempo limite de %d dias a partir de quando já não podem ser recolhidas mais mensagens. Isto é necessário para garantir que recolher feeds não atrasa no seu cômputo geral, os acessos a este fórum.',
	'SMARTFEED_MARK_READ'                           => 'Marcar mensagens privadas como lidas quando surgirem no feed',
	'SMARTFEED_MAX_ITEMS'                           => 'Número máximo de itens no feed',
	'SMARTFEED_MAX_ITEMS_EXPLAIN'                   => 'O número máximo de mensagens num feed permitidas pelo administrador do fórum é %d. Se configurado para zero, não irá existir um limite de quantidade de itens permitidos no campo. Se especificar o zero, o limite do fórum será usado caso esteja estipulado.',
	'SMARTFEED_MAX_ITEMS_EXPLAIN_BLANK'             => 'Se for zero, pode estar qualquer quantidade de itens contida num feed.',
	'SMARTFEED_MAX_WORD_SIZE'                       => 'Máximo de palavras a exibir numa mensagem ou numa mensagem privada',
	'SMARTFEED_MAX_WORD_SIZE_EXPLAIN'               => 'Se configurado a zero, uma mensagem ou mensagem privada poderá ter qualquer dimensão contida no feed que não ultrapasse o limite do fórum, caso haja um estipulado. <em>Aviso</em>: se não figurar como zero, de forma a garantir uma renderização consistente caso uma mensagem ou mensagem privada seja truncada, o HTML irá ser removido. É permitido um número máximo de %d palavras.',
	'SMARTFEED_MAX_WORD_SIZE_EXPLAIN_BLANK'         => 'Se for zero, uma mensagem ou mensagem privada pode ter qualquer tamanho no feed até ao limite do fórum, caso haja um definido. <em>Aviso</em>: se não figurar como zero, de forma a garantir uma renderização consistente caso uma mensagem ou mensagem privada seja truncada, o HTML irá ser removido.',
	'SMARTFEED_MIN_WORDS'                           => 'Mínimo de palavras exigidas numa mensagem para que esta possa surgir no feed',
	'SMARTFEED_MIN_WORDS_EXPLAIN'                   => 'Se for zero, não são exigidas nenhumas quantidades mínimas de palavras. Este limite não é aplicável a mensagens privadas.',
	'SMARTFEED_NEW_PMS_NOTIFICATIONS_ONLY'          => 'Tem mensagens privadas novas no fórum. Por favor, entre na sua conta do fórum para as poder ler.',
	'SMARTFEED_NO_FORUMS_SELECTED'                  => 'Não selecionou qualquer fórum, como tal nenhum URL pode ser gerado. Por favor selecione pelo menos um fórum.',
	'SMARTFEED_NO_LIMIT'                            => 'Nenhum',
	'SMARTFEED_NO_OPENSSL_SUPPORT'                  => '<strong>Aviso: este site apenas fornece feeds para fóruns públicos</strong>',
	'SMARTFEED_NOT_LOGGED_IN'                       => '<strong>Visto não ter sessão iniciada, ou o estatuto da sua conta como membro não o permitir, só vai conseguir subscrever na lista de fóruns públicos exibida abaixo. Por favor, <a href="%s" class="postlink">Inicie Sessão</a> ou <a href="%s" class="postlink">Registe-se</a> caso pretenda subscrever igualmente a fóruns de natureza não-pública, ou aceder a funcionalidades restritas, reservadas exclusivamente a membros devidamente registados.</strong>',
	'SMARTFEED_POSTS_TYPE_ANY'                      => 'Todas as mensagens',
	'SMARTFEED_POSTS_TYPE_FIRST'                    => 'Apenas primeira mensagem dos tópicos',
	'SMARTFEED_POSTS_TYPE_LAST'                     => 'Apenas última mensagem dos tópicos',
	'SMARTFEED_POWERED_BY'                          => 'phpbbservices.com',
	'SMARTFEED_PRIVATE_MESSAGES_IN_FEED'            => 'Adicionar as minhas mensagens privadas não-lidas',
	'SMARTFEED_REMOVE_YOURS'                        => 'Remover as minhas mensagens',
	'SMARTFEED_RSS_10'                              => 'RSS 1.0 (RDF)',
	'SMARTFEED_RSS_20'                              => 'RSS 2.0',
	'SMARTFEED_SELECT_FORUMS'                       => 'Incluir mensagens pertencentes a estes fóruns',
	'SMARTFEED_SELECT_FORUMS_EXPLAIN'               => 'Nomes de fóruns assinalados a negrito, caso haja algum, são os fóruns que o administrador impõe que devem ser obrigatoriamente mostrados em qualquer feed de notícias. Não pode retirar a seleção destes fóruns. Fóruns acompanhados de texto traçado, não são permitidos em feeds de notícias e tão-pouco podem ser selecionados. Em caso de ter sessão devidamente iniciada, toda a seleção a fóruns é desativada, caso selecione ter apenas acesso a exibir tópicos assinalados como favoritos.',
	'SMARTFEED_SINCE_LAST_VISIT_TEXT'               => 'Desde a Minha Última Visita',
	'SMARTFEED_SORT_BY'                             => 'Ordenar mensagens por',
	'SMARTFEED_SORT_BY_EXPLAIN'                     => 'A forma de ordenar por defeito, é a que vigora nas definições do phpBB; isto se não a alterar através do Painel de Controlo do Utilizador (PCU). Como padrão normal as mensagens aparecem no feed ordenadas por categoria (na ascendente), em seguida a ordenação do próprio fórum dentro das categorias correspondentes (na ascendente) , seguido do último post colocado do tópico contido no fórum (na descendente), e para terminar surge ainda a opção tempo da mensagem (na ascendente) contida no tópico correspondente.',
	'SMARTFEED_SORT_FORUM_TOPIC'                    => 'Ordem padrão',
	'SMARTFEED_SORT_FORUM_TOPIC_DESC'               => 'Ordem padrão, contendo as últimas mensagens dispostas em primeiro lugar',
	'SMARTFEED_SORT_POST_DATE'                      => 'Do mais antigo ao mais recente',
	'SMARTFEED_SORT_POST_DATE_DESC'                 => 'Do mais recente ao mais antigo',
	'SMARTFEED_SORT_USER_ORDER'                     => 'Utilizar as preferências de exibição da conta contidas neste fórum',
	'SMARTFEED_STYLE_BASIC'                         => 'Básico',
	'SMARTFEED_STYLE_BASIC_EXPLAIN'                 => 'O nível Básico vai retirar-lhe qualquer formatação assim como os atributos de BBCode; não obstante, se permitir, irá exibir as linhas de assinatura.',
	'SMARTFEED_STYLE_COMPACT'                       => 'Compacto',
	'SMARTFEED_STYLE_COMPACT_EXPLAIN'               => 'No caso do compacto, além de retirar qualquer formatação, irá remover todo o BBCode, suprimir por completo assinaturas e de igual forma retira também os parágrafos.',
	'SMARTFEED_STYLE_HTML'                          => 'HTML',
	'SMARTFEED_STYLE_HTML_EXPLAIN'                  => 'O HTML garante uma exibição cheia de formatações, não esconde o BBCode bem como assinaturas e exibe de igual modo como estas se encontram ilustradas e configuradas no fórum, caso tal esteja a ser permitido. Resumindo, as suas mensagens vão estar no seu leitor de forma semelhante às que vê dentro do fórum. Este feed em específico do tipo HTML, não suporta validação.',
	'SMARTFEED_STYLE_HTML_SAFE'                     => '<a href="http://validator.w3.org/feed/docs/warning/SecurityRiskAttr.html" class="postlink" onclick="window.open(this.href);return false;">Safe HTML</a>',
	'SMARTFEED_STYLE_HTML_SAFE_EXPLAIN'             => 'As Safe HTML (HTML Seguro) vão reter atributos considerados não-seguros para a generalidade dos leitores de notícias, de acordo com o padrão exigido pelas regras W3C.',
	'SMARTFEED_SUPPRESS_FORUM_NAMES'                => 'Suprimir/Ocultar os Nomes dos Fóruns',
	'SMARTFEED_SUPPRESS_FORUM_NAMES_EXPLAIN'        => 'Apenas o nome do fórum a constar no próprio título de item; e o que garante ter consigo um título ainda mais resumido.',
	'SMARTFEED_SUPPRESS_USERNAMES'                  => 'Suprimir os Nomes de Utilizador',
	'SMARTFEED_SUPPRESS_USERNAMES_EXPLAIN'          => 'O Feed não irá de forma alguma mostrar o nome de quem colocou o artigo que se encontra a ver no próprio título do mesmo. Para garantir títulos de artigos muito mais apelativos ou vistosos no seu ecrã, esta será sem margem para dúvidas uma das melhores opções a reter em conta e de imenso prestígio.',
	'SMARTFEED_TITLE'                               => 'Smartfeed',
	'SMARTFEED_TOPIC_TITLES'                        => 'Apenas os Títulos referentes ao Tópico em questão',
	'SMARTFEED_TOPIC_TITLES_EXPLAIN'                => 'O feed mostra o nome do tópico em vez do assunto principal. Isto evita as repetentes letras ex.: "Re: ou Resp:" de estarem permanentemente a surgir em frente e a preceder os nomes que aparecem na janela dos mesmos.',
	'SMARTFEED_URL'                                 => 'Gerar o feed e visualizá-lo de seguida',
	'SMARTFEED_USE_BOOKMARKS'                       => 'Apenas tópicos adicionados aos Favoritos',
	'SMARTFEED_VALID_ATOM_1'                        => 'O Smartfeed gera feeds válidos via sistema padrão ATOM 1.0, o qual se encontra testado sob o serviço de normas W3C de forma a garantir a segurança pela: W3C Markup Validation Service (https://validator.w3.org).',
	'SMARTFEED_VALID_RSS_1'                         => 'O Smartfeed gera feeds válidos via sistema padrão RSS 1.0, o qual se encontra testado sob o serviço de normas W3C de forma a garantir a segurança pela: W3C Markup Validation Service (https://validator.w3.org).',
	'SMARTFEED_VALID_RSS_2'                         => 'O Smartfeed gera feeds válidos via sistema padrão RSS 2.0, o qual se encontra testado sob o serviço de normas W3C de forma a garantir a segurança pela: W3C Markup Validation Service (https://validator.w3.org).',
	'SMARTFEED_VIEW_FEED'                           => 'Visualizar o seu feed',
	'SMARTFEED_VIEW_FEED_BUTTON'                    => 'Ver o feed',
	'SMARTFEED_VIEW_FEED_BUTTON_EXPLAIN'            => 'Garante-lhe poder de forma rápida observar o código gerado em código-fonte de feed dentro de uma única janela para o seu ecrã.',
]);
