<?php

/**
 * @package BBEmoji for phpBB.
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
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
	'ACP_BBEMOJI'               => 'Ícones de Tópico - BBEmoji Ativado',
	'ACP_BBEMOJI_TITLE_EXPLAIN' => 'NOTA: Podes ativar/desativar o BBEmoji no assunto do tópico por fórum (desativado globalmente por padrão), através de ACP > FÓRUNS (editar opção do fórum). <br />Além disso, os ícones de tópico também podem ser ativados/desativados por fórum. ACP > FÓRUNS (editar opção do fórum). Diverte-te!',
	'SS_HELPER_NOTY'            => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBEMOJI_NOTICE'            => '<div class="phpinfo"><p>Escreve um ponto e vírgula na página de publicação ou no formulário de resposta rápida, assim ":" para que a sugestão automática apareça.<br />O emoji pode ser desativado ao nível do utilizador através de <strong>UCP &#187; Preferências do fórum &#187; Editar opções de exibição &#187; "Exibir smilies como imagens"</strong><br />Nota: Os emoji também são automaticamente ativados para <strong>ícones de tópico</strong> (podem ser adicionados/editados a partir do ACP, Publicações, Ícones de Tópico).<br>Os emoji também estão disponíveis para "assuntos das publicações". Estão desativados por padrão, mas podem ser ativados em ACP &#187; FÓRUNS &#187; (editar fórum clicando no ícone de engrenagem) &#187; "Ativar BBEmoji no assunto".<br> Outras extensões Premium como <strong>"BBstatus"</strong>, <strong>"BBgreetings"</strong>, <strong>"BBreaction"</strong> etc, também suportarão o BBEmoji se o tiveres instalado.</p></div>',

	'ICON_ADD'           => 'Adicionar novo ícone',
	'ICON'               => 'Ícone de Tópico Personalizado',
	'ICON_EXPLAIN'       => 'Adiciona aqui o caminho do teu ícone personalizado, relativo à raiz do phpBB.',
	'ICON_EMOJI'         => 'Ícone Emoji',
	'ICON_EMOJI_EXPLAIN' => 'Começa por digitar um ponto e vírgula para obteres a lista de emoji a partir do menu de sugestão automática',
	'ICON_ADDED'         => 'O novo ícone foi adicionado',
	'ICON_NOT_EXIST'     => 'O ícone não existe',

	'ENABLE_SUBJECT_EMOJI'         => 'Ativar BBEmoji no assunto',
	'ENABLE_SUBJECT_EMOJI_EXPLAIN' => 'Ativa/desativa emoji no assunto do tópico. Existem algumas considerações a ter em conta e um Administrador "sensato" deve definitivamente informar-se sobre o impacto dos emoji no título. Aqui ficam alguns artigos recentes e interessantes: <a href="https://yoast.com/ask-yoast-emojis-seo/" target="_blank">Emojis e SEO</a> e: <a href="https://www.wordtracker.com/academy/seo/page-optimization/will-an-emoji-in-the-description-harm-my-rankings" target="_blank">Will an emoji in the description harm my rankings?</a>.',

	// BBReaction
	'ACP_BBREACTION_EMOJI'         => 'BBEmoji',
	'ACP_BBREACTION_EMOJI_EXPLAIN' => 'Escolhe um BBEmoji como ícone. Começa por digitar :.',
]);
