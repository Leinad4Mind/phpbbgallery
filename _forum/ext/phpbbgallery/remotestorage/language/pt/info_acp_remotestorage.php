<?php
/**
 * phpBB Gallery - Remote Storage language
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'ACP_GALLERY_REMOTE_STORAGE' => 'Armazenamento remoto',
	'ACP_GALLERY_REMOTE_STORAGE_EXPLAIN' => 'Configura e verifica o armazenamento privado de objectos para os ficheiros da Galeria. Guardar estas definições não move ficheiros nem activa o S3.',
	'ACL_A_GALLERY_REMOTE_STORAGE' => 'Pode gerir o armazenamento remoto da Galeria',
	'GALLERY_CORE_NOT_FOUND' => 'É necessária a extensão phpBB Gallery Core.',
	'REMOTE_STORAGE_ACTIVE_PROVIDER' => 'Provider de armazenamento activo da Galeria: %s',
	'REMOTE_STORAGE_CONNECTION_FAILED' => 'O teste de ligação ao S3 falhou: %s',
	'REMOTE_STORAGE_ENVIRONMENT_OVERRIDES' => 'As seguintes variáveis de ambiente do processo substituem os valores do ACP. Os segredos fornecidos desta forma nunca são apresentados nem guardados pelo phpBB:',
	'REMOTE_STORAGE_NOT_ACTIVE_UNTIL_MIGRATION' => 'O S3 permanecerá inactivo até a migração controlada ser concluída. Isto evita que os ficheiros existentes da Galeria fiquem indisponíveis.',
	'REMOTE_STORAGE_REQUIREMENTS_MISSING' => 'O Armazenamento Remoto requer o cliente HTTP e o SimpleXML fornecidos por uma instalação phpBB suportada.',
	'REMOTE_STORAGE_S3_ACCESS_KEY' => 'Chave de acesso',
	'REMOTE_STORAGE_S3_BUCKET' => 'Bucket',
	'REMOTE_STORAGE_S3_ENDPOINT' => 'Endpoint S3',
	'REMOTE_STORAGE_S3_ENDPOINT_EXPLAIN' => 'Por exemplo, https://s3.eu-west-1.amazonaws.com ou o endpoint privado do MinIO/QNAP. Os redireccionamentos nunca são seguidos.',
	'REMOTE_STORAGE_S3_PREFIX' => 'Prefixo dos objectos',
	'REMOTE_STORAGE_S3_PREFIX_EXPLAIN' => 'Espaço de nomes privado utilizado dentro do bucket. Não deve ser partilhado com ficheiros sem relação com a Galeria.',
	'REMOTE_STORAGE_S3_REGION' => 'Região',
	'REMOTE_STORAGE_S3_REGION_EXPLAIN' => 'Utiliza a região exigida pelo serviço. Muitos providers compatíveis utilizam us-east-1.',
	'REMOTE_STORAGE_S3_SECRET_KEY' => 'Chave secreta',
	'REMOTE_STORAGE_S3_SETTINGS' => 'Ligação S3/S3-compatible',
	'REMOTE_STORAGE_SECRET_REQUIRED' => 'É necessária uma chave secreta ou a variável de ambiente PHPBBGALLERY_S3_SECRET_KEY.',
	'REMOTE_STORAGE_SECRET_RETAINED' => 'Deixa vazio para manter a chave secreta configurada.',
	'REMOTE_STORAGE_SETTINGS_SAVED' => 'A ligação ao S3 foi verificada e as definições foram guardadas. Nenhum ficheiro da Galeria foi movido.',
	'REMOTE_STORAGE_TEST_AND_SAVE' => 'Testar ligação e guardar',
]);
