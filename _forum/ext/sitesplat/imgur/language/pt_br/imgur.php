<?php

/**
 * Imgur - forum images uploader
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'IMGUR_CLIENT_ID'         => 'Identificador associado à Aplicação "ID Cliente (Client ID)"',
	'IMGUR_CLIENT_ID_EXPLAIN' => 'Irá ser necessário registar-se ou utilizar as suas credenciais ativas do "Imgur" por modo e intermédio duma App e criar uma indicação como forma para poder vir e passar a obter ou a lhe ser designada uma autêntica codificação da devida <strong>Chave do Cliente de API para a Aplicação (Client ID)</strong>.<br /> Para dar prosseguimento ao registar-se e ao de criar uma autêntica e original App bastará recorrer e dirigir-se com os devidos cliques aos enlaces perante <a href="https://api.imgur.com/oauth2/addclient" target="_blank">esta referida página</a>. Seguidamente e quando este passo se der por concluído apenas tem por fim e em base o respetivo inserimento nestes parâmetros e de guardar aqui todo esse código designado duma Client ID e o colar num preenchimento de caixa a isso destinado e assim proceder.',

	'IMGUR_UPLOAD_TITLE' => 'Alojamento das respetivas Imagens (Upload)',
	'IMGUR_UPLOAD_MAIN'  => 'Faça uso, desfrute e armazene localmente ao subir nos alojamentos com descarregamentos providenciados das imagens face à utilização em tópicos via os serviços do <a href="https://imgur.com" target="_blank">IMGUR</a>. Todas as imagens passarão em antemão para depois e por si só serem automaticamente inseridas no conteúdo ou no campo da mensagem com as suas partilhas a constarem acima destas desde o mesmo momento onde a tudo for devidamente submetido, tratado e guardado',
	'IMGUR_UPLOAD'       => 'Faça o Envio, Carregue E Ou Submeta De Imediato Para O Alojamento da(s) Imagens (Upload)',
	'IMGUR_SELECT'       => 'Procure Ou Clique Por Aqui Adicionando Como Também Selecionando Na Base Os Arquivos Destituídos Na Identificação De Imagens',
	'IMGUR_COPY'         => 'Copiar',

	'IMGUR_OUTPUT_LINK'         => 'O seu (URL) ou Endereço de Ligação Direto',
	'IMGUR_OUTPUT_IMAGE'        => 'Identificação base das (Tags) provenientes do modo ou modelo de visualização ou marcação tipo (BBCode)',
	'IMGUR_OUTPUT_IMAGE_DELETE' => 'O seu (URL) ou Endereço de Ligação Direto Relacionado Com o Modo ou Situação Em Remover/Excluir a(s) Respetiva(s) Publicação Face Ao Que Respeite Destituído Apenas da Cópia das Sua Imagens',
	'IMGUR_OUTPUT_MARKDOWN'     => 'Referência Exata Dos Códigos Em Alternativa Num Modelo/Modo Assente Na Exclusividade Associada Em (Markdown)',
	'MARKDOWN_WHATIS'           => '<a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="para o uso e funcionalidade destituída à visualização exclusiva dos Modelos/Temas assentes numa vertente destituída e com as características unicamente ligadas com os do tipo (Premium) do respetivo (Modo Avançado/Premium extension bbMarkdown ou a vertente dos temas em base Premium da marca ThemeSplat)" target="_blank"><i class="fa fa-question-circle"></i></a>',
	'IMGUR_OUTPUT_PLACEHOLDER'  => 'Aguarde... Encontra-se de momento em fase e num mero estado provisório a de processamento/carregamento associada na submissão com vista e ou de destino para envio final num aguardado alojamento local proveniente da sua imagem...',

	'IMGUR_SIGNATURE' => 'Habilitar a funcionalidade inerente da base da Extensão da(s) Imagem/Imagens (IMGUR Uploads) por forma também a virem ser inseridas/partilhadas ao ser exibido uma nova e inovadora área por debaixo do espaço em que se baseia a página da edição com as assinaturas.',

	'ALLOW_IMGUR'                 => 'Permitir/Habilitar Os (Avatares IMGUR)',
	'AVATAR_DRIVER_IMGUR_TITLE'   => 'Avatar tipo (IMGUR)',
	'AVATAR_DRIVER_IMGUR_EXPLAIN' => '',
	'IMGUR_AVATAR'                => 'Avatar do IMGUR',

	'IMGUR_QUICKREPLY' => 'Permitir/Habilitar a funcionalidade inerente da base da extensão associada em pleno e exibida na vertente exclusiva destituída à Edição na Interligação dum Resposta Rápida (Snappy Smart/Quick Reply)',

]);
