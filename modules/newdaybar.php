<?php

/*
 * Title:       New Day Bar
 * Date:	Sep 06, 2004
 * Version:	1.2
 * Author:      Joshua Ecklund
 * Email:       m.prowler@cox.net
 * Purpose:     Add a countdown timer for the new day to "Personal Info"
 *              status bar.
 *
 * --Change Log--
 *
 * Date:    	Jul 30, 2004
 * Version:	1.0
 * Purpose:     Initial Release
 *
 * Date:        Aug 01, 2004
 * Version:     1.1
 * Purpose:     Various changes/fixes suggested by JT Traub (jtraub@dragoncat.net)
 *
 * Date:        Sep 06, 2004
 * Version:     1.2
 * Purpose:     Updated to use functions included in 0.9.8-prerelease.3
 *
 */

function newdaybar_getmoduleinfo(){
	$info = array(
		"name"=>"New Day Bar",
		"version"=>"1.2",
		"author"=>"Joshua Ecklund",
        "download"=>"http://dragonprime.net/users/mProwler/newdaybar.zip",
		"category"=>"Stat Display",
		"settings"=>array(
			"New Day Bar Module Settings,title",
			"showtime"=>"Show time to new day,bool|1",
			"showbar"=>"Show time as a bar,bool|1",
		)
	);
	return $info;
}

function newdaybar_install(){
	module_addhook("charstats");
	return true;
}

function newdaybar_uninstall(){
	return true;
}

function newdaybar_dohook($hookname,$args){
	global $session;

	switch($hookname){
		case "charstats":
			$showtime = get_module_setting("showtime");
			$showbar  = get_module_setting("showbar");

			if (!$showtime && !$showbar) return;

        	require_once 'lib/datetime.php';

            $details = gametimedetails();
            $secstonewday = secondstonextgameday($details);

            $newdaypct = round($details['realsecstotomorrow'] / $details['secsperday'] * 100, 4);

        	$newdaytxt = date("G\\h i\\m s\\s",$secstonewday);

		    if ($newdaypct > 100) { $newdaypct = 100; }
        	elseif ($newdaypct < 0) { $newdaypct = 0; }

        	$ccode = "`@";
	        $stat = "Next day";

			if ($showtime) $newdaytxt = $ccode . $newdaytxt . '`0';
			else $newdaytxt = '';

			if ($showbar)
			{
				$new = "<div class='ui tiny indicating progress ".($newdaytxt?'':'remove margin')." newdaybar' data-percent='$newdaypct'><div class='bar'></div>";
				if ($newdaytxt) $new .= "<div class='label'>$newdaytxt</div>";
				$new .= '</div>';
				rawoutput("<script>
					 	var realSecsToTomorrow = " . $details['realsecstotomorrow'] . ";
						var secPerDay = " . $details['secsperday'] . ";
						function newdaybar () {
							if (realSecsToTomorrow > 0)
							{
								realSecsToTomorrow--;
								var percentage = (realSecsToTomorrow / secPerDay) * 100;
								$('.progress.newdaybar .progres-text').css('width' , percentage.toFixed(10) + '%');
								setTimeout(newdaybar,5000);
							}
							else
							{
								$('.progress.newdaybar .progres-text').html('<i class=\"sun icon\"></i> " . translate_inline("New Day Here") . "');
							}
						}
						newdaybar();
					 </script>");
			}
			else
			{
				$new = $newdaytxt;
			}
			setcharstat("Extra Info", $stat, $new);
			break;
	}
	return $args;
}

function newdaybar_run(){}