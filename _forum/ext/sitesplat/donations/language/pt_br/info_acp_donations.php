<?php

/**
 * @package BBdonations for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACP_DONATIONS_EXPLAIN'          => 'Configurações de doações para o seu site. Configure as opções desejadas, preencha os dados do PayPal e do Bitcoin para maximizar os resultados das suas doações.',
	'ACP_DONATIONS_INDEX_TITLE'      => 'Configuração',
	'ACP_DONATIONS_PAYPAL_EMAIL'     => 'Email do PayPal',
	'ACP_DONATIONS_PAYPAL_EXPLAIN'   => 'Digite aqui o seu email do PayPal. (deixe em branco para desativar este método de doação) Você pode precisar usar uma conta empresarial do PayPal, já que o sistema IPN pode exigir isso para funcionar corretamente.<br /> Para mais informações visite: <a href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNSetup/#id089EG030E5Z">Configuração do PayPal IPN</a>',
	'ACP_DONATIONS_OPTIONS'          => 'Opções de doação',
	'ACP_DONATIONS_OPTIONS_EXPLAIN'  => 'Estão disponíveis as seguintes opções: <br /> <strong>Modo Sandbox:</strong> Permite o modo sandbox (tanto para Bitcoin quanto para PayPal), útil para testar as doações. Observe que o sandbox da Coinbase não é confiável, então uma conta real deve ser usada para fazer testes. A forma mais fácil de testar é usar um aplicativo de smartphone e doar entre o seu fórum e o aplicativo. Use o seguinte aplicativo para telefones Android: <a href="https://airbitz.co/af/DJM" target="blank">AirBitz</a> <br /> <strong>Ativar mensagem:</strong> Permite que o usuário deixe uma pequena mensagem com a doação <br /> <strong>Mostrar doadores:</strong> Ativa a lista dos doadores mais recentes',
	'ACP_DONATIONS_SANDBOX'          => 'Modo sandbox',
	'ACP_DONATIONS_MESSAGE'          => 'Ativar mensagem',
	'ACP_DONATIONS_LIST'             => 'Mostrar doadores',
	'ACP_DONATIONS_BITCOIN'          => 'Bitcoin',
	'ACP_DONATIONS_BITCOIN_EXPLAIN'  => 'Digite aqui a sua Chave de API e o Segredo de API da coinbase (deixe em branco para desativar este método de doação). <br /> Siga <strong>EXATAMENTE</strong> (os links abrem em uma nova aba) estes passos para ativar com sucesso as doações em Bitcoin: <br /><strong>PASSO 1:</strong> <a href="https://www.coinbase.com/join/54c7b129d41344b592000006" target="_blank">Registre uma conta Coinbase</a> <br /><strong>PASSO 2:</strong> <a href="https://www.coinbase.com/merchant_profiles" target="_blank">Configure o perfil da página de comerciante</a> <br /><strong>PASSO 3:</strong> <a href="https://www.coinbase.com/merchant_settings" target="_blank">Configure as definições de comerciante</a> <br /><strong>PASSO 4:</strong> Na opção de URL de notificação, em Definições de Comerciante (PASSO 3), digite a URL do seu fórum assim:<br /> <code>http://www.my_board_url.com/app.php/donation/index.html?mode=notify_bitcoin</code> (onde "my_board_url.com" é a URL real do seu fórum) <br /><strong>PASSO 5:</strong> Registre o aplicativo Oauth aqui: <a href="https://www.coinbase.com/settings/api" target="_blank">Oauth App</a>. Clique no botão "+ New API key", depois em "Accounts" marque "My Wallet (Primary)", em "Permissions" clique em selecionar tudo e, por fim, em "Notifications" digite a mesma URL descrita no PASSO 4. Agora clique no botão "Create" e obtenha a sua Chave de API e o Segredo de API para digitar aqui à direita. <br /><strong>PASSO 6:</strong> Parabéns! Boa sorte com a sua campanha de doações!',
	'ACP_DONATIONS_BITCOIN_KEY'      => 'Chave de API',
	'ACP_DONATIONS_BITCOIN_SECRET'   => 'Segredo de API',
	'ACP_DONATIONS_AMOUNTS'          => 'Valores',
	'ACP_DONATIONS_TEXT'             => 'Texto',
	'ACP_DONATIONS_SYMBOL'           => 'Símbolo',
	'ACP_DONATIONS_ADD_ROW'          => 'Adicionar outra linha',
	'ACP_DONATIONS_DELL_ROW'         => 'Excluir última linha',
	'ACP_DONATIONS_AMOUNTS_EXPLAIN'  => 'Estão disponíveis as seguintes opções: (Use "%s" como espaço reservado para preencher automaticamente o valor e a moeda no seu campo de texto.) <br /><strong>Valor:</strong> Defina o valor da doação <br /><strong>Texto:</strong> Digite o seu texto personalizado para a meta de valor de doação <br /><strong>Símbolo:</strong> Selecione um símbolo font awesome para cada meta inserida.',
	'ACP_DONATIONS_STATUS'           => 'Status',
	'ACP_DONATIONS_GROUP'            => 'Grupo Automático',
	'ACP_DONATIONS_GROUP_EXPLAIN'    => 'Estão disponíveis as seguintes opções para as configurações do Grupo Automático: <br /><strong>Dias:</strong> tempo expresso em dias durante o qual o usuário permanece no grupo X. (Nenhum tempo desativa o grupo de reserva para este grupo) <br /> <strong>Valor:</strong> valor mínimo de moeda (doação) necessário para o Grupo Automático ser acionado. (0 desativa o Grupo Automático) <br /><strong>Grupo:</strong> Grupo para o qual o usuário é movido quando o valor mínimo é atingido <br /><strong>Grupo Padrão:</strong> Define o grupo como padrão para o usuário (marque para definir como padrão)',
	'ACP_DONATIONS_GROUP_DEF'        => 'Grupo padrão',
	'ACP_DONATIONS_GROUPS'           => 'Grupo',
	'ACP_DONATIONS_STATS'            => 'Estatísticas',
	'ACP_DONATIONS_TIME'             => 'Data',
	'ACP_DONATIONS_TOTAL'            => 'Soma de todas as doações',
	'ACP_DONATIONS_ADDRESS'          => 'Endereço do doador',
	'ACP_DONATIONS_COUNTRY'          => 'País do doador',
	'ACP_DONATIONS_TRANSACTIONS'     => 'Transações',
	'ACP_DONATIONS_FALLBACK'         => 'Grupo de Reserva',
	'ACP_DONATIONS_FALLBACK_EXPLAIN' => 'Um grupo de reserva para o qual o usuário retorna se o tempo (em Dias) for excedido.<br />Nenhum grupo desativa esta função.',
	'ACP_DONATIONS_AMOUNT'           => 'Valor',

	'ACP_DONATIONS_DAY_STAY'      => 'Dias para permanecer neste grupo',
	'ACP_DONATIONS_CHANGE_STATUS' => 'Alterar status',
	'ACP_DONATIONS_MAX_AMO'       => 'Valor máximo para este grupo',

	'ACP_DONATIONS_DAYS'             => 'Dias',
	'ACP_DONATIONS_TRANSACTION'      => 'ID da Transação',
	'ACP_DONATIONS_CURRENCY'         => 'Código de moeda',
	'ACP_DONATIONS_CURRENCY_EXPLAIN' => 'O código de moeda segue os padrões permitidos pelo <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_blank">PayPal Multiple Currencies</a>. <br /> Certifique-se de que a moeda que você vai usar está habilitada na sua conta do PayPal. <br />Se a moeda não for suportada na sua conta do PayPal, as transações serão retornadas como "Não verificadas" ou "Pendentes".',
	'ACP_DONATIONS_USERNAME'         => 'Nome de usuário',
	'DONATIONS_NOTICE'               => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'                 => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',


	'SITESPLAT_COM'         => 'https://sitesplat.com',
	'SITESPLAT_COPY'        => '&#169; SiteSplat',
	'LICENSE_INFO'          => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'   => 'Desenvolvedor',
	'ACP_NOTICE_CLOSE'      => 'Fechar',
	'ACP_DONATIONS_VERSION' => '1.0.10',
	'ACP_LOADING'           => 'Carregando... Aguarde',

	'EXT_BBD_DESCRIPTION_PAGE' => 'Uma extensão de doações incrível para o seu fórum phpBB com temas sitesplat. Muitas opções modernas e úteis, incluindo PayPal IPN e API Bitcoin.',
	'EXT_BBD_TASKS_1'          => 'Grupo Automático',
	'EXT_BBD_TASKS_2'          => 'Metas de doação totalmente editáveis',
	'EXT_BBD_TASKS_3'          => 'PayPal IPN',
	'EXT_BBD_TASKS_4'          => 'Suporte a Bitcoin',
	'EXT_BBD_TASKS_5'          => 'Pronto para o phpBB 3.2',
	'EXT_BBD_TASKS_6'          => 'Confira os outros addons premium compatíveis em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',

]);

// Description of Donations extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral das doações',
			'DESCRIPTION_2' => 'API do Paypal / Bitcoins',
			'DESCRIPTION_3' => 'Grupos automáticos',
			'DESCRIPTION_4' => 'Retorna ao grupo padrão após x período de tempo',
			'DESCRIPTION_5' => 'Os visitantes também podem doar',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para o phpBB 3.2'
		]
	]
]);
