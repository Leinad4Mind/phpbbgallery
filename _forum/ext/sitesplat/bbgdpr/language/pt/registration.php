<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
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
	'BULK_EMAILS'         => 'E-mails/Correio Eletrónico',
	'BULK_EMAILS_EXPLAIN' => 'Ao assinalar e deixar este visto ativado você expressa o seu total e absoluto consentimento perante a autorização concedida em que os Administradores encontram-se desde logo dotados do poder de lhe poderem enviar livremente informações por email, seja por envios globais para todos os membros ou para si individualmente. A aceitação expressa e inequívoca da sua parte são requeridas com carácter urgente e de forma obrigatória de modo a que lhe seja possibilitado dar continuidade na criação do seu novo registo. Tais medidas visam garantir e suportar para que todas as funções sejam garantidamente e estritamente funcionais como a ativação do seu perfil ou envio de lembretes assim como possíveis violações de segurança que venham a ocorrer na sua conta.',

	'PRIVACY_POLICY'         => 'Política de Privacidade',
	'PRIVACY_POLICY_EXPLAIN' => 'Ao assinalar e deixar este visto ativado você certifica-se e consente estar de total e perfeito acordo com as Políticas de Privacidade aplicáveis bem como as suas normativas adjacentes em que as mesmas são apresentadas na página sobre as condições e termos do fórum. Também poderá encontrar na sua posse com acesso rápido à secção que detalha a Privacidade da Política logo após ter efetuado e estar já ligado (logado) com a conta registada. A sua aprovação e aceitação de todas as cláusulas é-lhe expressamente imperativa de modo a que possa ser devidamente autorizado a prosseguir com o registo.',
	'REG_UNDRSTD'            => 'Eu Entendo Plenamente as Consequências e Aceito',

	'AGREEMENTS_REQUIRED' => 'A sua plena aceitação e concordância será um dos requisitos mínimos exigidos (Isso não é Spam)',

	'BULK_EMAILS_QUICK_AGREE'    => 'E-mails ou Correio Eletrónico das Notícias do Fórum',
	'PRIVACY_POLICY_QUICK_AGREE' => 'Adequação GDPR e Regulamentação do Fórum',

]);
