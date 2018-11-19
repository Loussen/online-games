<?php
//    require "./onlinegames/".$current_game_code;
    readfile(SITE_PATH."/onlinegames/".$current_game_code);
?>

<iframe src="<?=SITE_PATH?>/onlinegames/<?=$current_game_code?>"></iframe>
