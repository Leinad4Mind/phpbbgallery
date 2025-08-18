<?php
/**
 * ---------------------------------------------------------------------
   
   phpBBDumper]
   http://phpbb3-support.square7.ch/

   Copyright (c) 2025 by Mahony
   ----------------------------------------------------------------------
   Based on:
   
   MyOOS [Dumper]
    Copyright (c) 2013 - 2023 by the MyOOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   MySqlDumper
   https://www.mysqldumper.de

   Copyright (C)2004-2011 Daniel Schlichtholz (admin@mysqldumper.de)
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ----------------------------------------------------------------------
 */

/* ensure this file is being included by a parent file */
defined('OOS_VALID_MOD') or exit('Direct Access to this location is not allowed.');

require './inc/functions_global.php';

//Buffer fuer Multipart-Filesizepruefung
$buffer = 10 * 1024;

function new_file($last_groesse = 0)
{
    global $dump, $databases, $config, $out, $lang, $nl, $mysql_commentstring;

    // Dateiname aus Datum und Uhrzeit bilden
    if ($dump['part'] - $dump['part_offset'] == 1) {
        $dump['filename_stamp'] = date('Y_m_d_H_i', time());
    }
    if (isset($config['multi_part']) && (1 == $config['multi_part'])) {
        $dateiname = $databases['Name'][$dump['dbindex']].'_'.$dump['filename_stamp'].'_part_'.($dump['part'] - $dump['part_offset']);
    } else {
        $dateiname = $databases['Name'][$dump['dbindex']].'_'.date('Y_m_d_H_i', time());
    }
    $endung = (isset($config['compression']) && ($config['compression'])) ? '.sql.gz' : '.sql';
    $dump['backupdatei'] = $dateiname.$endung;

    if (file_exists($config['paths']['backup'].$dump['backupdatei'])) {
        unlink($config['paths']['backup'].$dump['backupdatei']);
    }
    $cur_time = date('Y-m-d H:i');
    $statuszeile = GetStatusLine().$nl.$mysql_commentstring.' Dump by phpBBDumper '.MOD_VERSION.' ('.$config['homepage'].')'.$nl;
    $statuszeile .= '/*!40101 SET NAMES \''.$dump['dump_encoding'].'\' */;'.$nl;
    $statuszeile .= 'SET FOREIGN_KEY_CHECKS=0;'.$nl;

    if ($dump['part'] - $dump['part_offset'] == 1) {
        if (isset($config['multi_part']) && (0 == $config['multi_part'])) {
            if (isset($config['multi_part']) && 1 == $config['multi_dump'] && 0 == $dump['dbindex']) {
                WriteLog('starting Multidump with '.(is_countable($databases['multi']) ? count($databases['multi']) : 0).' Datenbases.');
            }
            WriteLog('Start Dump \''.$dump['backupdatei'].'\'');
        } else {
            WriteLog('Start Multipart-Dump \''.$dateiname.'\'');
        }

        $out .= '<strong>'.$lang['L_STARTDUMP'].' `'.$databases['Name'][$dump['dbindex']].'`</strong>'.(('' != $databases['praefix'][$dump['dbindex']]) ? ' ('.$lang['L_WITHPRAEFIX'].' <span style="color:blue">'.$databases['praefix'][$dump['dbindex']].'</span>)' : '').'...   ';
        if (1 == $dump['part']) {
            $dump['table_offset'] = 0;
            $dump['countdata'] = 0;
        }
        // Seitenerstaufruf -> Backupdatei anlegen
        $dump['data'] = $statuszeile.$mysql_commentstring.' Dump created: '.$cur_time;
    } else {
        if (0 != $config['multi_part']) {
            WriteLog('Continue Multipart-Dump with File '.($dump['part'] - $dump['part_offset']).' (last file was '.$last_groesse.' Bytes)');
            $dump['data'] = $statuszeile.$mysql_commentstring.' This is part '.($dump['part'] - $dump['part_offset']).' of the backup.'.$nl.$nl.$dump['data'];
        }
    }
    WriteToDumpFile();
    ++$dump['part'];
}

