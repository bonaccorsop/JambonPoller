<?php

//imposta la current working directory per l'interfaccia HTTP
define('APP_CWD', __DIR__);

//nome del processo CLI
define('CLI_PROCESS_NAME', 'jambon-poller-cli');

//timezone dell'app
define('APP_TIMEZONE', 'Europe/Rome');

//autoload di composer
require_once APP_CWD . '/vendor/autoload.php';

//Impostazione del Timezone
date_default_timezone_set(APP_TIMEZONE);

// --------------------------------------------------------------------

//setup del dumper
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

VarDumper::setHandler(function ($var) {
    $cloner = new VarCloner();
    $dumper = 'cli' === PHP_SAPI ?
        new CliDumper() :
        new HtmlDumper();
    $dumper->dump($cloner->cloneVar($var));
});


function dd($data)
{
    dump($data); exit;
}
