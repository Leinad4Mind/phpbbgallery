<?php

/**
 * Advanced Polls [English]
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
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
	'ADVANCEDPOLLS_EXT_NAME' => 'Votações Avançadas',

// Viewtopic
	'AP_VOTES_HIDDEN'         => 'Votos ocultos',
	'AP_POLL_RUN_TILL_APPEND' => ', até que todos os votos estejam ocultos.',
	'AP_VOTERS'               => 'Votantes',
	'AP_NONE'                 => 'Ninguém',
	'AP_DELETED_USER'         => 'Usuário excluído',

	'AP_POLL_CANT_VOTE'              => 'Você não pode votar nesta votação. Razão',
	'AP_POLL_REASON_NOT_POSTED'      => 'Você não escreveu neste tópico.',
	'AP_POLL_VOTES_ARE_VISIBLE'      => 'Tenha em conta que, se você votar, seu voto será visível.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS' => 'Não quero votar, quero ver os resultados',
	'AP_POLL_RESULTS_ARE_ORDERED'    => 'Os resultados estão ordenados por número decrescente de votos recebidos.',
	'AP_POLL_TYPE_MISMATCH'          => 'Dados inconsistentes na votação, erro interno.',
	'AP_VOTE_CHANGED'                => 'Não tem permissão para alterar os votos já emitidos.',
	'AP_TOO_MANY_VOTES'              => 'Tentou adicionar demasiados votos.',
	'AP_ABSTAINERS' => 'Optaram por não votar',
	'AP_DELETE_VOTE' => 'Excluir meu voto',

	'AP_MAX_VOTES_SELECT' => [
		1 => 'Você pode enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
		2 => 'Você pode enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
	],
	'AP_GUEST_VOTES' => [
		1 => '%d voto de convidado',
		2 => '%d votos de convidados',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d voto',
		2 => '%d votos',
	],
	'AP_SCORE_BREAKDOWN' => 'Detalhamento dos votos',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d voto de %2$d ponto',
		2 => '%1$d votos de %2$d pontos',
	],
	'AP_RANK_TOTAL' => [1 => '%d ponto', 2 => '%d pontos'],
	'AP_RANK_BREAKDOWN' => 'Detalhamento do ranking',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%1$d voto na posição %2$d', 2 => '%1$d votos na posição %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Selecione exatamente %d opção por ordem de preferência.',
		2 => 'Selecione exatamente %d opções por ordem de preferência.',
	],
// Posting
	'AP_POLL_TYPE' => 'Tipo de enquete',
	'AP_POLL_TYPE_EXPLAIN' => 'Escolha como os usuários atribuem seus votos ou pontos.',
	'AP_POLL_TYPE_CHOICE' => 'Escolha',
	'AP_POLL_TYPE_SCORING' => 'Pontuação numérica',
	'AP_POLL_TYPE_RANKING' => 'Ranking ordenado',
	'AP_POLL_VISIBILITY' => 'Visibilidade dos resultados',
	'AP_POLL_VISIBILITY_EXPLAIN' => 'Escolha quando os resultados agregados da votação ficarão visíveis.',
	'AP_VISIBILITY_PUBLIC' => 'Pública — sempre mostrar os resultados',
	'AP_VISIBILITY_DEFAULT' => 'Após o primeiro voto',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Após usar todos os votos disponíveis',
	'AP_VISIBILITY_PRIVATE' => 'Privada — somente após o término da votação',
	'AP_POLL_VOTE_MODE' => 'Alterações de voto',
	'AP_POLL_VOTE_MODE_EXPLAIN' => 'Escolha se os votos são definitivos, podem ser enviados de forma incremental ou alterados enquanto a votação estiver aberta.',
	'AP_VOTE_MODE_NO_CHANGE' => 'Sem alterações',
	'AP_VOTE_MODE_INCREMENTAL' => 'Votação incremental',
	'AP_VOTE_MODE_CHANGE' => 'Permitir alterações',
	'AP_POLL_VOTES_HIDE'           => 'Ocultar votos',
	'AP_POLL_VOTES_HIDE_EXPLAIN'   => 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
	'AP_POLL_VOTERS_SHOW'          => 'Mostrar votantes da votação',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'  => 'Se estiver ativado, os votantes serão mostrados a quem tenha permissão. Tenha em conta que os votantes estarão ocultos caso os votos estejam ocultos.',
	'AP_POLL_VOTERS_LIMIT'         => 'Limite de votos',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN' => 'Se estiver ativado, os usuários habilitados só podem votar se escreveram neste tópico.',
	'AP_POLL_SHOW_ORDERED'         => 'Ordenar resultados',
	'AP_POLL_SHOW_ORDERED_EXPLAIN' => 'Quando os resultados são mostrados, eles são ordenados por número decrescente de votos recebidos (o mais votado primeiro). Caso contrário, é usada a ordem das opções na votação.',
	'AP_POLL_COLLAPSIBLE' => 'Enquete recolhível',
	'AP_POLL_COLLAPSIBLE_EXPLAIN' => 'Permite que os usuários recolham e expandam esta enquete.',
	'AP_COLLAPSE_POLL' => 'Recolher enquete',
	'AP_EXPAND_POLL' => 'Expandir enquete',
	'AP_RUN_POLL'                  => 'Realizar votação',
	'AP_RUN_POLL_FOR'              => 'durante',
	'AP_RUN_POLL_UNTIL'            => 'até',
	'AP_RUN_POLL_INDEFINITELY'     => 'indefinidamente',
	'AP_POLL_END'                  => 'Fim da votação',
	'AP_POLL_END_EXPLAIN'          => 'Especifique a data e hora do término da votação. Caso especifique um destes campos, a duração da votação não será considerada. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso queira voltar a usar a duração, você precisará apagar o conteúdo de todos estes campos.',

	'AP_YYYY_MM_DD'                 => 'AAAA-MM-DD',
	'AP_HH_MM'                      => 'HH:MM',
	'AP_POLL_END_INVALID'           => 'A data/hora especificada não é válida',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES' => 'O número máximo de votos a uma opção não pode ser superior ao total de votos a repartir entre as opções possíveis',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'  => 'O número máximo de opções que se pode votar não pode ser superior ao total de votos a repartir entre as opções possíveis',

	'AP_POLL_MAX_VALUE'             => 'Votos máximos',
	'AP_POLL_MAX_VALUE_EXPLAIN'     => 'Este é o número máximo de votos que um votante pode escolher numa mesma opção.',
	'AP_POLL_TOTAL_VALUE'           => 'Votos totais',
	'AP_POLL_TOTAL_VALUE_EXPLAIN'   => 'Este é o número total de votos que um votante pode escolher, repartidos entre as opções possíveis.',

	'AP_RANK_POINTS' => 'Pontos por posição',
	'AP_RANK_POINTS_EXPLAIN' => 'Defina um valor positivo e decrescente para cada posição. O número de posições é controlado pelo máximo de opções por usuário.',
	'AP_RANK_POSITION' => 'Posição %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE' => 'Não pode escolher um número de votos superior ao máximo permitido.',
	'AP_POLL_VALUES_INVALID' => 'A pontuação mínima não pode exceder a máxima; o máximo de opções, a pontuação máxima e a pontuação total devem ser maiores que zero.',
	'AP_RANK_POSITIONS_INVALID' => 'O número de posições deve estar entre 1 e o número de opções da enquete.',
	'AP_RANK_POINTS_INCOMPLETE' => 'Defina um valor de pontos para cada posição.',
	'AP_RANK_POINTS_INVALID' => 'Cada valor de pontos deve estar entre 1 e 999.',
	'AP_RANK_POINTS_ORDER' => 'Os pontos devem diminuir estritamente da primeira para a última posição.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'A votação incremental não pode ser usada com o ranking ordenado.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'Selecione exatamente o número configurado de opções por ordem de preferência.',
	'AP_QUESTION' => 'Pergunta',
	'AP_QUESTION_REQUIRED' => 'Pergunta obrigatória',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'Exige uma resposta à primeira pergunta antes que o boletim completo possa ser enviado.',
	'AP_ADDITIONAL_QUESTIONS' => 'Páginas de perguntas adicionais',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => 'Cada página usa o mesmo tipo de enquete e as mesmas regras de limites, pontos, visibilidade e alteração de voto. Insira uma opção por linha.',
	'AP_ADD_QUESTION' => 'Adicionar pergunta',
	'AP_MULTI_INVALID' => 'Os dados das perguntas adicionais são inválidos.',
	'AP_MULTI_TOO_MANY' => 'Uma enquete pode conter no máximo 20 perguntas adicionais.',
	'AP_MULTI_CONTENT_INVALID' => 'Cada pergunta adicional precisa de um título e de opções válidas suficientes para os limites globais da enquete.',
	'AP_REQUIRED_QUESTION_MISSING' => 'Responda a esta pergunta obrigatória antes de continuar.',
	'AP_POLL_NAVIGATION' => 'Navegação pelas perguntas da enquete',
	'AP_POLL_MIN_VALUE' => 'Pontuação mínima',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'Esta é a pontuação mínima que um votante pode atribuir a uma opção selecionada.',
	'AP_VOTE_OUTSIDE_RANGE' => 'Cada pontuação atribuída deve estar entre os valores mínimo e máximo configurados.',
]);
