<?php

//bootloading delle dipendenze
require_once __DIR__ . '/bootstrap.php';

//rinominazione del processo CLI
//cli_set_process_title(CLI_PROCESS_NAME);

// disable DOMPDF's internal autoloader if you are using Composer
define('DOMPDF_ENABLE_AUTOLOAD', false);

define('PROCESSED_EMAILS_DB', APP_CWD . '/processed-emails.txt');

define('SOUND_BELL', APP_CWD . '/sounds/bell1.mp3');

// include DOMPDF's default configuration
require_once APP_CWD . '/vendor/dompdf/dompdf/dompdf_config.inc.php';


$args = \CommandLine::parseArgs($_SERVER['argv']);
$listeningMode = @$args['listen'] ? true : false;


$gmail = new JamPoller\GmailClient\GmailClient;

$emailProcessedDatabase = [];

setProcessed($emailProcessedDatabase, null);

do {

    $t1 = time();

    $emails = $gmail->readEmails([
        'maxResults' => 10,
        'labelIds' => 'INBOX',
        'includeSpamTrash' => true,
        'q' => 'from:mosaicoon.com'
    ]);


    foreach ($emails as $email) {

        //controllo se il messaggio è già stato processato
        if(in_array($email['id'], $emailProcessedDatabase)) {
            continue;
        }

        //controllo se il messaggio è più vecchio di 8 ore
        $time = \Carbon\Carbon::createFromTimestamp(substr($email['time'], 0, -3));
        $hoursOffset = \Carbon\Carbon::now()->diffInHours($time);

        if($hoursOffset > 8) {
            continue;
        }


        if(! empty($email['body']['html'])) {

            $html = $email['body']['html'][0];

            if(matchSubject($email['subject'], 'Invio ordine MOSAICOON SpA', false)) {

                //ricezione di un ordine
                sendHtmlPrintJob($html);
                suonaCampanellino();

            } elseif(matchSubject($email['subject'], 'MENU')) {

                //conferma caricamento menu
                //$html = pulisciTabellaPerPapa($html);
                sendHtmlPrintJob($html);
                suonaCampanellino();

            }

        }

        //segna come processato
        setProcessed($emailProcessedDatabase, $email['id']);

    }

    $t2 = time();


    dump($t2 - $t1);

} while ($listeningMode);


// --------------------------------------------------------------------

function pulisciTabellaPerPapa($html)
{

    return $html;

    $crawler = new Symfony\Component\DomCrawler\Crawler($html);

    //dump($html);

    $crawler
        ->filter('table tr')
        ->reduce(function ($node, $i) {

            $tipologia = $node->filter('td')->eq(0)->text();
            $remove = ! in_array(strtolower($tipologia), ['bibite', 'aggiunte', 'condimenti', 'panini']);

            return $remove;
        });



    $crawler->clear();

    dd($crawler->html());

    return dd();
}

// --------------------------------------------------------------------

function setProcessed(&$emailProcessedDatabase, $id)
{
    $str = ! empty($id) ? $id . PHP_EOL : null;
    file_put_contents(PROCESSED_EMAILS_DB, $str, FILE_APPEND);
    $emailProcessedDatabase = explode(PHP_EOL, file_get_contents(PROCESSED_EMAILS_DB));
    echo("Email {$id} processata!\n");

    return true;
}

// --------------------------------------------------------------------

function suonaCampanellino()
{
    $mplayerCommand = MPLAYER_COMMAND;
    $soundBell = SOUND_BELL;
    exec("{$mplayerCommand} {$soundBell}");
}

// --------------------------------------------------------------------

function matchSubject($subject, $toMatch, $caseSensitive = true)
{
    $matches = is_array($toMatch) ? $toMatch : [$toMatch];

    foreach ($matches as $m) {

        if(! $caseSensitive) {
            $subject = strtoupper($subject);
            $m = strtoupper($m);
        }

        if(strpos($subject, $m) !== false) {
            return true;
        }
    }

    return false;
}

// --------------------------------------------------------------------

function sendHtmlPrintJob($html)
{
    if(empty($html)) {
        return false;
    }

    $lprCommand = LPR_COMMAND;

    $dompdf = new \DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();

    $fileBuffer = APP_CWD . '/tmp.pdf';

    file_put_contents($fileBuffer, $dompdf->output());

    echo("Invio di un processo di stampa...\n");

    if(PRINT_MESSAGES) {
        return exec("{$lprCommand} {$fileBuffer}");
    } else {
        return true;
    }


}


