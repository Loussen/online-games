<?php
//Wekil upload papkasi,  ../images/menyular
$add=intval($_GET["add"]);
$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$up=intval($_GET["up"]);
$down=intval($_GET["down"]);
$parent=intval($_GET["parent"]);
$delete_img=intval($_GET["delete_img"]);
if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$edit' "))==0) header("Location: index.php?do=$do");

if($_POST) // Add && edit
{
	extract($_POST);	
	$parent_auto_id=intval($parent_auto_id);
	$link=safe($link);
	$sekil_hardan=$_FILES["file"]["tmp_name"];
	$son_sira=mysqli_fetch_assoc(mysqli_query($db,"select sira from $do where parent_auto_id='$parent_auto_id' order by sira desc")); $son_sira=intval($son_sira["sira"])+1;
	$auto_id=mysqli_fetch_assoc(mysqli_query($db,"select auto_id from $do order by auto_id desc"));
	$auto_id=intval($auto_id["auto_id"])+1;
	$aktivlik=1;
	if($edit>0)
	{
		$info_edit=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where parent_auto_id='$parent_auto_id' and auto_id='$edit' "));
		$add_where="and auto_id='$edit' ";
		$auto_id=$edit;
		$son_sira=$info_edit["sira"];
		$aktivlik=$info_edit["aktivlik"];
		
		if($parent_auto_id!=$info_edit["parent_auto_id"])
		{
			$info_edit2=mysqli_fetch_assoc(mysqli_query($db,"select sira from $do where parent_auto_id='$parent_auto_id' order by sira desc limit 1 "));
			$son_sira=$info_edit2["sira"]+1;
		}
	}
	else $add_where="";
	
	$sql=mysqli_query($db,"select * from diller order by sira");
	while($row=mysqli_fetch_assoc($sql))
	{
		$name="name_".$row["id"]; $name=mysqli_real_escape_string($db,htmlspecialchars($$name));
		$title="title_".$row["id"]; $title=mysqli_real_escape_string($db,htmlspecialchars($$title));
		$qisa_metn="qisa_metn_".$row["id"]; $qisa_metn=mysqli_real_escape_string($db,htmlspecialchars($$qisa_metn));
		$text="text_".$row["id"]; $text=mysqli_real_escape_string($db,htmlspecialchars($$text));
		
		if($name=='' && $row["id"]!=$main_lang) {$c='name'; $$c=get_lang_val($do,$auto_id,$c);}
		if($title=='' && $row["id"]!=$main_lang) {$c='title'; $$c=get_lang_val($do,$auto_id,$c);}
		if($qisa_metn=='' && $row["id"]!=$main_lang) {$c='qisa_metn'; $$c=get_lang_val($do,$auto_id,$c);}
		if($text=='' && $row["id"]!=$main_lang) {$c='text'; $$c=get_lang_val($do,$auto_id,$c);}
		
		if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$row[id]' $add_where"))>0 && $edit>0)
		{
			mysqli_query($db,"update $do set name='$name',title='$title',qisa_metn='$qisa_metn',text='$text',parent_auto_id='$parent_auto_id', sira='$son_sira', link='$link' where lang_id='$row[id]' $add_where");
			if($info_edit["parent_auto_id"]!=$parent_auto_id)
			{
				$yeni_sira=1; $sql2=mysqli_query($db,"select auto_id from $do where lang_id='$main_lang' and parent_auto_id='$parent_auto_id' order by sira");
				while($row2=mysqli_fetch_assoc($sql2)){
					mysqli_query($db,"update $do set sira='$yeni_sira' where parent_auto_id='$parent_auto_id' and auto_id='$row2[auto_id]' "); $yeni_sira++;
				}
			}
		}
		else mysqli_query($db,"insert into $do values (0,'$name','$title','$link','$qisa_metn','','$text','$parent_auto_id','$son_sira', '$aktivlik', '$row[id]', '$auto_id', '0') ");
		
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
				move_uploaded_file($sekil_hardan,'../images/menus/'.$this_id.'.'.$tip);
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

if($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where parent_auto_id='$parent' and auto_id='$delete' and vacib_menu='0' "))>0)
{
	mysqli_query($db,"delete from $do where parent_auto_id='$parent' and auto_id='$delete' ");
	mysqli_query($db,"delete from $do where parent_auto_id='$delete' ");
	$ok="Məlumat silindi.";
		$yeni_sira=1;
		$sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and parent_auto_id='$parent' order by sira"); $siraUpdate='';
		while($row=mysqli_fetch_assoc($sql)){
			$siraUpdate.=" when auto_id='$row[auto_id]' and parent_auto_id='$parent' then '$yeni_sira' ";
			$yeni_sira++;
		}
		$query_update="update $do set sira=case".$siraUpdate."else sira end;"; if($siraUpdate!='') mysqli_query($db,$query_update);
}
elseif($delete_img>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$delete_img' and tip!='' "))>0)
{
	$info_tip=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$delete_img' and tip!='' "));
	mysqli_query($db,"update $do set tip='' where auto_id='$delete_img' and tip!='' ");
	$ok="Şəkil silindi.";
	@unlink('../images/menus/'.$delete_img.'.'.$info_tip["tip"]);
}
elseif($up>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where parent_auto_id='$parent' and auto_id='$up' "))>0)
{
	$indiki_sira=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where parent_auto_id='$parent' and auto_id='$up' ")); $indiki_sira=$indiki_sira["sira"];
	if($indiki_sira>1)
	{
		$asagi_sira=$indiki_sira-1;
		mysqli_query($db,"update $do set sira='-1' where parent_auto_id='$parent' and sira='$asagi_sira' ");
		mysqli_query($db,"update $do set sira='$asagi_sira' where parent_auto_id='$parent' and sira='$indiki_sira' ");
		mysqli_query($db,"update $do set sira='$indiki_sira' where parent_auto_id='$parent' and sira='-1' ");
	}
	
}
elseif($down>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where parent_auto_id='$parent' and auto_id='$down' "))>0)
{
	$indiki_sira=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where parent_auto_id='$parent' and auto_id='$down' ")); $indiki_sira=$indiki_sira["sira"];
	$son_sira=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where parent_auto_id='$parent' order by sira desc")); $son_sira=$son_sira["sira"];
	if($indiki_sira<$son_sira)
	{
		$yuxari_sira=$indiki_sira+1;
		mysqli_query($db,"update $do set sira='-1' where parent_auto_id='$parent' and sira='$yuxari_sira' ");
		mysqli_query($db,"update $do set sira='$yuxari_sira' where parent_auto_id='$parent' and sira='$indiki_sira' ");
		mysqli_query($db,"update $do set sira='$indiki_sira' where parent_auto_id='$parent' and sira='-1' ");
	}
}
?>
<div class="onecolumn">
	<div class="header">
		<span>Menyular <?php if($edit>0) echo '(Menu ID: '.$edit.')'; ?></span>
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
		<form action="index.php?do=<?php echo $do; ?><?php if($edit>0) echo '&edit='.$edit.''; ?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
		<a href="index.php?do=<?php echo $do; ?>&add=1" style="margin-right:50px"><img style="vertical-align: text-top;" src="images/icon_add.png" alt="" /> <b>Yeni əlavə et</b></a>
		<hr class="clear" />
		 <?php
		$sql=mysqli_query($db,"select * from diller order by sira");
		while($row=mysqli_fetch_assoc($sql))
		{
			if($add==1 || $edit>0) $hide=""; else $hide="hide";
			$information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$row[id]' "));
			
			if($lang_count>1) echo '<div id="tab'.$row["id"].'_content" class="tab_content '.$hide.'">'; else echo '<div class="'.$hide.'">';
			echo '  Ad:<br />
			  <input type="text" name="name_'.$row["id"].'" value="'.$information["name"].'" style="width:250px" />
			  <br /><br />
			  Text:<br />
			<textarea name="text_'.$row["id"].'" rows="1" cols="1" id="editor'.$row["sira"].'">'.$information["text"].'</textarea>
			<br /></div>
			  ';
		}
		$information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$main_lang' "));
		echo '<div class="'.$hide.'">';
		if($information["tip"]!="" && $edit>0) $sekili='<ul class="media_photos" style="margin-left:450px;margin-top:-25px"><li><a rel="slide" href="../images/menus/'.$information["auto_id"].'.'.$information["tip"].'?rand='.rand(0,10000).'" title="">Hazırkı şəkil <img src="../images/menus/'.$information ["auto_id"].'.'.$information["tip"].'?rand='.rand(0,10000).'" alt="" width="120" /></a><br class="clear" />
			  <a href="index.php?do='.$do.'&delete_img='.$information["auto_id"].'" title="Delete" class="delete"><img src="images/icon_delete.png" alt="" /></a></li></ul>'; else $sekili='';
            echo 'Şəkil (848 x 439): <input name="file" type="file" />'.$sekili.'<br /><br />';

            if($information["tip"]!="" && $edit>0) echo '<br /><br />';
		echo 'Link:<br /><input type="text" name="link" value="'.$information["link"].'" style="width:250px" /><br /><br />
		Ana menyu<br />
			<select name="parent_auto_id" id="cat">
			<option value="0"> </option>';
				$sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id!='$edit' order by name");
				while($row=mysqli_fetch_assoc($sql))
				{
					if($row["auto_id"]==$information["parent_auto_id"]) echo '<option value="'.$row["auto_id"].'" selected="selected">'.$row["name"].'</option>';
					else echo '<option value="'.$row["auto_id"].'">'.$row["name"].'</option>';
				}
			echo '</select><br /><br />
			<input type="submit" name="button" value=" Save " />
			  <hr class="clear" />
			  <br class="clear" /></div>';
		
		?>
		</form>
		<a href="javascript:void(0);" class="chbx_del"><img src="images/icon_delete.png" alt="" title="" /></a>
		<a href="javascript:void(0);" class="chbx_active" data-val="1"><img src="images/1_lamp.png" alt="" title="" /></a>
		<a href="javascript:void(0);" class="chbx_active" data-val="2"><img src="images/0_lamp.png" alt="" title="" /></a>
		<input type="hidden" value="index.php?do=<?=$do?>&page=<?=$page?>&limit=<?=$limit?>&forId=2" id="current_link" />
		
		<?php
		function sub_menular($do,$main_lang,$parent_auto_id)
		{
			global $db;
			$mesafe='';
			$yoxlanis_parent_auto_id=$parent_auto_id;
			for($i=1;$i<=10;$i++)
			{
				$yoxlanis=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id='$yoxlanis_parent_auto_id' "));
				if($yoxlanis["auto_id"]==0) break;
				else
				{
					$yoxlanis_parent_auto_id=$yoxlanis["parent_auto_id"];
					$mesafe.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
			}
			
			$sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and parent_auto_id='$parent_auto_id' order by sira");
			while($row=mysqli_fetch_assoc($sql))
			{
				$ana_menyu=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id='$row[parent_auto_id]' "));
				echo '<tr>
						<td>'.$mesafe.'<input type="checkbox" id="chbx_'.$row["auto_id"].'" value="'.$row["auto_id"].'" onclick="chbx_(this.id)" /> '.$row["name"].'</td>
						<td>'.$ana_menyu["name"].'</td>
						<td>
							<a href="index.php?do='.$do.'&edit='.$row["auto_id"].'"><img src="images/icon_edit.png" alt="" title="Düzəliş" /></a>
							';
//						if($row["vacib_menu"]=="0") echo '<a href="index.php?do='.$do.'&parent='.$row["parent_auto_id"].'&delete='.$row["auto_id"].'" class="delete" data-title='.$row['name'].'><img src="images/icon_delete.png" alt="" title="Sil" /></a>';
						echo '
							<a href="index.php?do='.$do.'&up='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/up.png" alt="" title="Yuxarı" /></a>
							<a href="index.php?do='.$do.'&down='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/down.png" alt="" title="Aşağı" /></a>';
							if($row["aktivlik"]==1) $title='Active'; else $title='Deactive';
					echo '<img src="images/'.$row["aktivlik"].'_lamp.png" title="'.$title.'" border="0" align="absmiddle" style="cursor:pointer" id="info_'.$row["auto_id"].'" onclick="aktivlik(\''.$do.'\',this.id,this.title)"  />
					<a href="index.php?do=menyular_gallery&menyular='.$row['auto_id'].'"><img src="images/fotoqalereya.png" alt="" title="Qalereya" /></a>';
						echo '</td>
					</tr>';
				
				if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$main_lang' and parent_auto_id='$row[auto_id]' and $row[auto_id]>0"))>0)
				{
					$parent_auto_id=$row["auto_id"];
					sub_menular($do,$main_lang,$parent_auto_id);
				}
			}
		}
		//////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////
echo '<table class="data" width="100%" cellpadding="0" cellspacing="0" ><thead><tr>
	<th style="width:40%"><input type="checkbox" data-val="0" name="all_check" id="hamisini_sec" value="all_check" /> Ad</th>
	<th style="width:30%">Ana menyu</th>
	<th style="width:30%">Düzəlişlər</th>
</tr></thead><tbody>';
		$sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and parent_auto_id='0' order by sira");
		while($row=mysqli_fetch_assoc($sql))
		{
			$ana_menyu=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id='$row[parent_auto_id]' "));
			echo '<tr>
					<td><input type="checkbox" id="chbx_'.$row["auto_id"].'" value="'.$row["auto_id"].'" onclick="chbx_(this.id)" /> '.$row["name"].'</td>
					<td>'.$ana_menyu["name"].'</td>
					<td>
						<a href="index.php?do='.$do.'&edit='.$row["auto_id"].'"><img src="images/icon_edit.png" alt="" title="Edit" /></a>
						';
//						if($row["vacib_menu"]=="0") echo '<a href="index.php?do='.$do.'&parent='.$row["parent_auto_id"].'&delete='.$row["auto_id"].'" class="delete" data-title="'.$row["name"].'"><img src="images/icon_delete.png" alt="" title="Sil" /></a>';
						echo '
						<a href="index.php?do='.$do.'&up='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/up.png" alt="" title="Up" /></a>
						<a href="index.php?do='.$do.'&down='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/down.png" alt="" title="Down" /></a>';
						if($row["aktivlik"]==1) $title='Active'; else $title='Deactive';
				echo '<img src="images/'.$row["aktivlik"].'_lamp.png" title="'.$title.'" border="0" align="absmiddle" style="cursor:pointer" id="info_'.$row["auto_id"].'" onclick="aktivlik(\''.$do.'\',this.id,this.title)"  />
				<a href="index.php?do=menyular_gallery&menyular='.$row['auto_id'].'"><img src="images/fotoqalereya.png" alt="" title="Qalereya" /></a>';
					echo '</td>
				</tr>';
				
				
				if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$main_lang' and parent_auto_id='$row[auto_id]' and $row[auto_id]>0"))>0)
				{
					$parent_auto_id=$row["auto_id"];
					sub_menular($do,$main_lang,$parent_auto_id);
				}
		}
echo '</tbody></table>';
		?>
		<br class="clear"/>
	<!-- Content end-->
	</div>
</div>