function GetStatusLine($kind = 'php')
{
    /*AUFBAU der Statuszeile:
        -- Status:tabellenzahl:datensätze:Multipart:Datenbankname:script:scriptversion:Kommentar:MySQLVersion:Backupflags:SQLBefore:SQLAfter:Charset:CharsetEXTINFO
        Aufbau Backupflags (1 Zeichen pro Flag, 0 oder 1, 2=unbekannt)
        (complete inserts)(extended inserts)(ignore inserts)(delayed inserts)(downgrade)(lock tables)(optimize tables)
    */

    global $databases, $config, $lang, $dump, $mysql_commentstring;

    $t_array = explode('|', (string) $databases['db_actual_tableselected']);
    $t = 0;
    $r = 0;
    $t_zeile = "$mysql_commentstring\n$mysql_commentstring TABLE-INFO\r\n";
    mod_mysqli_connect();
    $res = mysqli_query($config['dbconnection'], 'SHOW TABLE STATUS FROM `'.$databases['Name'][$dump['dbindex']].'`');
    $numrows = intval(@mysqli_num_rows($res));
    for ($i = 0; $i < $numrows; ++$i) {
        $erg = mysqli_fetch_array($res);
        // Get nr of records -> need to do it this way because of incorrect returns when using InnoDBs
        $sql_2 = 'SELECT count(*) as `count_records` FROM `'.$databases['Name'][$dump['dbindex']].'`.`'.$erg['Name'].'`';
        $res2 = mysqli_query($config['dbconnection'], $sql_2);
        if (false === $res2) {
            // error reading table definition
            $read_create_error = sprintf($lang['L_FATAL_ERROR_DUMP'], $databases['Name'][$dump['dbindex']], $erg['Name']).': '.mysqli_error($config['dbconnection']);
            Errorlog('DUMP', $databases['Name'][$dump['dbindex']], '', $read_create_error, 0);
            WriteLog($read_create_error);
            if ($config['stop_with_error'] > 0) {
                exit($read_create_error);
            }
            ++$dump['errors'];
            //$i++; // skip corrupted table
        } else {
            $row2 = mysqli_fetch_array($res2);
            $erg['Rows'] = $row2['count_records'];

            if (('' == $databases['db_actual_tableselected'] || ('' != $databases['db_actual_tableselected'] && (in_array($erg[0], $t_array)))) && (substr((string) $erg[0], 0, strlen($databases['praefix'][$dump['dbindex']] ?? '')) == $databases['praefix'][$dump['dbindex']])) {
                ++$t;
                $r += $erg['Rows'];
                if (isset($erg['Type'])) {
                    $erg['Engine'] = $erg['Type'];
                }
                $t_zeile .= "$mysql_commentstring TABLE|".$erg['Name'].'|'.$erg['Rows'].'|'.($erg['Data_length'] + $erg['Index_length']).'|'.$erg['Update_time'].'|'.$erg['Engine']."\n";
            }
        }
    }
    //$dump['totalrecords'] = $r;
    $flags = 1;

    $mp = (isset($config['multi_part']) && (1 == $config['multi_part'])) ? $mp = 'MP_'.($dump['part'] - $dump['part_offset']) : 'MP_0';
    $statusline = "$mysql_commentstring Status:$t:$r:$mp:".$databases['Name'][$dump['dbindex']].":$kind:".MOD_VERSION.':'.$dump['kommentar'].':';
    $statusline .= MOD_MYSQL_VERSION.":$flags:::".$dump['dump_encoding'].":EXTINFO\n".$t_zeile."$mysql_commentstring"." EOF TABLE-INFO\n$mysql_commentstring";
    return $statusline;
}

// Liest die Eigenschaften der Tabelle aus der DB und baut die CREATE-Anweisung zusammen
function get_def($db, $table, $withdata = 1)
{
    global $config, $nl, $mysql_commentstring, $dump;

    $def = "\n\n$mysql_commentstring\n$mysql_commentstring Create Table `$table`\n$mysql_commentstring\n\n";
    if ('VIEW' == $dump['table_types'][getDBIndex($db, $table)]) {
        $def .= "DROP VIEW IF EXISTS `$table`;\n";
        $withdata = 0;
    } else {
        $def .= "DROP TABLE IF EXISTS `$table`;\n";
    }
    mysqli_select_db($config['dbconnection'], $db);
    $result = mysqli_query($config['dbconnection'], 'SHOW CREATE TABLE `'.$table.'`');
    $row = mysqli_fetch_row($result);
    if (false === $row) {
        return false;
    }
    $def .= $row[1].';'."\n\n";
    if (1 == $withdata) {
        $def .= "$mysql_commentstring\n$mysql_commentstring Data for Table `$table`\n$mysql_commentstring\n\n";
        $def .= "/*!40000 ALTER TABLE `$table` DISABLE KEYS */;".$nl;
    }
    return $def;
}

