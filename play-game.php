<?php
/**
 * Created by PhpStorm.
 * User: fhasanli
 * Date: 11/18/2018
 * Time: 11:43 AM
 */

include "gamesmanagement/pages/includes/config.php";

include "includes/functions.php";

if(subscribe_check($db))
{
    $game_id = intval($_GET['id']);
    $game_slug = mysqli_real_escape_string($db,$_GET['slug']);

    // Get game info
    $stmt_select = mysqli_prepare($db,
        "SELECT 
                    `auto_id`,
                    `name`,
                    `code`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `auto_id`=(?)
                    LIMIT 1");
    $stmt_select->bind_param('iii', $main_lang,$active_status,$game_id);
    $stmt_select->execute();
    $stmt_select->bind_result($current_game_id,$current_game_name,$current_game_code);
    $stmt_select->fetch();
    $stmt_select->close();

    if($game_id!=$current_game_id || $game_slug!=slugGenerator($current_game_name))
    {
        header("Location: ".SITE_PATH."/404");
        exit('Redirecting...');
    }

    ?>
    <style>
        html, body
        {
            margin: 0 !important;
        }
    </style>
    <iframe frameborder="0" src="<?=SITE_PATH."/onlinegames/".$current_game_code."/index.php"?>" style="width: 100%; height: 100%;"></iframe>
    <?php
}
else
{
    header("Location: ".SITE_PATH."/404");
    exit('Redirecting...');
}

?>