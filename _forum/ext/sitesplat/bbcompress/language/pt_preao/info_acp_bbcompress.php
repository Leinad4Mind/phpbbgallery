<?php

/**
 * BBcompress
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_BBCOMPRESS'       => 'BBcompress',
	'ACP_BBCOMPRESS_TITLE' => 'BBcompress',
	'ACP_SETTINGS'         => 'Configurações',

	'SS_HELPER_NOTY'      => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBCOMPRESS_NOTICE'   => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se no separador <strong>Extensões</strong>.</p></div>',
	'ACP_BBCOMPRESS_NOTE' => 'Tenha em atenção que os valores script timeout (tempo limite do script) e max_upload_file_size poderão precisar de ser aumentados. Estes podem, por vezes, ser alterados através de um .htaccess, mas nem sempre funciona. Isto é frequentemente feito via php.ini na configuração do seu servidor. Se tiver erros de tempo limite (timeout), peça ao seu serviço de alojamento para aumentar o tempo limite (timeout) do script, bem como o max_upload_file_size.',

	'ACP_BBCOMPRESS_SETTINGS_EXPLAIN' => 'Aqui pode definir todas as configurações da BBcompress. Selecione se deseja otimizar imagens nas publicações, MPs e/ou avatares. Escolha da lista de drivers fornecida a definição de compressão pretendida. Cada driver devolve resultados diferentes e/ou tem opções e restrições adicionais. <br /><br /><strong>A BBcompress já otimizou e poupou-lhe: <span class="badge badge-success">%s</span></strong>',

	'ACP_OPTIMIZER_GENERAL_OPTIONS'          => 'Configurações gerais',
	'ACP_BBCOMPRESS_ALLOWED_POSTS'           => 'Permitir otimização em imagens publicadas recentemente',
	'ACP_BBCOMPRESS_ALLOWED_POSTS_EXPLAIN'   => 'Isto permitirá que a extensão otimize todas as novas imagens enviadas como anexos de publicações e MPs.',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS'         => 'Permitir otimização em novos avatares',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS_EXPLAIN' => 'Isto permitirá que a extensão otimize todas as novas imagens enviadas como avatares.',

	'ACP_OPTIMIZER_DRIVER'         => 'Driver de Otimização',
	'ACP_OPTIMIZER_DRIVER_EXPLAIN' => 'Selecione a partir da lista de drivers do otimizador. O driver selecionado irá otimizar as imagens antes das mesmas serem guardadas. Dependendo do driver escolhido, poderão surgir opções extra adicionais, por favor, reveja e preencha as mesmas com cuidado.',

	'ACP_IMAGEOPTIM_USERNAME'         => 'Nome de utilizador ImageOptim',
	'ACP_IMAGEOPTIM_USERNAME_EXPLAIN' => 'Por favor, preencha o seu nome de utilizador (username API) para começar a comprimir imagens. Visite <a href="https://im2.io/register" target="_blank">A página de Registo de conta na API ImageOptim</a> para obter um nome de utilizador (username API).',

	'ACP_KRAKEN_API_KEY'            => 'Chave da API Kraken',
	'ACP_KRAKEN_API_KEY_EXPLAIN'    => 'Por favor, preencha com uma chave de API para começar a comprimir imagens. Visite <a href="https://kraken.io/account" target="_blank">A secção da conta Kraken</a> para obter uma chave de API.',
	'ACP_KRAKEN_API_SECRET'         => 'Segredo da API Kraken',
	'ACP_KRAKEN_API_SECRET_EXPLAIN' => 'Por favor, preencha com um segredo de API para começar a comprimir imagens. Visite <a href="https://kraken.io/account" target="_blank">A secção da conta Kraken</a> para obter o segredo de API.',

	'ACP_TINIFY_API_KEY'         => 'Chave da API TinyPNG',
	'ACP_TINIFY_API_KEY_EXPLAIN' => 'Por favor, preencha com uma chave de API para começar a comprimir imagens. Visite <a href="https://tinypng.com/developers" target="_blank">A secção de Developer do TinyPNG</a> para obter uma chave de API.',

	'ACP_TINIFY_RESIZE'         => 'Método de redimensionamento',
	'ACP_TINIFY_RESIZE_EXPLAIN' => 'Escolha um método de redimensionamento. Tenha em mente, que o redimensionamento conta como uma compressão adicional.<br>
												<strong>Scale (Escala)</strong> a imagem é ajustada para baixo proporcionalmente. Deve informar/fornecer quer a largura quer a altura desejada, não ambas. A imagem resultante terá o tamanho exato da largura ou altura informada.<br>
												<strong>Fit (Ajuste)</strong> a imagem é ajustada para baixo proporcionalmente de forma a caber exatamente entre a dimensão desejada. Deve informar/fornecer a largura e a altura desejada. A imagem resultante não excederá as dimensões informadas.<br>
												<strong>Cover (Cobrir)</strong> a imagem é ajustada para baixo proporcionalmente e cortada caso necessário de modo a que a imagem resultante tenha a dimensão exata que pretende. Deve informar/fornecer a largura e a altura desejada. Um algoritmo inteligente descobre as áreas mais importantes não as desfigurando. Se pretender, pode <a href="mailto:support@tinify.com">enviar o seu feedback</a> diretamente para o email da equipa do TinyPNG.',
	'NO_RESIZE'         => 'Não redimensionar',
	'RESIZE_SCALE'      => 'Scale',
	'RESIZE_FIT'        => 'Fit',
	'RESIZE_COVER'      => 'Cover',
	'ACP_TINIFY_WIDTH'  => 'Largura',
	'ACP_TINIFY_HEIGHT' => 'Altura',

	'ACP_TINIFY_WIDTH_EXPLAIN'  => 'Tamanho em px (píxeis)',
	'ACP_TINIFY_HEIGHT_EXPLAIN' => 'Tamanho em px (píxeis)',

	'ACP_BBCOMPRESS_SETTING_SAVED' => 'As configurações do BBcompress foram guardadas',
	'ACP_TINIFY_API_KEY_INVALID'   => 'A Chave de API TinyPNG está guardada, mas a extensão BBcompress não conseguiu efectuar e validar com sucesso a sua chave de API, por isso deve verificar as suas credenciais ou pode ter excedido os seus limites de conta. Por favor, tente novamente utilizando uma chave de API válida (caso o seu limite não tenha sido excedido). Se tiver a certeza que a sua chave de API e/ou o limite não foram atingidos, poderá ser simplesmente um erro/constrangimento momentâneo de rede.',
	'ACP_KRAKEN_INACTIVE'          => 'A sua conta encontra-se inativa. Por favor, verifique se a mesma não excedeu a quota permitida.',
	'ACP_KRAKEN_API_KEY_INVALID'   => 'As chaves Kraken são inválidas. Por favor, reveja-as.',
]);