// Liest die Daten aus der DB aus und baut die INSERT-Anweisung zusammen
function get_content($db, $table)
{
    global $config, $nl, $dump, $buffer;

    $content = '';
    $complete = Fieldlist($db, $table).' ';

    if (!isset($config['dbconnection'])) {
        mod_mysqli_connect();
    }

    $table_ready = 0;
    $query = 'SELECT * FROM `'.$table.'` LIMIT '.$dump['zeilen_offset'].','.($dump['restzeilen'] + 1);
    mysqli_select_db($config['dbconnection'], $db);
    $result = mysqli_query($config['dbconnection'], $query);
    $ergebnisse = mysqli_num_rows($result);
    if (false !== $ergebnisse) {
        // $num_felder=mysqli_field_count($result);
        $num_felder = mysqli_field_count($config['dbconnection']);

        $first = 1;

        if ($ergebnisse > $dump['restzeilen']) {
            $dump['zeilen_offset'] += $dump['restzeilen'];
            --$ergebnisse;
            $dump['restzeilen'] = 0;
        } else {
            ++$dump['table_offset'];
            $dump['zeilen_offset'] = 0;
            $dump['restzeilen'] = $dump['restzeilen'] - $ergebnisse;
            $table_ready = 1;
        }
        $ax = 0;
        for ($x = 0; $x < $ergebnisse; ++$x) {
            $row = mysqli_fetch_row($result);
            ++$ax;

            $insert = 'INSERT INTO `'.$table.'` '.$complete.'VALUES (';

            for ($j = 0; $j < $num_felder; ++$j) {
                if (!isset($row[$j])) {
                    $insert .= 'NULL,';
                } else {
                    $fieldinfo = mysqli_fetch_field_direct($result, $j);
                    if (($fieldinfo->flags & 128) == true && isset($config['use_binary_container']) && 1 == $config['use_binary_container']) {
                        if ('' != $row[$j]) {
                            $insert .= '_binary 0x'.bin2hex((string) $row[$j]).',';
                        } else {
                            $insert .= '_binary \'\',';
                        }
                    } elseif ('' != $row[$j]) {
                        $insert .= '\''.mysqli_real_escape_string($config['dbconnection'], (string) $row[$j]).'\',';
                    } else {
                        $insert .= '\'\',';
                    }
                }
            }
            $insert = substr($insert, 0, -1).');'.$nl;
            $dump['data'] .= $insert;
            ++$dump['countdata'];
            $config['memory_limit'] ??= 0;
            if (strlen((string) $dump['data']) > $config['memory_limit'] || (1 == $config['multi_part'] && strlen($dump['data'] ?? '') + $buffer > $config['multipart_groesse'])) {
                WriteToDumpFile();
            }
        }
        if (1 == $table_ready && 'VIEW' != $dump['table_types'][getDBIndex($db, $table)]) {
            $dump['data'] .= "/*!40000 ALTER TABLE `$table` ENABLE KEYS */;\n";
        }
    } else {
        // table corrupt -> skip it
        ++$dump['table_offset'];
        $dump['zeilen_offset'] = 0;
        $dump['restzeilen'] = $dump['restzeilen'] - $ergebnisse;
        $dump['data'] .= "/*!40000 ALTER TABLE `$table` ENABLE KEYS */;\n";
        if (strlen($dump['data'] ?? '') > $config['memory_limit'] || (1 == $config['multi_part'] && strlen($dump['data'] ?? '') + $buffer > $config['multipart_groesse'])) {
            WriteToDumpFile();
        }
    }
    @mysqli_free_result($result);
}

function WriteToDumpFile()
{
    global $config, $dump, $buffer;
    $dump['filesize'] = 0;

    $df = $config['paths']['backup'].$dump['backupdatei'];

    if (isset($config['compression']) && (1 == $config['compression'])) {
        if ('' != $dump['data']) {
            $fp = gzopen($df, 'ab');
            gzwrite($fp, (string) $dump['data']);
            gzclose($fp);
        }
    } else {
        if ('' != $dump['data']) {
            $fp = fopen($df, 'ab');
            fwrite($fp, (string) $dump['data']);
            fclose($fp);
        }
    }
    $dump['data'] = '';
    if (!isset($dump['fileoperations'])) {
        $dump['fileoperations'] = 0;
    }
    ++$dump['fileoperations'];

    if (isset($config['multi_part']) && (1 == $config['multi_part'])) {
        clearstatcache();
    }
    $dump['filesize'] = filesize($df);
    if ((isset($config['multi_part']) && 1 == $config['multi_part']) && ($dump['filesize'] + $buffer > $config['multipart_groesse'])) {
        @chmod($df, 0777);
        new_file($dump['filesize']); // Wenn maximale Dateigroesse erreicht -> neues File starten
    }
}

