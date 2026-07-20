<?php

/**
 * @package phpBB Extension - Smartfeed for phpBB.
 * @copyright (c) 2020 Mark D. Hamill (mark@phpbbservices.com)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

global $phpbb_container;

$phpEx = $phpbb_container->getParameter('core.php_ext');

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_SMARTFEED'                                           => 'Smartfeed',
	'ACP_SMARTFEED_ADDITIONAL'                                => 'Configurações e opções adicionais',
	'ACP_SMARTFEED_ADDITIONAL_EXPLAIN'                        => 'Ajustar configurações e opções diversas do Smartfeed',
	'ACP_SMARTFEED_ALL_BY_DEFAULT'                            => 'Selecionar todos os fóruns por padrão',
	'ACP_SMARTFEED_ALL_BY_DEFAULT_EXPLAIN'                    => 'Se definido como Sim, quando a página de geração do URI do Smartfeed for exibida, todos os fóruns estarão marcados. Se tiver muitos fóruns, pode ser melhor definir isto como Não.',
	'ACP_SMARTFEED_APACHE_HTACCESS_ENABLED'                   => 'Apache .htaccess ativado para Smartfeed',
	'ACP_SMARTFEED_APACHE_HTACCESS_ENABLED_EXPLAIN'           => 'Se utilizar a autenticação do Apache, precisa primeiro de corrigir manualmente o arquivo .htaccess do seu fórum para permitir que o programa app.php/smartfeed/feed contorne a autenticação. Caso contrário, será impossível que o Smartfeed funcione, uma vez que a autenticação do Apache não o deixará passar. Se corrigiu o seu arquivo .htaccess, então pode definir isto como verdadeiro. Claro, se não utilizar autenticação do Apache, esta definição será ignorada.',
	'ACP_SMARTFEED_AUTO_ADVERTISE_PUBLIC_FEED'                => 'Anunciar os seus feeds públicos automaticamente',
	'ACP_SMARTFEED_AUTO_ADVERTISE_PUBLIC_FEED_EXPLAIN'        => 'Defina como verdadeiro se quiser expor o seu feed público automaticamente. Isto adiciona tags nos cabeçalhos HTML com URIs para feeds públicos predefinidos Atom e RSS.',
	'ACP_SMARTFEED_BREADCRUMB_AFTER'                          => 'Depois das ligações de navegação (breadcrumbs)',
	'ACP_SMARTFEED_BREADCRUMB_BEFORE'                         => 'Antes das ligações de navegação (breadcrumbs)',
	'ACP_SMARTFEED_DEFAULT_FETCH_TIME_LIMIT'                  => 'Intervalo de tempo máximo das mensagens',
	'ACP_SMARTFEED_DEFAULT_FETCH_TIME_LIMIT_EXPLAIN'          => 'Define um ponto no tempo em horas a partir de agora além do qual nenhuma mensagem pode ser obtida. Caso contrário, em fóruns com muito tráfego pode levar minutos ou horas para montar um feed de notícias, podendo afetar outros membros. O padrão é retroceder 30 dias (720 horas). <em>Cuidado</em>: se definir isto para zero, pode estar a dar permissão a todos os membros para criarem um feed com centenas ou milhares de mensagens.',
	'ACP_SMARTFEED_EXCLUDE_FORUMS'                            => 'Excluir sempre estes fóruns',
	'ACP_SMARTFEED_EXCLUDE_FORUMS_EXPLAIN'                    => 'Introduza os forum_ids dos fóruns que nunca devem aparecer em qualquer feed de notícias. Separe os forum_ids com vírgulas. Se deixado em branco, nenhum fórum será excluído. Para determinar os forum_ids, ao navegar num fórum, observe o parâmetro &ldquo;f&rdquo; no campo URI. Esse é o forum_id. Exemplo: http://www.exemplo.com/phpBB3/viewforum.php?f=1. Não utilize forum_ids que correspondam a categorias. As categorias não podem ser selecionadas com o phpBB Smartfeed. Note que, por padrão, o Smartfeed proíbe qualquer pessoa de ler fóruns para os quais não tenham privilégios de leitura.',
	'ACP_SMARTFEED_EXTERNAL_FEEDS'                            => 'Feeds externos',
	'ACP_SMARTFEED_EXTERNAL_FEEDS_EXPLAIN'                    => 'Introduza os URIs dos feeds externos que quer que apareçam no feed de notícias, colocando cada URI numa linha diferente. Os feeds externos aparecem na ordem em que foram introduzidos. Nota: onde aplicável, as regras de filtragem que se aplicam a mensagens também se aplicam a itens em feeds externos. Em particular, se a data de publicação do artigo não se enquadrar no intervalo de datas do feed (como sete dias) estes artigos não aparecerão. Não é possível guardar mais de 255 caracteres neste campo.',
	'ACP_SMARTFEED_EXTERNAL_FEEDS_TOP'                        => 'Itens do feed externo no topo do feed',
	'ACP_SMARTFEED_EXTERNAL_FEEDS_TOP_EXPLAIN'                => 'Se selecionar Não, os itens do feed externo ficarão no fundo do feed. As mensagens privadas, se houver, aparecerão sempre primeiro no feed.',
	'ACP_SMARTFEED_FEED_IMAGE_PATH'                           => 'Caminho e arquivo da imagem do feed',
	'ACP_SMARTFEED_FEED_IMAGE_PATH_EXPLAIN'                   => 'O caminho para a imagem que deseja que apareça no feed para marcar o seu feed. A imagem predefinida é site_logo.svg, que é o logotipo do phpBB (ou a imagem que o substituiu). A diretoria do estilo predefinido será usada, por isso defina-a para o caminho relativo a partir da diretoria de estilo predefinida do seu fórum. A marcação aparece apenas nos feeds RSS 1.0 e RSS 2.0. Se o logótipo for realmente mostrado depende das capacidades do leitor de notícias usado.',
	'ACP_SMARTFEED_HEADER_NAVIGATION_APPEND'                  => 'Depois do botão FAQ',
	'ACP_SMARTFEED_HEADER_NAVIGATION_PREPEND'                 => 'Depois do botão de links rápidos',
	'ACP_SMARTFEED_HOURS'                                     => 'horas',
	'ACP_SMARTFEED_INCLUDE_FORUMS'                            => 'Incluir sempre estes fóruns',
	'ACP_SMARTFEED_INCLUDE_FORUMS_EXPLAIN'                    => 'Introduza os forum_ids dos fóruns que têm de aparecer em qualquer feed de notícias. Separe os forum_ids com vírgulas. Se deixado em branco, nenhum fórum tem de ser incluído. Para determinar os forum_ids, ao navegar num fórum, observe o parâmetro &ldquo;f&rdquo; no campo URI. Esse é o forum_id. Exemplo: http://www.exemplo.com/phpBB3/viewforum.php?f=1. Não utilize forum_ids que correspondam a categorias. As categorias não podem ser selecionadas com o Smartfeed.',
	'ACP_SMARTFEED_MAX_ITEMS'                                 => 'Itens máximos permitidos em qualquer feed',
	'ACP_SMARTFEED_MAX_ITEMS_EXPLAIN'                         => 'Isto é usado para estabelecer um limite superior no número de itens permitidos num feed de notícias. Se for 0, não há limite. Para fóruns com muito tráfego, pode considerar ter de definir um limite para evitar que o fórum fique sobrecarregado.',
	'ACP_SMARTFEED_MAX_WORD_SIZE'                             => 'Palavras máximas para mostrar numa mensagem',
	'ACP_SMARTFEED_MAX_WORD_SIZE_EXPLAIN'                     => 'Nenhuma mensagem em qualquer feed pode exceder este número de palavras. Insira 0 para permitir um tamanho de palavra sem restrições para qualquer mensagem. O usuário tem sempre a opção de limitar o número de palavras numa mensagem para menos do que o limite do fórum. Aviso: Para garantir uma renderização consistente, se uma mensagem tiver de ser truncada, as marcações (tags) serão removidas da mensagem. <em>Nota:</em> itens em feeds externos não são afetados.',
	'ACP_SMARTFEED_MINUTES'                                   => 'minutos',
	'ACP_SMARTFEED_NEW_POST_NOTIFICATIONS_ONLY'               => 'Mostrar apenas notificações de novas mensagens e mensagens privadas no feed',
	'ACP_SMARTFEED_NEW_POST_NOTIFICATIONS_ONLY_EXPLAIN'       => 'Se o seu conteúdo for altamente sensível, pode querer habilitar esta funcionalidade. Se ativado, o feed não mostrará o conteúdo de nenhuma mensagem ou mensagens privadas, mas apresentará uma mensagem por cada tópico onde haja novas mensagens e uma notificação caso existam novas mensagens privadas. O usuário terá de se ligar ao fórum para ver as novas mensagens ou as mensagens privadas. Repare que esta é uma definição global, por isso afetará todas as categorias, fóruns e usuários bem como mensagens privadas. Nomes de autores e assuntos de mensagens ficarão escondidos, mas o nome do tópico é mostrado.',
	'ACP_SMARTFEED_PPT'                                       => 'Aceleradores primários de desempenho',
	'ACP_SMARTFEED_PPT_EXPLAIN'                               => 'Ajustar os grandes aceleradores de desempenho do Smartfeed',
	'ACP_SMARTFEED_PRIVACY_MODE'                              => 'Modo de privacidade',
	'ACP_SMARTFEED_PRIVACY_MODE_EXPLAIN'                      => 'Se Sim, os endereços de e-mail reais do autor da mensagem não serão exibidos no feed, sendo substituídos por um endereço de e-mail falso se necessário para validar o feed. Mesmo se estiver definido como Não, se o membro especificar nas preferências do fórum para não permitir que outros o contactem por e-mail, então um endereço de e-mail falso será substituído. Também neste modo, os blocos de assinaturas não serão exibidos aos membros públicos. A ideia é evitar que spammers tenham mais uma forma de recolher endereços de e-mail e maximizar a privacidade da informação dos seus membros.',
	'ACP_SMARTFEED_PUBLIC_ONLY'                               => 'Feed apenas público',
	'ACP_SMARTFEED_PUBLIC_ONLY_EXPLAIN'                       => 'Neste modo, apenas os fóruns públicos podem ser selecionados num feed. Portanto, características como exigir autenticação IP não se aplicarão e os usuários só podem selecionar a partir de uma lista de fóruns públicos.',
	'ACP_SMARTFEED_QUICK_LINKS_AFTER'                         => 'Depois do último link rápido',
	'ACP_SMARTFEED_QUICK_LINKS_BEFORE'                        => 'Antes do primeiro link rápido',
	'ACP_SMARTFEED_REQUIRE_IP_AUTHENTICATION'                 => 'Requer autenticação de IP',
	'ACP_SMARTFEED_REQUIRE_IP_AUTHENTICATION_EXPLAIN'         => 'A configuração para Sim aumenta a segurança de todos os membros registados limitando a amplitude de IP para a qual o Smartfeed devolve um feed. Deverá habilitar esta configuração se o seu fórum possuir informação sensível. Se deixar configurado para Não, cada membro registado pode decidir por si próprio se quer esta funcionalidade de segurança extra. Por favor note que a menos que o seu fórum utilize HTTPS ou seja acedido por via de uma VPN, o feed não será cifrado (encriptado).',
	'ACP_SMARTFEED_RFC1766_LANG'                              => 'Código de Linguagem RFC-1766',
	'ACP_SMARTFEED_RFC1766_LANG_EXPLAIN'                      => 'Idioma do conteúdo do seu feed. Isto é utilizado em feeds ATOM e RSS 2.0. <a href="http://www.w3.org/TR/REC-html40/struct/dirlang.html#langcodes" target="_blank">Lista de códigos válidos</a>.',
	'ACP_SMARTFEED_SECURITY'                                  => 'Configurações de segurança',
	'ACP_SMARTFEED_SECURITY_EXPLAIN'                          => 'Ajustar configurações de segurança do Smartfeed',
	'ACP_SMARTFEED_SHOW_SESSIONS'                             => 'Mostrar sessões do Smartfeed',
	'ACP_SMARTFEED_SHOW_SESSIONS_EXPLAIN'                     => 'Se Sim, a informação de Ver Quem Está Online será enganadora porque pessoas ou visitantes que estejam, de facto, a aceder a um feed irão surgir como online. Muitas sessões Smartfeed irão surgir como sessões de visitantes. A configuração como Sim também pode alterar o valor de maior número de usuários online de sempre.',
	'ACP_SMARTFEED_SHOW_USERNAME_IN_FIRST_TOPIC_POST'         => 'Mostrar o nome do membro na primeira mensagem do tópico',
	'ACP_SMARTFEED_SHOW_USERNAME_IN_FIRST_TOPIC_POST_EXPLAIN' => 'Configure para Sim se pretender que o nome do membro surja no título do item do primeiro tópico de uma mensagem. Pode configurar como Não se pretender desmembrar o seu próprio feed noutro sítio, por exemplo para mostrar uma lista de tópicos novos na página principal do seu sítio (site). Note que o valor de autor do item é sempre fornecido, mas nem todos os leitores de notícias irão exibi-lo.',
	'ACP_SMARTFEED_SHOW_USERNAME_IN_REPLIES'                  => 'Mostrar o nome do membro nas respostas',
	'ACP_SMARTFEED_SHOW_USERNAME_IN_REPLIES_EXPLAIN'          => 'Se configurar isto para Não, os nomes dos membros não vão aparecer nas respostas ao tópico. Isto pode ser uma medida imprudente dado que o leitor de notícias poderá escolher não exibir os autores de itens individuais no feed, o que iria dificultar os leitores de saberem quem colocou a resposta.',
	'ACP_SMARTFEED_SUPPRESS_FORUM_NAMES'                      => 'Ocultar os nomes dos fóruns',
	'ACP_SMARTFEED_SUPPRESS_FORUM_NAMES_EXPLAIN'              => 'Por padrão, o nome do fórum aparece no título do item. Contudo, os nomes dos fóruns podem ser muito compridos e quando unidos com o nome do tópico, o título do item pode ficar muito comprido. Para ocultar o nome do fórum do título do item para todos os membros, altere este valor para Sim.',
	'ACP_SMARTFEED_TITLE'                                     => 'Configurações Smartfeed',
	'ACP_SMARTFEED_TTL'                                       => 'Tempo de Vida do Feed de Notícias (TTL)',
	'ACP_SMARTFEED_TTL_EXPLAIN'                               => 'Quantos minutos deverá o leitor de notícias colocar o feed em cache antes de o atualizar? Puxe o valor para cima se o seu fórum estiver a ficar atolado, mas os leitores de notícias poderão ignorar o seu conselho. Note que isto é uma funcionalidade exclusiva do RSS 2.0.',
	'ACP_SMARTFEED_UI_INTERFACE_LOCATION'                     => 'Localização da interface de usuário do Smartfeed',
	'ACP_SMARTFEED_UI_INTERFACE_LOCATION_EXPLAIN'             => 'Pode escolher onde pretende que os usuários descubram a conexão para o Smartfeed. Pode selecionar de entre diversas localizações padrão na barra de navegação, no menu breadcrumbs ou no menu de ligações rápidas.',
	'ACP_SMARTFEED_WEBMASTER'                                 => 'Endereço E-Mail do Administrador do Web (Webmaster)',
	'ACP_SMARTFEED_WEBMASTER_EXPLAIN'                         => 'Caso deseje, forneça o endereço de email do Administrador Web do fórum phpBB ou daquele que trate de questões referentes a feeds. O endereço de email irá constar em feeds RSS 2.0. Por forma a providenciar máxima interoperabilidade, inclua o nome da pessoa associada ao endereço de email em parênteses, ex.: jjones@exemplo.com (John Jones).',

	'LOG_CONFIG_ADDITIONAL'        => '<strong>Atualizadas configurações e opções adicionais do Smartfeed</strong>',
	'LOG_CONFIG_PPT'               => '<strong>Atualizados aceleradores primários de desempenho do Smartfeed</strong>',
	'LOG_CONFIG_SECURITY'          => '<strong>Atualizadas configurações de segurança do Smartfeed</strong>',
	'LOG_CONFIG_SMARTFEED_EXTFEED' => '<strong>A solicitação Smartfeed do feed externo &ldquo;%s&rdquo; está incorreta ou não consegue ser processada como feed.</strong>',
]);
