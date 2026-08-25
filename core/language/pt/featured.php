<?php
/**
 * phpBB Gallery - Featured Images language.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'FEATURED_IMAGES' => 'Imagens em destaque',
	'FEATURED_SETTINGS' => 'Imagens em destaque e slideshow',
	'FEATURE_IMAGE' => 'Destacar imagem',
	'UNFEATURE_IMAGE' => 'Remover das imagens em destaque',
	'FEATURED_IMAGE_ADDED' => 'A imagem foi adicionada à seleção em destaque.',
	'FEATURED_IMAGE_REMOVED' => 'A imagem foi removida da seleção em destaque.',
	'FEATURED_NOT_AUTHORISED' => 'Não estás autorizado a gerir imagens em destaque neste álbum.',
	'FEATURED_APPROVED_ONLY' => 'Apenas imagens aprovadas podem ser destacadas.',
	'FEATURED_ENABLE' => 'Apresentar imagens em destaque',
	'FEATURED_ENABLE_EXPLAIN' => 'Apresenta no índice da Galeria a seleção feita pela moderação.',
	'FEATURED_LOCATION' => 'Apresentar em',
	'FEATURED_LOCATION_EXPLAIN' => 'Escolhe se as imagens em destaque aparecem no índice da Galeria, no índice do fórum, em ambos ou em nenhum.',
	'FEATURED_LOCATION_NONE' => 'Nenhum índice',
	'FEATURED_LOCATION_GALLERY' => 'Índice da Galeria',
	'FEATURED_LOCATION_FORUM' => 'Índice do fórum',
	'FEATURED_LOCATION_BOTH' => 'Ambos os índices',
	'FEATURED_POSITION' => 'Posição no índice',
	'FEATURED_POSITION_EXPLAIN' => 'Coloca as imagens em destaque antes ou depois do conteúdo principal do índice. Esta definição fica oculta quando não está selecionado nenhum índice.',
	'FEATURED_POSITION_TOP' => 'Topo',
	'FEATURED_POSITION_BOTTOM' => 'Fundo',
	'FEATURED_COUNT' => 'Número de imagens em destaque',
	'FEATURED_COUNT_EXPLAIN' => 'Número de imagens em destaque visíveis a apresentar, entre 1 e 20. As permissões são filtradas separadamente para cada utilizador.',
	'FEATURED_SLIDESHOW' => 'Usar apresentação em slideshow',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Apresenta uma imagem em destaque ampliada de cada vez, com navegação acessível. Quando desativado, usa o layout de cartões configurado na Galeria.',
	'FEATURED_AUTOPLAY' => 'Iniciar o slideshow automaticamente',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'A reprodução automática é desativada para quem pede movimento reduzido e pode ser sempre colocada em pausa.',
	'FEATURED_INTERVAL' => 'Intervalo do slideshow',
	'FEATURED_INTERVAL_EXPLAIN' => 'Tempo entre mudanças automáticas, entre 3 e 30 segundos.',
	'FEATURED_INCLUDE_PERSONAL' => 'Incluir imagens de álbuns pessoais',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Permite apresentar imagens selecionadas de álbuns pessoais quando o utilizador tem permissão para as ver.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Controlos das imagens em destaque',
	'FEATURED_PREVIOUS' => 'Imagem em destaque anterior',
	'FEATURED_NEXT' => 'Imagem em destaque seguinte',
	'FEATURED_PLAY' => 'Reproduzir slideshow',
	'FEATURED_PAUSE' => 'Colocar slideshow em pausa',
	'FEATURED_GO_TO' => 'Apresentar imagem em destaque %d',
	'GALLERY_CORE_NOT_FOUND' => 'O Gallery Core 4.2.0 ou superior tem de estar instalado e ativo antes de ativar as Imagens em Destaque.',
]);
