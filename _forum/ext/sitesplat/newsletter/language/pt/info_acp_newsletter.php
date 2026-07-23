<?php

/**
 * @package BBnewsletter for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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

$lang = array_merge($lang, [
	'ACP_NEWSLETTER'           => 'Newsletter',
	'ACP_NEWSLETTER_EXPLAIN'   => 'Configura a tua Newsletter; várias opções estão disponíveis abaixo. Certifica-te de que o teu servidor de email aceita todos os emails, caso contrário serão usadas as definições de email do phpBB para enviar os emails em pequenos lotes. <br />As novidades semanais e mensais do fórum ("Catch-up") são enviadas pela tarefa cron. Instala a <a href="https://github.com/ForumHulp/cronstatus" target="_blank">extensão Cronstatus</a> e seleciona "Executar cron sempre" nas opções para executar as novidades "Catch-up" com mais frequência (especialmente útil para fóruns pequenos). <br />Para emails em HTML, instala a <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">Extensão HTML emails</a>, que ativa as definições de HTML.<br />',
	'FORUMS_NEWS_FROM'         => 'Fórum de origem da newsletter',
	'FORUMS_FROM_EXPLAIN'      => 'Seleciona os fóruns a partir dos quais pretendes que os utilizadores recebam as novidades',
	'SEND_IMMEDIATELY'         => 'Enviar imediatamente',
	'SEND_IMMEDIATELY_EXPLAIN' => 'Tenta enviar os emails imediatamente. Isto depende dos parâmetros de configuração de email do servidor',
	'PERIOD'                   => 'Período do Resumo (ou Catch-up) por Email',
	'PERIOD_EXPLAIN'           => 'Isto irá enviar emails automáticos "Catch-up" aos utilizadores subscritos. O email será gerado com base nos novos tópicos do fórum, com o objetivo de despertar o interesse do utilizador na atividade recente do fórum. Edita os ficheiros de modelo newsletter_html.txt para a versão em HTML e newsletter_txt.txt para a versão em texto simples, em:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> Para aprenderes a enviar emails HTML com aspeto profissional, consulta os tutoriais em <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> ou clica na secção "Tutoriais" acima.',
	'WEEKLY'                   => 'Semanal',
	'MONTHLY'                  => 'Mensal',
	'NO_OVERVIEW'              => 'Nenhum',
	'PERIOD_SEND'              => 'Define o período para a newsletter automática',
	'SEND_TO_GROUP'            => 'Enviar para grupo',
	'SEND_TO_USERS'            => 'Enviar para utilizador(es)',
	'SEND_TO_USERS_EXPLAIN'    => 'Ao usares este campo, este sobrepõe-se à opção "Enviar para grupo" acima. Um utilizador por linha',
	'ALL_USERS'                => 'Todos os utilizadores',
	'NEW_USER'                 => 'Permitir novos utilizadores',
	'MAIL_LOW_PRIORITY'        => 'Baixa',
	'MAIL_NORMAL_PRIORITY'     => 'Normal',
	'MAIL_HIGH_PRIORITY'       => 'Alta',
	'MAIL_PRIORITY'            => 'Prioridade do email',
	'USE_HTML'                 => 'Usar emails em HTML',
	'COMPOSE_HTML'             => 'Enviar manualmente',
	'COMPOSE_HTML_EXPLAIN'     => 'Se selecionares "Enviar manualmente", o editor HTML fica disponível para enviares emails personalizados em formato HTML',
	'MASS_MESSAGE'             => 'Mensagem (Corpo da Newsletter)',
	'MASS_MESSAGE_EXPLAIN'     => 'A mensagem em HTML será removida se a Extensão HTML email não estiver ativa. Para usares o editor HTML, clica em "Ferramentas" e depois em "Código-fonte" e introduz o código HTML no editor',
	'FHHTML_EMAIL_NOT_ENABLED' => 'A extensão de email HTML não está ativa. Transfere-a a partir de https://github.com/ForumHulp/htmlemail',
	'FHHTML_EMAIL_DOWNLOAD'    => 'A Extensão de email HTML não está ativa. Transfere-a a partir de <a href="https://github.com/ForumHulp/htmlemail" target="blank">GitHub HTML Email Ext</a>',
	'LAST_SEND'                => '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Membros</span> subscritos, a última newsletter foi enviada em <strong class="text-info">%2$s</strong>',
	'LAST_SEND_LETTERS'        => 'Últimas newsletters',
	'LAST_SEND_EXPLAIN'        => '**Nota: os novos utilizadores registados são automaticamente subscritos. (Clica em "X Membros" acima para veres a lista de utilizadores)',
	'LAST_NEWSLETTERS_EXPLAIN' => '**Nota: o modelo visualizado nos emails individuais abaixo NÃO reflete 100% o email que foi efetivamente enviado. Isto deve-se às regras de reset de CSS obsoletas da folha de estilos do ACP do phpBB. Consulta a tua cópia do email ou o arquivo público para veres o email exato.<br /> Esta lista tem como único propósito manter um registo simples dos emails e utilizadores.<br />Guarda sempre uma cópia do email HTML composto antes de o enviares, caso queiras reutilizá-lo no futuro.',
	'NEWS_PAGE'                => 'Visível',
	'HIDE'                     => 'Ocultar',
	'SHOW'                     => 'Mostrar',
	'DELETE_MAIL_SUCCES'       => 'Newsletter eliminada',
	'ACP_NEWSOVERVIEW_SEND'    => 'Newsletter(s) enviada(s) com sucesso',
	'ACP_NEWSOVERVIEW_SAVED'   => 'Definições guardadas com sucesso',

	'SITESPLAT_COM'             => 'https://sitesplat.com',
	'SITESPLAT_COPY'            => '&#169; SiteSplat',
	'LICENSE_INFO'              => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'       => 'Desenvolvedor',
	'ACP_NOTICE_CLOSE'          => 'Fechar',
	'ACP_NEWS_VERSION'          => '1.0.5',
	'ACP_LOADING'               => 'A carregar... Aguarda',
	'FORUM_CONTENT'             => 'conteúdo do fórum',
	'EXT_NEWS_DESCRIPTION_PAGE' => 'Um sistema de newsletter com arquivo, opções semanais, mensais e muito mais para geres a tua própria newsletter em HTML como um profissional!',
	'EXT_NEWS_TASKS_1'          => 'Arquivo de Newsletters',
	'EXT_NEWS_TASKS_2'          => 'HTML completo ativado',
	'EXT_NEWS_TASKS_3'          => 'Sincronização com tarefas Cron e compatível com <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
	'EXT_NEWS_TASKS_4'          => 'Newsletter agendada',
	'EXT_NEWS_TASKS_5'          => 'Consulta os outros addons premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'EXT_NEWS_TASKS_6'          => 'Pronto para o phpBB 3.2',

	'NEWS_SUBSCRIBERS_INFO'  => 'Informação de subscritores e novidades',
	'NEWS_TRICKS_TITLE'      => 'Dicas e Truques',
	'ACP_NEWS_TRICK_EXPLAIN' => '<p>O teu ISP limita o número de emails que podes enviar por dia?</p>
									<p><strong>Claro que sim!</strong>
									</p>
									<p>Todos os servidores de email SMTP de saída são regidos pela política de email do fornecedor, que inclui limites de envio horários e/ou diários. Esta política determina, em última análise, quantos emails podes enviar por dia. Podes encontrar abaixo uma lista dos limites horários e diários da maioria dos principais ISPs, empresas de alojamento web e fornecedores de email gratuito.</p>
									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Limites de Envio de Email de ISPs, Alojamento Web e Fornecedores de Email Gratuito</a></strong>
									</p>
									<p>Se tentares enviar mais emails do que os limites horários ou diários do teu servidor de email, verás erros a serem devolvidos assim que a quota especificada for atingida, algo como:<em> </em>
									</p>
									<blockquote>
										<p><em>atingiste a tua quota diária de envio</em>…</p>
									</blockquote>
									<p>Se ultrapassares os <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">limites diários de envio SMTP</a> do teu fornecedor, normalmente terás de esperar 24 horas antes de poderes enviar mais emails através desse servidor.</p>
									<p>Mas quais são os limites horários ou diários de envio do <em>teu</em> servidor de email?</p>
									<ul>
										<li>O limite de envio do servidor Gmail é de aproximadamente 100-150 emails por dia quando ligado ao servidor a partir de um cliente de email remoto. Podes enviar 500 emails por dia através do servidor SMTP do Gmail quando estiveres ligado à interface web.</li>
										<li>O servidor Comcast limita os clientes residenciais a 1000 mensagens por dia. Os clientes Comcast Business podem enviar 24 000 emails por dia através do servidor SMTP de saída da Comcast.</li>
										<li>O servidor básico do GoDaddy limita os remetentes a apenas 250 emails de saída por dia, mas podes <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">enviar mais emails adicionando relays SMTP à tua conta GoDaddy</a>
										</li>
									</ul>
									<p>&nbsp;</p>
									<p>Então, o que fazer se precisares de enviar a tua newsletter mensal a 5000 subscritores entusiastas, mas o teu ISP tiver um limite diário de envio de 500 emails por dia?</p>
									<p><strong>O que podes fazer se o teu servidor de email tiver limites que não suportam o tamanho da tua lista de envio?</strong>
									</p>
									<p>Se o teu servidor SMTP de saída atual não suportar o tamanho da tua lista de email ou a frequência de envio, tens várias opções:</p>
									<p style="padding-left: 30px;">1. Contacta o alojamento do(s) teu(s) servidor(es) SMTP de saída e pergunta se têm uma conta empresarial que te permita enviar mais emails por dia.</p>
									<p style="padding-left: 30px;">2. Usa a <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">opção de Envio Direto</a> do GroupMail, que te permite contornar o teu servidor SMTP externo e enviar email diretamente do teu computador para os destinatários, usando o motor SMTP interno do próprio GroupMail.</p>
									<p style="padding-left: 30px;">3. Usa um serviço SMTP de saída como o <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> para retransmitir as tuas grandes campanhas de email.</p>
									<p style="padding-left: 30px;">4. Encontra uma empresa de alojamento web com limites diários de envio de email que satisfaçam as tuas necessidades.</p>
									<p style="padding-left: 30px;">5. Configura o teu próprio <a href="http://www.msexchange.org/tutorials/MF002.html">Servidor MS Exchange</a> para entrega de email por SMTP.</p>
									<p>Assim, embora o GroupMail te permita enviar e gerir listas de email de tamanho <strong>ilimitado</strong>, o sucesso da entrega de email a grandes grupos depende, em última análise, dos limites de envio definidos na política de email do servidor SMTP que estiveres a usar.</p>
									<p><strong>Artigos relacionados que poderão interessar-te:</strong>
									</p>
									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Limites de Envio de Email de ISPs, Alojamento Web e Fornecedores de Email Gratuito</a>
									</p>
									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Descrições e Soluções de Códigos de Erro de Email Comuns</a>
									</p>
									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Software e Serviços Gratuitos de Newsletter e Marketing por Email</a>
									</p>
									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Definições de Email para os Servidores de Email Mais Comuns</a>
									</p>
									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Guia Passo-a-Passo para Configuração e Entrega de Email</a>
									</p>
									<p>&nbsp;</p>
									<hr>
									<p></p>',

	'EXT_NEWS_TUTORIALS_TITLE'   => 'Tutoriais',
	'EXT_NEWS_TUTORIALS_EXPLAIN' => '<li><p>Modelos</p>
					<ul>
					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: Um ótimo <strong>ponto de partida</strong> para codificares emails.</li>
					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Construtor de modelos + modelos gratuitos para transferir</li>
					</ul>
					</li>

					<li><p>Tutoriais e Guias</p>

					<ul>
					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>Como Codificar Emails em HTML (Mailchimp)</strong></a>: Como funciona o email HTML, conceitos básicos, boas práticas, dicas e truques</li>
					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Desenhar e Construir Newsletters por Email Sem Perderes a Cabeça (nem a Alma)</strong></a>: informação de que precisas para planeares, desenhares e construíres uma newsletter em HTML que se apresente bem</li>
					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Guia de Marketing por Email (Mailchimp)</strong></a></li>
					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 Dicas de Email HTML que Gostava de Ter Sabido Mais Cedo</strong></a></li>
					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>O Guia Definitivo</a>: Da Campaign Monitor</strong></li>
					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Usar CSS em Emails HTML</strong></a>: Alguns "eu bem te avisei" e dicas sobre emails HTML e CSS.</li>
					</ul>
					</li>

					<li><p>Testes</p>

					<ul>
					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Testes gratuitos e pagos</li>
					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
					</ul>
					</li>

					<li><p>Outros Recursos</p>

					<ul>
					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Clientes de Email Populares da Campaign Monitor</strong></a></li>
					</ul>
					</li>',


	'NEWSLETTER_NOTICE' => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Nota que, na primeira configuração, quando o período é definido (por exemplo, semanal) e o formato (HTML), o primeiro resumo automático da newsletter é enviado imediatamente após as definições serem guardadas! <br />Isto é necessário para iniciar a Sincronização. Tendo isto em conta, considera usar um fórum de teste antes de usares a extensão, para te certificares de que o resultado final da newsletter tem o aspeto pretendido.</p></div>',
	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
]);

// Description of Donations extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Newsletter em HTML',
			'DESCRIPTION_2' => 'Seleção de grupos',
			'DESCRIPTION_3' => 'Resumo de novidades semanal / mensal',
			'DESCRIPTION_4' => 'Envio imediato ou em lote',
			'DESCRIPTION_5' => 'Resumo de subscritores',
		],
		'note' => [
			'NOTICE_1' => 'É necessária a <a href="https://github.com/ForumHulp/htmlemail" target="_blank">extensão de email HTML</a> para ativar as definições de HTML.',
			'NOTICE_2' => 'Pronto para o phpBB 3.2'
		]
	]
]);
