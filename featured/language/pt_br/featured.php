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
	'FEATURED_SETTINGS' => 'Imagens em destaque e apresentação',
	'FEATURE_IMAGE' => 'Destacar imagem',
	'UNFEATURE_IMAGE' => 'Remover das imagens em destaque',
	'FEATURED_IMAGE_ADDED' => 'A imagem foi adicionada à seleção em destaque.',
	'FEATURED_IMAGE_REMOVED' => 'A imagem foi removida da seleção em destaque.',
	'FEATURED_NOT_AUTHORISED' => 'Você não tem autorização para gerenciar imagens em destaque neste álbum.',
	'FEATURED_APPROVED_ONLY' => 'Apenas imagens aprovadas podem ser destacadas.',
	'FEATURED_ENABLE' => 'Exibir imagens em destaque',
	'FEATURED_ENABLE_EXPLAIN' => 'Exibe no índice da Galeria a seleção organizada pelos moderadores.',
	'FEATURED_LOCATION' => 'Exibir em',
	'FEATURED_LOCATION_EXPLAIN' => 'Escolha se as imagens em destaque aparecem no índice da Galeria, no índice do fórum, nos dois ou em nenhum.',
	'FEATURED_LOCATION_NONE' => 'Nenhum índice',
	'FEATURED_LOCATION_GALLERY' => 'Índice da Galeria',
	'FEATURED_LOCATION_FORUM' => 'Índice do fórum',
	'FEATURED_LOCATION_BOTH' => 'Ambos os índices',
	'FEATURED_POSITION' => 'Posição no índice',
	'FEATURED_POSITION_EXPLAIN' => 'Coloca as imagens em destaque antes ou depois do conteúdo principal do índice. Esta configuração fica oculta quando nenhum índice é selecionado.',
	'FEATURED_POSITION_TOP' => 'Topo',
	'FEATURED_POSITION_BOTTOM' => 'Rodapé',
	'FEATURED_COUNT' => 'Quantidade de imagens em destaque',
	'FEATURED_COUNT_EXPLAIN' => 'Quantidade de imagens em destaque visíveis a exibir, de 1 a 20. As permissões são filtradas separadamente para cada visitante.',
	'FEATURED_SLIDESHOW' => 'Usar apresentação de slides',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Exibe uma imagem em destaque grande de cada vez com navegação acessível. Quando desativada, usa o layout de cartões configurado na Galeria.',
	'FEATURED_AUTOPLAY' => 'Iniciar a apresentação automaticamente',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'A reprodução automática é desativada para visitantes que solicitam movimento reduzido e sempre pode ser pausada.',
	'FEATURED_INTERVAL' => 'Intervalo da apresentação',
	'FEATURED_INTERVAL_EXPLAIN' => 'Tempo entre mudanças automáticas, de 3 a 30 segundos.',
	'FEATURED_INCLUDE_PERSONAL' => 'Incluir imagens de álbuns pessoais',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Permite exibir imagens selecionadas de álbuns pessoais quando o visitante tem permissão para vê-las.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Controles das imagens em destaque',
	'FEATURED_PREVIOUS' => 'Imagem em destaque anterior',
	'FEATURED_NEXT' => 'Próxima imagem em destaque',
	'FEATURED_PLAY' => 'Reproduzir apresentação',
	'FEATURED_PAUSE' => 'Pausar apresentação',
	'FEATURED_GO_TO' => 'Exibir imagem em destaque %d',
	'GALLERY_CORE_NOT_FOUND' => 'O Gallery Core 4.2.0 ou posterior deve estar instalado e ativado antes de ativar Imagens em destaque.',
]);
