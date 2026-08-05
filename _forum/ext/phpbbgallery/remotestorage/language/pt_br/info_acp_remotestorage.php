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
	'ACP_GALLERY_REMOTE_STORAGE_EXPLAIN' => 'Configure e verifique provedores de armazenamento remoto privado para os arquivos da Galeria. Salvar configurações não move nem expõe os arquivos existentes.',
	'ACL_A_GALLERY_REMOTE_STORAGE' => 'Pode gerenciar o armazenamento remoto da Galeria',
	'GALLERY_CORE_NOT_FOUND' => 'A extensão phpBB Gallery Core é necessária.',
	'REMOTE_STORAGE_ACTIVE_PROVIDER' => 'Provedor de armazenamento ativo da Galeria: %s',
	'REMOTE_STORAGE_CONNECTION_FAILED' => 'O teste de conexão com o armazenamento remoto falhou: %s',
	'REMOTE_STORAGE_ENVIRONMENT_OVERRIDES' => 'As seguintes variáveis de ambiente do processo substituem seus valores no ACP. Os segredos fornecidos desta forma nunca são exibidos nem armazenados pelo phpBB:',
	'REMOTE_STORAGE_MIGRATION' => 'Migração de provedor',
	'REMOTE_STORAGE_MIGRATION_ABORT' => 'Abortar migração',
	'REMOTE_STORAGE_MIGRATION_ABORT_CONFIRM' => 'Abortar a migração de provedor ativa? As cópias verificadas no destino serão mantidas, mas o provedor de origem continuará ativo.',
	'REMOTE_STORAGE_MIGRATION_ABORTED' => 'A migração de provedor foi abortada. O provedor de origem continua ativo.',
	'REMOTE_STORAGE_MIGRATION_COMPLETE' => 'Todos os objetos enumerados foram copiados e verificados. O provedor de destino agora está ativo; as cópias de origem foram mantidas para reversão.',
	'REMOTE_STORAGE_MIGRATION_CONTINUE' => 'Continuar migração',
	'REMOTE_STORAGE_MIGRATION_DIRECTION' => 'Direção: %1$s → %2$s',
	'REMOTE_STORAGE_MIGRATION_EXPLAIN' => 'Os arquivos são copiados em lotes retomáveis. As alterações nos arquivos da Galeria são espelhadas durante a operação, cada objeto é verificado por tamanho e SHA-256 e as cópias de origem são mantidas.',
	'REMOTE_STORAGE_MIGRATION_FAILED' => 'Não foi possível iniciar ou retomar a migração de provedor: %s',
	'REMOTE_STORAGE_MIGRATION_PROGRESS' => 'Variante: %1$s. Copiados: %2$d; já idênticos: %3$d; tentativas com falha: %4$d.',
	'REMOTE_STORAGE_MIGRATION_RETRY' => 'Tentar novamente o lote com falha',
	'REMOTE_STORAGE_MIGRATION_START' => 'Iniciar migração de provedor',
	'REMOTE_STORAGE_MIGRATION_START_CONFIRM' => 'Iniciar a migração de provedor? As alterações nos arquivos da Galeria serão espelhadas nos dois provedores até que todos os objetos tenham sido copiados e verificados.',
	'REMOTE_STORAGE_MIGRATION_TO' => 'Migrar para %s',
	'REMOTE_STORAGE_NOT_ACTIVE_UNTIL_MIGRATION' => 'Um provedor remoto configurado permanece inativo até a migração controlada ser concluída. Isso evita que os arquivos existentes da Galeria fiquem indisponíveis.',
	'REMOTE_STORAGE_REQUIREMENTS_MISSING' => 'O Armazenamento Remoto requer o cliente HTTP e o SimpleXML fornecidos por uma instalação phpBB compatível.',
	'REMOTE_STORAGE_S3_ACCESS_KEY' => 'Chave de acesso',
	'REMOTE_STORAGE_S3_BUCKET' => 'Bucket',
	'REMOTE_STORAGE_S3_ENDPOINT' => 'Endpoint S3',
	'REMOTE_STORAGE_S3_ENDPOINT_EXPLAIN' => 'Por exemplo, https://s3.eu-west-1.amazonaws.com ou o endpoint privado do MinIO/QNAP. Redirecionamentos nunca são seguidos.',
	'REMOTE_STORAGE_S3_PREFIX' => 'Prefixo dos objetos',
	'REMOTE_STORAGE_S3_PREFIX_EXPLAIN' => 'Namespace privado usado dentro do bucket. Ele não deve ser compartilhado com arquivos não relacionados.',
	'REMOTE_STORAGE_S3_REGION' => 'Região',
	'REMOTE_STORAGE_S3_REGION_EXPLAIN' => 'Use a região exigida pelo serviço. Muitos provedores compatíveis usam us-east-1.',
	'REMOTE_STORAGE_S3_SECRET_KEY' => 'Chave secreta',
	'REMOTE_STORAGE_S3_SETTINGS' => 'Conexão S3/compatível com S3',
	'REMOTE_STORAGE_SECRET_REQUIRED' => 'É necessária uma credencial do provedor ou a variável de ambiente correspondente.',
	'REMOTE_STORAGE_SECRET_RETAINED' => 'Deixe em branco para manter a chave secreta configurada.',
	'REMOTE_STORAGE_SETTINGS_SAVED' => 'A conexão com o armazenamento remoto foi verificada e as configurações foram salvas. Nenhum arquivo da Galeria foi movido.',
	'REMOTE_STORAGE_SETTINGS_LOCKED' => 'As configurações dos provedores remotos não podem ser alteradas enquanto uma migração estiver ativa.',
	'REMOTE_STORAGE_TEST_AND_SAVE' => 'Testar conexão e salvar',
	'REMOTE_STORAGE_AZURE_ACCOUNT' => 'Nome da conta de armazenamento',
	'REMOTE_STORAGE_AZURE_ACCOUNT_KEY' => 'Chave da conta de armazenamento',
	'REMOTE_STORAGE_AZURE_CONTAINER' => 'Contêiner privado de blobs',
	'REMOTE_STORAGE_AZURE_ENDPOINT' => 'Endpoint do serviço Blob',
	'REMOTE_STORAGE_AZURE_ENDPOINT_EXPLAIN' => 'Normalmente https://conta.blob.core.windows.net. Endpoints personalizados podem ser usados com serviços locais compatíveis; redirecionamentos nunca são seguidos.',
	'REMOTE_STORAGE_AZURE_PREFIX' => 'Prefixo dos objetos',
	'REMOTE_STORAGE_AZURE_PREFIX_EXPLAIN' => 'Namespace privado usado dentro do contêiner. Ele não deve ser compartilhado com arquivos não relacionados à Galeria.',
	'REMOTE_STORAGE_AZURE_SETTINGS' => 'Conexão com o Azure Blob Storage',
	'REMOTE_STORAGE_LOCAL' => 'Armazenamento local do servidor',
	'REMOTE_STORAGE_MIGRATION_TARGET' => 'Provedor de destino',
	'REMOTE_STORAGE_MIGRATION_TARGET_INVALID' => 'O provedor de destino selecionado é inválido ou já está ativo.',
]);
