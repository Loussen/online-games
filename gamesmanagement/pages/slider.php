<?php
// Bu scriptde albom, saytin index.php faylinin yaninda bu directoride olmalidir:   $site/images/slider/$sekil_id.$sekil_tip;
$page=intval($_GET["page"]); if($page<1) $page=1;
$limit=10;
$max_page=ceil(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$main_lang'"))/$limit);
if($page>$max_page) $page=$max_page; if($page<1) $page=1;
$start=$page*$limit-$limit;

$add=intval($_GET["add"]);
$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$up=intval($_GET["up"]);
$down=intval($_GET["down"]);

if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$edit' "))==0) header("Location: index.php?do=$do");

if($_POST) // Add && edit
{
    extract($_POST);
    $son_sira=mysqli_fetch_assoc(mysqli_query($db,"select sira from $do order by sira desc")); $son_sira=intval($son_sira["sira"])+1;
    $auto_id=mysqli_fetch_assoc(mysqli_query($db,"select auto_id from $do order by auto_id desc")); $auto_id=intval($auto_id["auto_id"])+1;
    $aktivlik=1;
    $url=htmlspecialchars($url);
    $url2=htmlspecialchars($url2);
    $target=intval($target);
    if($target=="1") $target='target="_blank"'; else $target='';
    if($edit>0)
    {
        $info_edit=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' "));
        $add_where="and auto_id='$edit' ";
        $auto_id=$edit;
        $son_sira=$info_edit["sira"];
        $aktivlik=$info_edit["aktivlik"];
    }
    else $add_where="";

    ///////////////// Sekil isi
    $sekil=$_FILES["slide_file"]["tmp_name"];
    $sekil_type=$_FILES["slide_file"]["type"];
    $sekil_name=strtolower($_FILES["slide_file"]["name"]);
    $tip=end(explode(".",$sekil_name));
    $sekil_olar=false;
    if($sekil_type=="image/pjpeg" || $sekil_type=="image/jpeg" || $sekil_type=="image/bmp"  || $sekil_type=="image/x-png" || $sekil_type=="image/png" || $sekil_type=="image/gif" and ( $tip=="jpg" || $tip=="bmp"  || $tip=="png" || $tip=="gif" || $tip=="jpeg" ) ) $sekil_olar=true;
    //////////////////

    $sql=mysqli_query($db,"select * from diller order by sira");
    while($row=mysqli_fetch_assoc($sql))
    {
        $title1="title1_".$row["id"]; $title1=htmlspecialchars($$title1);
        $title2="title2_".$row["id"]; $title2=htmlspecialchars($$title2);
        $title3="title3_".$row["id"]; $title3=htmlspecialchars($$title3);

        if($title1=='' && $row["id"]!=$main_lang) {$c='title1'; $$c=get_lang_val($do,$auto_id,$c);}
        if($title2=='' && $row["id"]!=$main_lang) {$c='title2'; $$c=get_lang_val($do,$auto_id,$c);}
        if($title3=='' && $row["id"]!=$main_lang) {$c='title3'; $$c=get_lang_val($do,$auto_id,$c);}

        if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$row[id]' $add_where"))>0 && $edit>0)
        {
            mysqli_query($db,"update $do set title1='$title1',title2='$title2',title3='$title3',url='$url',url2='$url2',target='$target' where lang_id='$row[id]' $add_where");
            if($sekil!="" && $sekil_olar==true)
            {
                move_uploaded_file($sekil,'../images/slider/'.$auto_id.'.'.$tip);
                chmod('../images/slider/'.$auto_id.'.'.$tip, 0755);
                mysqli_query($db,"update $do set tip='$tip' where lang_id='$row[id]' $add_where");
                //Thumb yaradir
//					$uploaded_sekil='../images/slider/'.$auto_id.'.'.$tip;
//					checkMaxSizeImage($uploaded_sekil,$maxWidth=1920,$maxHeight=946);
//					$thumbFile='../images/slider/'.$auto_id.'_thumb.'.$tip;
//					makeThumb($uploaded_sekil,$thumbFile,910,270);
//					create_thumbnail($uploaded_sekil,'../images/slider/'.$auto_id.'.'.$tip,1302,400);
                //
            }
            elseif($sekil!="") $error="Şəkil tipi uyğun deyil.";
        }
        else
        {
            if($sekil!="" && $sekil_olar==true)
            {
                mysqli_query($db,"insert into $do values (0,'$title1','$title2','$title3','$tip','$url','','$target','$son_sira','$aktivlik','$row[id]','$auto_id') ");
                move_uploaded_file($sekil,'../images/slider/'.$auto_id.'.'.$tip);
                chmod('../images/slider/'.$auto_id.'.'.$tip, 0755);
                //Thumb yaradir
//					$uploaded_sekil='../images/slider/'.$auto_id.'.'.$tip;
//                    checkMaxSizeImage($uploaded_sekil,$maxWidth=1920,$maxHeight=946);
//					$thumbFile='../images/slider/'.$auto_id.'_thumb.'.$tip;
//					makeThumb($uploaded_sekil,$thumbFile,910,270);
//					create_thumbnail($uploaded_sekil,'../images/slider/'.$auto_id.'.'.$tip,1302,400);
                //
            }
            elseif($sekil!="") $error="Şəkil tipi uyğun deyil.";
        }
    }
    if($error=="") $ok="Məlumatlar uğurla yadda saxlanıldı.";
    $edit=0;
}

if($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$delete' "))>0)
{
    $tip=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$delete'"));
    mysqli_query($db,"delete from $do where auto_id='$delete' ");
    @unlink('../images/slider/'.$delete.'.'.$tip["tip"]);
    $ok="Məlumat silindi.";

    $yeni_sira=1;
    $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' order by sira"); $siraUpdate='';
    while($row=mysqli_fetch_assoc($sql)){
        $siraUpdate.=" when auto_id='$row[auto_id]' then '$yeni_sira' ";
        $yeni_sira++;
    }
    $query_update="update $do set sira=case".$siraUpdate."else sira end;"; if($siraUpdate!='') mysqli_query($db,$query_update);
}
elseif($up>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$up' "))>0)
{
    $indiki_sira=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$up' ")); $indiki_sira=$indiki_sira["sira"];
    if($indiki_sira>1)
    {
        $asagi_sira=$indiki_sira-1;
        mysqli_query($db,"update $do set sira='-1' where sira='$asagi_sira' ");
        mysqli_query($db,"update $do set sira='$asagi_sira' where sira='$indiki_sira' ");
        mysqli_query($db,"update $do set sira='$indiki_sira' where sira='-1' ");
    }

}
elseif($down>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$down' "))>0)
{
    $indiki_sira=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$down' ")); $indiki_sira=$indiki_sira["sira"];
    $son_sira=mysqli_fetch_assoc(mysqli_query($db,"select sira from $do order by sira desc")); $son_sira=$son_sira["sira"];
    if($indiki_sira<$son_sira)
    {
        $yuxari_sira=$indiki_sira+1;
        mysqli_query($db,"update $do set sira='-1' where sira='$yuxari_sira' ");
        mysqli_query($db,"update $do set sira='$yuxari_sira' where sira='$indiki_sira' ");
        mysqli_query($db,"update $do set sira='$indiki_sira' where sira='-1' ");
    }
}
?>
<div class="onecolumn">
    <div class="header">
        <span>Sliders</span>
        <div class="switch">
            <table cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <?php
                    $sql=mysqli_query($db,"select * from diller order by sira");
                    if(mysqli_num_rows($sql)>1 and ($add==1 || $edit>0) )
                    {
                        while($row=mysqli_fetch_assoc($sql))
                        {
                            echo '<td><input type="button" id="tab_lang'.$row["id"].'" onclick="tab_select(this.id)" class="left_switch" value="'.$row["ad"].'" style="width:50px"/></td>';
                        }
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br class="clear"/>
    <div class="content">
        <?php
        if($ok!="") echo '<div class="alert_success"><p><img src="images/icon_accept.png" alt="success" class="mid_align"/>'.$ok.'</p></div>';
        if($error!="") echo '<div class="alert_error"><p><img src="images/icon_error.png" alt="delete" class="mid_align"/>'.$error.'</p></div>';
        ?>
        <!-- Content start-->
        <form action="index.php?do=<?php echo $do; ?>&page=<?php echo $page; ?><?php if($edit>0) echo '&edit='.$edit; ?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
            <a href="index.php?do=<?php echo $do; ?>&add=1" style="margin-right:50px"><img style="vertical-align: text-top;" src="images/icon_add.png" alt="" /> <b>Yeni əlavə et</b></a>
            <hr class="clear" />
            <?php
            $sql=mysqli_query($db,"select * from diller order by sira");
            while($row=mysqli_fetch_assoc($sql))
            {
                if($add==1 || $edit>0) $hide=""; else $hide="hide";
                $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$row[id]' "));
                if($lang_count>1) echo '<div id="tab'.$row["id"].'_content" class="tab_content '.$hide.'">'; else echo '<div class="'.$hide.'">';

                echo 'Başlıq 1 :<br /><input name="title1_'.$row["id"].'" type="text" value="'.stripslashes($information["title1"]).'" style="width:500px" /><br /><br />';
                echo 'Başlıq 2 :<br /><input name="title2_'.$row["id"].'" type="text" value="'.stripslashes($information["title2"]).'" style="width:500px" /><br /><br />';
                echo 'Başlıq 3 :<br /><textarea style="width:500px; height: 100px;" name="title3_'.$row["id"].'">'.stripslashes($information["title3"]).'</textarea><br /><br />';
                echo '
			
		</div>';
            }
            $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$main_lang' "));
            ?>
            <?php echo '<div class="'.$hide.'">'; ?>
            <?php
            if($information["target"]!="") $selected2='selected="selected"'; else $selected1='selected="selected"';
            if(!isset($_GET["edit"])) {$selected1='selected="selected"'; $selected2='';}

            echo 'Button link :<br /><input name="url" type="text" value="'.stripslashes($information["url"]).'" style="width:500px" /><br /><br />';
            ?>
            Şəkil (1920 X 620)<br />
            <input name="slide_file" type="file" />
            <?php if($information["tip"]!="" && $edit>0) echo '<br /><br /><br /><ul class="media_photos" style="margin-left:380px;margin-top:-80px"><li><a rel="slide" href="../images/slider/'.$information["auto_id"].'.'.$information["tip"].'?rand='.rand(0,10000).'" title="">Current image: <img src="../images/slider/'.$information["auto_id"].'.'.$information["tip"].'?rand='.rand(0,10000).'" alt="" width="75" height="75" /> </a></li></ul>';
            echo '<br class="clear" />
			  <br class="clear" />';
            if($information["tip"]!="" && $edit>0) echo '<br /><br />';
            echo '
		<input type="submit" name="button" value=" Save " />
		<hr class="clear" />';
            ?>
            <?php echo '</div>'; ?>

        </form>
        <a href="javascript:void(0);" class="chbx_del"><img src="images/icon_delete.png" alt="" title="" /></a>
        <a href="javascript:void(0);" class="chbx_active" data-val="1"><img src="images/1_lamp.png" alt="" title="" /></a>
        <a href="javascript:void(0);" class="chbx_active" data-val="2"><img src="images/0_lamp.png" alt="" title="" /></a>
        <input type="hidden" value="index.php?do=<?=$do?>&page=<?=$page?>&limit=<?=$limit?>&forId=2" id="current_link" />
        <?php
        echo '<table class="data" width="100%" cellpadding="0" cellspacing="0"><thead><tr><th style="width:10%">
<input type="checkbox" data-val="0" name="all_check" id="hamisini_sec" value="all_check" /></th>
<th style="width:30%">Başlıq</th><th style="width:30%">Şəkil</th><th style="width:15%">Düzəlişlər</th></tr></thead><tbody>';
        $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' order by sira limit $start,$limit");
        while($row=mysqli_fetch_assoc($sql))
        {
            echo '<tr>
					<td><input type="checkbox" id="chbx_'.$row["auto_id"].'" value="'.$row["auto_id"].'" onclick="chbx_(this.id)" /> </td>
					<td>'.$row['title1'].'</td>
					<td><ul class="media_photos" style="padding:0;margin-top:0px;margin-bottom:-40px"><li><a rel="slide" href="../images/slider/'.$row["auto_id"].'.'.$row["tip"].'" title=""><img src="../images/slider/'.$row["auto_id"].'.'.$row["tip"].'?rand='.rand(0,10000).'" width="100" height="60"></a></li></ul></td>
					<td>
						<a href="index.php?do='.$do.'&page='.$page.'&edit='.$row["auto_id"].'"><img src="images/icon_edit.png" alt="" title="Edit" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&delete='.$row["auto_id"].'" class="delete"><img src="images/icon_delete.png" alt="" title="Delete" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&up='.$row["auto_id"].'"><img src="images/up.png" alt="" title="Up" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&down='.$row["auto_id"].'"><img src="images/down.png" alt="" title="Down" /></a>';
            if($row["aktivlik"]==1) $title='Active'; else $title='Deactive';
            echo '<img src="images/'.$row["aktivlik"].'_lamp.png" title="'.$title.'" border="0" align="absmiddle" style="cursor:pointer" id="info_'.$row["auto_id"].'" onclick="aktivlik(\''.$do.'\',this.id,this.title)"  />';
            echo '</td>
				</tr>';
        }
        echo '</tbody></table>';
        ?>
        <?php			//Paginator ///////////////////////////////////////////
        echo '<div class="pagination">';
        $show=3;
        if($page>$show+1) echo '<a href="index.php?do='.$do.'&page=1">İlk səhifə</a>';
        if($page>1) echo '<a href="index.php?do='.$do.'&page='.($page-1).'">«</a>';
        for($i=$page-$show;$i<=$page+$show;$i++)
        {
            if($i==$page) $class='class="active"'; else $class='';;
            if($i>0 && $i<=$max_page) echo '<a href="index.php?do='.$do.'&page='.$i.'" '.$class.'>'.$i.'</a>';
        }
        if($page<$max_page) echo '<a href="index.php?do='.$do.'&page='.($page+1).'">»</a>';
        if($page<$max_page-$show && $max_page>1) echo '<a href="index.php?do='.$do.'&page='.$max_page.'"> Son səhifə </a>';
        echo '</div>'; //Paginator ///////////////////////////////////////////
        ?>
        <!-- Content end-->
    </div>
</div>