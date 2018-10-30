<?php
// Bu scriptde works saytin index.php faylinin yaninda bu directoride olmalidir:   $site/images/fotoqalereya/$works_id/$sekil_id.$sekil_tip;
$works=intval($_GET["works"]); if($works==0) {$works=mysqli_fetch_assoc(mysqli_query($db,"select * from works order by id desc")); $works=$works["auto_id"];}
$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$add=intval($_GET["add"]);

if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from works where auto_id='$edit' "))==0) header("Location: index.php?do=$do");

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

			mysqli_query($db,"insert into $do values (0,'$time','$tip','$works') ");

			$last_id=mysqli_insert_id($db);
			move_uploaded_file($sekil_hardan,'../images/works_gallery/'.$last_id.'.'.$tip);
			chmod('../images/works_gallery/'.$last_id.'.'.$tip, 0755);
			//Thumb yaradir
			$uploaded_sekil='../images/works_gallery/'.$last_id.'.'.$tip;
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
//			checkMaxSizeImage($uploaded_sekil,$maxWidth=700,$maxHeight=345);
			$thumbFile='../images/works_gallery/'.$last_id.'_thumb.'.$tip;
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
	@unlink('../images/works_gallery/'.$delete.'.'.$tip);
	@unlink('../images/works_gallery/'.$delete.'_thumb.'.$tip);
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
		<span>Qalereya (İşlərimiz)</span>

	</div>
	<br class="clear"/>
	<div class="content">
		<?php
		if($ok!="") echo '<div class="alert_success"><p><img src="images/icon_accept.png" alt="success" class="mid_align"/>'.$ok.'</p></div>';
		if($error!="") echo '<div class="alert_error"><p><img src="images/icon_error.png" alt="delete" class="mid_align"/>'.$error.'</p></div>';
		?>
		<!-- Content start-->
		<form action="index.php?do=<?php echo $do; ?><?php if($works>0) echo '&works='.$works; if($edit>0) echo '&edit='.$edit; if($add==1) echo '&add='.$add;?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
			<hr class="clear" />

			Xəbərlər:&nbsp;&nbsp;&nbsp;
			<select name="sorgu" onchange="MM_jumpMenu('parent',this,0)">
				<?php
				$sql=mysqli_query($db,"select * from works where lang_id='$main_lang' order by auto_id desc");
				while($row=mysqli_fetch_assoc($sql))
				{
					if($row["auto_id"]==$works) echo '<option value="index.php?do='.$do.'&works='.$row["auto_id"].'" selected="selected">'.$row["name"].'</option>';
					else echo '<option value="index.php?do='.$do.'&works='.$row["auto_id"].'">'.$row["name"].'</option>';
				}
				?>
			</select>
			<br class="clear" /><br />
			<u>Şəkillər:</u><br class="clear" />
			<ul class="media_photos">
				<?php
				$sql=mysqli_query($db,"select * from $do where works_id='$works' order by id");
				while($row=mysqli_fetch_assoc($sql))
				{
					echo '<li style="margin-bottom:20px">
				  <a rel="slide" href="../images/works_gallery/'.$row["id"].'.'.$row["tip"].'" title="">
				  	<img src="../images/works_gallery/'.$row["id"].'.'.$row["tip"].'" alt="" width="75" height="75" />
				  </a>
				  <br class="clear" />
				  '.$row["basliq"].' <a href="index.php?do='.$do.'&delete='.$row["id"].'&works='.$works.'" title="Sil" class="delete"><img src="images/icon_delete.png" alt="" /></a>
			</li>';
				}
				?>
			</ul>
			<br class="clear" />
			<div style="display:<?php if($add==0 && $edit_works==0) echo "block"; else echo "none"; ?>">
				<b>Yeni əlavə et:</b><br />
				Şəkillər (1000 x 500): <input name="yeni_sekil[]" type="file" multiple /> <input type="submit" name="add_yeni_sekil" value=" Save " />
			</div>
		</form>
		<!-- Content end-->
	</div>
</div>