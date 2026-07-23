<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
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
	'UCP_PRIVACY' => 'Privacidade',

	'UCP_REVIEW'          => 'Rever dados pessoais',
	'UCP_REVIEW_EXPLAIN'  => 'Abaixo irás encontrar e consultar detalhes dos teus dados pessoais que o nosso site preserva e armazena. Não te esqueças e não deixes de verificar ou rever as abas e o menu do teu perfil aqui mesmo para consultar que outras informações pessoais estão preenchidas e visíveis.',
	'REG_DATE'            => 'Data de registo da tua conta e as horas',
	'COOKIE_CHANGED_MIND' => 'Mudaste de ideias? <a href="%s">Aceita os Cookies</a>.',
	'REG_IP'              => 'Registo de IP\'s',
	'USER_IPS'            => 'Endereços de IP (IP addresses) que utilizaste ao longo do tempo',

	'UCP_DOWNLOAD'           => 'Transferir/Descarregar dados',
	'UCP_DOWNLOAD_EXPLAIN'   => 'Abaixo poderás efectuar a transferência e descarregar todos os teus dados e respetivas publicações que o fórum preserva e armazena sobre ti. Será providenciado e transferido um ficheiro comprimido em formato ZIP contendo os diretórios das tuas <samp>posts/</samp> que contará por sua vez com subdiretórios bem e devidamente estruturados da seguinte forma: o primeiro diretório base é correspondente ao do ID do Fórum, dentro existirão outros subdiretórios com o nome do ID dos respetivos Tópicos desse mesmo fórum. E finalmente o último elemento, a chave mestre para a caixa forte do cofre, constarão lá ficheiros HTML com um número longo, UNIX timestamp, equivalente às horas de quando efectuaste e criaste a dita publicação no fórum em questão. No caso de não ser o suficiente e optares por transferir toda a tua informação/dados na totalidade, será ainda providenciado e incluído em anexo à parte um novo ficheiro chamado e conhecido como <samp>personal.txt</samp> onde poderás encontrar toda a tua informação confidencial/pessoal que guardamos sobre a tua identidade.',
	'UCP_DOWNLOAD_BTN_POSTS' => 'Transferir/Descarregar as Publicações',
	'UCP_DOWNLOAD_BTN_DATA'  => 'Transferir/Descarregar todos os teus Dados Pessoais',
	'UCP_USER_NO_POSTS'      => 'Ainda não tens qualquer publicação que permita ser transferida.',

	'UCP_DELETE'             => 'Eliminar conta',
	'CANNOT_DELETE_ACCOUNT'  => 'Sendo Administrador Fundador do fórum não te é permitido nem te encontras autorizado a eliminar contas do respetivo grupo e/ou remover os teus próprios dados de forma automatizada.',
	'DELETE_MY_ACCOUNT_TEXT' => 'Podes usar este formulário de modo a prosseguir com a eliminação da tua própria conta de utilizador. Fica plenamente consciente que, uma vez efectuado, toda a tua informação restrita assim como os dados pessoais serão permanentemente e irreversivelmente eliminados e removidos do site. Para não falar do óbvio em que não conseguirás nunca mais efectuar uma ligação (login) para te conectares de novo no site com estas mesmas credenciais.',
	'REALY_DELETE'           => 'Eu pretendo verdadeiramente e genuinamente eliminar de vez a minha conta.',
	'UNDERSTAND_DELETE'      => 'Eu entendo os riscos e aceito plenamente não me arrepender, uma vez que estas acções não possuem retorno.',
	'DELETE_MY_POSTS'        => 'Elimina e remove adicionalmente todas as minhas publicações (as publicações passarão a estar em nome de utilizadores tipo visitantes através de um nome aleatório e anónimo no caso deste ponto não ser assinalado e deixado em branco).',
	'ENTER_PASSWORD'         => 'Insere a tua palavra-passe',
	'ENTER_PASSWORD_EXPLAIN' => 'É fundamental a inserção da tua palavra-passe atual e não das anteriores de modo a salvaguardar e legitimar todo este teu pedido e/ou intenção de exclusão.',
	'ENTER_PASSWORD_HERE'    => 'escreve e insere aqui a tua palavra-passe ...',
	'DELETE_FINAL'           => 'Confirmação Final',
	'DELETE_FINAL_CONFIRM'   => '<p>Queremos agradecer-te muito por todo o apoio e também o tempo que dispuseste connosco. Vemo-nos num breve reencontro por aí...</p><p>O teu pedido de encerramento, assim como a eliminação da respetiva conta, foi validado com sucesso. Esta serve como a última Confirmação Final e uma vez mais serve de alerta para algo que não possui um botão de voltar para trás. Tens mesmo a absoluta e inquestionável certeza de que queres permanentemente apagar e eliminar em definitivo os teus dados e conta?</p>',

	'FOUNDER_ERROR'    => 'Os Administradores Fundadores não podem aceder a este mecanismo de exclusão/eliminação automatizado pelo utilizador por motivos compreensíveis de segurança.',
	'REALLY_ERROR'     => 'Tens e terás a estrita obrigação de seres tu próprio a confirmar que é de tua vontade legítima proceder com a finalização e fecho de conta.',
	'UNDERSTAND_ERROR' => 'Apenas uma questão de princípio em que deves estar bem ciente, entender e aceitar plenamente que uma vez eliminado e apagado do sistema a tua conta/dados perdem-se para o infinito e jamais reaparecerão como o Super-Homem...',
	'PASSWORD_ERROR'   => 'A palavra-passe introduzida encontra-se desatualizada ou encontra-se errada.',
	'GOODBYE_ERROR'    => 'Adeus meu velho amigo(a), a tua conta já foi de saco e apagada.',

	'REQUEST_FOR_DELETION_SUBJECT'  => 'Pedido e Solicitação de Eliminação da Conta de Utilizador - GDPR (Regulamento Geral sobre a Proteção de Dados)',
	'REQUEST_FOR_DELETION_BODY'     => 'Eu pretendo, requeiro e solicito de livre e espontânea vontade e em plena consciência o direito que me assiste para prosseguirem ao fecho e exclusão imediata e para a eliminação na totalidade da minha atual conta.',
	'DELETE_REQUEST_REALLY'         => 'Confirmação Final',
	'DELETE_REQUEST_REALLY_CONFIRM' => '<p>Queremos agradecer-te muito por todo o apoio e também o tempo que dispuseste connosco. Vemo-nos num breve reencontro por aí...</p><p>O teu pedido de encerramento, assim como a eliminação da respetiva conta, foi validado com sucesso. Esta serve como a última Confirmação Final. Tens mesmo a absoluta e inquestionável certeza de que queres solicitar à nossa Equipa a remoção e eliminação permanente e em definitivo de toda e qualquer referência dos teus dados em relação à atual conta?</p>',
	'REQUEST_FOR_DELETION_SENT'     => 'O teu pedido procedeu e transitou já para os responsáveis, tendo sido remetido também uma cópia para os Administradores de modo a estarem ao corrente do teu caso. Eles tratarão de lidar da melhor forma possível em relação ao teu infortúnio com maior zelo e também o mais depressa e o quanto antes possível o for viável.',
]);
