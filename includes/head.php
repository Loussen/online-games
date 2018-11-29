<?php
/**
 * Created by PhpStorm.
 * User: fuad
 * Date: 1/16/17
 * Time: 6:18 PM
 */
?>

<?php
    if(!$cache->isCached('seo'))
    {
        $stmt_select = mysqli_prepare($db,"SELECT `description_`,`title_`,`keywords_` FROM `seo` WHERE `lang_id`=(?) LIMIT 1");
        $stmt_select->bind_param('i', $main_lang);
        $stmt_select->execute();
        $stmt_select->bind_result($site_description,$site_title,$site_keywords);
        $stmt_select->fetch();
        $stmt_select->close();

        $description = $site_description;
        $title = $site_title;
        $image = SITE_PATH.'/assets/img/GameEthio.png';
        $keywords = $site_keywords;
        $og_url = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

        $cache->store('seo', [
                'description'   => $site_description,
                'title'         => $site_title,
                'image'         => SITE_PATH.'/assets/img/GameEthio.png',
                'keywords'      => $site_keywords,
                'og_url'        => 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]
        ],100);
    }
    else
    {
        $cache_seo_result = $cache->retrieve('seo');

        $description = $cache_seo_result['description'];
        $title = $cache_seo_result['title'];
        $image = $cache_seo_result['image'];
        $keywords = $cache_seo_result['keywords'];
        $og_url = $cache_seo_result['og_url'];
    }

    if($do=="category")
    {
        $category_id = intval($_GET['id']);
        $category_slug = mysqli_real_escape_string($db,$_GET['slug']);

        // Get current category
        if(!$cache->isCached('current_category_'.$category_id.$category_slug))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT
            `name`,
            `auto_id`
            FROM `categories`
            WHERE `lang_id`=(?) and `active`=(?) and `auto_id`=(?)
            LIMIT 1");
            $stmt_select->bind_param('iii', $main_lang,$active_status,$category_id);
            $stmt_select->execute();
            $stmt_select->bind_result($current_category_name,$current_category_id);
            $stmt_select->fetch();
            $stmt_select->close();

            $cache->store('current_category_'.$category_id.$category_slug,[
                    'current_category_name' =>  $current_category_name,
                    'current_category_id'   =>  $current_category_id
            ],100);
        }
        else
        {
            $cache_current_category_result = $cache->retrieve('current_category_'.$category_id.$category_slug);
            $current_category_name = $cache_current_category_result['current_category_name'];
            $current_category_id = $cache_current_category_result['current_category_id'];
        }

        if($category_slug!=slugGenerator($current_category_name) || $current_category_id!=$category_id)
        {
            header("Location: ".SITE_PATH."/404");
            exit('Redirecting...');
        }

        // Paginator
        $limit = 10;

        $stmt_select = mysqli_prepare($db,
            "SELECT 
                    `id`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `category_id`=(?)
                    order by `order_number` asc");
        $stmt_select->bind_param('iii', $main_lang,$active_status,$category_id);
        $stmt_select->execute();
        $stmt_select->store_result();

        $count_rows = $stmt_select->num_rows;
        $max_page=ceil($count_rows/$limit);
        $page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page;
        if($page<1) $page = 1;
        $start=$page*$limit-$limit;
        $stmt_select->close();

        if(!$cache->isCached('result_games_by_categories_'.$category_id.$category_slug))
        {
            // Get games by category
            $stmt_select = mysqli_prepare($db,
                "SELECT 
                    `name`,
                    `image_name`,
                    `auto_id`,
                    `star`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `category_id`=(?)
                    order by `order_number` asc limit $start,$limit");

            $stmt_select->bind_param('iii', $main_lang,$active_status,$category_id);
            $stmt_select->execute();
            $result_games_by_categories = $stmt_select->get_result();
            $stmt_select->close();

            $result_games_by_categories_arr = [];
            while($row=$result_games_by_categories->fetch_assoc())
            {
                $result_games_by_categories_arr[] = $row;
            }

            $cache->store('result_games_by_categories_'.$category_id.$category_slug,$result_games_by_categories_arr, 100);
        }
        else
        {
            $result_games_by_categories_arr = $cache->retrieve('result_games_by_categories_'.$category_id.$category_slug);
        }

        // Get all categories
        if(!$cache->isCached('all_categories'))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT
            `name`,
            `auto_id`
            FROM `categories`
            WHERE `lang_id`=(?) and `active`=(?)");
            $stmt_select->bind_param('ii', $main_lang,$active_status);
            $stmt_select->execute();
            $result_all_categories = $stmt_select->get_result();
            $stmt_select->close();

            $result_all_categories_arr = [];
            while($row=$result_all_categories->fetch_assoc())
            {
                $result_all_categories_arr[] = $row;
            }

            $cache->store('all_categories',$result_all_categories_arr, 100);
        }
        else
        {
            $result_all_categories_arr = $cache->retrieve('all_categories');
        }

        // Get recommandation games
        $recogame_status = 1;

        if(!$cache->isCached('reco_games'))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT 
                    `name`,
                    `image_name`,
                    `auto_id`,
                    `text`,
                    `star`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `recogame`=(?)
                    order by `order_number` asc LIMIT 3");

            $stmt_select->bind_param('iii', $main_lang,$active_status,$recogame_status);
            $stmt_select->execute();
            $result_games_reco = $stmt_select->get_result();
            $stmt_select->close();

            $result_reco_games_arr = [];
            while($row=$result_games_reco->fetch_assoc())
            {
                $result_reco_games_arr[] = $row;
            }

            $cache->store('reco_games',$result_reco_games_arr, 100);
        }
        else
        {
            $result_reco_games_arr = $cache->retrieve('reco_games');
        }


        $title = $title.' - '.$current_category_name.' games';
        $description = $current_category_name;
    }
    elseif($do=="inner")
    {
        $game_id = intval($_GET['id']);
        $game_slug = mysqli_real_escape_string($db,$_GET['slug']);

        // Get game info
        if(!$cache->isCached('game_inner_'.$game_id.$game_slug))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT 
                    `games`.`auto_id` as `g_id`,
                    `games`.`name` as `g_name`,
                    `games`.`image_name` as `g_image_name`,
                    `games`.`text` as `g_text`,
                    `games`.`star` as `g_star`,
                    `categories`.`name` as `c_name`,
                    `categories`.`auto_id` as `c_id`
                    FROM `games`
                    LEFT JOIN `categories` on `games`.`category_id`=`categories`.`auto_id`
                    WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `games`.`auto_id`=(?)
                    LIMIT 1");
            $stmt_select->bind_param('iii', $main_lang,$active_status,$game_id);
            $stmt_select->execute();
            $stmt_select->bind_result($current_game_id,$current_game_name,$current_game_image_name,$current_game_text,$current_game_star,$current_category_name,$current_category_id);
            $stmt_select->fetch();
            $stmt_select->close();

            $cache->store('game_inner_'.$game_id.$game_slug,[
                    'current_game_id'           => $current_game_id,
                    'current_game_name'         => $current_game_name,
                    'current_game_image_name'   => $current_game_image_name,
                    'current_game_text'         => $current_game_text,
                    'current_game_star'         => $current_game_star,
                    'current_category_name'     => $current_category_name,
                    'current_category_id'       => $current_category_id
            ],100);
        }
        else
        {
            $cache_game_inner_result = $cache->retrieve('game_inner_'.$game_id.$game_slug);

            $current_game_id = $cache_game_inner_result['current_game_id'];
            $current_game_name = $cache_game_inner_result['current_game_name'];
            $current_game_image_name = $cache_game_inner_result['current_game_image_name'];
            $current_game_text = $cache_game_inner_result['current_game_text'];
            $current_game_star = $cache_game_inner_result['current_game_star'];
            $current_category_name = $cache_game_inner_result['current_category_name'];
            $current_category_id = $cache_game_inner_result['current_category_id'];
        }


        if($game_id!=$current_game_id || $game_slug!=slugGenerator($current_game_name))
        {
            header("Location: ".SITE_PATH."/404");
            exit('Redirecting...');
        }

        // Get game's gallery
