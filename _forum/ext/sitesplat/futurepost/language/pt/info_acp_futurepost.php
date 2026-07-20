<?php

/**
 * BBpostdated
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'LOG_FUTURE_POST_APROVED' => '<strong>Publicação destinada do passado aprovada neste futuro</strong><br />&#187; %s',
	'FUTUREPOSTS_NOTICE'      => '<div style="width:80%;margin:20px auto;"><p>As configurações resultantes à aplicação desta extensão (indicador do calendário ou data "date picker") podem ser ativadas bem como se preverá ser da sua indicação com os respetivos encontros ao visualizarem-se as mesmas numa altura de preenchimento correspondente do editor de mensagens.<br />Apenas nunca se venha a esquecer e de antemão verificar, ajustar, aprovar ou conceder se for necessário e em conformidade as demais das devidas (Permissões de Atuação do Fórum). ACP &#187; Permissões &#187; Funções das permissões &#187; Funções de moderador &#187; Opte na edição do (Moderador Global) selecionando por detrás da Roda Dentada Verde &#187; Vá ao Separador na parte referente à categoria (Diversos): E Assinale SIM Na Opção em que indica [Pode Gerir Ou Publicar e/ou Moderar Mensagens Criadas Baseadas Ou Omitidas Do Passado Destinadas Ao Presente Ou Exibidas Depois Ao Público No Futuro (Can manage Future Posts)]</p></div>',
	'SS_HELPER_NOTY'          => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',

]);
