<?php
$menyular=intval($_GET["menyular"]); if($menyular==0) {$menyular=mysqli_fetch_assoc(mysqli_query($db,"select * from menyular order by id desc")); $menyular=$menyular["auto_id"];}
$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$add=intval($_GET["add"]);

if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from menyular where auto_id='$edit' "))==0) header("Location: index.php?do=$do");

if($_POST["add_yeni_sekil"])
{

	$sekil_hardans=$_FILES["yeni_sekil"]["tmp_name"];
	$sekil_tips=$_FILES["yeni_sekil"]["type"];
	$sekil_names=$_FILES["yeni_sekil"]["name"];
	$say=0;

	$time = time();
	foreach($sekil_hardans as $sekil_hardan){
		$tip=explode(".",$sekil_names[$say]);	$tip=end($tip);		$tip=strtolower($tip);
		$sekil_tip=$sekil_tips[$say];
		$sekil_name=$sekil_names[$say];
		$sekil_olar=false;

		if( ($sekil_tip=="image/pjpeg" || $sekil_tip=="image/jpeg" || $sekil_tip=="image/bmp"  || $sekil_tip=="image/x-png" || $sekil_tip=="image/gif" || $sekil_tip=="image/png")and($tip=="jpg" || $tip=="bmp"  || $tip=="png" || $tip=="gif" || $tip=="jpeg") ) $sekil_olar=true;
		if($sekil_olar==true)
		{

			mysqli_query($db,"insert into $do values (0,'$time','$tip','$menyular') ");

			$last_id=mysqli_insert_id($db);
			move_uploaded_file($sekil_hardan,'../images/menyular_gallery/'.$last_id.'.'.$tip);
			chmod('../images/menyular_gallery/'.$last_id.'.'.$tip, 0755);
			//Thumb yaradir
			$uploaded_sekil='../images/menyular_gallery/'.$last_id.'.'.$tip;
//			list($width, $height, $type, $attr) = getimagesize($uploaded_sekil);
//			if ($width>1000 or $height>800){
//				$image = new SimpleImage();
//				$image->load($uploaded_sekil);
//
//				if($width>1000) $image->resizeToWidth(1000);
//				if($height>800) $image->resizeToHeight(800);
//				$image->save($uploaded_sekil);
//			}

//			create_thumbnail($uploaded_sekil,'../images/telim_photos/'.$last_id.'_thumb.'.$tip,107,107);
//			checkMaxSizeImage($uploaded_sekil,$maxWidth=848,$maxHeight=439);
			$thumbFile='../images/menyular_gallery/'.$last_id.'_thumb.'.$tip;
			makeThumb($uploaded_sekil,$thumbFile,848,439);
			$ok="Yeni şəkil əlavə olundu.";


		}
		$say++;
		$auto_id++;
	}
}
elseif($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where id='$delete' "))>0)
{
	$tip=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where id='$delete'")); $tip=$tip["tip"];
	mysqli_query($db,"delete from $do where id='$delete' ");
	@unlink('../images/menyular_gallery/'.$delete.'.'.$tip);
	@unlink('../images/menyular_gallery/'.$delete.'_thumb.'.$tip);
	$ok="Şəkil silindi.";
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
		<span>Qalereya (Xəbərlər)</span>

	</div>
	<br class="clear"/>
	<div class="content">
		<?php
		if($ok!="") echo '<div class="alert_success"><p><img src="images/icon_accept.png" alt="success" class="mid_align"/>'.$ok.'</p></div>';
		if($error!="") echo '<div class="alert_error"><p><img src="images/icon_error.png" alt="delete" class="mid_align"/>'.$error.'</p></div>';
		?>
		<!-- Content start-->
		<form action="index.php?do=<?php echo $do; ?><?php if($menyular>0) echo '&menyular='.$menyular; if($edit>0) echo '&edit='.$edit; if($add==1) echo '&add='.$add;?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
			<hr class="clear" />

			Xəbərlər:&nbsp;&nbsp;&nbsp;
			<select name="sorgu" onchange="MM_jumpMenu('parent',this,0)">
				<?php
				$sql=mysqli_query($db,"select * from menyular where lang_id='$main_lang' order by auto_id desc");
				while($row=mysqli_fetch_assoc($sql))
				{
					if($row["auto_id"]==$menyular) echo '<option value="index.php?do='.$do.'&menyular='.$row["auto_id"].'" selected="selected">'.$row["name"].'</option>';
					else echo '<option value="index.php?do='.$do.'&menyular='.$row["auto_id"].'">'.$row["name"].'</option>';
				}
				?>
			</select>
			<br class="clear" /><br />
			<u>Şəkillər:</u><br class="clear" />
			<ul class="media_photos">
				<?php
				$sql=mysqli_query($db,"select * from $do where menyular_id='$menyular' order by id");
				while($row=mysqli_fetch_assoc($sql))
				{
					echo '<li style="margin-bottom:20px">
				  <a rel="slide" href="../images/menyular_gallery/'.$row["id"].'.'.$row["tip"].'" title="">
				  	<img src="../images/menyular_gallery/'.$row["id"].'.'.$row["tip"].'" alt="" width="75" height="75" />
				  </a>
				  <br class="clear" />
				  '.$row["basliq"].' <a href="index.php?do='.$do.'&delete='.$row["id"].'&menyular='.$menyular.'" title="Sil" class="delete"><img src="images/icon_delete.png" alt="" /></a>
			</li>';
				}
				?>
			</ul>
			<br class="clear" />
			<div style="display:<?php if($add==0 && $edit_menyular==0) echo "block"; else echo "none"; ?>">
				<b>Yeni əlavə et:</b><br />
				Şəkillər (1000 x 500): <input name="yeni_sekil[]" type="file" multiple /> <input type="submit" name="add_yeni_sekil" value=" Save " />
			</div>
		</form>
		<!-- Content end-->
	</div>
</div>