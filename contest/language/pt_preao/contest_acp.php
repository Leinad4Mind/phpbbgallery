<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ALBUM_TYPE_CONTEST'                  => 'Concurso',
	'CONTEST_CREATION'                     => 'Permitir novos concursos',
	'CONTEST_CREATION_EXPLAIN'             => 'Permite aos administradores criar novos álbuns de concurso. Os concursos existentes permanecem activos e editáveis quando esta opção está desactivada.',
	'CONTEST_CREATION_DISABLED'            => 'A criação de novos álbuns de concurso está desactivada na configuração da Galeria.',
	'CONTEST_SCHEMA_OUTDATED'              => 'O esquema da base de dados do add-on Concursos está desactualizado. Executa as migrations do phpBB ou desactiva e volta a activar o add-on antes de criares ou editares um concurso.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'      => 'Um Álbum de Não-Concurso não pode ser transformado em um Álbum de Concurso.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE'    => 'Não é possível alterar o tipo de álbum devido à existência de um concurso neste álbum.',
	'CONTEST_DATE_EXPLAIN'                 => 'Tens de fornecer uma data e hora no formato AAAA-MM-DD HH:MM.',
	'CONTEST_END'                          => 'Término da Classificação e/ou Votação',
	'CONTEST_END_BEFORE_RATING'            => 'O fim do concurso não pode ser antes do início da votação do concurso.',
	'CONTEST_END_BEFORE_START'             => 'O concurso deverá terminar após o seu início.',
	'CONTEST_END_EXPLAIN'                  => 'Fim da classificação/votação (exibição dos resultados do concurso).',
	'CONTEST_END_INVALID'                  => 'Fim do concurso inválido (%s). Por favor, insere a data no formato AAAA-MM-DD HH:MM.',
	'CONTEST_RATING'                       => 'Início da votação',
	'CONTEST_RATING_BEFORE_START'          => 'O início da votação do concurso não pode ser antes do início do concurso.',
	'CONTEST_RATING_EXPLAIN'               => 'Após o "Início da votação", os utilizadores não podem mais fazer upload de imagens.',
	'CONTEST_RATING_INVALID'               => 'Votação do concurso inválida (%s). Por favor, insere a data no formato AAAA-MM-DD HH:MM.',
	'CONTEST_SETTINGS'                     => 'Configurações do concurso',
	'CONTEST_WINNER_THUMBNAIL'             => 'Usar miniaturas vencedoras dos concursos',
	'CONTEST_WINNER_THUMBNAIL_EXPLAIN'     => 'Após o fim de um concurso, usa por predefinição a imagem válida em primeiro lugar como miniatura do álbum. Cada concurso pode herdar ou substituir esta definição. Uma imagem de álbum configurada manualmente tem sempre prioridade.',
	'CONTEST_THUMBNAIL_POLICY'             => 'Miniatura do álbum após o concurso',
	'CONTEST_THUMBNAIL_POLICY_EXPLAIN'     => 'Controla apenas a miniatura na listagem de álbuns. A data, o autor e o estado de leitura da última imagem não são alterados.',
	'CONTEST_THUMBNAIL_INHERIT'            => 'Herdar a definição global',
	'CONTEST_THUMBNAIL_LAST'               => 'Usar a última imagem',
	'CONTEST_THUMBNAIL_WINNER'             => 'Usar a imagem vencedora após o fim do concurso',
	'CONTEST_START'                        => 'Início da Classificação/Votação',
	'CONTEST_START_EXPLAIN'                => 'A partir deste momento já não se permite adicionar qualquer imagem. A partir de agora e de acordo com as permissões fornecidas, poderá efectuar um comentário a quem desejar.',
	'CONTEST_START_INVALID'                => 'Início do concurso inválido (%s). Por favor, insere a data no formato AAAA-MM-DD HH:MM.',
]);
