<?php

//bootloading delle dipendenze
require_once __DIR__ . '/bootstrap.php';

//rinominazione del processo CLI
//cli_set_process_title(CLI_PROCESS_NAME);

// disable DOMPDF's internal autoloader if you are using Composer
define('DOMPDF_ENABLE_AUTOLOAD', false);

define('LPR_COMMAND', '/usr/bin/lpr');

define('PROCESSED_EMAILS_DB', APP_CWD . '/processed-emails.txt');

define('MPLAYER_COMMAND', '/usr/local/bin/mplayer');

define('SOUND_BELL', APP_CWD . '/sounds/bell1.mp3');

// include DOMPDF's default configuration
require_once APP_CWD . '/vendor/dompdf/dompdf/dompdf_config.inc.php';


$html = '<HTML><style type="text/css">.flexTable {   padding: 2pt;   border: 0pt; }  .flexTable tr:nth-child(even) {   background-color: #FFFFFF; }  .flexTable tr:nth-child(odd) { \tbackground-color:  #A0A0A0; }  .flexTable td { \tpadding: 2pt; }  .flexTable-ColumnLabel {   color: white;   padding: 3px; }  .flexTable-ColumnLabelCell {   border-width: 0 0 1px 0;   border-style: solid;   border-color: white;   margin: 0;   padding: 0;   text-align: center; }  .flexTable-Cell {   border-width: 0px 0px 0px 1px;   border-style: solid;   border-color: white;   padding: 5px; } </style><body>In base al file CSV ricevuto è stato caricato il seguente menu valido per il giorno 28/12/2015.<hr><table class="flexTable"><tr><td>TIPOLOGIA</td><td>Descrizione</td><td>Prezzo</td></tr><tr><td>Primi Piatti</td><td>Anelletti al forno con Ragù</td><td>3</td></tr><tr><td>Primi Piatti</td><td>Tabulè di Verdure con Tonno</td><td>2.5</td></tr><tr><td>Primi Piatti</td><td>Gateau di Patate</td><td>3</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Parmigiana di Melanzane</td><td>2.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Involtini di Melanzane Grigliate con Bufala, Misticanza e Prosciutto Cotto</td><td>3.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Sfoglia con ricotta e spinaci</td><td>2.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Frittatine di Ricotta</td><td>3</td></tr><tr><td>Secondi di carne</td><td>Cotoletta di Pollo con Patate al Forno</td><td>3.5</td></tr><tr><td>Secondi di carne</td><td>Bistecca ai ferri con Patate Fritte</td><td>5</td></tr><tr><td>Secondi di carne</td><td>Arrosto panato con Patate Fritte</td><td>5</td></tr><tr><td>Piatti Vegetariani</td><td>Insalata Variegata (Lattughino, Belga, Radicchio, Valeriana, Mais) [NON CONDITO, Specificare Condimenti Sotto]</td><td>3.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Involtini di Bresaola con Mozzarella e Lattughino</td><td>3.5</td></tr><tr><td>Piatti Vegetariani</td><td>Insalata Variegata con Mozzarella [NON CONDITO, Specificare Condimenti Sotto]</td><td>3.5</td></tr><tr><td>Condimenti</td><td>Aggiunta Sale</td><td>0</td></tr><tr><td>Condimenti</td><td>Aggiunta Olio</td><td>0</td></tr><tr><td>Condimenti</td><td>Aggiunta Pepe</td><td>0</td></tr><tr><td>Condimenti</td><td>Aggiunta Limone</td><td>0</td></tr><tr><td>Condimenti</td><td>Aggiunta Aceto</td><td>0</td></tr><tr><td>Condimenti</td><td>Aggiunta Aceto Alle Fragole</td><td>0.2</td></tr><tr><td>Condimenti</td><td>Aggiunta Glassa di Aceto Balsamico</td><td>0.2</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Frittata di Patate</td><td>2.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Bietole Lesse</td><td>2</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Broccoletti Lessi</td><td>2</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Grigliata di Verdure (Melanzane e Zucchine)</td><td>2.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Zucca rossa in agrodolce</td><td>2.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Carciofi alla contadina</td><td>2.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Carciofi imbottiti con patate in umido</td><td>3</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Patate al forno</td><td>2</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Caprese in vaschetta (Fior di Latte)</td><td>2.5</td></tr><tr><td>Verdure, ortaggi e contorni</td><td>Caprese in vaschetta (Bufala)</td><td>3.3</td></tr><tr><td>Aggiunte</td><td>Panino</td><td>0.3</td></tr><tr><td>Panini Imbottiti</td><td>Panino con Cotto</td><td>1.8</td></tr><tr><td>Panini Imbottiti</td><td>Panino con Salame Napoli</td><td>1.8</td></tr><tr><td>Panini Imbottiti</td><td>Panino con Pancetta</td><td>1.8</td></tr><tr><td>Panini Imbottiti</td><td>Panino con Mortadella</td><td>1.8</td></tr><tr><td>Panini Imbottiti</td><td>Panino con Speck</td><td>1.8</td></tr><tr><td>Panini Imbottiti</td><td>Panino con Crudo</td><td>2.5</td></tr><tr><td>Panini Imbottiti</td><td>Panino con Bresaola</td><td>2.5</td></tr><tr><td>Panini Imbottiti</td><td>Panino Caprese (con Fior di Latte)</td><td>2.5</td></tr><tr><td>Panini Imbottiti</td><td>Panino Caprese (con Bufala)</td><td>3</td></tr><tr><td>Aggiunte</td><td>Aggiunta Provoletta</td><td>0.8</td></tr><tr><td>Aggiunte</td><td>Aggiunta Svizzero</td><td>0.8</td></tr><tr><td>Aggiunte</td><td>Aggiunta Primosale</td><td>0.8</td></tr><tr><td>Aggiunte</td><td>Aggiunta Fior di Latte</td><td>0.8</td></tr><tr><td>Aggiunte</td><td>Aggiunta Mozzarella di Bufala</td><td>1</td></tr><tr><td>Bibite</td><td>Coca Cola 0,33cl</td><td>1</td></tr><tr><td>Bibite</td><td>Fanta 0,33cl</td><td>1</td></tr><tr><td>Bibite</td><td>Chinotto 0,33cl</td><td>1</td></tr><tr><td>Frutta e Dessert</td><td>Macedonia di Frutta con succo di arancia (no zucchero)</td><td>2</td></tr><tr><td>Frutta e Dessert</td><td>Ananas affettata</td><td>2</td></tr><tr><td>Frutta e Dessert</td><td>Ricotta alla pera</td><td>3</td></tr><tr><td>Frutta e Dessert</td><td>Ricotta al pistacchio</td><td>3</td></tr><tr><td>Frutta e Dessert</td><td>Crostata del Monte Amiata (Specialità toscana)</td><td>2</td></tr></table></body></html>';

pulisciTabellaPerPapa($html);



// --------------------------------------------------------------------

function pulisciTabellaPerPapa($html)
{
    $crawler = new Symfony\Component\DomCrawler\Crawler($html);

    $res = $crawler
        ->filter('table tr')
        ->reduce(function ($node) {

            $tipologia = $node->filter('td')->eq(0)->text();
            $remove = in_array(strtolower($tipologia), ['bibite', 'aggiunte', 'condimenti', 'panini imbottiti', 'frutta e dessert']);

            return $remove;

            // if($remove) {

            //     dd(get_class_methods($node));

            //     $node->extract();



            //     // $node->parents()->removeChild($node);
            // }
        });

    //die;

    dd($res->html());

    die;

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

function matchSubject($subject, $toMatch)
{
    $matches = is_array($toMatch) ? $toMatch : [$toMatch];

    foreach ($matches as $m) {
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

    $result = exec("{$lprCommand} {$fileBuffer}");

    //return true;
    return $result;
}


