<?php

/**
 * @package phpbbgallery/exif for phpBB.
 * phpBB Gallery - ACP Exif Extension
 * @author    nickvergessen
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for Exif data
*/
$lang = array_merge($lang, [
	'EXIF_DATA'                => 'Dados Exif',
	'EXIF_APERTURE'            => 'Abertura (Número-F)',
	'EXIF_CAM_MODEL'           => 'Modelo da Câmara',
	'EXIF_DATE'                => 'Imagem capturada em',
	'EXIF_RESOLUTION'          => 'Densidade da resolução',
	'EXIF_EXPOSURE'            => 'Velocidade do obturador',
	'EXIF_EXPOSURE_EXP'        => '%s Seg',
	'EXIF_EXPOSURE_BIAS'       => 'Compensação de exposição',
	'EXIF_EXPOSURE_BIAS_EXP'   => '%s EV',
	'EXIF_EXPOSURE_PROG'       => 'Programa de exposição',
	'EXIF_EXPOSURE_PROG_0'     => 'Não definido',
	'EXIF_EXPOSURE_PROG_1'     => 'Manual',
	'EXIF_EXPOSURE_PROG_2'     => 'Programa Normal',
	'EXIF_EXPOSURE_PROG_3'     => 'Prioridade à Abertura',
	'EXIF_EXPOSURE_PROG_4'     => 'Prioridade ao Obturador',
	'EXIF_EXPOSURE_PROG_5'     => 'Programa Criativo (favorece profundidade de campo)',
	'EXIF_EXPOSURE_PROG_6'     => 'Programa de Ação (favorece velocidade do obturador alta)',
	'EXIF_EXPOSURE_PROG_7'     => 'Modo Retrato (fotos de perto com o fundo desfocado)',
	'EXIF_EXPOSURE_PROG_8'     => 'Modo Paisagem (fotos de paisagem com o fundo focado)',
	'EXIF_FLASH'               => 'Flash',
	'EXIF_FLASH_CASE_0'        => 'Flash não disparou',
	'EXIF_FLASH_CASE_1'        => 'Flash disparou',
	'EXIF_FLASH_CASE_5'        => 'luz de retorno não detetada',
	'EXIF_FLASH_CASE_7'        => 'luz de retorno detetada',
	'EXIF_FLASH_CASE_8'        => 'Ligado, Flash não disparou',
	'EXIF_FLASH_CASE_9'        => 'Flash disparou, modo flash forçado',
	'EXIF_FLASH_CASE_13'       => 'Flash disparou, modo flash forçado, luz de retorno não detetada',
	'EXIF_FLASH_CASE_15'       => 'Flash disparou, modo flash forçado, luz de retorno detetada',
	'EXIF_FLASH_CASE_16'       => 'Flash não disparou, modo flash forçado',
	'EXIF_FLASH_CASE_20'       => 'Desligado, Flash não disparou, luz de retorno não detetada',
	'EXIF_FLASH_CASE_24'       => 'Flash não disparou, modo auto',
	'EXIF_FLASH_CASE_25'       => 'Flash disparou, modo auto',
	'EXIF_FLASH_CASE_29'       => 'Flash disparou, modo auto, luz de retorno não detetada',
	'EXIF_FLASH_CASE_31'       => 'Flash disparou, modo auto, luz de retorno detetada',
	'EXIF_FLASH_CASE_32'       => 'Sem função de flash',
	'EXIF_FLASH_CASE_48'       => 'Desligado, Sem função de flash',
	'EXIF_FLASH_CASE_65'       => 'Flash disparou, modo redução de olhos vermelhos',
	'EXIF_FLASH_CASE_69'       => 'Flash disparou, modo redução de olhos vermelhos, luz de retorno não detetada',
	'EXIF_FLASH_CASE_71'       => 'Flash disparou, modo redução de olhos vermelhos, luz de retorno detetada',
	'EXIF_FLASH_CASE_73'       => 'Flash disparou, modo flash forçado, redução de olhos vermelhos',
	'EXIF_FLASH_CASE_77'       => 'Flash disparou, modo flash forçado, redução de olhos vermelhos, luz de retorno não detetada',
	'EXIF_FLASH_CASE_79'       => 'Flash disparou, modo flash forçado, redução de olhos vermelhos, luz de retorno detetada',
	'EXIF_FLASH_CASE_80'       => 'Desligado, Redução de olhos vermelhos',
	'EXIF_FLASH_CASE_88'       => 'Auto, Não disparou, Redução de olhos vermelhos',
	'EXIF_FLASH_CASE_89'       => 'Flash disparou, modo auto, redução de olhos vermelhos',
	'EXIF_FLASH_CASE_93'       => 'Flash disparou, modo auto, luz de retorno não detetada, redução de olhos vermelhos',
	'EXIF_FLASH_CASE_95'       => 'Flash disparou, modo auto, luz de retorno detetada, redução de olhos vermelhos',
	'EXIF_FOCAL'               => 'Distância focal',
	'EXIF_FOCAL_EXP'           => '%s mm',
	'EXIF_ISO'                 => 'Sensibilidade ISO',
	'EXIF_METERING_MODE'       => 'Modo de medição',
	'EXIF_METERING_MODE_0'     => 'Desconhecido',
	'EXIF_METERING_MODE_1'     => 'Média',
	'EXIF_METERING_MODE_2'     => 'Média com ponderação central',
	'EXIF_METERING_MODE_3'     => 'Ponto',
	'EXIF_METERING_MODE_4'     => 'Multi-ponto',
	'EXIF_METERING_MODE_5'     => 'Padrão',
	'EXIF_METERING_MODE_6'     => 'Parcial',
	'EXIF_METERING_MODE_255'   => 'Outro',
	'EXIF_NOT_AVAILABLE'       => 'não disponível',
	'EXIF_WHITEB'              => 'Balanço de brancos',
	'EXIF_WHITEB_AUTO'         => 'Auto',
	'EXIF_WHITEB_MANU'         => 'Manual',
	'DISP_EXIF_DATA'           => 'Mostrar Dados Exif',
	'DISP_EXIF_DATA_EXP'       => 'Esta funcionalidade não pode ser utilizada neste momento, porque a função necessária "exif_read_data" não está incluída na sua instalação do PHP.',
	'DISP_EXIF_DATE'           => 'Mostrar “Imagem captada em”',
	'DISP_EXIF_FOCAL'          => 'Mostrar distância focal',
	'DISP_EXIF_EXPOSURE'       => 'Mostrar velocidade do obturador',
	'DISP_EXIF_APERTURE'       => 'Mostrar abertura',
	'DISP_EXIF_ISO'            => 'Mostrar sensibilidade ISO',
	'DISP_EXIF_WHITEB'         => 'Mostrar equilíbrio de brancos',
	'DISP_EXIF_FLASH'          => 'Mostrar flash',
	'DISP_EXIF_CAM_MODEL'      => 'Mostrar modelo da câmara',
	'DISP_EXIF_RESOLUTION'     => 'Mostrar densidade da resolução',
	'DISP_EXIF_EXPOSURE_PROG'  => 'Mostrar programa de exposição',
	'DISP_EXIF_EXPOSURE_BIAS'  => 'Mostrar compensação de exposição',
	'DISP_EXIF_METERING_MODE'  => 'Mostrar modo de medição',
	'SHOW_EXIF'                => 'mostrar/ocultar',
	'VIEWEXIFS_DEFAULT'        => 'Ver Dados Exif por padrão',
	'GALLERY_CORE_NOT_FOUND'   => 'A extensão phpBB Gallery Core deve ser instalada e ativada primeiro.',
	'EXTENSION_ENABLE_SUCCESS' => 'A extensão foi ativada com sucesso.',
	'ACP_GALLERY_EXIF'           => 'Metadados EXIF',
	'ACP_GALLERY_EXIF_EXPLAIN'   => 'Gere as datas de captura indexadas utilizadas na ordenação da Galeria.',
	'ACP_EXIF_CAPTURE_INDEX'     => 'Índice de datas de captura',
	'ACP_EXIF_INDEXED_IMAGES'    => 'Imagens com data de captura indexada',
	'ACP_EXIF_SYNC_EXPLAIN'      => 'Reconstrói o índice a partir dos metadados EXIF guardados e, quando necessário, dos ficheiros JPEG originais. A operação decorre em pequenos lotes retomáveis.',
	'ACP_EXIF_SYNC_CONFIRM'      => 'Tens a certeza de que pretendes reconstruir o índice de datas de captura EXIF?',
	'ACP_EXIF_SYNC_PROGRESS'     => 'Sincronização EXIF em curso: %1$d imagens verificadas, %2$d datas de captura indexadas e %3$d ficheiros source temporariamente indisponíveis.',
	'DISP_EXIF_DATA_EXPLAIN' => 'Ativa globalmente a apresentação de EXIF. Quando desativada, as escolhas EXIF da página individual da imagem e dos cartões de miniaturas são ignoradas.',
	'EXIF_IMAGE_PAGE_FIELD_EXPLAIN' => 'Controla este valor apenas na página individual da imagem. Para o apresentar sob miniaturas, seleciona-o separadamente na definição de informações dos cartões correspondente.',
	'ACP_EXIF_SYNC_COMPLETE'     => 'Sincronização EXIF concluída: %1$d imagens verificadas, %2$d datas de captura indexadas e %3$d ficheiros source indisponíveis.',
]);