function ExecuteCommand($when)
{
    global $config, $databases, $dump, $out, $lang;
    $lf = '<br>';
    if (!isset($dump['dbindex'])) {
        return;
    }
    if ('b' == $when) { // before dump
        $cd = $databases['command_before_dump'][$dump['dbindex']];
        //WriteLog('DbIndex: '.$dump['dbindex'].' Before: '.$databases['command_before_dump'][$dump['dbindex']]);
    } else {
        $cd = $databases['command_after_dump'][$dump['dbindex']];
        //WriteLog('DbIndex: '.$dump['dbindex'].' After: '.$databases['command_after_dump'][$dump['dbindex']]);
    }

    if ('' != $cd) {
        //jetzt ausführen
        if (!str_starts_with(strtolower((string) $cd), 'system:')) {
            $cad = [];
            @mysqli_select_db($config['dbconnection'], $databases['Name'][$dump['dbindex']]);
            if (strpos((string) $cd, ';')) {
                $cad = explode(';', (string) $cd);
            } else {
                $cad[0] = $cd;
            }

            for ($i = 0; $i < sizeof($cad); ++$i) {
                if (trim((string) $cad[$i]) > '') {
                    $result = mysqli_query($config['dbconnection'], $cad[$i]);

                    if (false === $result) {
                        WriteLog("Error executing Query '$cad[$i]'! MySQL returns: ".trim((string) mysqli_error($config['dbconnection'])));
                        ErrorLog("Error executing Query '$cad[$i]'!", $databases['Name'][$dump['dbindex']], $cad[$i], mysqli_error($config['dbconnection']), 0);
                        ++$dump['errors'];
                        $out .= '<span class="error">Error executing Query '.$cad[$i].'</span>'.$lf;
                    } else {
                        WriteLog("Successfully executed Query: '$cad[$i]'");
                        $out .= '<span class="success">Successfully executed Query: \''.$cad[$i].'\'</span>'.$lf;
                    }
                }
            }
        } elseif (str_starts_with(strtolower((string) $cd), 'system:')) {
            $command = substr((string) $cd, 7);
            $result = @system($command, $returnval);
            if (!$result) {
                WriteLog("Error while executing System Command '$command'");
                ++$dump['errors'];
                $out .= $lf.'<span class="error">ERROR executing System Command \''.$command.'\'</span><br>';
            } else {
                WriteLog("Successfully executed System Command '$command'. [$returnval]");
                $out .= $lf.'<span class="success">Successfully executed System Command \''.$command.'.</span><br>';
            }
        }
    }
}


 function ConfigureSMTPMailer($mail)
{
    global $config;

    switch ((int) $config['cron_use_mail']) {
        case 0:
            $mail->IsSMTP();
            $mail->Host = $config['cron_smtp'];
            $mail->Port = 25;
            break;
        case 1:
            $mail->isSendmail();
            $mail->Sendmail = $config['cron_sendmail'];
            break;
        case 2:
            $mail->IsSMTP();
            $mail->SMTPAuth = !empty($config['other_smtp_username']) || !empty($config['other_smtp_password']);
            $mail->Host     = $config['other_smtp_host'];
            $mail->Username = $config['other_smtp_username'];
            $mail->Password = $config['other_smtp_password'];
            $mail->Port     = $config['other_smtp_port'];
            if ($mail->Port == 465) {
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($mail->Port == 587) {
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            }
            break;
        default:
            $mail->IsMail();
            break;
    }
}
 
 
 function DoEmail()
{
    global $phpmailer, $config, $dump, $databases, $lang, $out;

    if (empty($config['email_recipient']) || empty($config['email_sender'])) {
        return false;
    }

    $singlePartMode = (0 == $config['multi_part']);

    if (!($phpmailer instanceof PHPMailer\PHPMailer\PHPMailer)) {
        include_once MOD_INCLUDE_PATH . '/vendor/phpmailer/phpmailer/src/Exception.php';
        include_once MOD_INCLUDE_PATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        include_once MOD_INCLUDE_PATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';
    }

    if ($singlePartMode) {
        $file     = $dump['backupdatei'];
        $filename = $config['paths']['backup'] . $file;

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->setLanguage($config['language'] ?? 'en', MOD_INCLUDE_PATH . '/vendor/phpmailer/phpmailer/language/');
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);

        try {
            $mail->setFrom($config['email_sender'], '');
        } catch (PHPMailer\PHPMailer\Exception $e) {
            $out .= '<span class="error">Fehlerhafte Absenderadresse: ' . htmlentities($e->getMessage()) . '</span><br>';
            WriteLog("Fehlerhafte Absenderadresse: " . $e->getMessage());
            ++$dump['errors'];
            return;
        }

        $mail->addAddress($config['email_recipient']);
        if (!empty($config['email_recipient_cc'])) {
            $mail->addCC($config['email_recipient_cc']);
        }

        ConfigureSMTPMailer($mail);

        $mail->Subject = "Backup '" . $databases['Name'][$dump['dbindex']] . "' - " . date("d.m.Y H:i");

        if (($config['email_maxsize'] > 0 && filesize($filename) > $config['email_maxsize']) || 0 == $config['send_mail_dump']) {
            include_once './inc/functions.php';
            $msg_body = sprintf(
                addslashes($lang['L_EMAILBODY_TOOBIG']),
                byte_output($config['email_maxsize']),
                $databases['Name'][$dump['dbindex']],
                "$file (" . byte_output(filesize($filename)) . ')<br>'
            );
            $msg_body .= '<br><a href="' . getServerProtocol() . $_SERVER['HTTP_HOST'] .
                         substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')) . '/' .
                         $config['paths']['backup'] . $file . '">' . $file . '</a>';
        } else {
            $msg_body = sprintf(
                addslashes($lang['L_EMAILBODY_ATTACH']),
                $databases['Name'][$dump['dbindex']],
                "$file (" . byte_output(filesize($filename)) . ')'
            );
            $mail->addAttachment($filename);
        }

        $mail->Body = $msg_body;
        $mail->AltBody = strip_tags($msg_body);

        try {
            $mail->send();
            $out .= '<span class="success">✅ E-Mail erfolgreich versendet an ' . htmlentities($config['email_recipient']) . '</span><br>';
            WriteLog("E-Mail erfolgreich versendet an '" . $config['email_recipient'] . "'");
        } catch (PHPMailer\PHPMailer\Exception $e) {
            $out .= '<span class="error">❌ Versandfehler: ' . htmlentities($e->getMessage()) . '</span><br>';
            WriteLog("E-Mail-Versand fehlgeschlagen: " . $e->getMessage());
            ++$dump['errors'];
        }

        return;
    }

    // Übersichtsmail + Multi-Part-Versand
    SendMultipartOverviewEmail();

    $dateistamm = substr($dump['backupdatei'], 0, strrpos($dump['backupdatei'], 'part_')) . 'part_';
    $dateiendung = (1 == $config['compression']) ? '.sql.gz' : '.sql';
    $mpdatei = [];

    for ($i = 1; $i < ($dump['part'] - $dump['part_offset']); ++$i) {
        $mpdatei[] = $dateistamm . $i . $dateiendung;
    }

    foreach ($mpdatei as $index => $file) {
        $filename = $config['paths']['backup'] . $file;

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->setLanguage($config['language'] ?? 'en', MOD_INCLUDE_PATH . '/vendor/phpmailer/phpmailer/language/');
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);

        try {
            $mail->setFrom($config['email_sender'], '');
        } catch (PHPMailer\PHPMailer\Exception $e) {
            $out .= '<span class="error">Fehlerhafte Absenderadresse für `' . $file . '`: ' . htmlentities($e->getMessage()) . '</span><br>';
            WriteLog("Fehlerhafte Absenderadresse für Teil: " . $e->getMessage());
            ++$dump['errors'];
            continue;
        }

        $mail->addAddress($config['email_recipient']);
        if (!empty($config['email_recipient_cc'])) {
            $mail->addCC($config['email_recipient_cc']);
        }

        ConfigureSMTPMailer($mail);

        $mail->Subject = "Backup '" . $databases['Name'][$dump['dbindex']] . "' - " . date("d.m.Y") . " [Teil " . ($index + 1) . " / " . count($mpdatei) . "]";
        $msg_body = addslashes($lang['L_EMAIL_ONLY_ATTACHMENT'] . $lang['L_EMAILBODY_FOOTER']);
        $mail->Body = $msg_body;
        $mail->AltBody = strip_tags($msg_body);
        $mail->addAttachment($filename);

        try {
            $mail->send();
            $out .= '<span class="success">✅ Datei `' . $file . '` erfolgreich versendet</span><br>';
            WriteLog("Backup-Teil '$file' versendet an '" . $config['email_recipient'] . "'");
        } catch (PHPMailer\PHPMailer\Exception $e) {
            $out .= '<span class="error">❌ Versandfehler für Datei `' . $file . '`: ' . htmlentities($e->getMessage()) . '</span><br>';
            WriteLog("Fehler beim Versand von '$file': " . $e->getMessage());
            ++$dump['errors'];
        }
    }
}


