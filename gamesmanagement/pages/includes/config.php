<?php
ob_start(); session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$timezone = "Asia/Baku"; if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

define('host','localhost');
define('username','root');
define('password','');
define('db_name','onlinegames');


$site="http://".$_SERVER['SERVER_NAME'];	// sonda / iwaresi qoyulmasin
define('SITE_PATH',$site);	// URL of site
$time=time();
$this_day=date("Y-m-d");
function connect(){
    global $db;
    $db=mysqli_connect(host,username,password, db_name) or die(mysqli_error() );
    return $db;
}
connect();
mysqli_query($db,"set names utf8");
//mysqli_set_charset($link, "utf8")
ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');
include 'functions.php';
$this_ip=addslashes($_SERVER['REMOTE_ADDR']);
//Lang
$main_lang=mysqli_fetch_assoc(mysqli_query($db,"select id from diller where status='1' and aktivlik=1"));	$main_lang=$main_lang["id"];
$lang_count=mysqli_num_rows(mysqli_query($db,"select id from diller where aktivlik=1"));
if(is_file('gamesmanagement/langs/index.php')) include 'gamesmanagement/langs/index.php';
elseif(is_file('langs/gamesmanagement/index.php')) include 'langs/gamesmanagement/index.php';


$contact_config = mysqli_fetch_assoc(mysqli_query($db,"SELECT `email`,`phone`,`facebook`,`youtube`,`twitter`,`google_map`,`address` FROM `contacts` WHERE `lang_id`='$main_lang'"));

$hava_active = 0;
if($hava_active==1)	//Hava update
{
    $query_update="update hava set ";
    $regions=array(
        'baki'=>'27103',
//        'sumqayit'=>'26921',
//        'gence'=>'28166',
//        'lenkeran'=>'29090',
//        'quba'=>'30500',
//        'seki'=>'27610',
//        'sirvan'=>'30724',
//        'mingecevir'=>'29699',
//        'naxcivan'=>'30012',
//        'susa'=>'30815',

    );
    foreach($regions as $key=>$val){
        $datas=get_fcontent("http://www.accuweather.com/az/az/baku/".$val."/daily-weather-forecast/".$val);
        $all_hava=$datas[0]; $this_hava=strstr($all_hava,'<span class="temp">');
        $gunduz=intval(substr($this_hava,19,5)); $this_hava=substr($this_hava,19); $this_hava=strstr($this_hava,'<span class="temp">');
        $gece=intval(substr($this_hava,19,5)); $this_hava=$gunduz."```".$gece;
        $query_update.="$key='$this_hava', ";
    }

    $query_update.=" tarix='$this_day' ";
    mysqli_query($db,$query_update);
}

//

// Online guest count
/*
$this_link=strstr(safe($_SERVER['REQUEST_URI']),"index.php");
$online_time=1800; //30 deqiqe
$all_online=mysqli_num_rows(mysqli_query($db,"select id from visitors where last_visit>$time-$online_time "));
$user_online=mysqli_num_rows(mysqli_query($db,"select id from users where last_visit>$time-$online_time "));
$guest_online=$all_online-$user_online;
*/

//Visitors...
/*
if(mysqli_num_rows(mysqli_query($db,"select id from visitors where ip='$this_ip' and first_visit='$this_day' "))==0)
mysqli_query($db,"insert into visitors values ('','$this_ip','$this_day','$time')");
else mysqli_query($db,"update visitors set last_visit='$time' where ip='$this_ip' and first_visit='$this_day' ");
*/
//

//Static update.php
//include 'static_update.php';
include "check_site_user.php";
?>