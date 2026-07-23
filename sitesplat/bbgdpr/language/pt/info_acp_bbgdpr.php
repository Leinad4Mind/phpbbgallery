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
	'ACP_BBGDPR'         => 'BBgdpr',
	'ACP_BBGDPR_EXPLAIN' => 'Lembra-te de verificar a permissão de grupo que permite aos utilizadores eliminar as suas publicações quando eliminam as suas contas (está desativada por padrão e o nome de utilizador da conta eliminada será substituído por um nome de utilizador gerado aleatoriamente). <br/>Podes também rever as datas de aceitação dos utilizadores em ACP &#62; Utilizadores e Grupos: Gerir Utilizadores.<br /> Um registo das eliminações de utilizadores também é guardado em ACP &#62; Manutenção: registos de utilizador.',
	'GDPR'               => 'GDPR',
	'DELETED_USERS'      => 'Total de utilizadores que eliminaram a sua conta ao abrigo do GDPR: <strong>%d</strong>.<br />',

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBGDPR_NOTICE'  => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se no separador "EXTENSÕES".<br /> Existem também outras configurações em vários locais: <br />&#45;Permissão de grupo <br />&#45;ACP &#62; Utilizadores e Grupos: Gerir Utilizadores <br />&#45;ACP &#62; Manutenção: registos de utilizador<br />&#45; UCP &#62; Privacidade<br />Por fim, certifica-te de que revês desde já o modelo de privacidade para garantir que representa corretamente o teu fórum.</p></div>',

	'ACP_GDPR_SETTINGS_SAVED' => 'A configuração do GDPR foi guardada.',

	'PRIVACY_POLICY'         => 'Política de Privacidade',
	'PRIVACY_POLICY_EXPLAIN' => 'O conteúdo introduzido aqui será exibido a todos os utilizadores para que aceitem a tua política, conforme exigido pelo GDPR. Podes usar HTML.<br />Nota que, sempre que editares este formulário, a data de aceitação do GDPR será reiniciada e será exigida uma nova aceitação a todos os utilizadores. Isto facilita aos Administradores voltarem a impor a política do GDPR sempre que ocorra uma atualização.<br /> Certifica-te de que revês desde já a política padrão, pois destina-se a fóruns em geral e pode não ser adequada para o teu fórum.',

	'COOKIES_BANNER'                    => 'Banner de cookies UE',
	'TRACKING_CODES'                    => 'Códigos de rastreamento',
	'TRACKING_CODES_EXPLAIN'            => 'Cola aqui todos os códigos de rastreamento que utilizas para análise e/ou outros fins, sem a etiqueta <samp>&lt;script&gt;</samp> a envolvê-los, separados por uma linha em branco. Os códigos só serão executados para utilizadores que aceitarem os cookies gerados por esses serviços (por ex.: Google Analytics).',
	'SITESPLAT_BBGDPR_ADSENSE'          => 'Código AdSense',
	'SITESPLAT_BBGDPR_ADSENSE_EXPLAIN'  => 'Cola o teu código AdSense, que só será incluído quando o utilizador tiver aceite os cookies. (Consulta mais informações aqui: <a href="https://support.google.com/adsense/answer/9007336" target="_blank">Controlos de consentimento do utilizador da UE no AdSense</a> ) <br>Usa o seguinte código: <br><code>&#x3C;!-- IF S_GDPR_JS_ALLOWED --&#x3E;{{ GDPR_ADSENSE }}&#x3C;!-- ENDIF --&#x3E;</code> no teu tema premium, como os templates FLATBOOTS, para o exibir.<br> Se tiveres o Mini CMS instalado, também o podes modificar para usar o código deste modo, por exemplo: <br><code> &#x3C;!-- IF ADSENSE_FOOTER neq &#x27;&#x27; --&#x3E;&#x3C;!-- IF S_GDPR_JS_ALLOWED --&#x3E;&#x3C;div class=&#x22;clearfix text-center&#x22;&#x3E;{ADSENSE_FOOTER}&#x3C;/div&#x3E;&#x3C;!-- ENDIF --&#x3E;&#x3C;!-- ENDIF --&#x3E;</code>',
	'SITESPLAT_BBGDPR_GEOIP'            => 'Usar o serviço de localização GeoIP para identificar cidadãos da UE',
	'SITESPLAT_BBGDPR_GEOIP_EXPLAIN'    => 'Isto permitirá localizar os utilizadores pelo respetivo endereço IP, de forma a exibir o banner de cookies UE apenas a cidadãos da UE. Nota que este serviço de localização é impreciso e pode resultar numa deteção incorreta da localização do utilizador. Além disso, a consulta de IP é uma tarefa sensível à carga, o que pode abrandar o servidor.',

	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME'         => 'Manter o nome de utilizador ao eliminar a conta',
	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME_EXPLAIN' => 'Defina como Não (No) para gerar aleatoriamente um nome de utilizador anónimo que passará a substituir o anterior quando o utilizador pretender apagar e remover a sua conta.',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS'             => 'Forçar o ecrã com as novas Políticas GDPR (Regulamento Geral sobre a Proteção de Dados) apenas para utilizadores atuais já existentes',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS_EXPLAIN'     => 'Não faz qualquer sentido aos novos utilizadores este ecrã do GDPR pois os mesmos já o aceitarão aquando da criação do seu novo registo em concordância. Defina como Não (No) para forçar as políticas GDPR a TODOS os utilizadores em absoluto sem exceção para sua aceitação.',
	'SITESPLAT_BBGDPR_REQUEST_DELETE'               => 'Método de exclusão',
	'SITESPLAT_BBGDPR_REQUEST_DELETE_EXPLAIN'       => 'Defina para Solicitar (Request) um pedido sempre que um utilizador queira apagar/remover os seus dados ou conta, com isto os Administradores irão receber por MP tal notificação e tratarão do caso. Caso contrário se desativado e deixado para Pessoal (Self) os utilizadores estão aptos a poderem apagar pessoalmente e de imediato a sua conta/dados.',
	'REQUEST_DELETE'                                => 'Solicitar',
	'SELF_DELETE'                                   => 'Pessoal',

	'LOG_USER_REJECTED_PRIVACY' => '<strong>Rejeitou a nova política de privacidade.</strong><br>» Última data de aceitação: %s',
]);
