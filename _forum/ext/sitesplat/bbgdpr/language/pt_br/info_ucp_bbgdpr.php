<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'UCP_REVIEW_EXPLAIN'  => 'Abaixo irá encontrar e consultar detalhes dos seus dados pessoais que o nosso site preserva e armazena. Não se esqueça e não deixe de verificar ou rever as abas e o menu do seu perfil aqui mesmo para consultar que outras informações pessoais estão preenchidas e visíveis.',
	'REG_DATE'            => 'Data de registro da sua conta e as horas',
	'COOKIE_CHANGED_MIND' => 'Mudou de ideias? <a href="%s">Aceite os Cookies</a>.',
	'REG_IP'              => 'Registro de IP\'s',
	'USER_IPS'            => 'Endereços de IP (IP addresses) que utilizou ao longo do tempo',

	'UCP_DOWNLOAD'           => 'Transferir/Baixar dados',
	'UCP_DOWNLOAD_EXPLAIN'   => 'Abaixo poderá efetuar a transferência e baixar todos os seus dados e respetivas publicações que o fórum preserva e armazena sobre o seu usuário. Será providenciado e transferido um arquivo comprimido em formato ZIP contendo os diretórios das suas <samp>posts/</samp> que contará por sua vez com subdiretórios bem e devidamente estruturados da seguinte forma: o primeiro diretório base é correspondente ao do ID do Fórum, dentro existirão outros subdiretórios com o nome do ID dos respetivos Tópicos desse mesmo fórum. E finalmente o último elemento, a chave mestre para a caixa forte do cofre, constarão lá arquivos HTML com um número longo, UNIX timestamp, equivalente às horas de quando efetuou e criou a dita publicação no fórum em questão. No caso de não ser o suficiente e optar por transferir toda a sua informação/dados na totalidade, será ainda providenciado e incluído em anexo à parte um novo arquivo chamado e conhecido como <samp>personal.txt</samp> onde poderá encontrar toda a sua informação confidencial/pessoal que guardamos sobre a sua identidade.',
	'UCP_DOWNLOAD_BTN_POSTS' => 'Transferir/Baixar as Publicações',
	'UCP_DOWNLOAD_BTN_DATA'  => 'Transferir/Baixar todos os seus Dados Pessoais',
	'UCP_USER_NO_POSTS'      => 'Não possui ainda qualquer publicação que permita ser transferida.',

	'UCP_DELETE'             => 'Excluir conta',
	'CANNOT_DELETE_ACCOUNT'  => 'Sendo Administrador Fundador do fórum não lhe é permitido nem encontra-se autorizado a excluir contas do respetivo grupo e/ou remover os seus próprios dados de forma automatizada.',
	'DELETE_MY_ACCOUNT_TEXT' => 'Pode usar este formulário de modo a prosseguir com a exclusão da sua própria conta de usuário. Fique plenamente consciente que, uma vez efetuado, toda a sua informação restrita assim como os dados pessoais serão permanentemente e irreversivelmente excluídos e removidos do site. Para não falar do óbvio em que não conseguirá nunca mais efetuar uma conexão (login) para se conectar de novo no site com estas mesmas credenciais.',
	'REALY_DELETE'           => 'Eu pretendo verdadeiramente e genuinamente excluir de vez a minha conta.',
	'UNDERSTAND_DELETE'      => 'Eu entendo os riscos e aceito plenamente não me arrepender, uma vez que estas ações não possuem retorno.',
	'DELETE_MY_POSTS'        => 'Elimine e remova adicionalmente todas as minhas publicações (as publicações passarão a estar em nome de usuários tipo visitantes através de um nome aleatório e anônimo no caso deste ponto não ser assinalado e deixado em branco).',
	'ENTER_PASSWORD'         => 'Insira a sua senha',
	'ENTER_PASSWORD_EXPLAIN' => 'É fundamental a inserção da sua senha atual e não das anteriores de modo a salvaguardar e legitimar todo este seu pedido e/ou intenção de exclusão.',
	'ENTER_PASSWORD_HERE'    => 'escreva e insira aqui a sua senha ...',
	'DELETE_FINAL'           => 'Confirmação Final',
	'DELETE_FINAL_CONFIRM'   => '<p>Queremos agradecer-lhe muito por todo o apoio e também o tempo que dispôs connosco. Vemo-nos num breve reencontro por aí...</p><p>O seu pedido de encerramento, assim como a exclusão da respetiva conta, foi validado com sucesso. Esta serve como a última Confirmação Final e uma vez mais serve de alerta para algo que não possuí um botão de voltar para trás. Tem mesmo a absoluta e inquestionável certeza de que quer permanentemente apagar e excluir em definitivo os seus dados e conta?</p>',

	'FOUNDER_ERROR'    => 'Os Administradores Fundadores não podem aceder a este mecanismo de exclusão/exclusão automatizado pelo usuário por motivos compreensíveis de segurança.',
	'REALLY_ERROR'     => 'Tem e terá a estrita obrigação de ser você próprio a confirmar que é de sua vontade legitima proceder com a finalização e fecho de conta.',
	'UNDERSTAND_ERROR' => 'Apenas uma questão de princípio em que deve estar bem ciente, entender e aceitar plenamente que uma vez excluído e apagado do sistema a sua conta/dados perdem-se para o infinito e jamais reaparecerão como o Super-Homem...',
	'PASSWORD_ERROR'   => 'A senha introduzida encontra-se desatualizada ou encontra-se errada.',
	'GOODBYE_ERROR'    => 'Adeus meu velho amigo(a), a sua conta já foi de saco e apagada.',

	'REQUEST_FOR_DELETION_SUBJECT'  => 'Pedido e Solicitação de Exclusão da Conta de Usuário - GDPR (Regulamento Geral sobre a Proteção de Dados)',
	'REQUEST_FOR_DELETION_BODY'     => 'Eu pretendo, requeiro e solicito de livre e espontânea vontade e em plena consciência o direito que me assiste para prosseguirem ao fecho e exclusão imediata e para a exclusão na totalidade da minha atual conta.',
	'DELETE_REQUEST_REALLY'         => 'Confirmação Final',
	'DELETE_REQUEST_REALLY_CONFIRM' => '<p>Queremos agradecer-lhe muito por todo o apoio e também o tempo que dispôs connosco. Vemo-nos num breve reencontro por aí...</p><p>O seu pedido de encerramento, assim como a exclusão da respetiva conta, foi validado com sucesso. Esta serve como a última Confirmação Final. Tem mesmo a absoluta e inquestionável certeza de que quer solicitar à nossa Equipa a remoção e exclusão permanente e em definitivo de toda e qualquer referência dos seus dados em relação à atual conta?</p>',
	'REQUEST_FOR_DELETION_SENT'     => 'O seu pedido procedeu e transitou já para os responsáveis, tendo sito remetido também uma cópia para os Administradores de modo a estarem ao corrente do seu caso. Eles tratarão de lidar da melhor forma possível em relação ao seu infortúnio com maior zelo e também o mais depressa e o quanto antes possível o for viável.',
]);