//        $stmt_select = mysqli_prepare($db,
//            "SELECT
//            `image_name`
//            FROM `gallery`
//            WHERE `game_id`=(?)");
//        $stmt_select->bind_param('i', $game_id);
//        $stmt_select->execute();
//        $result_game_gallery = $stmt_select->get_result();
//        $count_gallery = mysqli_num_rows($result_game_gallery);
//        $stmt_select->close();

        // Get most played games without current game
        $stmt_select = mysqli_prepare($db,
            "SELECT
                    `play_game`.`id`
                    FROM `play_game`
                    LEFT JOIN `games` on `games`.`auto_id`=`play_game`.`games_id`
                    WHERE `games`.`lang_id`=(?) and `games`.`active`=(?)
                    GROUP BY `play_game`.`games_id`");
        $stmt_select->bind_param('ii', $main_lang,$active_status);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        $count_games = mysqli_num_rows($result);

        if($count_games>0)
        {
            if(!$cache->isCached('most_played_'.$game_id.$game_slug))
            {
                $stmt_select = mysqli_prepare($db,
                    "SELECT 
                        `games`.`name` as `g_name`,
                        `games`.`image_name` as `g_image_name`,
                        `games`.`auto_id` as `g_id`,
                        `games`.`star` as `g_star`,
                        sum(`play_game`.`count`) as `play_count`
                        FROM `play_game`
                        LEFT JOIN `games` on `games`.`auto_id`=`play_game`.`games_id`
                        WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `games`.`auto_id`!=(?)
                        GROUP BY `play_game`.`games_id` order by `play_count` desc LIMIT 20");
                $stmt_select->bind_param('iii', $main_lang,$active_status,$game_id);
                $stmt_select->execute();
                $result_most_played_game = $stmt_select->get_result();

                $result_most_played_games_arr = [];
                while($row=$result_most_played_game->fetch_assoc())
                {
                    $result_most_played_games_arr[] = $row;
                }

                $cache->store('most_played_'.$game_id.$game_slug,$result_most_played_games_arr, 100);
            }
            else
            {
                $result_most_played_games_arr = $cache->retrieve('most_played_'.$game_id.$game_slug);
            }
        }
        else
        {
            if(!$cache->isCached('most_played_'.$game_id.$game_slug))
            {
                $stmt_select = mysqli_prepare($db,
                    "SELECT 
                        `games`.`name` as `g_name`,
                        `games`.`image_name` as `g_image_name`,
                        `games`.`auto_id` as `g_id`,
                        `games`.`star` as `g_star`
                        FROM `games`
                        WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `games`.`topgame`=0 and `games`.`recogame`=1 and `games`.`auto_id`!=(?)
                        order by `games`.`order_number` asc LIMIT 20");
                $stmt_select->bind_param('iii', $main_lang,$active_status,$game_id);
                $stmt_select->execute();
                $result_most_played_game = $stmt_select->get_result();

                $result_most_played_games_arr = [];
                while($row=$result_most_played_game->fetch_assoc())
                {
                    $result_most_played_games_arr[] = $row;
                }

                $cache->store('most_played_'.$game_id.$game_slug,$result_most_played_games_arr, 100);
            }
            else
            {
                $result_most_played_games_arr = $cache->retrieve('most_played_'.$game_id.$game_slug);
            }
        }
        $stmt_select->close();

        // Get similar games
        if(!$cache->isCached('similar_game_'.$game_id.$game_slug))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT
                    `auto_id`,
                    `name`,
                    `image_name`,
                    `star`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `category_id`=(?) and `auto_id`!=(?)
                    order by `order_number` asc");
            $stmt_select->bind_param('iiii', $main_lang,$active_status,$current_category_id,$game_id);
            $stmt_select->execute();
            $result_similar_games = $stmt_select->get_result();
            $stmt_select->close();

            $result_similar_games_arr = [];
            while($row=$result_similar_games->fetch_assoc())
            {
                $result_similar_games_arr[] = $row;
            }

            $cache->store('similar_game_'.$game_id.$game_slug,$result_similar_games_arr, 100);
        }
        else
        {
            $result_similar_games_arr = $cache->retrieve('similar_game_'.$game_id.$game_slug);
        }


        $title = $title.' - '.$current_category_name.' - '.$current_game_name;
        $image = SITE_PATH."/images/games/".$current_game_image_name;
        $description = $current_game_name;
    }
    elseif($do=="faq")
    {
        // Get f.a.q
        if(!$cache->isCached('faq'))
        {
            $stmt_select = mysqli_prepare($db,
                "SELECT 
                    `question`,
                    `answer`
                    FROM `faq`
                    WHERE `lang_id`=(?) and `active`=(?)
                    order by `order_number` asc");
            $stmt_select->bind_param('ii', $main_lang,$active_status);
            $stmt_select->execute();
            $result_faq = $stmt_select->get_result();
            $stmt_select->close();

            $result_faq_arr = [];
            while($row=$result_faq->fetch_assoc())
            {
                $result_faq_arr[] = $row;
            }

            $cache->store('faq',$result_faq_arr, 100);
        }
        else
        {
            $result_faq_arr = $cache->retrieve('faq');
        }

        $title = $title.' - Frequently Asked Questions';
    }
    elseif($do=="search")
    {
        $search = mysqli_real_escape_string($db,$_GET['search']);

        if(strlen($search)>=3)
        {
            $search_param = "%{$search}%";

            // Get searched games
            $stmt_select = mysqli_prepare($db,
                "SELECT 
                    `auto_id`,
                    `name`,
                    `image_name`,
                    `star`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `name` LIKE ?");
            $stmt_select->bind_param('iis', $main_lang,$active_status,$search_param);
            $stmt_select->execute();
            $result_search = $stmt_select->get_result();
            $count_games = mysqli_num_rows($result_search);
            $stmt_select->close();
        }
        else
        {
            $count_games = 0;
        }

        $title = $title.' - Search';
    }
//    elseif($do=="play_game")
//    {
//        if(subscribe_check($db)==true)
//        {
//            $game_id = intval($_GET['id']);
//            $game_slug = mysqli_real_escape_string($db,$_GET['slug']);
//
//            // Get game info
//            $stmt_select = mysqli_prepare($db,
//                "SELECT
//                    `auto_id`,
//                    `name`,
//                    `code`
//                    FROM `games`
//                    WHERE `lang_id`=(?) and `active`=(?) and `auto_id`=(?)
//                    LIMIT 1");
//            $stmt_select->bind_param('iii', $main_lang,$active_status,$game_id);
//            $stmt_select->execute();
//            $stmt_select->bind_result($current_game_id,$current_game_name,$current_game_code);
//            $stmt_select->fetch();
//            $stmt_select->close();
//
//            if($game_id!=$current_game_id || $game_slug!=slugGenerator($current_game_name))
//            {
//                header("Location: ".SITE_PATH."/404");
//                exit('Redirecting...');
//            }
//
//            $title = $title.' - '.' - '.$current_game_name;
//        }
//        else
//        {
//            header("Location: ".SITE_PATH."/404");
//            exit('Redirecting...');
//        }
//    }
?>
<base href="/">
<meta charset="utf-8">
<meta name="language" content="en" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

<meta property="description" content="<?=$description?>"/>
<meta property="keywords" content="<?=$keywords?>"/>
<meta property="og:type" content="article" />
<meta property="og:image" content="<?=$image?>"/>
<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />
<meta property="og:title" content="<?=$title?>"/>
<meta property="og:url" content="<?=SITE_PATH?>"/>
<meta property="og:description" content="<?=$description?>"/>

<!-- Favicon -->
    <link rel="shortcut icon" href="<?=SITE_PATH?>/assets/favicon/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="<?=SITE_PATH?>/assets/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="<?=SITE_PATH?>/assets/favicon/favicon-192.png">
    <link rel="icon" type="image/png" sizes="160x160" href="<?=SITE_PATH?>/assets/favicon/favicon-160.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=SITE_PATH?>/assets/favicon/favicon-96.png">
    <link rel="icon" type="image/png" sizes="64x64" href="<?=SITE_PATH?>/assets/favicon/favicon-64.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_PATH?>/assets/favicon/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_PATH?>/assets/favicon/favicon-16.png">
    <link rel="apple-touch-icon" href="<?=SITE_PATH?>/assets/favicon/favicon-57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_PATH?>/assets/favicon/favicon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_PATH?>/assets/favicon/favicon-72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=SITE_PATH?>/assets/favicon/favicon-144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=SITE_PATH?>/assets/favicon/favicon-60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=SITE_PATH?>/assets/favicon/favicon-120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=SITE_PATH?>/assets/favicon/favicon-76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=SITE_PATH?>/assets/favicon/favicon-152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_PATH?>/assets/favicon/favicon-180.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="<?=SITE_PATH?>/assets/favicon/favicon-144.png">
    <meta name="msapplication-config" content="<?=SITE_PATH?>/assets/favicon/browserconfig.xml">
<!-- Favicon -->

<title><?=$title?></title>

<link rel='stylesheet' id='layerslider-css' href='<?=SITE_PATH?>/assets/css/layerslider.css?ver=5.1.1' type='text/css' media='all'/>
<link rel='stylesheet' id='ls-google-fonts-css' href='<?=SITE_PATH?>/assets/css/fonts.googleapis.css' type='text/css' media='all'/>
<link rel='stylesheet' id='tsr-all-ie8-css' href='<?=SITE_PATH?>/assets/css/tsr-all-ie8.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='tsr-core-ol-ie-css' href='<?=SITE_PATH?>/assets/css/tsr-core-old-ie.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='tsr-core-css' href='<?=SITE_PATH?>/assets/css/tsr-core.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='main-css' href='<?=SITE_PATH?>/assets/css/main.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='bootstrap-css' href='<?=SITE_PATH?>/assets/css/bootstrap.min.css?ver=4.5.15' type='text/css' media='all'/>
<!--<link rel='stylesheet' href='--><?//=SITE_PATH?><!--/assets/css/modal.css' type='text/css' media='all'/>-->
<link rel='stylesheet' href='<?=SITE_PATH?>/assets/css/back.css' type='text/css' media='all'/>

<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.js'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery-migrate.min.js?ver=1.4.1'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/layerslider.kreaturamedia.jquery.js?ver=5.1.1'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/greensock.js?ver=1.11.2'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/layerslider.transitions.js?ver=5.1.1'></script>

<!-- Google Analytics -->

<!-- End Google Analytics -->

<?php
    if($lang==2)
        $lang_short = 'ru';
    elseif($lang==3)
        $lang_short = 'en';
    else
        $lang_short = 'az';
?>

<script>
    var base_url = '<?=SITE_PATH?>';
</script>


