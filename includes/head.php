<?php
/**
 * Created by PhpStorm.
 * User: fuad
 * Date: 1/16/17
 * Time: 6:18 PM
 */
?>

<?php
    $stmt_select = mysqli_prepare($db,"SELECT `description_`,`title_`,`keywords_` FROM `seo` WHERE `lang_id`=(?) LIMIT 1");
    $stmt_select->bind_param('i', $main_lang);
    $stmt_select->execute();
    $stmt_select->bind_result($site_description,$site_title,$site_keywords);
    $stmt_select->fetch();
    $stmt_select->close();

//    $info_description=mysqli_fetch_assoc(mysqli_query($db,"select `description_`,`title_`,`keywords_` from `seo` where `lang_id`='$esas_dil' "));
    $description=$site_description;
    $title=$site_title;
    $image=SITE_PATH.'/images/logo/ASET-LOGO2.png';
    $keywords = $site_keywords;
    $og_url ='http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

    if($do=="category")
    {
        $category_id = intval($_GET['id']);

        // Paginator
        $stmt_select = mysqli_prepare($db,
            "SELECT 
                    `id`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `category_id`=(?)
                    order by `order_number` asc");
        $stmt_select->bind_param('iii', $main_lang,$active_status,$category_id);
        $stmt_select->execute();
        $stmt_select->store_result();

        echo $stmt_select->num_rows; exit;
        // Paginator

        $stmt_select = mysqli_prepare($db,
            "SELECT 
                    `name`,
                    `image_name`,
                    `auto_id`
                    FROM `games`
                    WHERE `lang_id`=(?) and `active`=(?) and `category_id`=(?)
                    order by `order_number` asc");
        $stmt_select->bind_param('iii', $main_lang,$active,$category_id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="online-games")
    {
        echo $do;
    }
?>
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
<!--<link rel="icon" href="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico" sizes="32x32">-->
<!--<link rel="icon" href="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico" sizes="192x192">-->
<!--<link rel="apple-touch-icon-precomposed"-->
<!--      href="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico">-->
<!--<meta name="msapplication-TileImage"-->
<!--      content="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico">-->
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


