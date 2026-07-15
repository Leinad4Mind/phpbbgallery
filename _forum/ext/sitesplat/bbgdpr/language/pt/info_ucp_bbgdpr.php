<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'UCP_PRIVACY'	=> 'Privacidade',

	'UCP_REVIEW'				=> 'Rever dados pessoais',
	'UCP_REVIEW_EXPLAIN'		=> 'Em baixo poderás encontrar todos os detalhes dos teus dados pessoais que guardámos. Não te esqueças de verificar a aba do perfil para veres outras informações pessoais.',
	'REG_DATE'					=> 'Data e hora de Registo',
	'COOKIE_CHANGED_MIND'		=> 'Mudaste de ideias? <a href="%s">Sim, quero aceitar as cookies</a>.',
	'REG_IP'					=> 'IP de Registo',
	'USER_IPS'					=> 'Endereços IP usados por ti',

	'UCP_DOWNLOAD'				=> 'Transferir dados',
	'UCP_DOWNLOAD_EXPLAIN'		=> 'Em baixo poderás transferir todos os dados que esta plataforma guarda sobre ti ou apenas as tuas mensagens. Irá ser-te enviado um .zip contendo uma pasta <samp>mensagens/</samp> com sub-pastas com a seguinte estrutura: a primeira pasta é o ID do fórum, dentro da mesma encontra-se sub-pastas com o ID do tópico. Dentro destas pastas encontram-se ficheiros HTML nomeados com o tempo em formato UNIX, tempo este que corresponde à data de criação da mensagem. Se escolheres transferir todos os teus dados, ser-te-á enviado outro ficheiro: <samp>personal.txt</samp> onde poderás encontrar todos os dados pessoais que guardámos sobre ti.',
    'UCP_DOWNLOAD_BTN_POSTS'	=> 'Transferir Mensagens',
	'UCP_DOWNLOAD_BTN_DATA'		=> 'Transferir Dados Pessoais',
	'UCP_USER_NO_POSTS'			=> 'Não tens quaisquer mensagens para puderes transferir.',
	
	'UCP_DELETE'				=> 'Remover conta',
	'CANNOT_DELETE_ACCOUNT'		=> 'Não podes remover a tua conta, porque és um fundador deste fórum.',
	'DELETE_MY_ACCOUNT_TEXT'	=> 'Poderás usar este formulário para remover a tua própria conta. Após o processo ser concluído todos os teus dados pessoais e privados serão removidos da nossa plataforma e nunca mais poderás voltar a usar esta mesma conta.',
	'REALY_DELETE'				=> 'Desejo mesmo remover a minha conta.',
	'UNDERSTAND_DELETE'			=> 'Estou ciente de que esta acção não possa ser desfeita.',
	'DELETE_MY_POSTS'			=> 'Desejo também que as minhas mensagens sejam removidas (as tuas mensagens passarão serão associadas a um nome falso aleatório, se desmarcado).',
	'ENTER_PASSWORD'			=> 'Introduz a tua senha',
	'ENTER_PASSWORD_EXPLAIN'	=> 'Esta senha é a mesma que usas para entrar no fórum.',
	'ENTER_PASSWORD_HERE'		=> 'escreve a senha aqui ...',
	'DELETE_FINAL'				=> 'Confirmação Definitiva',
	'DELETE_FINAL_CONFIRM'		=> '<p>Obrigado na mesma por teres feito parte desta comunidade. Ficamos tristes por te ver a ir embora.</p><p>O pedido de remoção da conta foi validado. Esta é a confirmação definitiva, e não haverá forma de voltar atrás. Tens a certeza que desejas remover permanentemente a tua conta?</p>',

	'FOUNDER_ERROR'				=> 'Fundadores não podem usar o processo de remoção própria.',
	'REALLY_ERROR'				=> 'Tens de confirmar que desejas realmente remover a tua conta.',
	'UNDERSTAND_ERROR'			=> 'Tens de confirmar que estás ciente que este processo não pode ser desfeito.',
	'PASSWORD_ERROR'			=> 'A senha introduzida não está correcta.',
	'GOODBYE_ERROR'				=> 'A tua conta foi removida.',

	'REQUEST_FOR_DELETION_SUBJECT'	=> 'Pedido de remoção de conta - RGPD',
	'REQUEST_FOR_DELETION_BODY'		=> 'Venho por este meio pedir que a minha conta seja removida.',
	'DELETE_REQUEST_REALLY'			=> 'Confirmação Definitiva',
	'DELETE_REQUEST_REALLY_CONFIRM'	=> '<p>Obrigado na mesma por teres feito parte desta comunidade. Ficamos tristes por te ver a ir embora.</p><p>O teu pedido de remoção de conta foi validado. Esta é a confirmação definitiva, e não haverá forma de voltar atrás. Tens a certeza que desejas que os Administradores desta comunidade removam permanentemente a tua conta?</p>',
	'REQUEST_FOR_DELETION_SENT'		=> 'O teu pedido foi enviado com sucesso aos Administradores. Será resolvido assim que possível.',
));
