<?php
/**
 * Restore hitpoints.
 *
 * @param int   $hitpoins             Can be negative
 * @param array $item                 Data of item
 * @param bool  $overrideMaxhitpoints Allow restore more than maxhitpoints of character
 * @param bool  $canDie               Can die for effect of item?
 *
 * @return array|false Return false if nothing happend or an array of messages
 */
function itemeffects_restore_hitpoints($hitpoints, $item, $overrideMaxhitpoints = null, $canDie = true)
{
    global $session;

    $hitpoints = (int) $hitpoints;
    $overrideMaxhitpoints = (bool) $overrideMaxhitpoints;
    $canDie = (bool) $canDie;

    //-- Check max health to restore
    $maxRestoreHP = $session['user']['maxhitpoints'] - $session['user']['hitpoints'];

    //-- Not has health to restore
    if ($maxRestoreHP <= 0)
    {
        return false;
    }

    //-- It is not allowed to exceed the maximum health
    if (! $overrideMaxhitpoints)
    {
        $hitpoints = min($hitpoints, $maxRestoreHP);
    }

    $out = [];

    if ($hitpoints > 0)
    {
        $session['user']['hitpoints'] += $hitpoints;

        $message = ['`^You have been `@healed`^ for %s points.`0`n', $hitpoints];
        if ($hitpoints == $maxRestoreHP)
        {
            $message = '`^Your hitpoints have been `@fully`^ restored.`0`n';
        }

        $out[] = $message;
        debuglog("Restored $hitpoints health points using the item {$item['itemid']}");
    }
    elseif ($hitpoints < 0)
    {
        $session['user']['hitpoints'] += $hitpoints;

        $message = '`$You die. ¡What a pity!.`0`n';
        if ($session['user']['hitpoints'] > 0)
        {
            $message = ['`^You `4loose`^ %s hitpoints.`0`n', abs($hitpoints)];
            $debuglog = "Loss $hitpoints hitpoints using item {$item['itemid']}";
        }
        elseif ($session['user']['hitpoints'] <= 0 && false == $canDie)
        {
            $session['user']['hitpoints'] = 1;
            $message = '`^You were `$almost`^ killed.`0`n';
            $debuglog = "Were almost killed when using item {$item['itemid']}";
        }
        else
        {
            $session['user']['alive'] = 0;
            $session['user']['hitpoints'] = 0;
            $debuglog = "Died when I used the item {$item['itemid']}";
        }

        $out[] = $message;
        debuglog($debuglog);
    }
    else
    {
        $out[] = ['`&You used "`i%s`i" but it had no effect.`0`n', $item['name']];
    }

    return $out;
}