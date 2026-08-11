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
	'CONTEST_CREATION_EXPLAIN'             => 'Permite que os administradores criem novos álbuns de concurso. Os concursos existentes permanecem ativos e editáveis quando esta opção está desativada.',
	'CONTEST_CREATION_DISABLED'            => 'A criação de novos álbuns de concurso está desativada na configuração da Galeria.',
	'CONTEST_SCHEMA_OUTDATED'              => 'O esquema do banco de dados do complemento Concursos está desatualizado. Execute as migrations do phpBB ou desative e reative o complemento antes de criar ou editar um concurso.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'      => 'Um Álbum de Não-Concurso não pode ser transformado em um Álbum de Concurso.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE'    => 'Não é possível alterar o tipo de álbum devido à existência de um concurso neste álbum.',
	'CONTEST_DATE_EXPLAIN'                 => 'Selecione a data e a hora. É usado o fuso horário configurado no seu perfil do phpBB.',
	'CONTEST_END'                          => 'Término da Classificação e/ou Votação',
	'CONTEST_END_BEFORE_RATING'            => 'O fim do concurso não pode ser antes do início da votação do concurso.',
	'CONTEST_END_BEFORE_START'             => 'O concurso deve terminar depois de começar.',
	'CONTEST_END_EXPLAIN'                  => 'Fim da classificação/votação (exibição dos resultados do concurso).',
	'CONTEST_END_INVALID'                  => 'Fim do concurso inválido (%s). Selecione uma data e hora válidas.',
	'CONTEST_RATING'                       => 'Início da votação',
	'CONTEST_RATING_BEFORE_START'          => 'O início da votação do concurso não pode ser antes do início do concurso.',
	'CONTEST_RATING_EXPLAIN'               => 'Após o "Início da votação", os usuários não podem mais fazer upload de imagens.',
	'CONTEST_RATING_INVALID'               => 'Início da votação inválido (%s). Selecione uma data e hora válidas.',
	'CONTEST_SETTINGS'                     => 'Configurações do concurso',
	'CONTEST_WINNER_THUMBNAIL'             => 'Usar miniaturas vencedoras dos concursos',
	'CONTEST_WINNER_THUMBNAIL_EXPLAIN'     => 'Após o fim de um concurso, usa por padrão a imagem válida em primeiro lugar como miniatura do álbum. Cada concurso pode herdar ou substituir esta configuração. Uma imagem de álbum configurada manualmente sempre tem prioridade.',
	'CONTEST_THUMBNAIL_POLICY'             => 'Miniatura do álbum após o concurso',
	'CONTEST_THUMBNAIL_POLICY_EXPLAIN'     => 'Controla apenas a miniatura na lista de álbuns. A data, o autor e o estado de leitura da última imagem não são alterados.',
	'CONTEST_THUMBNAIL_INHERIT'            => 'Herdar a configuração global',
	'CONTEST_THUMBNAIL_LAST'               => 'Usar a última imagem',
	'CONTEST_THUMBNAIL_WINNER'             => 'Usar a imagem vencedora após o fim do concurso',
	'CONTEST_START'                        => 'Início da Classificação/Votação',
	'CONTEST_START_EXPLAIN'                => 'A partir deste momento, não será possível adicionar imagens. De acordo com as permissões, você ainda poderá publicar comentários.',
	'CONTEST_START_INVALID'                => 'Início do concurso inválido (%s). Selecione uma data e hora válidas.',
]);
