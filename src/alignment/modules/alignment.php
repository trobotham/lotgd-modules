<?php

function alignment_getmoduleinfo()
{
    return [
        'name' => 'Alignment Core',
        'author' => '`QWebPixie and Chris Vorndran`0, refactoring by `%IDMarinas`0, <a href="//draconia.infommo.es">draconia.infommo.es</a>',
        'version' => '2.0.0',
        'category' => 'Stat Display',
        'download' => 'http://dragonprime.net/index.php?module=Downloads;sa=dlview;id=64',
        'vertxtloc' > 'http://dragonprime.net/users/Sichae/',
        'description' => 'This module will display the alignment of a character (Evil, Neutral, Good). Certain events in the LotGD universe will affect this alignment.',
        'settings' => [
            'Alignment Settings,title',
            'evilalign' => 'What number is evil alignment,int|-430',
            'Any number under the evil number will make the user show up evil. You can use negative numbers.,note',
            'goodalign' => 'What number is good alignment,int|430',
            'Any number above the good number will make the user show up good,note',
            'Any number between evil and good number the user shows up neutral,note',
            'display-num' => 'Display a number alongside of the Alignment statement?,bool|0',
            'Maximum/Minimum Settings,title',
            'reset' => "Reset user's alignment if it goes over/under the maximum/minimum (see below),bool|0",
            'max-num' => 'What is the maximum alignment?,int|5000',
            'min-num' => 'What is the minimum alignment?,int|-5000',
            'Other Settings,title',
            'shead' => 'What Stat heading does this go under (Translation format: "key;textDomain" ),text|statistic.category.character.personal;app-default',
            'pvp' => 'Does PVP affect Alignment,bool|1',
            "Whether to remove or add is based on a comparison of the warrior's alignment.,note",
            "How much to remove or add is based from the character's level divided by two.,note",
            'In the neutral case it is a 50/50 chance either way. Level is divided by 3 for amount to change.,note',
        ],
        'prefs-mounts' => [
            'Mount Alignment Settings,title',
            'Please note that this change happens at newday.,note',
            'al' => "How much does having this mount affect a person's alignment?,int|0",
            '0 This value to disable. You may also set negative numbers.,note',
        ],
        'prefs-creatures' => [
            'Creature Alignment Settings,title',
            'al' => "How much does slaying this creature affect a person's alignment?,int|0",
            '0 This value to disable. You may also set negative numbers.,note',
        ],
        'prefs' => [
            'Alignment user preferences,title',
            'alignment' => 'Current alignment number,int|0',
        ],
        'requires' => [
            'lotgd' => '>=4.0.0|Need a version equal or greater than 4.0.0 IDMarinas Edition'
        ]
    ];
}

function alignment_install()
{
    module_addhook('biostat');
    module_addhook('charstats');
    module_addhook('newday');
    module_addhook('battle-victory-end');

    return true;
}

function alignment_uninstall()
{
    return true;
}

function alignment_dohook($hookname, $args)
{
    global $session,$badguy,$options;

    require_once 'modules/alignment/func.php';

    $title = \LotgdTranslator::t('alignment.title', [], 'alignment-module');
    $good = \LotgdTranslator::t('alignment.good', [], 'alignment-module');
    $evil = \LotgdTranslator::t('alignment.evil', [], 'alignment-module');
    $neutral = \LotgdTranslator::t('alignment.neutral', [], 'alignment-module');

    $evilalign = get_module_setting('evilalign', 'alignment');
    $goodalign = get_module_setting('goodalign', 'alignment');

    switch ($hookname)
    {
        case 'newday':
            $max_num = get_module_setting('max-num');
            $min_num = get_module_setting('min-num');

            if ('none' == get_align())
            {
                set_align(round(($max_num + $min_num) / 2));
            }

            $id = $session['user']['hashorse'];

            if ($id)
            {
                $al = get_module_objpref('mounts', $id, 'al');

                if ('' != $al)
                {
                    align($al);
                }
            }

            if (get_module_setting('reset'))
            {
                $align = get_align();

                if ($align > $max_num)
                {
                    set_align($max_num);
                }
                elseif ($align < $min_num)
                {
                    set_align($min_num);
                }
            }
        break;
        case 'charstats':
            $val = get_module_pref('alignment');
            $extra = '';

            if (get_module_setting('display-num'))
            {
                $extra = "(`b{$val}´b)";
            }

            $align = get_align_name();
            $color = sprintf('`b%s´b %s', ${$align}, $extra);

            $area = explode(';', get_module_setting('shead'));

            setcharstat(\LotgdTranslator::t($area[0], [], $area[1]), $title, $color);

        break;
        case 'biostat':
            $align = get_align_name($args['target']['acctid']);

            $args['messages'][] = [
                'alignment.biostat',
                [ 'align' => ${$align} ],
                'alignment-module'
            ];
        break;
        case 'battle-victory-end':
            foreach ($args['enemies'] as $badguy)
            {
                if ('pvp' == $options['type'] && get_module_setting('pvp'))
                {
                    $ual = get_module_pref('alignment');
                    $al = get_module_pref('alignment', 'alignment', $badguy['acctid']);

                    if ($al > $goodalign && $ual < $evilalign)
                    {
                        $new = round($session['user']['level'] / 2);
                        $args['messages'][] = [
                            'battle.victory.pvp.evil',
                            [],
                            'alignment-module'
                        ];
                        align("-$new");
                    }
                    elseif ($al < $evilalign && $ual > $goodalign)
                    {
                        $new = round($session['user']['level'] / 2);
                        $args['messages'][] = [
                            'battle.victory.pvp.good',
                            [],
                            'alignment-module'
                        ];
                        align("+$new");
                    }
                    else
                    {
                        switch (e_rand(1, 2))
                        {
                            case 1:
                                $new = round($session['user']['level'] / 3);
                                $args['messages'][] = [
                                    'battle.victory.pvp.rand.good',
                                    [],
                                    'alignment-module'
                                ];
                                align("+$new");
                            break;
                            case 2:
                                $new = round($session['user']['level'] / 3);
                                $args['messages'][] = [
                                    'battle.victory.pvp.rand.evil',
                                    [],
                                    'alignment-module'
                                ];
                                align("-$new");
                            break;
                        }
                    }
                }
                elseif ('forest' == $options['type'] || 'travel' == $options['type'])
                {
                    $al = (int) get_module_objpref('creatures', $badguy['creatureid'], 'al');

                    if ($al > 0)
                    {
                        align($al);

                        $args['messages'][] = [
                            'battle.victory.pve.good',
                            [ 'creatureName' => $badguy['creaturename'] ],
                            'alignment-module'
                        ];
                    }
                    elseif ($al < 0)
                    {
                        align($al);

                        $args['messages'][] = [
                            'battle.victory.pve.evil',
                            [ 'creatureName' => $badguy['creaturename'] ],
                            'alignment-module'
                        ];
                    }
                }
            }
        break;
    }

    return $args;
}
