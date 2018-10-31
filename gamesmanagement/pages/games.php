<?php
$category_id=intval($_GET["category_id"]); //$do-nu gostermek ucun secilen kateqoriyadir
if(mysqli_num_rows(mysqli_query($db,"select id from categories where id='$category_id' "))==0) $category_id=0;

// Paginator
$limit=intval($_GET["limit"]);
if($limit!=15 && $limit!=25 && $limit!=50 && $limit!=100 && $limit!=999999) $limit=15;
$query_count="select id from $do where lang_id='$main_lang' ";
if($category_id>0) $query_count.=" and category_id='$category_id' ";
$count_rows=mysqli_num_rows(mysqli_query($db,$query_count));
$max_page=ceil($count_rows/$limit);
$page=intval($_GET["page"]); if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
$start=$page*$limit-$limit;
//

if($category_id>0) $add_information_sql = " and category_id='$category_id'";

$add=intval($_GET["add"]);
$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$up=intval($_GET["up"]);
$down=intval($_GET["down"]);

if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$edit' "))==0)
{
    header("Location: index.php?do=$do");
    exit;
}

if($_POST) // Add && edit
{
    extract($_POST);
    $last_order=mysqli_fetch_assoc(mysqli_query($db,"select order_number from $do order by order_number desc"));
    $last_order=intval($last_order["order_number"])+1;
    $auto_id=mysqli_fetch_assoc(mysqli_query($db,"select auto_id from $do order by auto_id desc"));
    $auto_id=intval($auto_id["auto_id"])+1;
    $active=1;

    $image_tmp = $_FILES["image_file"]["tmp_name"];

    $zip_tmp = $_FILES["zip_file"]["tmp_name"];

    if($edit>0)
    {
        $info_edit=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' "));
        $add_where="and auto_id='$edit' ";
        $auto_id=$edit;
        $last_order=$info_edit["order_number"];
        $active=$info_edit["active"];
    }
    else $add_where="";

    $sql=mysqli_query($db,"select * from diller where aktivlik=1 order by sira");
    while($row=mysqli_fetch_assoc($sql))
    {
        $name="name_".$row["id"]; $name=mysqli_real_escape_string($db,htmlspecialchars($$name));
        $text="text_".$row["id"]; $text=mysqli_real_escape_string($db,htmlspecialchars($$text));

//        if($name=='' && $row["id"]!=$main_lang) {$c='name'; $$c=get_lang_val($do,$auto_id,$c);}
//        if($text=='' && $row["id"]!=$main_lang) {$c='text'; $$c=get_lang_val($do,$auto_id,$c);}

        $time = time();

        if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$row[id]' $add_where"))>0 && $edit>0)
        {
            mysqli_query($db,"update $do set name='$name',text='$text',category_id='$category_id',updated_at='$time' where lang_id='$row[id]' $add_where");
        }
        else
        {
            mysqli_query($db,"insert into $do values (0,'$name','','$category_id','$text','$last_order','', '$active', '$row[id]', '$auto_id', '$time',0) ");
        }
    }

    if($edit>0) $this_id=$edit;
    else
    {
        $this_id=mysqli_insert_id($db);
        $this_id=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where id='$this_id' "));
        $this_id=$this_id["auto_id"];
    }

    // Image upload
    if($image_tmp!="")
    {
        $image_type=$_FILES["image_file"]["type"];
        $image_name=strtolower($_FILES["image_file"]["name"]);
        $type=end(explode(".",$image_name));
        $image_access=false;
        if($type=="jpg" || $type=="bmp"  || $type=="png" || $type=="gif" || $type=="jpeg") $image_access=true;
        if($image_access==true)
        {
            $image_upload_name = substr(sha1(mt_rand()),17,15)."-".$image_name.".".$type;

            if($edit>0)
            {
                $old_image_name = mysqli_fetch_assoc(mysqli_query($db,"SELECT image_name FROM $do WHERE id='$this_id'"));
                @unlink("../images/games/".$old_image_name['image_name']);
            }

            move_uploaded_file($image_tmp,'../images/games/'.$image_upload_name);
            mysqli_query($db,"update $do set image_name='$image_upload_name' where auto_id='$this_id'");
        }
    }

    //Zip file upload & unpack
    if($zip_tmp!="")
    {
        $filename = $_FILES["zip_file"]["name"];
        $source = $_FILES["zip_file"]["tmp_name"];
        $type = $_FILES["zip_file"]["type"];

        $original_type = end(explode(".",$filename));

        $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');

        $continue = (strtolower($original_type) == 'zip' && in_array($type,$accepted_types)) ? true : false;

        if($continue==true)
        {
            $folder_name = substr(sha1(mt_rand()),17,8);

            if($edit>0)
            {
                $old_folder_path = mysqli_fetch_assoc(mysqli_query($db,"SELECT code FROM $do WHERE id='$this_id'"));
                @rmdir_recursive("../onlinegames/".$old_folder_path['code']);
                $folder_name = $old_folder_path['code'];
            }

            $path = "../onlinegames/".$folder_name;
            @mkdir($path);

            if(move_uploaded_file($source, $path."/".$filename))
            {
                $zip = new ZipArchive();
                $x = $zip->open($path."/".$filename);
                if ($x === true)
                {
                    $zip->extractTo($path);

                    mysqli_query($db,"update $do set code='$folder_name' where auto_id='$this_id'");

                    @unlink($path."/".$filename);

                    $zip->close();
                }
            }
        }
    }
    $ok="Data has been successfully saved.";
    $edit=0;
}


