<?php
/**
 * Created by PhpStorm.
 * User: fuad
 * Date: 1/16/17
 * Time: 6:18 PM
 */
?>

<?php
    $info_description=mysqli_fetch_assoc(mysqli_query($db,"select `description_`,`title_`,`keywords_` from `seo` where `lang_id`='$esas_dil' "));
    $description=$info_description["description_"];
    $title=$info_description["title_"];
    $image=SITE_PATH.'/images/logo/ASET-LOGO2.png';
    $keywords = $info_description["keywords_"];
    $og_url ='http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

    if($do=="company")
    {
        $sql_company = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`text`,`auto_id`,`tip` FROM `about` WHERE `lang_id`='$esas_dil' and `aktivlik`=1"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name` from `menyular` where lang_id='$esas_dil' and link='company' and `aktivlik`=1"));
        $title = $info_description["title_"].' - '.$menyu['name'];
        $image = SITE_PATH.'/images/about/'.$sql_company['auto_id'].'.'.$sql_company['tip'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_company['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="project")
    {
        $sql_project = mysqli_query($db, "SELECT `auto_id`,`tip`,`name` FROM `project` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name` from `menyular` where lang_id='$esas_dil' and link='project' and `aktivlik`=1"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="project-detail")
    {
        $id = intval($_GET['id']);
        $sql_project_inner = mysqli_fetch_assoc(mysqli_query($db,"SELECT `auto_id`,`tip`,`name`,`text` FROM `project` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link` from `menyular` where lang_id='$esas_dil' and link='project' and `aktivlik`=1"));
        $image = SITE_PATH.'/images/project/'.$sql_project_inner['auto_id'].'.'.$sql_project_inner['tip'];
        $title = $info_description["title_"].' - '.$menyu['name'].' - '.$sql_project_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_project_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="services")
    {
        $sql_services = mysqli_query($db,"SELECT `auto_id`,`fontawesome`,`name`,`qisa_metn` FROM services WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name` from `menyular` where lang_id='$esas_dil' and link='services' and `aktivlik`=1"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="service")
    {
        $id = intval($_GET['id']);
        $sql_service_inner = mysqli_fetch_assoc(mysqli_query($db,"SELECT `auto_id`,`tip`,`name`,`text` FROM `services` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link` from `menyular` where lang_id='$esas_dil' and link='services' and `aktivlik`=1"));
        $image = SITE_PATH.'/images/services/'.$sql_service_inner['auto_id'].'.'.$sql_service_inner['tip'];
        $title = $info_description["title_"].' - '.$menyu['name'].' - '.$sql_service_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_service_inner['text'])),0,250,"utf-8").'...';

        $sql_service_other = mysqli_query($db,"SELECT `auto_id`,`fontawesome`,`name`,`qisa_metn` FROM services WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`!='$id' order by `sira`");
    }
    elseif($do=="partners")
    {
        $sql_partners = mysqli_query($db, "SELECT `auto_id`,`tip`,`name` FROM `partners` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name` from `menyular` where lang_id='$esas_dil' and link='partners' and `aktivlik`=1"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="partner")
    {
        $id = intval($_GET['id']);
        $sql_partner_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`tip`,`name`,`text` FROM `partners` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id' order by `sira`"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link` from `menyular` where lang_id='$esas_dil' and link='partners' and `aktivlik`=1"));
        $image = SITE_PATH.'/images/partners/'.$sql_partner_inner['auto_id'].'.'.$sql_partner_inner['tip'];
        $title = $info_description["title_"].' - '.$menyu['name'].' - '.$sql_partner_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_partner_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=='news')
    {
        //Paginator
        $limit = 10;
        $query_count="select `id` from `blog` where `aktivlik`=1 and `lang_id`='$esas_dil' and `text`!=''";
        $count_rows=mysqli_num_rows(mysqli_query($db,$query_count));
        $max_page=ceil($count_rows/$limit);
        $page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page;
        if($page<1) $page = 1;
        $start=$page*$limit-$limit;
        //

        $sql_news = mysqli_query($db,"select `created_at`,`tip`,`name`,`auto_id`,`qisa_metn` from `blog` where `aktivlik`=1 and `lang_id`='$esas_dil' and `text`!='' order by `created_at` desc limit $start,$limit");

        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='news' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="news-inner")
    {
        $id = intval($_GET['id']);
        $sql_news_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`tip`,`name`,`text`,`created_at` FROM `blog` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id' and `text`!='' order by `sira`"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='news' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $image = SITE_PATH.'/images/blog/'.$sql_news_inner['auto_id'].'.'.$sql_news_inner['tip'];
        $title = $info_description["title_"].' - '.$menyu['name'].' - '.$sql_news_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_news_inner['text'])),0,250,"utf-8").'...';

        $sql_news_gallery = mysqli_query($db, "SELECT `id`,`tip` FROM `news_gallery` WHERE `blog_id`='$sql_news_inner[auto_id]' order by `id`");
    }
    elseif($do=="leadership")
    {
        $sql_leadership = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`tip`,`name`,`text` FROM `rehber` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira` desc LIMIT 1"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='leadership' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $image = SITE_PATH.'/images/about/'.$sql_leadership['auto_id'].'.'.$sql_leadership['tip'];
        $title = $info_description["title_"].' - '.$menyu['name'].' - '.$sql_leadership['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_leadership['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="dmx")
    {
        $sql_dmx = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`tip`,`name`,`text` FROM `dmx` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira` desc LIMIT 1"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='dmx' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'].' - '.$sql_dmx['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_dmx['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="legislation")
    {
        $type = strip_tags($_GET['slug']);
        if($type=='naxacts')
            $act_id = 2;
        elseif($type=='globacts')
            $act_id = 3;
        else
            $act_id = 1;

        $sql_acts = mysqli_query($db, "SELECT `auto_id`,`basliq`,`tip`,`act_id` FROM `acts` WHERE `act_id`='$act_id' and `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='legislation/$type' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="legislation-inner")
    {
        $id = intval($_GET['id']);

        $sql_acts = mysqli_query($db, "SELECT `auto_id`,`basliq`,`tip`,`act_id` FROM `acts` WHERE `act_sub_id`='$id' and `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang72;
    }
    elseif($do=="booklet")
    {
        $sql_booklet = mysqli_query($db, "SELECT `auto_id`,`name` FROM `beledci` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang27;
    }
    elseif($do=="booklet-inner")
    {
        $id = intval($_GET['id']);
        $sql_booklet_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`name`,`text` FROM `beledci` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$sql_booklet_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_booklet_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="questions")
    {
        $sql_questions = mysqli_query($db, "SELECT `auto_id`,`name`,`text` FROM `sual` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang29;
    }
    elseif($do=="structure")
    {
        $sql_structure = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`tip`,`text` FROM `structure` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira` DESC LIMIT 1"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='structure' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="duties")
    {
        $sql_duties = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`qisa_metn`,`text` FROM `rusum` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira` desc LIMIT 1"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang28;
        $description=mb_substr(strip_tags(html_entity_decode($sql_duties['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="calculator")
    {
        $sql_calculator = mysqli_fetch_assoc(mysqli_query($db, "SELECT `text` FROM `calculator` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira` desc LIMIT 1"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang26;
        $description=mb_substr(strip_tags(html_entity_decode($sql_calculator['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="onlinequeue")
    {
        $_POST = array_map("strip_tags", $_POST);
        extract($_POST);
        $sql_novbe = mysqli_fetch_assoc(mysqli_query($db, "SELECT `text` FROM `novbe` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira` desc LIMIT 1"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang6;
        $description=mb_substr(strip_tags(html_entity_decode($sql_novbe['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="days")
    {
        $sql_days = mysqli_fetch_assoc(mysqli_query($db, "SELECT `qisa_metn`,`text` FROM `days` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira` desc LIMIT 1"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='days' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_days['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="interviews")
    {
        $sql_interviews = mysqli_query($db, "SELECT `auto_id`,`name` FROM `interviews` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='interviews' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="interviews-inner")
    {
        $id = intval($_GET['id']);
        $sql_interviews_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`name`,`text` FROM `interviews` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='interviews' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$sql_interviews_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_interviews_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="articles")
    {
        $sql_articles = mysqli_query($db, "SELECT `auto_id`,`name` FROM `articles` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='articles' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="articles-inner")
    {
        $id = intval($_GET['id']);
        $sql_articles_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`name`,`text` FROM `articles` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='articles' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$sql_articles_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_articles_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="audio")
    {
        $sql_audio = mysqli_query($db, "SELECT `auto_id`,`basliq` FROM `audio` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='audio' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="audio-inner")
    {
        $id = intval($_GET['id']);
        $sql_audio_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`basliq`,`tam_metn`,`tip` FROM `audio` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='audio' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$sql_audio_inner['basliq'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_audio_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="helpful")
    {
        $id = intval($_GET['id']);
        $sql_faydali_alt = mysqli_query($db, "SELECT `auto_id`,`basliq` FROM `faydali_alt` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `act_id`='$id' order by `sira`");
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang9;
    }
    elseif($do=="helpful-inner")
    {
        $id = intval($_GET['id']);
        $sql_faydali_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`basliq`,`text` FROM `faydali_alt` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$sql_faydali_inner['basliq'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_faydali_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="citizenship")
    {
        $id = intval($_GET['id']);
        $sql_citizenship_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`name`,`text` FROM `vetendasliq` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$sql_citizenship_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_citizenship_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="announcement")
    {
        $id = intval($_GET['id']);
        $sql_elanlar_inner = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`name`,`text` FROM `elanlar` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `auto_id`='$id'"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$sql_elanlar_inner['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_elanlar_inner['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="occupy")
    {
        $row_karabag = mysqli_fetch_assoc(mysqli_query($db, "SELECT `auto_id`,`text`,`tip` FROM `karabag` WHERE `lang_id`='$esas_dil' and `aktivlik`=1"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang41;
        $description=mb_substr(strip_tags(html_entity_decode($row_karabag['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="naxcivan")
    {
        $sql_naxcivan = mysqli_query($db, "SELECT `auto_id`,`name` FROM `naxcivan` WHERE `lang_id`='$esas_dil' and `aktivlik`=1");
        $sql_naxcivan_in = mysqli_query($db, "SELECT `auto_id`,`text`,`name` FROM `naxcivan` WHERE `lang_id`='$esas_dil' and `aktivlik`=1");
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang3;
    }
    elseif($do=="callcenter")
    {
        $row_callcenter = mysqli_fetch_assoc(mysqli_query($db, "SELECT `text` FROM `callcenter` WHERE `lang_id`='$esas_dil' and `aktivlik`=1"));
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang7;
        $description=mb_substr(strip_tags(html_entity_decode($row_callcenter['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="documents")
    {
        $sql_documents = mysqli_query($db, "SELECT `auto_id`,`name`,`text` FROM `senedler` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang30;
    }
    elseif($do=="letter")
    {
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='letter' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=='photo')
    {
        //Paginator
        $limit = 10;
        $query_count="select `id` from `alboms` where `aktivlik`=1 and `lang_id`='$esas_dil'";
        $count_rows=mysqli_num_rows(mysqli_query($db,$query_count));
        $max_page=ceil($count_rows/$limit);
        $page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page;
        if($page<1) $page = 1;
        $start=$page*$limit-$limit;
        //

        $sql_photo = mysqli_query($db,"select `tarix`,`tip`,`basliq`,`auto_id` from `alboms` where `aktivlik`=1 and `lang_id`='$esas_dil' order by `tarix` desc limit $start,$limit");

        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='photo' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="photo-inner")
    {
        $id = intval($_GET['id']);
        $row_photo = mysqli_fetch_assoc(mysqli_query($db,"select `tarix`,`tip`,`basliq`,`auto_id`,`tam_metn` from `alboms` where `aktivlik`=1 and `lang_id`='$esas_dil' and `auto_id`='$id'"));

        $sql_photo_inner = mysqli_query($db, "SELECT `id`,`tip` FROM `gallery` WHERE `albom_id`='$id' order by `tarix` desc");
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='photo' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $image = SITE_PATH.'/images/albom/'.$row_photo['auto_id'].'.'.$row_photo['tip'];
        $title = $info_description["title_"].' - '.$menyu['name'].' - '.$row_photo['basliq'];
        $description=mb_substr(strip_tags(html_entity_decode($row_photo['tam_metn'])),0,250,"utf-8").'...';
    }
    elseif($do=='video')
    {
        //Paginator
        $limit = 10;
        $query_count="select `id` from `videos` where `aktivlik`=1 and `lang_id`='$esas_dil'";
        $count_rows=mysqli_num_rows(mysqli_query($db,$query_count));
        $max_page=ceil($count_rows/$limit);
        $page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page;
        if($page<1) $page = 1;
        $start=$page*$limit-$limit;
        //

        $sql_video = mysqli_query($db,"select `tarix`,`tip`,`basliq`,`auto_id`,`video_link` from `videos` where `aktivlik`=1 and `lang_id`='$esas_dil' order by `tarix` desc limit $start,$limit");

        $menyu=mysqli_fetch_assoc(mysqli_query($db,"select `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='video' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
    }
    elseif($do=="contact")
    {
        $menyu=mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link`,`parent_auto_id` from `menyular` where lang_id='$esas_dil' and link='contact' and `aktivlik`=1"));
        $parent_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `name`,`link` FROM `menyular` WHERE `auto_id`='$menyu[parent_auto_id]'"));
        $title = $info_description["title_"].' - '.$menyu['name'];
        $description=mb_substr(strip_tags(html_entity_decode($sql_contact['text'])),0,250,"utf-8").'...';
    }
    elseif($do=="search")
    {
        $data = strip_tags($_GET['data']);
        //Paginator
        $limit = 10;
        $query_count="select `id` from `blog` where (`name` LIKE '%$data%' or `text` LIKE '%$data%') and `aktivlik`=1 and `lang_id`='$esas_dil' and `text`!=''";
        $count_rows=mysqli_num_rows(mysqli_query($db,$query_count));
        $max_page=ceil($count_rows/$limit);
        $page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page;
        if($page<1) $page = 1;
        $start=$page*$limit-$limit;
        //

        $sql_search = mysqli_query($db,"select `created_at`,`tip`,`name`,`auto_id`,`qisa_metn` from `blog` where (`name` LIKE '%$data%' or `text` LIKE '%$data%') and `aktivlik`=1 and `lang_id`='$esas_dil' and `text`!='' order by `created_at` desc limit $start,$limit");

        $main_menu = mysqli_fetch_assoc(mysqli_query($db,"SELECT `link`,`name` FROM `menyular` WHERE `lang_id`='$esas_dil' and `link`='/' and `aktivlik`=1 order by id DESC LIMIT 1"));
        $title = $info_description["title_"].' - '.$lang68;
    }
    else
    {
        $sql_services = mysqli_query($db,"SELECT `auto_id`,`fontawesome`,`name`,`qisa_metn` FROM services WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $sql_partner = mysqli_query($db, "SELECT `auto_id`,`tip`,`name` FROM `partners` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 order by `sira`");
        $sql_news = mysqli_query($db, "SELECT `auto_id`,`tip`,`name`,`qisa_metn`,`created_at` FROM `blog` WHERE `lang_id`='$esas_dil' and `aktivlik`=1 and `text`!='' order by `created_at` DESC");
        $sql_contact = mysqli_fetch_assoc(mysqli_query($db,"SELECT `address`,`text`,`phone`,`email` FROM `contacts` WHERE `lang_id`='$esas_dil'"));
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
<link rel="icon" href="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico" sizes="32x32">
<link rel="icon" href="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico" sizes="192x192">
<link rel="apple-touch-icon-precomposed"
      href="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico">
<meta name="msapplication-TileImage"
      content="http://play.ucell.uz/wp-content/themes/ucell-games/dist/images/favicon.ico">
<!-- Favicon -->

<title><?=$title?></title>

<link rel='stylesheet' id='layerslider-css' href='<?=SITE_PATH?>/<?=SITE_PATH?>/assets/css/layerslider.css?ver=5.1.1' type='text/css' media='all'/>
<link rel='stylesheet' id='ls-google-fonts-css' href='<?=SITE_PATH?>/assets/css/fonts.googleapis.css' type='text/css' media='all'/>
<link rel='stylesheet' id='tsr-all-ie8-css' href='<?=SITE_PATH?>/assets/css/tsr-all-ie8.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='tsr-core-ol-ie-css' href='<?=SITE_PATH?>/assets/css/tsr-core-old-ie.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='tsr-core-css' href='<?=SITE_PATH?>/assets/css/tsr-core.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='main-css' href='<?=SITE_PATH?>/assets/css/main.css?ver=4.5.15' type='text/css' media='all'/>
<link rel='stylesheet' id='bootstrap-css' href='<?=SITE_PATH?>/assets/css/bootstrap.min.css?ver=4.5.15' type='text/css' media='all'/>

<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.js?ver=1.12.4'></script>
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


