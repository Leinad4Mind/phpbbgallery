<?php

/**
 * @package BBdonations for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

/**
 * DO NOT CHANGE
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
	'ACP_DONATIONS'                  => 'BBDonations',
	'ACP_DONATIONS_EXPLAIN'          => 'Configurações de donativos para o teu site. Configura as opções desejadas, preenche os dados do PayPal e do Bitcoin para maximizares os resultados dos teus donativos.',
	'ACP_DONATIONS_INDEX_TITLE'      => 'Configuração',
	'ACP_DONATIONS_PAYPAL_EMAIL'     => 'Email do PayPal',
	'ACP_DONATIONS_PAYPAL_EXPLAIN'   => 'Introduz aqui o teu email do PayPal. (deixa em branco para desativar este método de donativo) Poderás precisar de usar uma conta empresarial do PayPal, já que o sistema IPN pode exigir isso para funcionar corretamente.<br /> Para mais informações visita: <a href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNSetup/#id089EG030E5Z">Configuração do PayPal IPN</a>',
	'ACP_DONATIONS_OPTIONS'          => 'Opções de donativo',
	'ACP_DONATIONS_OPTIONS_EXPLAIN'  => 'Estão disponíveis as seguintes opções: <br /> <strong>Modo Sandbox:</strong> Permite o modo sandbox (tanto para Bitcoin como para PayPal), útil para testar os donativos. Tem em atenção que o sandbox da Coinbase não é fiável, pelo que deves usar uma conta real para fazer testes. A forma mais fácil de testar é usar uma app de smartphone e fazer donativos entre o teu fórum e a app. Usa a seguinte app para telemóveis Android: <a href="https://airbitz.co/af/DJM" target="blank">AirBitz</a> <br /> <strong>Ativar mensagem:</strong> Permite ao utilizador deixar uma pequena mensagem com o donativo <br /> <strong>Mostrar doadores:</strong> Ativa a lista dos doadores mais recentes',
	'ACP_DONATIONS_SANDBOX'          => 'Modo sandbox',
	'ACP_DONATIONS_MESSAGE'          => 'Ativar mensagem',
	'ACP_DONATIONS_LIST'             => 'Mostrar doadores',
	'ACP_DONATIONS_BITCOIN'          => 'Bitcoin',
	'ACP_DONATIONS_BITCOIN_EXPLAIN'  => 'Introduz aqui a tua Chave de API e o Segredo de API da coinbase (deixa em branco para desativar este método de donativo). <br /> Segue <strong>EXATAMENTE</strong> (as ligações abrem numa nova aba) estes passos para ativares com sucesso os donativos em Bitcoin: <br /><strong>PASSO 1:</strong> <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">Regista uma conta Coinbase</a> <br /><strong>PASSO 2:</strong> <a href="https://www.coinbase.com/merchant_profiles" target="_blank">Configura o perfil da página de comerciante</a> <br /><strong>PASSO 3:</strong> <a href="https://www.coinbase.com/merchant_settings" target="_blank">Configura as definições de comerciante</a> <br /><strong>PASSO 4:</strong> Na opção de URL de notificação, em Definições de Comerciante (PASSO 3), introduz o URL do teu fórum assim:<br /> <code>http://www.my_board_url.com/app.php/donation/index.html?mode=notify_bitcoin</code> (onde "my_board_url.com" é o URL real do teu fórum) <br /><strong>PASSO 5:</strong> Regista a aplicação Oauth aqui: <a href="https://www.coinbase.com/settings/api" target="_blank">Oauth App</a>. Clica no botão "+ New API key", depois em "Accounts" assinala "My Wallet (Primary)", em "Permissions" clica em selecionar tudo e, por fim, em "Notifications" introduz o mesmo URL descrito no PASSO 4. Agora clica no botão "Create" e obtém a tua Chave de API e o Segredo de API para introduzires aqui à direita. <br /><strong>PASSO 6:</strong> Parabéns! Boa sorte com a tua campanha de donativos!',
	'ACP_DONATIONS_BITCOIN_KEY'      => 'Chave de API',
	'ACP_DONATIONS_BITCOIN_SECRET'   => 'Segredo de API',
	'ACP_DONATIONS_AMOUNTS'          => 'Montantes',
	'ACP_DONATIONS_TEXT'             => 'Texto',
	'ACP_DONATIONS_SYMBOL'           => 'Símbolo',
	'ACP_DONATIONS_ADD_ROW'          => 'Adicionar outra linha',
	'ACP_DONATIONS_DELL_ROW'         => 'Eliminar última linha',
	'ACP_DONATIONS_AMOUNTS_EXPLAIN'  => 'Estão disponíveis as seguintes opções: (Usa "%s" como espaço reservado para preencher automaticamente o montante e a moeda no teu campo de texto.) <br /><strong>Montante:</strong> Define o montante do donativo <br /><strong>Texto:</strong> Introduz o teu texto personalizado para o objetivo do montante de donativo <br /><strong>Símbolo:</strong> Seleciona um símbolo font awesome para cada objetivo introduzido.',
	'ACP_DONATIONS_STATUS'           => 'Estado',
	'ACP_DONATIONS_GROUP'            => 'Grupo Automático',
	'ACP_DONATIONS_GROUP_EXPLAIN'    => 'Estão disponíveis as seguintes opções para as definições do Grupo Automático: <br /><strong>Dias:</strong> tempo expresso em dias durante o qual o utilizador permanece no grupo X. (Sem tempo definido desativa o grupo de recurso para este grupo) <br /> <strong>Montante:</strong> valor mínimo de moeda (donativo) necessário para o Grupo Automático ser despoletado. (0 desativa o Grupo Automático) <br /><strong>Grupo:</strong> Grupo para o qual o utilizador é movido quando o montante mínimo é atingido <br /><strong>Grupo Padrão:</strong> Define o grupo como padrão para o utilizador (assinala para definir como padrão)',
	'ACP_DONATIONS_GROUP_DEF'        => 'Grupo padrão',
	'ACP_DONATIONS_GROUPS'           => 'Grupo',
	'ACP_DONATIONS_STATS'            => 'Estatísticas',
	'ACP_DONATIONS_TIME'             => 'Data',
	'ACP_DONATIONS_TOTAL'            => 'Soma de todos os donativos',
	'ACP_DONATIONS_ADDRESS'          => 'Endereço do doador',
	'ACP_DONATIONS_COUNTRY'          => 'País do doador',
	'ACP_DONATIONS_TRANSACTIONS'     => 'Transações',
	'ACP_DONATIONS_FALLBACK'         => 'Grupo de Recurso',
	'ACP_DONATIONS_FALLBACK_EXPLAIN' => 'Um grupo de recurso para o qual o utilizador regressa se o tempo (em Dias) for excedido.<br />Nenhum grupo desativa esta funcionalidade.',
	'ACP_DONATIONS_AMOUNT'           => 'Montante',

	'ACP_DONATIONS_DAY_STAY'      => 'Dias a permanecer neste grupo',
	'ACP_DONATIONS_CHANGE_STATUS' => 'Alterar estado',
	'ACP_DONATIONS_MAX_AMO'       => 'Montante máximo para este grupo',

	'ACP_DONATIONS_DAYS'             => 'Dias',
	'ACP_DONATIONS_TRANSACTION'      => 'ID da Transação',
	'ACP_DONATIONS_CURRENCY'         => 'Código de moeda',
	'ACP_DONATIONS_CURRENCY_EXPLAIN' => 'O código de moeda segue os padrões permitidos pelo <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">PayPal Multiple Currencies</a>. <br /> Certifica-te de que a moeda que vais usar está ativada na tua conta do PayPal. <br />Se a moeda não for suportada na tua conta do PayPal, as transações serão devolvidas como "Não verificadas" ou "Pendentes".',
	'ACP_DONATIONS_USERNAME'         => 'Nome de utilizador',
	'DONATIONS_NOTICE'               => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'                 => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',


	'SITESPLAT_COM'         => 'https://sitesplat.com',
	'SITESPLAT_COPY'        => '&#169; SiteSplat',
	'LICENSE_INFO'          => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'   => 'Programador',
	'ACP_NOTICE_CLOSE'      => 'Fechar',
	'ACP_DONATIONS_VERSION' => '1.0.10',
	'ACP_LOADING'           => 'A carregar... Aguarda',

	'EXT_BBD_DESCRIPTION_PAGE' => 'Uma extensão de donativos incrível para o teu fórum phpBB com temas sitesplat. Muitas opções modernas e úteis, incluindo PayPal IPN e API Bitcoin.',
	'EXT_BBD_TASKS_1'          => 'Grupo Automático',
	'EXT_BBD_TASKS_2'          => 'Objetivos de donativo totalmente editáveis',
	'EXT_BBD_TASKS_3'          => 'PayPal IPN',
	'EXT_BBD_TASKS_4'          => 'Suporte a Bitcoin',
	'EXT_BBD_TASKS_5'          => 'Pronto para o phpBB 3.2',
	'EXT_BBD_TASKS_6'          => 'Consulta os outros addons premium compatíveis em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',

]);

// Description of Donations extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral dos donativos',
			'DESCRIPTION_2' => 'API do Paypal / Bitcoins',
			'DESCRIPTION_3' => 'Grupos automáticos',
			'DESCRIPTION_4' => 'Regressa ao grupo padrão após x período de tempo',
			'DESCRIPTION_5' => 'Os visitantes também podem doar',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para o phpBB 3.2'
		]
	]
]);
