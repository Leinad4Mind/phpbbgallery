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
	'ACP_GALLERY_REMOTE_STORAGE_EXPLAIN' => 'Configura e verifica o armazenamento privado de objetos para os ficheiros da Galeria. Guardar estas definições não move ficheiros nem ativa o S3.',
	'ACL_A_GALLERY_REMOTE_STORAGE' => 'Pode gerir o armazenamento remoto da Galeria',
	'GALLERY_CORE_NOT_FOUND' => 'É necessária a extensão phpBB Gallery Core.',
	'REMOTE_STORAGE_ACTIVE_PROVIDER' => 'Provider de armazenamento ativo da Galeria: %s',
	'REMOTE_STORAGE_CONNECTION_FAILED' => 'O teste de ligação ao S3 falhou: %s',
	'REMOTE_STORAGE_ENVIRONMENT_OVERRIDES' => 'As seguintes variáveis de ambiente do processo substituem os valores do ACP. Os segredos fornecidos desta forma nunca são apresentados nem guardados pelo phpBB:',
	'REMOTE_STORAGE_MIGRATION' => 'Migração de provider',
	'REMOTE_STORAGE_MIGRATION_ABORT' => 'Abortar migração',
	'REMOTE_STORAGE_MIGRATION_ABORT_CONFIRM' => 'Abortar a migração de provider ativa? As cópias verificadas no destino serão mantidas, mas o provider de origem continuará ativo.',
	'REMOTE_STORAGE_MIGRATION_ABORTED' => 'A migração de provider foi abortada. O provider de origem continua ativo.',
	'REMOTE_STORAGE_MIGRATION_COMPLETE' => 'Todos os objetos enumerados foram copiados e verificados. O provider de destino está agora ativo; as cópias de origem foram mantidas para rollback.',
	'REMOTE_STORAGE_MIGRATION_CONTINUE' => 'Continuar migração',
	'REMOTE_STORAGE_MIGRATION_DIRECTION' => 'Direção: %1$s → %2$s',
	'REMOTE_STORAGE_MIGRATION_EXPLAIN' => 'Os ficheiros são copiados em lotes retomáveis. As alterações aos ficheiros da Galeria são espelhadas durante a operação, cada objeto é verificado por tamanho e SHA-256 e as cópias de origem são mantidas.',
	'REMOTE_STORAGE_MIGRATION_FAILED' => 'Não foi possível iniciar ou retomar a migração de provider: %s',
	'REMOTE_STORAGE_MIGRATION_PROGRESS' => 'Variante: %1$s. Copiados: %2$d; já idênticos: %3$d; tentativas falhadas: %4$d.',
	'REMOTE_STORAGE_MIGRATION_RETRY' => 'Repetir lote falhado',
	'REMOTE_STORAGE_MIGRATION_START' => 'Iniciar migração de provider',
	'REMOTE_STORAGE_MIGRATION_START_CONFIRM' => 'Iniciar a migração de provider? As alterações aos ficheiros da Galeria serão espelhadas nos dois providers até todos os objetos terem sido copiados e verificados.',
	'REMOTE_STORAGE_MIGRATION_TO' => 'Migrar para %s',
	'REMOTE_STORAGE_NOT_ACTIVE_UNTIL_MIGRATION' => 'O S3 permanecerá inativo até a migração controlada ser concluída. Isto evita que os ficheiros existentes da Galeria fiquem indisponíveis.',
	'REMOTE_STORAGE_REQUIREMENTS_MISSING' => 'O Armazenamento Remoto requer o cliente HTTP e o SimpleXML fornecidos por uma instalação phpBB suportada.',
	'REMOTE_STORAGE_S3_ACCESS_KEY' => 'Chave de acesso',
	'REMOTE_STORAGE_S3_BUCKET' => 'Bucket',
	'REMOTE_STORAGE_S3_ENDPOINT' => 'Endpoint S3',
	'REMOTE_STORAGE_S3_ENDPOINT_EXPLAIN' => 'Por exemplo, https://s3.eu-west-1.amazonaws.com ou o endpoint privado do MinIO/QNAP. Os redirecionamentos nunca são seguidos.',
	'REMOTE_STORAGE_S3_PREFIX' => 'Prefixo dos objetos',
	'REMOTE_STORAGE_S3_PREFIX_EXPLAIN' => 'Espaço de nomes privado utilizado dentro do bucket. Não deve ser partilhado com ficheiros sem relação com a Galeria.',
	'REMOTE_STORAGE_S3_REGION' => 'Região',
	'REMOTE_STORAGE_S3_REGION_EXPLAIN' => 'Utiliza a região exigida pelo serviço. Muitos providers compatíveis utilizam us-east-1.',
	'REMOTE_STORAGE_S3_SECRET_KEY' => 'Chave secreta',
	'REMOTE_STORAGE_S3_SETTINGS' => 'Ligação S3/S3-compatible',
	'REMOTE_STORAGE_SECRET_REQUIRED' => 'É necessária uma chave secreta ou a variável de ambiente PHPBBGALLERY_S3_SECRET_KEY.',
	'REMOTE_STORAGE_SECRET_RETAINED' => 'Deixa vazio para manter a chave secreta configurada.',
	'REMOTE_STORAGE_SETTINGS_SAVED' => 'A ligação ao S3 foi verificada e as definições foram guardadas. Nenhum ficheiro da Galeria foi movido.',
	'REMOTE_STORAGE_SETTINGS_LOCKED' => 'As definições da ligação S3 não podem ser alteradas enquanto estiver ativa uma migração de provider.',
	'REMOTE_STORAGE_TEST_AND_SAVE' => 'Testar ligação e guardar',
]);
