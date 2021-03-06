<?php

// addnews ready
// mail ready
// translator ready

function soulgem_getmoduleinfo()
{
    return [
        'name' => 'Soul Gems',
        'version' => '2.0.0',
        'author' => 'JT Traub, refactoring by `%IDMarinas`0, <a href="//draconia.infommo.es">draconia.infommo.es</a>',
        'category' => 'Graveyard Specials',
        'download' => 'core_module',
        'requires' => [
            'lotgd' => '>=4.0.0|Need a version equal or greater than 4.0.0 IDMarinas Edition'
        ]
    ];
}

function soulgem_install()
{
    module_addeventhook('graveyard', 'return 100;');

    return true;
}

function soulgem_uninstall()
{
    return true;
}

function soulgem_dohook($hookname, $args)
{
    return $args;
}

function soulgem_runevent($type)
{
    global $session;

    $session['user']['gravefights']++;
    $session['user']['deathpower'] += e_rand(1, 5);

    $params = [
        'textDomain' => 'module-soulgem',
        'deathOverlord' => getsetting('deathoverlord', '`$Ramius`0')
    ];

    rawoutput(\LotgdTheme::renderModuleTemplate('soulgem/runevent.twig', $params));
}

function soulgem_run()
{
}