function SendMultipartOverviewEmail()
{
    global $config, $dump, $databases, $lang, $out;

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->setLanguage($config['language'] ?? 'en', MOD_INCLUDE_PATH . '/vendor/phpmailer/phpmailer/language/');
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->isHTML(true);

    try {
        $mail->setFrom($config['email_sender'], '');
    } catch (PHPMailer\PHPMailer\Exception $e) {
        $out .= '<span class="error">Fehlerhafte Absenderadresse (Übersichtsmail): ' . htmlentities($e->getMessage()) . '</span><br>';
        WriteLog("Fehlerhafte Absenderadresse Übersichtsmail: " . $e->getMessage());
        ++$dump['errors'];
        return;
    }

    $mail->addAddress($config['email_recipient']);
    if (!empty($config['email_recipient_cc'])) {
        $mail->addCC($config['email_recipient_cc']);
    }

    ConfigureSMTPMailer($mail);

    // 🔍 Backup-Dateien auflisten
    $dateistamm = substr($dump['backupdatei'], 0, strrpos($dump['backupdatei'], 'part_')) . 'part_';
    $dateiendung = (1 == $config['compression']) ? '.sql.gz' : '.sql';
    $mpfiles = '';

    for ($i = 1; $i < ($dump['part'] - $dump['part_offset']); ++$i) {
        $filename = $dateistamm . $i . $dateiendung;
        $filepath = $config['paths']['backup'] . $filename;
        $size = @filesize($filepath);
        $sizeStr = ($size === false) ? 'Datei nicht gefunden' : byte_output($size);
        $mpfiles .= htmlentities($filename) . ' (' . $sizeStr . ')<br>';
    }

    // 📧 Mail-Inhalt mit Sprachvariable
    $mail->Subject = "Übersicht: Backup '" . $databases['Name'][$dump['dbindex']] . "' vom " . date("d.m.Y");
    $mail->Body = sprintf($lang['L_EMAILBODY_MP_ATTACH'], htmlentities($databases['Name'][$dump['dbindex']]), $mpfiles);
    $mail->AltBody = strip_tags($mail->Body);

    try {
        $mail->send();
        $out .= '<span class="success">ℹ️ Übersichtsmail erfolgreich versendet</span><br>';
        WriteLog("Übersichtsmail versendet an '" . $config['email_recipient'] . "'");
    } catch (PHPMailer\PHPMailer\Exception $e) {
        $out .= '<span class="error">❌ Fehler beim Versand der Übersichtsmail: ' . htmlentities($e->getMessage()) . '</span><br>';
        WriteLog("Fehler beim Versand der Übersichtsmail: " . $e->getMessage());
        ++$dump['errors'];
    }
}


 
function DoFTP($i)
{
    global $config, $dump, $out;

    if (0 == $config['multi_part']) {
        SendViaFTP($i, $dump['backupdatei'], 1);
    } else {
        $dateistamm = substr((string) $dump['backupdatei'], 0, strrpos((string) $dump['backupdatei'], 'part_')).'part_';
        $dateiendung = (1 == $config['compression']) ? '.sql.gz' : '.sql';
        for ($a = 1; $a < ($dump['part'] - $dump['part_offset']); ++$a) {
            $mpdatei = $dateistamm.$a.$dateiendung;
            SendViaFTP($i, $mpdatei, $a);
        }
    }
}

