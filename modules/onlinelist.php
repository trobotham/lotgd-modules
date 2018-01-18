<?php

function onlinelist_getmoduleinfo(){
    $info = array(
        "name"=>"Alternative Sorting",
        "author"=>"Christian Rutsch",
        "version"=>"1.2",
        "category"=>"Administrative",
        "download"=>"http://dragonprime.net/users/XChrisX/onlinelist.zip",
        "allowanonymous" => 1,
    );
    return $info;
}

function onlinelist_install(){
    module_addhook("onlinecharlist");
    return true;
}

function onlinelist_uninstall(){
    return true;
}

function onlinelist_dohook($hookname, $args){
    switch($hookname) {
        case "onlinecharlist":
        	$args['handled'] = true;
			$list_mods = "";
			$list_players = "";

            //-- Se elimina de las dos consultas, ya que no se usa después
            // ,alive,location,sex,level,laston,loggedin,lastip,uniqueid
			$sql="SELECT name FROM " . DB::prefix("accounts") . " WHERE locked=0 AND loggedin=1 AND superuser > 0 AND laston > '".date("Y-m-d H:i:s",strtotime("-".getsetting("LOGINTIMEOUT",900)." seconds"))."' ORDER BY superuser DESC, level DESC";
			$result = DB::query($sql);
			$count = DB::num_rows($result);
			$list_mods = appoencode(sprintf(translate_inline("`bOnline Staff`n(%s Staff Member):`b`n"),$count));
			$onlinecount_mods = 0;
			for ($i=0;$i<$count;$i++){
				$row = DB::fetch_assoc($result);
				$list_mods .= appoencode("`^{$row['name']}`n");
				$onlinecount_mods++;
			}
			DB::free_result($result);
			if ($onlinecount_mods == 0)
				$list_mods .= appoencode(translate_inline("`iNone`i"));

			$sql="SELECT name FROM " . DB::prefix("accounts") . " WHERE superuser = 0 AND locked=0 AND loggedin=1 AND laston>'".date("Y-m-d H:i:s",strtotime("-".getsetting("LOGINTIMEOUT",900)." seconds"))."' ORDER BY level DESC";
			$result = DB::query($sql);
			$count = DB::num_rows($result);
			$list_players = appoencode(sprintf(translate_inline("`bCharacters Online`n(%s Players):`b`n"),$count));
			$onlinecount_players = 0;
			for ($i=0;$i<$count;$i++){
				$row = DB::fetch_assoc($result);
				$list_players .= appoencode("`^{$row['name']}`n");
				$onlinecount_players++;
			}
			DB::free_result($result);
			if ($onlinecount_players == 0)
				$list_players .= appoencode(translate_inline("`iNone`i"));

			$args['list'] = $list_mods . "<br>" . $list_players;
			$args['count'] = $onlinecount_mods + $onlinecount_players;
            break;
    }
    return $args;
}

function onlinelist_run() {
}
?>