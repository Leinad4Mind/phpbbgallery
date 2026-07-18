-- Script de Migracao para correcao de maiusculas da extensao brunoais/readOthersTopics
-- Apenas correr isto no seu gestor de base de dados (ex: phpMyAdmin) ANTES ou DEPOIS de substituir a pasta por brunoais/readotherstopics

-- 1. Atualizar o nome da extensao na tabela phpbb_ext
UPDATE phpbb_ext 
SET ext_name = 'brunoais/readotherstopics' 
WHERE ext_name = 'brunoais/readOthersTopics';

-- 2. Atualizar o registo da migration na tabela phpbb_migrations
UPDATE phpbb_migrations 
SET migration_name = '\\brunoais\\readotherstopics\\migrations\\initial_release' 
WHERE migration_name = '\\brunoais\\readOthersTopics\\migrations\\initial_release';
