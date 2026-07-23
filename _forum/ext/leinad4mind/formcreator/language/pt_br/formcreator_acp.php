<?php

/**
 * @package phpBB Extension - Form Creator for phpBB.
 * @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'MODE'                     => 'Modo',
	'ELEMENTS'                 => 'Elementos',
	'FORM_NAME'                => 'Nome do Fórum',
	'FORUM_ID'                 => 'ID do Fórum',
	'ACP_FORM_CURRENT'         => 'Atualizar Formulário Atual',
	'ACP_FORM_CREATOR'         => 'Criador de Formulários',
	'ACP_FORM_CREATOR_EXPLAIN' => 'Com esta ferramenta você pode criar e gerenciar formulários para o seu fórum.',
	'ACP_FORM_EXT_NOTE'        => '<br><strong>Nota:</strong> Todas as ações são realizadas no formulário atualmente selecionado/exibido, não há confirmação implementada...',

	'ACP_FORM_CREATOR_FAQ' => '<strong>Como começar?</strong><br>
									&nbsp; &bull; Você só precisa selecionar primeiro o fórum onde vai querer criar o formulário.<br>
									<br>
									<strong>Como faço isso?</strong><br>
									&nbsp; &bull; Basta selecionar um novo fórum na caixa suspensa <strong><i>Fórum Atual</i></strong>...<br>
									<br>
									<strong>E agora?</strong><br>
									&nbsp; &bull; O próximo passo é adicionar novos elementos ao formulário<br>
									<br>
									<strong>Como adiciono um novo elemento ao formulário?</strong><br>
									&nbsp; &bull; Use <strong><i>Adicionar novo elemento ao formulário</i></strong> no rodapé.<br>
									<br>
									<strong>Depois de adicionar todos os elementos que quero, isso salva automaticamente?</strong><br>
									&nbsp; &bull; Sim, quando você adiciona o elemento do formulário, ele é salvo automaticamente no formulário atual, mas se você fizer alterações nos elementos do formulário em <strong><i>Atualizar Formulário Atual</i></strong>, vai precisar clicar em atualizar para que as alterações sejam salvas!<br>
									<br>
									<strong>Alguns campos não fazem sentido para meu tipo de elemento, acontece algo de ruim se eu preenchê-los?</strong><br>
									&nbsp; &bull; Não acontece nada de ruim. Você só vai colocar lixo no banco de dados. Toda essa informação será descartada. É por isso que se recomenda adicionar um novo elemento vazio e só depois atualizá-lo.<br>
									<br>
									<strong>Como excluo um formulário?</strong><br>
									&nbsp; &bull; Basta excluir todos os elementos do formulário...<br>
									<br>
									<br>
									<strong>O que é Nome Antes/Depois?</strong><br>
									&nbsp; &bull; Esses campos aceitam BBCode, e o que você escrever ali vai aparecer antes e depois do Nome da Entrada no post final, para que você possa personalizar o Nome da Entrada.<br>
									<br>
									<strong>Posso ver um exemplo dos campos Nome Antes/Depois?</strong><br>
									&nbsp; &bull; Claro. Você pode adicionar <i>[b]</i> no campo Antes e <i>[/b]</i> no campo Depois e se o Nome da Entrada for <i>Título</i>, então o post será processado como: <i>[b]Título[/b]</i><br>
									<br>
									<strong>O que é Nome da Entrada?</strong><br>
									&nbsp; &bull; Sério? Essa é a pergunta no campo do formulário, o texto antes do campo de entrada, e esse texto pode ou não ser importado para o post final.<br>
									<br>
									<strong>O que é Explicação da Entrada?</strong><br>
									&nbsp; &bull; Este é um campo opcional, se você preenchê-lo, ele vai aparecer abaixo do Nome da Entrada no formulário, para que você possa inserir um pequeno texto explicativo. Suporta BBCode e quebra de linha também.<br>
									<br>
									<strong>O que é Dica?</strong><br>
									&nbsp; &bull; A Dica é opcional e é o que aparece dentro dos campos de entrada, para que você possa dar uma ideia do que deve ser preenchido na caixa de entrada. É uma boa ideia usá-la em alguns casos para evitar abusar da Explicação da Entrada. Para a caixa de seleção, a dica será o primeiro elemento padrão.<br>
									<br>
									<strong>O que é Opções?</strong><br>
									&nbsp; &bull; Só funciona em alguns tipos de elemento: caixa de seleção, botões de opção, caixa de seleção múltipla e separador. Dito isso, é um campo onde você vai inserir as opções para esses tipos de elemento.<br>
									<br>
									<strong>Posso ver um exemplo dos campos Opções? Ainda estou confuso.</strong><br>
									&nbsp; &bull; Claro. Você pode adicionar, por exemplo, gêneros como: <i>Ação, Aventura, Terror, Romance, Ficção Científica</i>, e o usuário poderá apenas selecionar as opções, em vez de digitá-las.<br>
									<br>
									<strong>Isso faz sentido para caixa de seleção, botões de opção e caixa de seleção múltipla, mas separador? O que é isso?</strong><br>
									&nbsp; &bull; Sim, esse é uma exceção. Esse campo é apenas para personalização do layout do formulário. Uma forma de personalizar a aparência do próprio formulário.<br>
									<br>
									<strong>Ótimo! E eu sempre preciso usar uma vírgula para separar as palavras?</strong><br>
									&nbsp; &bull; Você pode usar uma vírgula ou uma quebra de linha e também há um recurso oculto. Se você usar "Administrador => Adm, Moderador => Mod, Usuário => U", o primeiro vai aparecer no formulário e o segundo no post.<br>
									<br>
									<strong>O que é Mín/Máx?</strong><br>
									&nbsp; &bull; Isso só funciona em Caixas de Seleção Múltipla, já que é o único tipo de elemento onde você pode selecionar vários itens, e com esses campos você pode exigir que o usuário escolha entre um valor mínimo e máximo. Se você colocar Mín: 1 e Máx: 3, o usuário vai precisar escolher pelo menos uma e menos de 3 opções.<br>
									<br>
									<strong>O que é Valor Antes/Depois?</strong><br>
									&nbsp; &bull; É parecido com <i>Nome Antes/Depois</i>. Também aceita BBCode e vai aparecer antes e depois do valor que o usuário inseriu.<br>
									<br>
									<strong>Ainda posso ver um exemplo dos campos Valor Antes/Depois?</strong><br>
									&nbsp; &bull; Por que não? Você pode adicionar <i>[color=#ff0000]</i> no campo Antes e <i>[/color]</i> no campo Depois e digamos que o Nome da Entrada seja <i>Título do Filme</i>. Aí o usuário insere no formulário algo como <i>Titanic</i> e quando envia, o post será processado como: <i>[color=#ff0000]Titanic[/color]</i><br>
									<br>
									<strong>Tem mais alguma coisa que eu deveria saber?</strong><br>
									&nbsp; &bull; Que bom que perguntou! Alguns campos como Nome da Entrada, Explicação, Dica e Opções são traduzíveis. Isso significa que você pode inserir variáveis de idioma {L_LANGUAGE_VARIABLE} para que o formulário seja multilíngue.<br>
									<br>
									<strong>UAU! Incrível! Mas onde posso adicionar as Variáveis de Idioma?</strong><br>
									&nbsp; &bull; Basta editar o arquivo root/ext/leinad4mind/formcreator/language/COUNTRY/common.php e adicionar novas variáveis, para depois poder usá-las na ACP.<br>
									<br>
									<strong>&#8730;</strong> O símbolo de visto indica que o item é obrigatório e não pode ficar vazio, o que obriga o usuário a preenchê-lo.<br>
									<strong><i class="fa fa-eye" aria-hidden="true"></i></strong> O símbolo de olho indica que o nome da entrada desse item não será importado para o post enviado.<br>',

	'CURRENT_FORUM'                   => 'Fórum Atual',
	'FORM_ADD_ITEM'                   => 'Adicionar novo elemento ao formulário',
	'FORM_CHECKBOX'                   => 'Caixa de Seleção Múltipla',
	'FORM_DETAILS'                    => 'Todos os formulários usam um arquivo de modelo genérico: styles/SEU_ESTILO/template/forms/form_creator.html',
	'FORM_ELEMENT_TYPE'               => 'Tipo de elemento',
	'FORM_ELEMENT_HINT'               => 'Dica',
	'FORM_ELEMENT_OPTIONS_SEPARATOR'  => 'Separador de opções',
	'FORM_ELEMENT_NAME_VISIBLE'       => 'Mostrar/ocultar o nome do elemento no formulário final.',
	'FORM_ELEMENT_NAME'               => 'Nome da Entrada',
	'FORM_ELEMENT_EXPLAIN'            => 'Explicação da Entrada',
	'FORM_ELEMENT_NAME_EXPLAIN'       => 'Nome/Explicação da Entrada',
	'FORM_ELEMENT_OPTIONS'            => 'Opções',
	'FORM_ELEMENT_MIN_MAX'            => 'Mín/Máx',
	'FORM_ELEMENT_MIN'                => 'Mín',
	'FORM_ELEMENT_MAX'                => 'Máx',
	'FORM_ELEMENT_NAME_BEFORE_AFTER'  => 'Nome antes/depois',
	'FORM_ELEMENT_VALUE_BEFORE_AFTER' => 'Valor antes/depois',
	'FORM_EMAILBOX'                   => 'Email',
	'FORM_INPUTBOX'                   => 'Texto',
	'FORM_CREATOR_ACP_RETURN'         => 'Voltar ao gerenciamento de formulários',
	'FORM_MANAGE'                     => 'Gerenciar este formulário',
	'FORM_MANAGE_EXPLAIN'             => 'Aqui você pode modificar todos os elementos do formulário atual, basta editar os campos e pressionar o botão <strong>Atualizar</strong>...',

	'FORM_NEW_ITEM_EXPLAIN' => '<pre style="font-size:11px; line-height: 100%;"><strong><u>Elementos de Formulário Suportados</u></strong><br>
									<strong>Caixa de texto:</strong>		Até 255 caracteres<br>
									<strong>Área de texto:</strong>	 	Várias linhas de texto dispostas em 3 linhas por 76 colunas.<br>
									<strong>Caixa de seleção múltipla:</strong>		Uma ou mais opções podem ser selecionadas.<br>
									<strong>Botão de opção:</strong> 		Apenas uma opção pode ser selecionada.<br>
									<strong>Caixa de seleção:</strong>		Uma opção de uma lista suspensa.<br>
									<strong>Email:</strong>			Endereço de email válido.<br>
									<strong>Senha:</strong>		Apenas para fins de teste...<br>
									<strong>URL:</strong>			Uma URL válida deve ser inserida.<br>
									<strong>Anexo:</strong>		Adiciona um arquivo ao sistema de anexos.<br>
									<strong>Número:</strong>			Apenas números de 0 a 9 são permitidos.<br>
									<strong>Data:</strong>			Abre um seletor de data.<br>
									<strong>Hora:</strong>			Abre um seletor de hora.<br>
									<strong>Separador:</strong>			Apenas para personalização do layout do formulário.<br>
									<br></pre>',

	'FORM_NO_FORM'      => 'Não há formulários atribuídos a: <strong>%s</strong>...<br>Para adicionar um novo formulário a este fórum, basta adicionar um elemento de formulário abaixo...',
	'FORM_RADIOBOX'     => 'Botões de Opção',
	'FORM_PASSWORDBOX'  => 'Senha',
	'FORM_SELECTBOX'    => 'Caixa de Seleção',
	'FORM_TXTBOX'       => 'Área de Texto',
	'FORM_URLBOX'       => 'URL',
	'FORM_ATTACH'       => 'Anexo',
	'FORM_NUMBER'       => 'Número',
	'FORM_DATE'         => 'Data',
	'FORM_TIME'         => 'Hora',
	'FORM_SEPARATOR'    => 'Separador',
	'HIDE_FORM_INFO'    => 'Ocultar informação',
	'HIDE_PREVIEW'      => 'Ocultar Pré-visualização',
	'HIDE_COPY'         => 'Ocultar cópia de formulário',
	'HOW_TO'            => '<strong>Ajuda Adicional...</strong>',
	'HOW_TO_MORE'       => 'Mais informações...',
	'HOW_TO_HIDE'       => '<strong>Ocultar</strong>',
	'NDX'               => 'NDX',
	'NDX_ORDER'         => 'Ordem do índice (a ordem em que os itens aparecem no formulário)',
	'FORMS_MOD_SAMPLE'  => 'Renderizando o formulário atual apenas para fins de visualização... não é um formulário funcional.',
	'SHOW_FORM_INFO'    => 'Mais informações sobre os Tipos de Elemento',
	'SHOW_PREVIEW'      => 'Pré-visualizar o formulário',
	'SHOW_COPY'         => 'Copiar formulário',
	'COPY_FORM'         => 'Copiar formulário para os fóruns selecionados',
	'COPY_FORM_EXPLAIN' => 'Isso vai excluir todos os elementos de formulário existentes nos fóruns de destino selecionados!',
	'COPY_FORM_SUCCESS' => 'Os elementos do formulário foram copiados para todos os fóruns selecionados.',

	'SHOW_FORM_DEFAULT' => 'Mostrar formulário por padrão',
	'FORCE_FORM'        => 'Forçar formulário',
]);
