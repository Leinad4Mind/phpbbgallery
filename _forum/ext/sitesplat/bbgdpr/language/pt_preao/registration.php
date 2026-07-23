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
	'BULK_EMAILS'         => 'E-mails/Correio Eletrónico',
	'BULK_EMAILS_EXPLAIN' => 'Ao assinalares e deixares este visto activado, expressas o teu total e absoluto consentimento perante a autorização concedida em que os Administradores se encontram desde logo dotados do poder de te poderem enviar livremente informações por email, seja por envios globais para todos os membros ou para ti individualmente. A tua aceitação expressa e inequívoca é requerida com carácter urgente e de forma obrigatória de modo a que te seja possibilitado dar continuidade à criação do teu novo registo. Tais medidas visam garantir e suportar que todas as funções sejam garantidamente e estritamente funcionais, como a activação do teu perfil ou envio de lembretes, assim como possíveis violações de segurança que venham a ocorrer na tua conta.',

	'PRIVACY_POLICY'         => 'Política de Privacidade',
	'PRIVACY_POLICY_EXPLAIN' => 'Ao assinalares e deixares este visto activado, certificas-te e consentes estar de total e perfeito acordo com as Políticas de Privacidade aplicáveis bem como as suas normativas adjacentes, que são apresentadas na página sobre as condições e termos do fórum. Também poderás encontrar, com acesso rápido, a secção que detalha a Política de Privacidade logo após teres efectuado o registo e estares já ligado (logado) com a conta registada. A tua aprovação e aceitação de todas as cláusulas é-te expressamente imperativa de modo a que possas ser devidamente autorizado a prosseguir com o registo.',
	'REG_UNDRSTD'            => 'Eu Entendo Plenamente as Consequências e Aceito',

	'AGREEMENTS_REQUIRED' => 'A tua plena aceitação e concordância será um dos requisitos mínimos exigidos (Isso não é Spam)',

	'BULK_EMAILS_QUICK_AGREE'    => 'E-mails ou Correio Eletrónico das Notícias do Fórum',
	'PRIVACY_POLICY_QUICK_AGREE' => 'Adequação GDPR e Regulamentação do Fórum',

]);
