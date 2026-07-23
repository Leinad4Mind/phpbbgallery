<?php

/**
 * BBcompress
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'ACP_BBCOMPRESS'       => 'BBcompress',
	'ACP_BBCOMPRESS_TITLE' => 'BBcompress',
	'ACP_SETTINGS'         => 'Configurações',

	'SS_HELPER_NOTY'      => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBCOMPRESS_NOTICE'   => '<div class="phpinfo"><p>As configurações para esta extensão encontram-se na aba <strong>Extensões</strong>.</p></div>',
	'ACP_BBCOMPRESS_NOTE' => 'Tenha em atenção que os valores script timeout (tempo limite do script) e max_upload_file_size poderão precisar ser aumentados. Estes podem, às vezes, ser alterados através de um .htaccess, mas nem sempre funciona. Isto é frequentemente feito via php.ini na configuração do seu servidor. Se tiver erros de tempo limite (timeout), peça ao seu serviço de hospedagem para aumentar o tempo limite (timeout) do script, bem como o max_upload_file_size.',

	'ACP_BBCOMPRESS_SETTINGS_EXPLAIN' => 'Aqui você pode definir todas as configurações do BBcompress. Selecione se deseja otimizar imagens em posts e MPs e/ou avatares. Escolha da lista de drivers fornecida a configuração de compressão pretendida. Cada driver retorna resultados diferentes e/ou tem opções e restrições adicionais. <br /><br /><strong>O BBcompress já otimizou e economizou para você: <span class="badge badge-success">%s</span></strong>',

	'ACP_OPTIMIZER_GENERAL_OPTIONS'          => 'Configurações gerais',
	'ACP_BBCOMPRESS_ALLOWED_POSTS'           => 'Permitir otimização em imagens postadas recentemente',
	'ACP_BBCOMPRESS_ALLOWED_POSTS_EXPLAIN'   => 'Isto permitirá que a extensão otimize todas as novas imagens enviadas como anexos de posts e MPs.',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS'         => 'Permitir otimização em novos avatares',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS_EXPLAIN' => 'Isto permitirá que a extensão otimize todas as novas imagens enviadas como avatares.',

	'ACP_OPTIMIZER_DRIVER'         => 'Driver de Otimização',
	'ACP_OPTIMIZER_DRIVER_EXPLAIN' => 'Selecione a partir da lista de drivers do otimizador. O driver selecionado irá otimizar as imagens antes de serem armazenadas. Dependendo do driver escolhido, poderão surgir opções extras adicionais; por favor, revise e preencha-as com cuidado.',

	'ACP_IMAGEOPTIM_USERNAME'         => 'Nome de usuário ImageOptim',
	'ACP_IMAGEOPTIM_USERNAME_EXPLAIN' => 'Por favor, preencha seu nome de usuário (username API) para começar a comprimir imagens. Visite a <a href="https://im2.io/register" target="_blank">página de registro de conta na API ImageOptim</a> para obter um nome de usuário (username API).',

	'ACP_KRAKEN_API_KEY'            => 'Chave da API Kraken',
	'ACP_KRAKEN_API_KEY_EXPLAIN'    => 'Por favor, preencha com uma chave de API para começar a comprimir imagens. Visite a <a href="https://kraken.io/account" target="_blank">seção da conta Kraken</a> para obter uma chave de API.',
	'ACP_KRAKEN_API_SECRET'         => 'Segredo da API Kraken',
	'ACP_KRAKEN_API_SECRET_EXPLAIN' => 'Por favor, preencha com um segredo de API para começar a comprimir imagens. Visite a <a href="https://kraken.io/account" target="_blank">seção da conta Kraken</a> para obter o segredo de API.',

	'ACP_TINIFY_API_KEY'         => 'Chave da API TinyPNG',
	'ACP_TINIFY_API_KEY_EXPLAIN' => 'Por favor, preencha com uma chave de API para começar a comprimir imagens. Visite a <a href="https://tinypng.com/developers" target="_blank">seção de Developer do TinyPNG</a> para obter uma chave de API.',

	'ACP_TINIFY_RESIZE'         => 'Método de redimensionamento',
	'ACP_TINIFY_RESIZE_EXPLAIN' => 'Escolha um método de redimensionamento. Tenha em mente que o redimensionamento conta como uma compressão adicional.<br>
												<strong>Scale (Escala)</strong> a imagem é redimensionada proporcionalmente para baixo. Você deve informar/fornecer a largura ou a altura desejada, não ambas. A imagem resultante terá exatamente a largura ou altura informada.<br>
												<strong>Fit (Ajuste)</strong> a imagem é redimensionada proporcionalmente para baixo, de forma a caber exatamente dentro da dimensão desejada. Você deve informar/fornecer a largura e a altura desejadas. A imagem resultante não excederá as dimensões informadas.<br>
												<strong>Cover (Cobrir)</strong> a imagem é redimensionada proporcionalmente e cortada, se necessário, de modo que o resultado tenha exatamente a dimensão desejada. Você deve informar/fornecer a largura e a altura desejadas. Um algoritmo inteligente descobre as áreas mais importantes e as mantém intactas. Se quiser, você pode <a href="mailto:support@tinify.com">enviar um feedback</a> diretamente para o e-mail da equipe do TinyPNG.',
	'NO_RESIZE'         => 'Sem redimensionamento',
	'RESIZE_SCALE'      => 'Scale',
	'RESIZE_FIT'        => 'Fit',
	'RESIZE_COVER'      => 'Cover',
	'ACP_TINIFY_WIDTH'  => 'Largura',
	'ACP_TINIFY_HEIGHT' => 'Altura',

	'ACP_TINIFY_WIDTH_EXPLAIN'  => 'Tamanho em px (pixels)',
	'ACP_TINIFY_HEIGHT_EXPLAIN' => 'Tamanho em px (pixels)',

	'ACP_BBCOMPRESS_SETTING_SAVED' => 'As configurações do BBcompress foram salvas',
	'ACP_TINIFY_API_KEY_INVALID'   => 'A Chave de API TinyPNG está salva, mas a extensão BBcompress não conseguiu verificar sua chave de API, ou você excedeu seu limite. Por favor, tente novamente com uma chave de API válida caso o limite excedido não seja o seu caso. Se você tem certeza de que sua chave de API está correta e seu limite não foi excedido, pode haver um problema na rede. Nesse caso, por favor, tente novamente mais tarde.',
	'ACP_KRAKEN_INACTIVE'          => 'Sua conta está inativa. Por favor, verifique se ela não excedeu a cota.',
	'ACP_KRAKEN_API_KEY_INVALID'   => 'As chaves Kraken são inválidas. Por favor, revise-as.',
]);
