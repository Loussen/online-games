<?php
$game=intval($_GET["game"]); 
if($game==0) 
{
    $game=mysqli_fetch_assoc(mysqli_query($db,"select * from games order by id desc")); 
    $game=$game["auto_id"];
}

$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$add=intval($_GET["add"]);

if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from games where auto_id='$edit' "))==0) 
    header("Location: index.php?do=$do");

if($_POST["add_new_image"])
{
    $image_tmp_names=$_FILES["image_file"]["tmp_name"];
    $image_types=$_FILES["image_file"]["type"];
    $image_names=$_FILES["image_file"]["name"];
    $count=0;

    $time = time();
    foreach($image_tmp_names as $image_tmp_name)
    {
        $type=strtolower(end(explode(".",$image_names[$count])));
        $image_type=$image_types[$count];
        $image_name=$image_names[$count];
        $image_access=false;

        if( ($image_type=="image/pjpeg" || $image_type=="image/jpeg" || $image_type=="image/bmp"  || $image_type=="image/x-png" || $image_type=="image/gif" || $image_type=="image/png") and ($type=="jpg" || $type=="bmp"  || $type=="png" || $type=="gif" || $type=="jpeg") )
            $image_access=true;

        if($image_access==true)
        {
            $image_upload_name = substr(sha1(mt_rand()),17,15)."-".pathinfo($image_name, PATHINFO_FILENAME).".".$type;

            mysqli_query($db,"insert into $do values (0,'$time','$image_upload_name','$game') ");

            $last_id=mysqli_insert_id($db);
            move_uploaded_file($image_tmp_name,'../images/game_gallery/'.$image_upload_name);
            chmod('../images/game_gallery/'.$image_upload_name, 0755);

            $ok="Data has been successfully saved.";
        }

        $count++;
        $auto_id++;
    }
}
elseif($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where id='$delete' "))>0)
{
    $data=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where id='$delete'"));
    mysqli_query($db,"delete from $do where id='$delete' ");
    @unlink('../images/game_gallery/'.$data['image_name']);
    $ok="Data has been successfully deleted.";
}
?>
<script type="text/JavaScript">
    <!--
    function MM_jumpMenu(targ,selObj,restore){ //v3.0
        eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        if (restore) selObj.selectedIndex=0;
    }
    //-->
</script>
<div class="onecolumn">
    <div class="header">
        <span>Games' gallery</span>
    </div>
    <br class="clear"/>
    <div class="content">
        <?php
        if($ok!="") echo '<div class="alert_success"><p><img src="images/icon_accept.png" alt="success" class="mid_align"/>'.$ok.'</p></div>';
        if($error!="") echo '<div class="alert_error"><p><img src="images/icon_error.png" alt="delete" class="mid_align"/>'.$error.'</p></div>';
        ?>
        <!-- Content start-->
        <form action="index.php?do=<?php echo $do; ?><?php if($game>0) echo '&game='.$game; if($edit>0) echo '&edit='.$edit; if($add==1) echo '&add='.$add;?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
            <hr class="clear" />

            Games:&nbsp;&nbsp;&nbsp;
            <select name="sorgu" onchange="MM_jumpMenu('parent',this,0)">
                <?php
                $sql=mysqli_query($db,"select * from games where lang_id='$main_lang' order by order_number desc");
                while($row=mysqli_fetch_assoc($sql))
                {
                    if($row["auto_id"]==$game) echo '<option value="index.php?do='.$do.'&game='.$row["auto_id"].'" selected="selected">'.$row["name"].'</option>';
                    else echo '<option value="index.php?do='.$do.'&game='.$row["auto_id"].'">'.$row["name"].'</option>';
                }
                ?>
            </select>
            <br class="clear" /><br />
            <u>Images:</u><br class="clear" />
            <ul class="media_photos">
                <?php
                $sql=mysqli_query($db,"select * from $do where game_id='$game' order by id");
                while($row=mysqli_fetch_assoc($sql))
                {
                    echo '<li style="margin-bottom:20px">
				  <a rel="slide" href="../images/game_gallery/'.$row['image_name'].'" title="">
				  	<img src="../images/game_gallery/'.$row['image_name'].'" alt="" width="75" height="75" />
				  </a>
				  <br class="clear" />
				  '.$row["name"].' <a href="index.php?do='.$do.'&delete='.$row["id"].'&game='.$game.'" title="Delete" class="delete"><img src="images/icon_delete.png" alt="" /></a>
			</li>';
                }
                ?>
            </ul>
            <br class="clear" />
            <div style="display:<?php if($add==0 && $edit_game==0) echo "block"; else echo "none"; ?>">
                <b>Create new:</b><br />
                Images (250 x 190): <input name="image_file[]" type="file" multiple /> <input type="submit" name="add_new_image" value=" Save " />
            </div>
        </form>
        <!-- Content end-->
    </div>
</div>