function SendViaFTP(int $i, string $source_file, int $conn_msg = 1): void
{
    global $config, $out, $lang;

    flush();

    if ($conn_msg === 1) {
        $out .= '<span class="success">' . $lang['L_FILESENDFTP'] .
                ' (' . $config['ftp_server'][$i] . ' - ' . $config['ftp_user'][$i] . ')</span><br>';
    }

    // Prüfen ob FTP-Funktionen verfügbar sind
    if (!function_exists('ftp_connect')) {
        throw new RuntimeException("FTP-Extension nicht verfügbar.");
    }

    // FTP-Verbindung herstellen
    $conn_id = ($config['ftp_useSSL'][$i] === 0)
        ? ftp_connect($config['ftp_server'][$i], $config['ftp_port'][$i], $config['ftp_timeout'][$i])
        : ftp_ssl_connect($config['ftp_server'][$i], $config['ftp_port'][$i], $config['ftp_timeout'][$i]);

    if (!$conn_id) {
        $out .= '<span class="error">' . $lang['L_FTPCONNERROR'] . $config['ftp_server'][$i] .
                $lang['L_FTPCONNERROR1'] . $config['ftp_user'][$i] . $lang['L_FTPCONNERROR2'] . '</span><br>';
        return;
    }

    // Einloggen
    if (!ftp_login($conn_id, $config['ftp_user'][$i], $config['ftp_pass'][$i])) {
        $out .= '<span class="error">' . $lang['L_FTPCONNERROR'] . $config['ftp_server'][$i] .
                $lang['L_FTPCONNERROR1'] . $config['ftp_user'][$i] . $lang['L_FTPCONNERROR2'] . '</span><br>';
        ftp_close($conn_id);
        return;
    }

    if ($config['ftp_mode'][$i] === 1) {
        ftp_pasv($conn_id, true);
    }

    if ($conn_msg === 1) {
        $out .= '<span class="success">' . $lang['L_FTPCONNECTED1'] . $config['ftp_server'][$i] .
                $lang['L_FTPCONNERROR1'] . $config['ftp_user'][$i] . '</span><br>';
    }

    // Upload der Datei
    $dest   = $config['ftp_dir'][$i] . $source_file;
    $source = $config['paths']['backup'] . $source_file;

    if (!ftp_put($conn_id, $dest, $source, FTP_BINARY)) {
        $out .= '<span class="error">' . $lang['L_FTPCONNERROR3'] . "<br>($source -> $dest)</span><br>";
    } else {
        $out .= '<span class="success">' . $lang['L_FILE'] . ' <a href="' . $source .
                '" class="smallblack">' . $source_file . '</a>' . $lang['L_FTPCONNECTED2'] .
                $config['ftp_server'][$i] . $lang['L_FTPCONNECTED3'] . '</span><br>';
        WriteLog("'$source_file' sent via FTP.");
    }

    ftp_close($conn_id);
}