if($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$delete' "))>0)
{
    $data = mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$delete' "));
    @unlink('../images/games/'.$data["image_name"]);
    @rmdir_recursive('../onlinegames/'.$data['code']);
    mysqli_query($db,"delete from $do where auto_id='$delete' ");
    $ok="Data has been successfully deleted.";
    $new_order=1;
    $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and category_id='$data[category_id]' order by order_number");
    $order_update='';
    while($row=mysqli_fetch_assoc($sql))
    {
        $order_update.=" when auto_id='$row[auto_id]' then '$new_order' ";
        $new_order++;
    }
    $query_update="update $do set order_number=case".$order_update."else order_number end;";
    if($order_update!='') mysqli_query($db,$query_update);
}
elseif($delete_img>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$delete_img' and image_name!='' "))>0)
{
    $info_image_name=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$delete_img' and image_name!='' "));
    mysqli_query($db,"update $do set image_name='' where auto_id='$delete_img' and image_name!='' ");
    $ok="Image has been deleted";
    @unlink('../images/games/'.$info_image_name['image_name']);
}
elseif($up>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$up' "))>0)
{
    $data = mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$up' "));
    $current_order=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$up' and category_id='$data[category_id]' "));
    $current_order=$current_order["order_number"];
    if($current_order>1)
    {
        $previous_order=$current_order-1;
        mysqli_query($db,"update $do set order_number='-1' where order_number='$previous_order' and category_id='$data[category_id]' ");
        mysqli_query($db,"update $do set order_number='$previous_order' where order_number='$current_order' and category_id='$data[category_id]'");
        mysqli_query($db,"update $do set order_number='$current_order' where order_number='-1' and category_id='$data[category_id]' ");
    }
}
elseif($down>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$down' "))>0)
{
    $data = mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$down' "));
    $current_order=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$down' and category_id='$data[category_id]' "));
    $current_order=$current_order["order_number"];
    $last_order=mysqli_fetch_assoc(mysqli_query($db,"select order_number from $do where category_id='$data[category_id]' order by order_number desc"));
    $last_order=$last_order["order_number"];
    if($current_order<$last_order)
    {
        $next_order=$current_order+1;
        mysqli_query($db,"update $do set order_number='-1' where order_number='$next_order' and category_id='$data[category_id]' ");
        mysqli_query($db,"update $do set order_number='$next_order' where order_number='$current_order' and category_id='$data[category_id]' ");
        mysqli_query($db,"update $do set order_number='$current_order' where order_number='-1' and category_id='$data[category_id]' ");
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
        <span>Games</span>
        <div class="switch">
            <table cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <?php
                    $sql=mysqli_query($db,"select * from diller where aktivlik=1 order by sira");
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
        <form action="index.php?do=<?php echo $do; ?>&page=<?php echo $page; if($edit>0) echo '&edit='.$edit; ?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
            <a href="index.php?do=<?php echo $do; ?>&add=1" style="margin-right:50px"><img src="images/icon_add.png" alt="" /> <b style="vertical-align: super;">Create new</b></a>
            <hr class="clear" />
            <?php
                if($add==1 || $edit>0) $hide=""; else $hide="hide";

                $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$main_lang' "));
                $sql_categories = mysqli_query($db,"SELECT `auto_id`,`name` FROM `categories` WHERE lang_id='$main_lang' and active=1");
                echo '<div class="'.$hide.'">';
                echo 'Choose category : <br />
                <select name="category_id" required id="category_id">';
                while($row_categories=mysqli_fetch_assoc($sql_categories))
                {
                    if($row_categories['auto_id']==$information["category_id"])
                    {
                        echo '<option value="'.$row_categories['auto_id'].'" selected="selected">'.$row_categories['name'].'</option>';
                    }
                    else
                    {
                        echo '<option value="'.$row_categories['auto_id'].'">'.$row_categories['name'].'</option>';
                    }
                }
                echo '</select><br class="clear" /><br />
                </div>';
                $sql=mysqli_query($db,"select * from diller where aktivlik=1 order by sira");
                while($row=mysqli_fetch_assoc($sql))
                {
                    if($row["id"]==$main_lang) $required = "required"; else $required = "";
                    if($add==1 || $edit>0) $hide=""; else $hide="hide";
                    $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$row[id]' "));

                    if($lang_count>1) echo '<div id="tab'.$row["id"].'_content" class="tab_content '.$hide.'">';
                    else echo '<div class="'.$hide.'">';

                    echo 'Name : <br />
                      <input type="text" '.$required.' name="name_'.$row["id"].'" value="'.$information["name"].'" style="width:250px" />
                      <br /><br />
                      Text : <br />
                        <textarea name="text_'.$row["id"].'" rows="1" cols="1" id="editor'.$row["sira"].'">'.$information["text"].'</textarea>
                    <br /></div>
                      ';
                }
                $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$main_lang'"));
                echo '<div class="'.$hide.'">';
                if($information["image_name"]!="" && $edit>0)
                {
                    $image='<ul class="media_photos" style="margin-left:450px;margin-top:-25px; margin-right: 40px;"><li><a rel="slide" href="../images/games/'.$information["image_name"].'?rand='.rand(0,10000).'" title="">
                    Current image : <img src="../images/games/'.$information ["image_name"].'?rand='.rand(0,10000).'" alt="" width="120" /></a>
                    <br class="clear" />
                  <a href="index.php?do='.$do.'&delete_img='.$information["auto_id"].'" title="Delete" class="delete"><img src="images/icon_delete.png" alt="" /></a></li></ul>';
                    $height_photo_div = "height:120px;";
                }
                else
                {
                    $height_photo_div = "";
                    $image='';
                }

                if($information['code']!="" && $edit>0)
                {
                    $game_file = '<a href="../onlinegames/'.$information['code'].'?rand='.rand(0,10000).'" target="_blank">Play game</a>';
                }
                else
                {
                    $game_file = '';
                }

                echo '<div style="padding: 30px 0 30px 15px;border: 1px solid #ddd;">Zip file (only "zip" file): <input name="zip_file" type="file" id="zip_file" /> '.$game_file.'</div>';
                echo '<div style="padding: 30px 0 50px 15px;border: 1px solid #ddd; margin-top: 5px; '.$height_photo_div.'">
                        <div style="float: left;">Choose image (120 x 120) : <input name="image_file" id="image_file" type="file" /></div><div style="float: right;">'.$image.'</div></div><br />';

                if($information["image_name"]!="" && $edit>0) echo '<br /><br />';
                echo '<input type="submit" id="save" name="button" value=" Save " />
                  <hr class="clear" />
                  <br class="clear" /></div>';
            ?>
        </form>
        <div>

            <div style="float: left;">
                <a href="javascript:void(0);" class="chbx_del"><img src="images/icon_delete.png" alt="" title="" /></a>
                <a href="javascript:void(0);" class="chbx_active" data-val="1"><img src="images/1_lamp.png" alt="" title="" /></a>
                <a href="javascript:void(0);" class="chbx_active" data-val="2"><img src="images/0_lamp.png" alt="" title="" /></a>
                <input type="hidden" value="index.php?do=<?=$do?>&page=<?=$page?>&limit=<?=$limit?>&forId=2" id="current_link" />
            </div>

            <div style="text-align: center; float: left; margin-left: 10%;">
                <select name="category_id" onchange="MM_jumpMenu('parent',this,0)">
                    <option value="index.php?do=<?=$do?>&category_id=0" selected disabled hidden>Choose category</option>
                    <option <?=($_GET['category_id']=="all") ? "selected" : ""?> value="index.php?do=<?=$do?>&category_id=all">ALL</option>
                    <?php
                    $sql=mysqli_query($db,"select auto_id,name from categories where lang_id='$main_lang' order by order_number asc");
                    while($row=mysqli_fetch_assoc($sql))
                    {
                        if($row["auto_id"]==intval($_GET['category_id'])) echo '<option value="index.php?do='.$do.'&category_id='.$row["auto_id"].'" selected="selected">'.$row["name"].'</option>';
                        else echo '<option value="index.php?do='.$do.'&category_id='.$row["auto_id"].'">'.$row["name"].'</option>';
                    }
                    ?>
                </select>
            </div>

            <div style="float: right;">
                <u>Show data's limit:</u>
                <select name="limit" id="limit" onchange="MM_jumpMenu('parent',this,0)" style="margin-bottom: 5px;">
                    <option value="index.php?<?=addFullUrl(array('limit'=>15,'page'=>0))?>" <?php if($limit==15) echo 'selected="selected"'; ?>>15</option>
                    <option value="index.php?<?=addFullUrl(array('limit'=>25,'page'=>0))?>" <?php if($limit==25) echo 'selected="selected"'; ?>>25</option>
                    <option value="index.php?<?=addFullUrl(array('limit'=>50,'page'=>0))?>" <?php if($limit==50) echo 'selected="selected"'; ?>>50</option>
                    <option value="index.php?<?=addFullUrl(array('limit'=>100,'page'=>0))?>" <?php if($limit==100) echo 'selected="selected"'; ?>>100</option>
                    <option value="index.php?<?=addFullUrl(array('limit'=>999999,'page'=>0))?>" <?php if($limit==999999) echo 'selected="selected"'; ?>>ALL</option>
                </select>
            </div>
        </div>

        <br class="clear" />
        <?php
        echo '<table class="data" width="100%" cellpadding="0" cellspacing="0" style="margin: 15px 0;"><thead><tr>
                <th style="width:40%"><input type="checkbox" data-val="0" name="all_check" id="hamisini_sec" value="all_check" /> Name</th>
                <th style="width:20%">Category</th>
                <th style="width:20%">Testing</th>
                <th style="width:30%">Editing</th>
</tr></thead><tbody>';
        $query=str_replace("select id ","select * ",$query_count);
        $query.=" order by auto_id desc limit $start,$limit";
        $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' ".$add_information_sql." order by order_number asc limit $start,$limit");
        while($row=mysqli_fetch_assoc($sql))
        {
            $row_categories = mysqli_fetch_assoc(mysqli_query($db, "SELECT `name` FROM `categories` WHERE active=1 and auto_id='$row[category_id]'"));
            echo '<tr>
					<td><input type="checkbox" id="chbx_'.$row["auto_id"].'" value="'.$row["auto_id"].'" onclick="chbx_(this.id)" /> '.stripslashes($row["name"]).'</td>
					<td>'.$row_categories['name'].'</td>
					<td><a href="../onlinegames/'.$row['code'].'?rand='.rand(0,10000).'" target="_blank">Play game</a></td>
					<td>
						<a href="index.php?do='.$do.'&page='.$page.'&edit='.$row["auto_id"].'"><img src="images/icon_edit.png" alt="" title="Edit" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&delete='.$row["auto_id"].'" class="delete"><img src="images/icon_delete.png" alt="" title="Sil" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&up='.$row["auto_id"].'"><img src="images/up.png" alt="" title="Up" /></a>
						<a href="index.php?do='.$do.'&page='.$page.'&down='.$row["auto_id"].'"><img src="images/down.png" alt="" title="Down" /></a>';
            if($row["active"]==1) $title='Active'; else $title='Deactive';
            echo '<img src="images/'.$row["active"].'_lamp.png" title="'.$title.'" border="0" align="absmiddle" style="cursor:pointer" id="info_'.$row["auto_id"].'" onclick="aktivlik(\''.$do.'\',this.id,this.title)"  />';
            echo '</td>
				</tr>';
        }
        echo '</tbody></table>';
        ?>
        <div class="ps_"><?=page_nav()?></div>
        <?php
            // Paginator
            echo '<div class="pagination">';
            $show=3;
            if($page>$show+1) echo '<a href="index.php?do='.$do.'&page=1">First page</a>';
            if($page>1) echo '<a href="index.php?do='.$do.'&page='.($page-1).'">Previous page</a>';
            for($i=$page-$show;$i<=$page+$show;$i++)
            {
                if($i==$page) $class='class="active"'; else $class='';;
                if($i>0 && $i<=$max_page) echo '<a href="index.php?do='.$do.'&page='.$i.'" '.$class.'>'.$i.'</a>';
            }
            if($page<$max_page) echo '<a href="index.php?do='.$do.'&page='.($page+1).'">Next page</a>';
            if($page<$max_page-$show && $max_page>1) echo '<a href="index.php?do='.$do.'&page='.$max_page.'"> Last page </a>';
            echo '</div>';
            // Paginator
        ?>
        <br class="clear" />
        <!-- Content end-->
    </div>
</div>

<?php
    if(!$edit>0 && $add==1)
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('input#save').bind("click",function()
                {
                    var imgVal = $('#image_file').val();
                    // var zipVal = $('#zip_file').val();
                    if(imgVal=='' /*|| zipVal==""*/)
                    {
                        alert("empty image or zip file");
                        return false;
                    }
                });
            });
        </script>
        <?php
    }
//?>