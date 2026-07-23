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
	'ACP_BBGDPR'         => 'BBgdpr',
	'ACP_BBGDPR_EXPLAIN' => 'Lembre-se de verificar a permissão de grupo que permite aos usuários excluir suas postagens quando excluem suas contas (está desativada por padrão e o nome de usuário da conta excluída será substituído por um nome de usuário gerado aleatoriamente). <br/>Você também pode revisar as datas de aceitação dos usuários em ACP &#62; Usuários e Grupos: Gerenciar Usuários.<br /> Um registro das exclusões de usuários também é salvo em ACP &#62; Manutenção: registros de usuário.',
	'GDPR'               => 'GDPR',
	'DELETED_USERS'      => 'Total de usuários que excluíram sua conta sob o GDPR: <strong>%d</strong>.<br />',

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBGDPR_NOTICE'  => '<div class="phpinfo"><p>As configurações para esta extensão estão na aba "EXTENSÕES".<br /> Também existem outras configurações em vários locais: <br />&#45;Permissão de grupo <br />&#45;ACP &#62; Usuários e Grupos: Gerenciar Usuários <br />&#45;ACP &#62; Manutenção: registros de usuário<br />&#45; UCP &#62; Privacidade<br />Por fim, certifique-se de revisar o modelo de privacidade imediatamente para garantir que ele representa corretamente o seu fórum.</p></div>',

	'ACP_GDPR_SETTINGS_SAVED' => 'A configuração do GDPR foi salva.',

	'PRIVACY_POLICY'         => 'Política de Privacidade',
	'PRIVACY_POLICY_EXPLAIN' => 'O conteúdo inserido aqui será exibido a todos os usuários para que aceitem sua política, conforme exigido pelo GDPR. Você pode usar HTML.<br />Observe que, sempre que você editar este formulário, a data de aceitação do GDPR será reiniciada e será exigida uma nova aceitação de todos os usuários. Isso facilita aos Administradores reforçarem a política do GDPR sempre que ocorrer uma atualização.<br /> Certifique-se de revisar imediatamente a política padrão, pois ela é voltada para fóruns em geral e pode não ser adequada para o seu fórum.',

	'COOKIES_BANNER'                    => 'Banner de cookies UE',
	'TRACKING_CODES'                    => 'Códigos de rastreamento',
	'TRACKING_CODES_EXPLAIN'            => 'Cole aqui todos os códigos de rastreamento que você usa para análise e/ou outros fins, sem a tag <samp>&lt;script&gt;</samp> envolvendo-os, separados por uma linha em branco. Os códigos só serão executados para usuários que aceitarem os cookies gerados por esses serviços (por ex.: Google Analytics).',
	'SITESPLAT_BBGDPR_ADSENSE'          => 'Código AdSense',
	'SITESPLAT_BBGDPR_ADSENSE_EXPLAIN'  => 'Cole seu código AdSense, que só será incluído quando o usuário tiver aceitado os cookies. (Veja mais informações aqui: <a href="https://support.google.com/adsense/answer/9007336" target="_blank">Controles de consentimento do usuário da UE no AdSense</a> ) <br>Use o seguinte código: <br><code>&#x3C;!-- IF S_GDPR_JS_ALLOWED --&#x3E;{{ GDPR_ADSENSE }}&#x3C;!-- ENDIF --&#x3E;</code> no seu tema premium, como os templates FLATBOOTS, para exibi-lo.<br> Se você tiver o Mini CMS instalado, também pode modificá-lo para usar o código assim, por exemplo: <br><code> &#x3C;!-- IF ADSENSE_FOOTER neq &#x27;&#x27; --&#x3E;&#x3C;!-- IF S_GDPR_JS_ALLOWED --&#x3E;&#x3C;div class=&#x22;clearfix text-center&#x22;&#x3E;{ADSENSE_FOOTER}&#x3C;/div&#x3E;&#x3C;!-- ENDIF --&#x3E;&#x3C;!-- ENDIF --&#x3E;</code>',
	'SITESPLAT_BBGDPR_GEOIP'            => 'Usar o serviço de localização GeoIP para identificar cidadãos da UE',
	'SITESPLAT_BBGDPR_GEOIP_EXPLAIN'    => 'Isso permitirá localizar os usuários pelo endereço IP deles, para exibir o banner de cookies UE apenas a cidadãos da UE. Observe que esse serviço de localização é impreciso e pode resultar em detecção incorreta da localização do usuário. Além disso, a consulta de IP é uma tarefa sensível à carga, o que pode deixar o servidor mais lento.',

	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME'         => 'Manter o nome de usuário ao excluir a conta',
	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME_EXPLAIN' => 'Defina como Não (No) para gerar aleatoriamente um nome de usuário anônimo que substituirá o anterior quando o usuário quiser apagar e remover sua conta.',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS'             => 'Forçar a tela com as novas Políticas GDPR (Regulamento Geral de Proteção de Dados) apenas para usuários atuais já existentes',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS_EXPLAIN'     => 'Não faz sentido exibir essa tela do GDPR para os novos usuários, pois eles já aceitarão ao criar o novo registro em concordância. Defina como Não (No) para forçar as políticas GDPR a TODOS os usuários sem exceção para sua aceitação.',
	'SITESPLAT_BBGDPR_REQUEST_DELETE'               => 'Método de exclusão',
	'SITESPLAT_BBGDPR_REQUEST_DELETE_EXPLAIN'       => 'Defina para Solicitar (Request) um pedido sempre que um usuário quiser apagar/remover seus dados ou conta; com isso, os Administradores receberão uma MP com essa notificação e cuidarão do caso. Caso contrário, se desativado e deixado como Pessoal (Self), os usuários poderão apagar pessoalmente e de imediato sua conta/dados.',
	'REQUEST_DELETE'                                => 'Solicitar',
	'SELF_DELETE'                                   => 'Pessoal',

	'LOG_USER_REJECTED_PRIVACY' => '<strong>Rejeitou a nova política de privacidade.</strong><br>» Última data de aceitação: %s',
]);