use League\Flysystem\Filesystem;
use League\Flysystem\UnableToWriteFile;

function DoSFTP($i)
{
    global $config, $dump, $out;

    // Überprüfen, ob multipart aktiviert ist
    if (0 == $config['multi_part']) {
        try {
            SendViaSFTP($i, $dump['backupdatei'], 1);
        } catch (UnableToWriteFile $e) {
            echo "❌ Fehler beim SFTP-Versand der Datei '{$dump['backupdatei']}': " . $e->getMessage();
            // Optional: Logging oder alternative Aktion
        } catch (Exception $e) {
            echo "❌ Allgemeiner Fehler: " . $e->getMessage();
        }
    } else {
        // Pfadbestandteile berechnen
        $dateistamm = substr((string) $dump['backupdatei'], 0, strrpos((string) $dump['backupdatei'], 'part_')) . 'part_';
        $dateiendung = (1 == $config['compression']) ? '.sql.gz' : '.sql';

        // Einzelne Teile verschicken
        for ($a = 1; $a < ($dump['part'] - $dump['part_offset']); ++$a) {
            $mpdatei = $dateistamm . $a . $dateiendung;
            try {
                SendViaSFTP($i, $mpdatei, $a);
            } catch (UnableToWriteFile $e) {
                echo "❌ Fehler beim SFTP-Versand von Teil {$a} ('{$mpdatei}'): " . $e->getMessage();
            } catch (Exception $e) {
                echo "❌ Allgemeiner Fehler bei Teil {$a}: " . $e->getMessage();
            }
        }
    }
}

