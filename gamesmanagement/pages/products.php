<?php
$goster_cat=intval($_GET["goster_cat"]); //$doi gostermek ucun secilen kateqoriyadir
//if(mysqli_num_rows(mysqli_query($db,"select id from kateqoriyalar where id='$goster_cat' "))==0) $goster_cat=0;


//Paginator
$limit=intval($_GET["limit"]);
if($limit!=15 && $limit!=25 && $limit!=50 && $limit!=100 && $limit!=999999) $limit=15;
$query_count="select id from $do where lang_id='$main_lang' ";
if($goster_cat>0) $query_count.=" and kateqoriya='$goster_cat' ";
$count_rows=mysqli_num_rows(mysqli_query($db,$query_count));
$max_page=ceil($count_rows/$limit);
$page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
$start=$page*$limit-$limit;
//

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
    $sekil_hardan=$_FILES["file"]["tmp_name"];
    $bsekil_hardan=$_FILES["file_big"]["tmp_name"];
    if($edit>0)
    {
        $info_edit=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' "));
        $add_where="and auto_id='$edit' ";
        $auto_id=$edit;
        $son_sira=$info_edit["sira"];
        $aktivlik=$info_edit["aktivlik"];
    }

    $sql=mysqli_query($db,"select * from diller order by sira");
    while($row=mysqli_fetch_assoc($sql))
    {
        $basliq="basliq_".$row["id"]; $basliq=mysqli_real_escape_string($db,htmlspecialchars($$basliq));
        $text="text_".$row["id"]; $text=mysqli_real_escape_string($db,htmlspecialchars($$text));
        $address="address_".$row["id"]; $address=mysqli_real_escape_string($db,htmlspecialchars($$address));

        if($basliq=='' && $row["id"]!=$main_lang) {$c='basliq'; $$c=get_lang_val($do,$auto_id,$c);}
        if($text=='' && $row["id"]!=$main_lang) {$c='text'; $$c=get_lang_val($do,$auto_id,$c);}
        if($address=='' && $row["id"]!=$main_lang) {$c='address'; $$c=get_lang_val($do,$auto_id,$c);}

        if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$row[id]' $add_where"))>0 && $edit>0) mysqli_query($db,"update $do set title='$basliq',text='$text',cat_id='$cat_id' where lang_id='$row[id]' $add_where");
        else mysqli_query($db,"insert into $do values (0,'$name','$basliq','$link','$qisa_metn','','$text',0,0,'$son_sira', '$aktivlik', '$row[id]', '$auto_id', '0','$cat_id',0,0) ");

//        echo "insert into $do values (0,'$name','$title','$link','$qisa_metn','','$text',0,0,'$son_sira', '$aktivlik', '$row[id]', '$auto_id', '0','$cat_id',0,0) "; exit;

        //Thumb yaradir
        if($sekil_hardan!="")
        {
            $sekil_tip=$_FILES["file"]["type"];
            $sekil_name=strtolower($_FILES["file"]["name"]);
            $tip=end(explode(".",$sekil_name));
            $sekil_olar=false;
            if($tip=="jpg" || $tip=="bmp"  || $tip=="png" || $tip=="gif" || $tip=="jpeg") $sekil_olar=true;
            if($sekil_olar==true)
            {
                if($edit>0) $this_id=$edit;
                else
                {
                    $this_id=mysqli_insert_id($db);
                    $this_id=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where id='$this_id' "));
                    $this_id=$this_id["auto_id"];
                }
                move_uploaded_file($sekil_hardan,'../images/products/'.$this_id.'.'.$tip);
                mysqli_query($db,"update $do set tip='$tip' where auto_id='$this_id'");
                //Thumb yaradir
//				$uploaded_sekil='../images/menus/'.$this_id.'.'.$tip;
//				checkMaxSizeImage($uploaded_sekil);
//				$thumbFile='../images/menus/'.$this_id.'_thumb.'.$tip;
//				makeThumb($uploaded_sekil,$thumbFile,0,174);
                //
            }
        }
    }
    $ok="Məlumatlar uğurla yadda saxlanıldı.";
    $edit=0;
}


