<?php

/**
 * BBCore DB Addon
 * @copyright (c) 2020 SiteSplat. All rights reserved.
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	return;
}

if (empty($addon_lang))
{
	$addon_lang = [];
}

$addon_lang = array_merge($addon_lang, [
	'DBXTRA_TITLE'       => 'Gestor de Base de Dados BBCore',
	'DBXTRA_ENGINE_DESC' => 'Os dois tipos mais comuns de motores de armazenamento MySQL/MariaDB são <strong>MyISAM</strong> e <strong>InnoDB</strong>. O MariaDB também suporta um motor designado <strong>Aria</strong>, que é extremamente semelhante ao MyISAM, sendo agrupados em conjunto nesta extensão.<br><br>
								Tabelas MyISAM podem ser facilmente migradas e não requerem muita memória ou espaço em disco. No entanto, têm tendência para ficarem fragmentadas quando atualizadas com muita regularidade, o que pode originar problemas numa tabela, ao ponto de corromper. As tabelas InnoDB são por sua vez mais rápidas, consistentes e estáveis, embora não sejam muito recomendadas se existirem migrações regulares de alojamento (apesar de possíveis claro), para além disso elas usam o dobro da memória e do espaço em disco em comparação com tabelas MyISAM.
								As tabelas MyISAM também são melhores quando as "queries" dependem da função de "LIMIT", sendo muito utilizada na criação da paginação.<br><br>
								Para o phpBB, as tabelas config e sessions deverão usar de preferência um tipo InnoDB pois sofrem atualizações constantes. Por seu lado as tabelas topics, posts e privmsgs deveriam possuir o motor MyISAM já que utilizam e tiram enorme partido de ações do tipo LIMIT.
								As restantes tabelas não afetam tanto, pelo que podem manter os seus formatos padrão/originais.',
	'DBXTRA_NO_INNODB'  => '<strong>A tabela "%s" deverá preferencialmente utilizar um motor do tipo InnoDB.</strong><br>',
	'DBXTRA_NO_MYISAM'  => '<strong>A tabela "%s" deverá preferencialmente utilizar um motor do tipo MyISAM.</strong><br>',
	'DBXTRA_FIX_INNODB' => 'Converter Para InnoDB',
	'DBXTRA_FIX_MYISAM' => 'Uma vez que estas três tabelas podem ser bastante pesadas e complexas, não é propriamente seguro de as converter em MyISAM diretamente a partir do seu phpBB (devido a configurações PHP por parte dos servidores/alojamentos que muitas das vezes corrompem processos a meio devido a tempo de limite etc). Recomendamos e advertimos que para uma conversão bem sucedida o faça de preferência via phpMyAdmin, ou se estiver muito à vontade use os comandos/linhas de <strong>mysql</strong> via terminal/consola.',
	'DBXTRA_OPTIMIZE'   => 'As opções para <strong>Otimizar MyISAM</strong> e <strong>Otimizar InnoDB</strong> irão reconstruir e desfragmentar as tabelas listadas, tornando assim possível tirar e maximizar as suas performances e a poupança em espaço.
								Consoante o tipo do seu sistema bem como das respetivas bases de dados, poderá ver ambas as opções ou então apenas uma. Por questões de segurança as opções não estarão disponíveis/visíveis se as tabelas da sua base de dados superarem o limite da segurança via phpBB de forma a evitar instabilidade/corromper.
								Devido a limitações de MySQL/MariaDB, a opção para <strong>Otimizar InnoDB</strong> ficará visível logo após o mesmo ter sido utilizado. Muito importante, não faça uso ou abuse uma segunda vez desta mesma opção! <strong>Tratamento e/ou alterações das tabelas de dados deverá ser sempre levado de forma externa e independente em relação ao seu phpBB, preferencialmente via phpMyAdmin ou com recurso a terminais de comando mysql.</strong>',
	'DBXTRA_ANALYZE'      => 'O botão <strong>Analisar</strong> irá fazer o check-up e otimizar as tabelas listadas resultando no aumento da velocidade das "queries". Embora o processo seja menos perigoso do que utilizar a função de Otimizar, considere a utilização do seu phpMyAdmin caso a base de dados em causa seja superior ou muito perto de limites do tipo 1GB ou superior.',
	'DBXTRA_DOWNLOAD'     => 'Pode efetuar o download/transferência e baixar na íntegra a sua base de dados comprimida em "GZip archive" carregando para isso no botão de <strong>Download</strong>. Ao contrário da versão padrão nativa, todas as tabelas em absoluto serão incluídas. Note que este processo pode demorar e é desaconselhado se estiver sob ligações muito curtas/fracas assim como a base de dados que estiver a extrair for superior a limites do tipo 1GB ou superior.',
	'DBXTRA_BTN_OPTINNO'  => 'Otimizar InnoDB',
	'DBXTRA_BTN_OPTISAM'  => 'Otimizar MyISAM',
	'DBXTRA_BTN_ANALYZE'  => 'Analisar',
	'DBXTRA_BTN_DOWNLOAD' => 'Download',
	'DBXTRA_OK_OPTIMIZE'  => 'As tabelas foram otimizadas.',
	'DBXTRA_OK_ANALYZE'   => 'As tabelas foram analisadas.',
	'DBXTRA_OK_INNODB'    => 'O(s) motor(es) de armazenamento foram convertidos para InnoDB.',
]);
