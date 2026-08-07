<?php

/**
 * Advanced Polls [English]
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
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
	'AP_DELETED_USER'         => 'Utilizador eliminado',

	'AP_POLL_CANT_VOTE'              => 'Não podes votar nesta votação. Razão',
	'AP_POLL_REASON_NOT_POSTED'      => 'Não escreveste neste tópico.',
	'AP_POLL_VOTES_ARE_VISIBLE'      => 'Tem em conta que se votares, o teu voto será visível.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS' => 'Não quero votar, quero ver os resultados',
	'AP_POLL_RESULTS_ARE_ORDERED'    => 'Os resultados estão ordenados por número decrescente de votos recebidos.',
	'AP_POLL_TYPE_MISMATCH'          => 'Dados inconsistentes na votação, erro interno.',
	'AP_VOTE_CHANGED'                => 'Não tens permissão para alterar os votos já emitidos.',
	'AP_TOO_MANY_VOTES'              => 'Tentaste adicionar demasiados votos.',
	'AP_ABSTAINERS'                  => 'Optaram por não votar',
	'AP_DELETE_VOTE'                 => 'Eliminar o meu voto',

	'AP_MAX_VOTES_SELECT' => [
		1 => 'Podes enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
		2 => 'Podes enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
	],
	'AP_GUEST_VOTES' => [
		1 => '%d voto de convidado',
		2 => '%d votos de convidados',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d voto',
		2 => '%d votos',
	],
	'AP_SCORE_BREAKDOWN' => 'Distribuição dos votos',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d voto de %2$d ponto',
		2 => '%1$d votos de %2$d pontos',
	],
	'AP_RANK_TOTAL' => [1 => '%d ponto', 2 => '%d pontos'],
	'AP_RANK_BREAKDOWN' => 'Detalhe do ranking',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%1$d voto na posição %2$d', 2 => '%1$d votos na posição %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Seleciona exatamente %d opção por ordem de preferência.',
		2 => 'Seleciona exatamente %d opções por ordem de preferência.',
	],
// Posting
	'AP_POLL_TYPE' => 'Tipo de votação',
	'AP_POLL_TYPE_EXPLAIN' => 'Escolhe como os utilizadores atribuem os seus votos ou pontos.',
	'AP_POLL_TYPE_CHOICE' => 'Escolha',
	'AP_POLL_TYPE_SCORING' => 'Pontuação numérica',
	'AP_POLL_TYPE_RANKING' => 'Ranking ordenado',
	'AP_POLL_VISIBILITY'                    => 'Visibilidade dos resultados',
	'AP_POLL_VISIBILITY_EXPLAIN'            => 'Escolhe quando os resultados agregados da votação ficam visíveis.',
	'AP_VISIBILITY_PUBLIC'                  => 'Pública — mostrar sempre os resultados',
	'AP_VISIBILITY_DEFAULT'                 => 'Após o primeiro voto',
	'AP_VISIBILITY_VOTE_COMPLETED'          => 'Após usar todos os votos disponíveis',
	'AP_VISIBILITY_PRIVATE'                 => 'Privada — apenas após o fim da votação',
	'AP_POLL_VOTE_MODE'                     => 'Alteração do voto',
	'AP_POLL_VOTE_MODE_EXPLAIN'             => 'Escolhe se os votos são definitivos, podem ser enviados de forma incremental ou alterados enquanto a votação estiver aberta.',
	'AP_VOTE_MODE_NO_CHANGE'                => 'Sem alterações',
	'AP_VOTE_MODE_INCREMENTAL'              => 'Votação incremental',
	'AP_VOTE_MODE_CHANGE'                   => 'Permitir alterações',
	'AP_POLL_VOTES_HIDE'           => 'Ocultar votos',
	'AP_POLL_VOTES_HIDE_EXPLAIN'   => 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
	'AP_POLL_VOTERS_SHOW'          => 'Mostrar votantes da votação',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'  => 'Se estiver ativado, os votantes serão mostrados a quem tenha permissões. Tem em conta que os votantes estarão ocultos caso os votos estejam ocultos.',
	'AP_POLL_VOTERS_LIMIT'         => 'Limite de votos',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN' => 'Se estiver ativado, os utilizadores habilitados só podem votar se escreveram neste tópico.',
	'AP_POLL_SHOW_ORDERED'         => 'Ordenar resultados',
	'AP_POLL_SHOW_ORDERED_EXPLAIN' => 'Quando se mostram os resultados, estes se ordenam por número decrescente de votos recebidos (o mais votado primeiro). Em caso contrário, usa-se a ordem de opções na votação.',
	'AP_POLL_COLLAPSIBLE' => 'Sondagem recolhível',
	'AP_POLL_COLLAPSIBLE_EXPLAIN' => 'Permite aos utilizadores recolher e expandir esta sondagem.',
	'AP_COLLAPSE_POLL' => 'Recolher sondagem',
	'AP_EXPAND_POLL' => 'Expandir sondagem',
	'AP_RUN_POLL'                  => 'Realizar votação',
	'AP_RUN_POLL_FOR'              => 'durante',
	'AP_RUN_POLL_UNTIL'            => 'até',
	'AP_RUN_POLL_INDEFINITELY'     => 'indefinidamente',
	'AP_POLL_END'                  => 'Fim da votação',
	'AP_POLL_END_EXPLAIN'          => 'Especifica a data e hora do término da votação. Caso se especifique um destes campos, não teremos em conta a duração da votação. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso se queira voltar a utilizar a duração, terás de apagar o conteúdo de todos estes campos.',

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
	'AP_RANK_POINTS_EXPLAIN' => 'Define um valor positivo e decrescente para cada posição. O número de posições é controlado pelo máximo de opções por utilizador.',
	'AP_RANK_POSITION' => 'Posição %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE' => 'Não podes escolher um número de votos superior ao máximo permitido.',
	'AP_POLL_VALUES_INVALID' => 'A pontuação mínima não pode exceder a máxima; o máximo de opções, a pontuação máxima e a pontuação total têm de ser superiores a zero.',
	'AP_RANK_POSITIONS_INVALID' => 'O número de posições tem de estar entre 1 e o número de opções da votação.',
	'AP_RANK_POINTS_INCOMPLETE' => 'Define um valor de pontos para cada posição.',
	'AP_RANK_POINTS_INVALID' => 'Cada valor de pontos tem de estar entre 1 e 999.',
	'AP_RANK_POINTS_ORDER' => 'Os pontos têm de diminuir estritamente da primeira para a última posição.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'A votação incremental não pode ser utilizada com o ranking ordenado.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'Seleciona exatamente o número configurado de opções por ordem de preferência.',
	'AP_QUESTION' => 'Pergunta',
	'AP_QUESTION_REQUIRED' => 'Pergunta obrigatória',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'Exige uma resposta à primeira pergunta antes de ser possível submeter o boletim completo.',
	'AP_APPEND_OPTIONS' => 'Adicionar opções sem repor os votos',
	'AP_APPEND_OPTIONS_EXPLAIN' => 'Conserva todos os votos existentes e adiciona apenas as novas opções no fim da lista de opções de uma pergunta.',
	'AP_APPEND_OPTIONS_WARNING' => 'As perguntas e opções existentes não podem ser renomeadas, removidas ou reordenadas. As alterações de voto têm de ser permitidas. Os utilizadores registados elegíveis que já votaram serão notificados de acordo com a definição do PCA e as respetivas preferências de notificação.',
	'AP_APPEND_INVALID' => 'Não é possível adicionar opções a esta votação de forma segura.',
	'AP_APPEND_REQUIRES_CHANGES' => 'Permite alterar o voto antes de adicionar opções sem repor os votos existentes.',
	'AP_APPEND_POLL_ENDED' => 'Não é possível adicionar opções sem repor os votos depois de a votação terminar.',
	'AP_APPEND_STRUCTURE_CHANGED' => 'Foram alteradas perguntas ou opções existentes. Restaura a definição original e adiciona as novas opções apenas no fim.',
	'AP_APPEND_TOO_MANY' => 'As opções adicionadas excedem o número máximo configurado de opções da votação.',
	'AP_APPEND_NONE' => 'Não foi adicionada nenhuma opção nova à votação.',
	'AP_ADDITIONAL_QUESTIONS' => 'Páginas de perguntas adicionais',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => 'Cada página utiliza o mesmo tipo de votação e as mesmas regras de limites, pontos, visibilidade e alteração de voto. Introduza uma opção por linha.',
	'AP_ADD_QUESTION' => 'Adicionar pergunta',
	'AP_MULTI_INVALID' => 'Os dados das perguntas adicionais são inválidos.',
	'AP_MULTI_TOO_MANY' => 'Uma votação pode conter, no máximo, 20 perguntas adicionais.',
	'AP_MULTI_CONTENT_INVALID' => 'Cada pergunta adicional precisa de um título e de opções válidas suficientes para os limites globais da votação.',
	'AP_REQUIRED_QUESTION_MISSING' => 'Responda a esta pergunta obrigatória antes de continuar.',
	'AP_POLL_NAVIGATION' => 'Navegação pelas perguntas da votação',
	'AP_POLL_MIN_VALUE' => 'Pontuação mínima',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'Esta é a pontuação mínima que um votante pode atribuir a uma opção selecionada.',
	'AP_VOTE_OUTSIDE_RANGE' => 'Cada pontuação atribuída tem de estar entre os valores mínimo e máximo configurados.',
]);