if($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$delete' "))>0)
{
    $sub_services = mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$delete' "));
    $tip=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$delete'"));
    mysqli_query($db,"delete from $do where auto_id='$delete' ");
    @unlink('../images/products/'.$delete.'.'.$tip["tip"]);
    $ok="Məlumat silindi.";
    $yeni_sira=1;
    $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and cat_id='$sub_services[cat_id]' order by sira"); $siraUpdate='';
    while($row=mysqli_fetch_assoc($sql)){
        $siraUpdate.=" when auto_id='$row[auto_id]' then '$yeni_sira' ";
        $yeni_sira++;
    }
    $query_update="update $do set sira=case".$siraUpdate."else sira end;"; if($siraUpdate!='') mysqli_query($db,$query_update);
}
elseif($up>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$up' "))>0)
{
    $sub_services = mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$up' "));
    $indiki_sira=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$up' and cat_id='$sub_services[cat_id]' ")); $indiki_sira=$indiki_sira["sira"];
    if($indiki_sira>1)
    {
        $asagi_sira=$indiki_sira-1;
        mysqli_query($db,"update $do set sira='-1' where sira='$asagi_sira' and cat_id='$sub_services[cat_id]' ");
        mysqli_query($db,"update $do set sira='$asagi_sira' where sira='$indiki_sira' and cat_id='$sub_services[cat_id]'");
        mysqli_query($db,"update $do set sira='$indiki_sira' where sira='-1' and cat_id='$sub_services[cat_id]' ");
    }

}
elseif($down>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$down' "))>0)
{
    $sub_services = mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$down' "));
    $indiki_sira=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$down' and cat_id='$sub_services[cat_id]' ")); $indiki_sira=$indiki_sira["sira"];
    $son_sira=mysqli_fetch_assoc(mysqli_query($db,"select sira from $do where cat_id='$sub_services[cat_id]' order by sira desc")); $son_sira=$son_sira["sira"];
    if($indiki_sira<$son_sira)
    {
        $yuxari_sira=$indiki_sira+1;
        mysqli_query($db,"update $do set sira='-1' where sira='$yuxari_sira' and cat_id='$sub_services[cat_id]' ");
        mysqli_query($db,"update $do set sira='$yuxari_sira' where sira='$indiki_sira' and cat_id='$sub_services[cat_id]' ");
        mysqli_query($db,"update $do set sira='$indiki_sira' where sira='-1' and cat_id='$sub_services[cat_id]' ");
    }
}
?>
<script type="text/JavaScript">
    function MM_jumpMenu(targ,selObj,restore){ //v3.0
        eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        if (restore) selObj.selectedIndex=0;
    }
</script>
<div class="onecolumn">
    <div class="header">
        <span>Məhsullar</span>
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
        <form action="index.php?do=<?php echo $do; ?>&page=<?php echo $page; ?>&goster_cat=<?php echo intval($goster_cat); ?><?php if($edit>0) echo '&edit='.$edit; ?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
            <a href="index.php?do=<?php echo $do; ?>&add=1" style="margin-right:50px"><img src="images/icon_add.png" alt="" /> <b>Yeni elave et</b></a>
            <hr class="clear" />
            <?php
            if($add==1 || $edit>0) $hide=""; else $hide="hide";

            $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$main_lang' "));
            $sql_faydali = mysqli_query($db,"SELECT `auto_id`,`name` FROM `menyular` WHERE lang_id='$main_lang' and aktivlik=1 and link='category'");
            echo '<div class="'.$hide.'">';
            echo 'Aid olduğu kateqoriya<br />
			<select name="cat_id" id="cat_id">';
            while($row_faydali=mysqli_fetch_assoc($sql_faydali))
            {
                if($row_faydali['auto_id']==$information["cat_id"]) echo '<option value="'.$row_faydali['auto_id'].'" selected="selected">'.$row_faydali['name'].'</option>';
                else  echo '<option value="'.$row_faydali['auto_id'].'">'.$row_faydali['name'].'</option>';
            }
            echo '</select><br class="clear" /><br />
			</div>';
		$sql=mysqli_query($db,"select * from diller order by sira");
		while($row=mysqli_fetch_assoc($sql))
		{
			if($add==1 || $edit>0) $hide=""; else $hide="hide";
			$information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$row[id]' "));

			if($lang_count>1) echo '<div id="tab'.$row["id"].'_content" class="tab_content '.$hide.'">'; else echo '<div class="'.$hide.'">';
			echo '  Ad:<br />
			  <input type="text" name="basliq_'.$row["id"].'" value="'.$information["title"].'" style="width:250px" />
			  <br /><br />
			  Text:<br />
			<textarea name="text_'.$row["id"].'" rows="1" cols="1" id="editor'.$row["sira"].'">'.$information["text"].'</textarea>
			<br /></div>
			  ';
		}
		$information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$main_lang' "));
		echo '<div class="'.$hide.'">';
		if($information["tip"]!="" && $edit>0) $sekili='<ul class="media_photos" style="margin-left:450px;margin-top:-25px"><li><a rel="slide" href="../images/products/'.$information["auto_id"].'.'.$information["tip"].'?rand='.rand(0,10000).'" title="">Hazırkı şəkil <img src="../images/products/'.$information ["auto_id"].'.'.$information["tip"].'?rand='.rand(0,10000).'" alt="" width="120" /></a><br class="clear" />
			  <a href="index.php?do='.$do.'&delete_img='.$information["auto_id"].'" title="Delete" class="delete"><img src="images/icon_delete.png" alt="" /></a></li></ul>'; else $sekili='';
            echo 'Şəkil (848 x 439): <input name="file" type="file" />'.$sekili.'<br /><br />';

            if($information["tip"]!="" && $edit>0) echo '<br /><br />';
            echo '<input type="submit" name="button" value=" Save " />
			  <hr class="clear" />
			  <br class="clear" /></div>';

            ?>
        </form>
        <a href="javascript:void(0);" class="chbx_del"><img src="images/icon_delete.png" alt="" title="" /></a>
        <a href="javascript:void(0);" class="chbx_active" data-val="1"><img src="images/1_lamp.png" alt="" title="" /></a>
        <a href="javascript:void(0);" class="chbx_active" data-val="2"><img src="images/0_lamp.png" alt="" title="" /></a>
        <input type="hidden" value="index.php?do=<?=$do?>&page=<?=$page?>&limit=<?=$limit?>&forId=2" id="current_link" />

        <!-- <u>Her sehifede goster:</u>
        <select name="limit" id="limit" onchange="MM_jumpMenu('parent',this,0)">
            <option value="index.php?<?=addFullUrl(array('limit'=>15,'page'=>0))?>" <?php if($limit==15) echo 'selected="selected"'; ?>>15</option>
            <option value="index.php?<?=addFullUrl(array('limit'=>25,'page'=>0))?>" <?php if($limit==25) echo 'selected="selected"'; ?>>25</option>
            <option value="index.php?<?=addFullUrl(array('limit'=>50,'page'=>0))?>" <?php if($limit==50) echo 'selected="selected"'; ?>>50</option>
            <option value="index.php?<?=addFullUrl(array('limit'=>100,'page'=>0))?>" <?php if($limit==100) echo 'selected="selected"'; ?>>100</option>
            <option value="index.php?<?=addFullUrl(array('limit'=>999999,'page'=>0))?>" <?php if($limit==999999) echo 'selected="selected"'; ?>>BÃ¼tÃ¼n</option>
        </select> -->

        <br class="clear" />
        <?php
        echo '<table class="data" width="100%" cellpadding="0" cellspacing="0"><thead><tr>
						<th style="width:50%"><input type="checkbox" data-val="0" name="all_check" id="hamisini_sec" value="all_check" /> Basliq</th><th style="width:20%">Aid oldugu məlumat</th>
						<th style="width:30%">Düzəlişlər</th>
</tr></thead><tbody>';
        $query=str_replace("select id ","select * ",$query_count);
        $query.=" order by auto_id desc limit $start,$limit";
        $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' order by cat_id asc,sira asc limit $start,$limit");
        while($row=mysqli_fetch_assoc($sql)){
            $row_faydali = mysqli_fetch_assoc(mysqli_query($db, "SELECT `name` FROM `menyular` WHERE aktivlik=1 and auto_id='$row[cat_id]' and link='category'"));
            echo '<tr>
					<td><input type="checkbox" id="chbx_'.$row["auto_id"].'" value="'.$row["auto_id"].'" onclick="chbx_(this.id)" /> '.stripslashes($row["title"]).'</td>
					<td>'.$row_faydali['name'].'</td>
					<td>
						<a href="index.php?do='.$do.'&page='.$page.'&edit='.$row["auto_id"].'"><img src="images/icon_edit.png" alt="" title="Edit" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&delete='.$row["auto_id"].'" class="delete"><img src="images/icon_delete.png" alt="" title="Sil" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&up='.$row["auto_id"].'"><img src="images/up.png" alt="" title="Yuxari" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&down='.$row["auto_id"].'"><img src="images/down.png" alt="" title="Asagi" /></a>';
            if($row["aktivlik"]==1) $title='Active'; else $title='Deactive';
            echo '<img src="images/'.$row["aktivlik"].'_lamp.png" title="'.$title.'" border="0" align="absmiddle" style="cursor:pointer" id="info_'.$row["auto_id"].'" onclick="aktivlik(\''.$do.'\',this.id,this.title)"  />';
            echo '</td>
				</tr>';
        }
        echo '</tbody></table>';
        ?>
        <div class="ps_"><?=page_nav()?></div>
        <?php			//Paginator ///////////////////////////////////////////
        echo '<div class="pagination">';
        $show=3;
        if($page>$show+1) echo '<a href="index.php?do='.$do.'&page=1">Ä°lk sÉ™hifÉ™</a>';
        if($page>1) echo '<a href="index.php?do='.$do.'&page='.($page-1).'">Â«</a>';
        for($i=$page-$show;$i<=$page+$show;$i++)
        {
            if($i==$page) $class='class="active"'; else $class='';;
            if($i>0 && $i<=$max_page) echo '<a href="index.php?do='.$do.'&page='.$i.'" '.$class.'>'.$i.'</a>';
        }
        if($page<$max_page) echo '<a href="index.php?do='.$do.'&page='.($page+1).'">Â»</a>';
        if($page<$max_page-$show && $max_page>1) echo '<a href="index.php?do='.$do.'&page='.$max_page.'"> Son sÉ™hifÉ™ </a>';
        echo '</div>'; //Paginator ///////////////////////////////////////////
        ?>
        <br class="clear" />
        <!-- Content end-->
    </div>
</div>