<?php

/**
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
	'STYLE_SETTINGS_LOGO'                => 'Logotipos &amp; Fundo do Cabeçalho',
	'STYLE_SETTINGS_LOGO_EXPLAIN'        => '',
	'STYLE_SETTINGS_LOGO_UPLOAD'         => 'Enviar imagem de logotipo',
	'STYLE_SETTINGS_LOGO_UPLOAD_EXPLAIN' => 'Envie uma imagem de logotipo. A localização do logotipo abaixo será preenchida automaticamente quando uma imagem for enviada. Formatos aceites: gif, jpg, png, svg.',
	'STYLE_SETTINGS_LOGO_PATH'           => 'Localização da imagem do logotipo',
	'STYLE_SETTINGS_LOGO_PATH_EXPLAIN'   => 'Isto será preenchido automaticamente. Apague e envie para remover o logotipo.',
	'STYLE_SETTINGS_LOGO_WIDTH'          => 'Largura do logotipo',
	'STYLE_SETTINGS_LOGO_WIDTH_EXPLAIN'  => 'Deixe em branco para usar o tamanho padrão',
	'STYLE_SETTINGS_LOGO_HEIGHT'         => 'Altura do logotipo',
	'STYLE_SETTINGS_LOGO_HEIGHT_EXPLAIN' => 'Deixe em branco para usar o tamanho padrão',
	'STYLE_SETTINGS_LOGO_ERROR'          => 'Falha ao enviar o ficheiro do logotipo %s.',

	'STYLE_SETTINGS_HEADER_ERROR'          => 'Falha ao enviar o ficheiro do cabeçalho %s.',
	'STYLE_SETTINGS_HEADER_UPLOAD'         => 'Enviar fundo do cabeçalho.',
	'STYLE_SETTINGS_HEADER_UPLOAD_EXPLAIN' => 'Envie uma imagem de cabeçalho (deixe em branco para usar a cor de destaque do tema como fundo). A localização do cabeçalho abaixo será preenchida automaticamente quando uma imagem for enviada.',
	'STYLE_SETTINGS_HEADER_PATH'           => 'Localização da imagem do cabeçalho',
	'STYLE_SETTINGS_HEADER_PATH_EXPLAIN'   => 'Isto será preenchido automaticamente. Apague e envie para remover a imagem do cabeçalho.',

	'STYLE_SETTINGS_FAVICON_ERROR'        => 'Falha ao enviar o ficheiro do favicon %s.',
	'STYLE_SETTINGS_FAVICON_UPLOAD'       => 'Enviar favicon.',
	'STYLE_SETTINGS_FAVICON_EXPLAIN'      => 'Envie um favicon. Recomendam-se vivamente imagens quadradas.',
	'STYLE_SETTINGS_FAVICON_PATH'         => 'Localização da imagem do favicon',
	'STYLE_SETTINGS_FAVICON_PATH_EXPLAIN' => 'Isto será preenchido automaticamente. Apague e envie para remover o favicon.',

	'STYLE_SETTINGS_HTML_CODE'    => 'Blocos de código HTML',
	'STYLE_SETTINGS_HTML_1'       => 'Conteúdo Personalizado da Barra Lateral Esquerda',
	'STYLE_SETTINGS_HTML_2'       => 'Conteúdo Personalizado da Barra Lateral Direita',
	'STYLE_SETTINGS_HTML_3'       => 'Código Social do Rodapé',
	'STYLE_SETTINGS_HTML_4'       => 'Código Global do &lt;head&gt;',
	'STYLE_SETTINGS_HTML_HELP_1'  => 'Suporta HTML e caracteres especiais',
	'STYLE_SETTINGS_HTML_HELP_2'  => 'Suporta HTML e caracteres especiais',
	'STYLE_SETTINGS_HTML_HELP_3'  => 'Veja a documentação para exemplos',
	'STYLE_SETTINGS_HTML_HELP_4'  => 'AVISO! Coisas más acontecerão se não tiver experiência',
	'STYLE_SETTINGS_HTML_EXPLAIN' => 'Usa a variável de modelo <samp>{STYLE_SETTINGS_HTML_%d}</samp>',

	'STYLE_SETTINGS_CONFIG'         => 'Configurações do Estilo',
	'STYLE_SETTINGS_CONFIG_EXPLAIN' => 'Usa a variável de modelo <samp>{%s}</samp>',

	'STYLE_SETTINGS_SAVED' => 'As configurações do estilo foram guardadas.',
]);
