<?php

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */

if(! defined('ENVIRONMENT')) {
    $envPath = APP_CWD . '/env.php';

    if(! file_exists($envPath)) {
        throw new \Exception("Nessun file di environment disponibile in: {$envPath}");
    }

    require_once $envPath;
}


if(! defined('ENVIRONMENT')) {
    throw new \Exception("Nessuna costante ENVIRONMENT configurata");
}

switch(ENVIRONMENT)
{


    default:
    case 'test':
    case 'testing':

    case 'team':
    case 'vagrant':
    case 'locl':
    case 'local':

        define('MPLAYER_COMMAND', '/usr/local/bin/mplayer');
        define('LPR_COMMAND', '/usr/bin/lpr');

        define('PRINT_MESSAGES', false);

    break;


    case 'stage':
    case 'staging':

        define('MPLAYER_COMMAND', '/usr/bin/mplayer');
        define('LPR_COMMAND', '/usr/bin/lpr');

        define('PRINT_MESSAGES', true);

    break;


    case 'prod':
    case 'production':

        define('MPLAYER_COMMAND', '/usr/bin/mplayer');

        define('LPR_COMMAND', '/usr/bin/lpr');

        define('PRINT_MESSAGES', true);


    break;

}
