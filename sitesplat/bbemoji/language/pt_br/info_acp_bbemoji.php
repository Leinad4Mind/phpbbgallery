<?php

/**
 * @package BBEmoji for phpBB.
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
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
	'ACP_BBEMOJI'               => 'Ícones de Tópico - BBEmoji Ativado',
	'ACP_BBEMOJI_TITLE_EXPLAIN' => 'NOTA: Você pode ativar/desativar o BBEmoji no assunto do tópico por fórum (desativado globalmente por padrão), através de ACP > FÓRUNS (editar opção do fórum). <br />Além disso, os ícones de tópico também podem ser ativados/desativados por fórum. ACP > FÓRUNS (editar opção do fórum). Divirta-se!',
	'SS_HELPER_NOTY'            => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBEMOJI_NOTICE'            => '<div class="phpinfo"><p>Digite um ponto e vírgula na página de postagem ou no formulário de resposta rápida, assim ":" para que a sugestão automática apareça.<br />O emoji pode ser desativado no nível do usuário através de <strong>UCP &#187; Preferências do fórum &#187; Editar opções de exibição &#187; "Exibir smilies como imagens"</strong><br />Nota: Os emoji também são automaticamente ativados para <strong>ícones de tópico</strong> (podem ser adicionados/editados a partir do ACP, Postagens, Ícones de Tópico).<br>Os emoji também estão disponíveis para "assuntos das postagens". Estão desativados por padrão, mas podem ser ativados em ACP &#187; FÓRUNS &#187; (editar fórum clicando no ícone de engrenagem) &#187; "Ativar BBEmoji no assunto".<br> Outras extensões Premium como <strong>"BBstatus"</strong>, <strong>"BBgreetings"</strong>, <strong>"BBreaction"</strong> etc, também suportarão o BBEmoji se você o tiver instalado.</p></div>',

	'ICON_ADD'           => 'Adicionar novo ícone',
	'ICON'               => 'Ícone de Tópico Personalizado',
	'ICON_EXPLAIN'       => 'Adicione aqui o caminho do seu ícone personalizado, relativo à raiz do phpBB.',
	'ICON_EMOJI'         => 'Ícone Emoji',
	'ICON_EMOJI_EXPLAIN' => 'Comece digitando um ponto e vírgula para obter a lista de emoji a partir do menu de sugestão automática',
	'ICON_ADDED'         => 'O novo ícone foi adicionado',
	'ICON_NOT_EXIST'     => 'O ícone não existe',

	'ENABLE_SUBJECT_EMOJI'         => 'Ativar BBEmoji no assunto',
	'ENABLE_SUBJECT_EMOJI_EXPLAIN' => 'Ativa/desativa emoji no assunto do tópico. Existem algumas considerações a serem levadas em conta e um Administrador "sensato" deve definitivamente se informar sobre o impacto dos emoji no título. Aqui estão alguns artigos recentes e interessantes: <a href="https://yoast.com/ask-yoast-emojis-seo/" target="_blank">Emojis e SEO</a> e: <a href="https://www.wordtracker.com/academy/seo/page-optimization/will-an-emoji-in-the-description-harm-my-rankings" target="_blank">Will an emoji in the description harm my rankings?</a>.',

	// BBReaction
	'ACP_BBREACTION_EMOJI'         => 'BBEmoji',
	'ACP_BBREACTION_EMOJI_EXPLAIN' => 'Escolha um BBEmoji como ícone. Comece digitando :.',
]);
