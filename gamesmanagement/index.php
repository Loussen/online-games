<?php
include "pages/includes/config.php";
if(isset($_GET["do"])) $do=safe($_GET["do"]); else $do='';
$do=str_replace(array("../","./","/"),"",$do);
include "pages/includes/check.php";
if(intval($user["id"])==0){header("Location: login.php"); exit('Go go go...'); die('Go go go...');}
include "pages/includes/function_thumb.php";
include "pages/includes/resize_class.php";
//$main_lang=1;

$checkboxes=safe($_GET["checkboxes"]);
if($checkboxes!=''){
	$checkboxes=substr($checkboxes,1,-1);	$checkboxes=str_replace("-",",",$checkboxes);
	$forId=intval($_GET["forId"]);		if($forId==1) $column='id'; else $column='auto_id';
	$checkbox_del=intval($_GET["checkbox_del"]);
	$active=intval($_GET["active"]);
	if($checkbox_del==1){
		mysqli_query($db,"delete from $do where $column in (".$checkboxes.") ");
		if($do=='mehsullar'){
			$sql=mysqli_query($db,"select id,tip,xeber_id from sekiller2 where xeber_id in (".$checkboxes.") ");
			while($row=mysqli_fetch_assoc($sql)){
				@unlink('../images/gallery2/'.$row["xeber_id"].'/'.$row["id"].'.'.$row["tip"]);
				@unlink('../images/gallery2/'.$row["xeber_id"].'/'.$row["id"].'_thumb.'.$row["tip"]);
			}
			mysqli_query($db,"delete from sekiller2 where xeber_id='$delete' ");
		}
	}
	elseif($active>0){
		if($active==2) $active=0; else $active=1;
		if($do=='mehsullar' && $active==1){
			$sql=mysqli_query($db,"select id,xeber_id from sekiller2 where xeber_id in (".$checkboxes.") and active=1 ");
			while($row=mysqli_fetch_assoc($sql)){
				mysqli_query($db,"update $do set active='$active' where auto_id='$row[xeber_id]' ");
			}
		}
		else mysqli_query($db,"update $do set active='$active' where $column in (".$checkboxes.") ");
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<head><?php include "pages/layouts/head.php"; ?></head>
<body>
<div class="content_wrapper">
	<?php include "pages/layouts/top.php"; ?>
	<?php include "pages/layouts/menu.php"; ?>
	<div id="content">
		<div class="inner">
			<?php
			if(is_file("pages/".$do.".php")) include "pages/".$do.".php";
			else echo '<center><strong id="basliq1">LOVATO<br>
                    LET THE BLUE DRIVE</strong></center>
            <br>
            <div class="page">
<p style="text-align: right;"><i>«Только веря в будущее, мы смогли добиться стабильности и уверенности, вдохновленные свободой и легкостью»</i><br>
<span style="font-weight: 600;">Отторино Ловато</span></p><p>
</p><p>Первые мастерские «Ловато», названные в честь Отторино Ловато, появились в Винченце (Италия) в 1958 году. Они с самого начала зарекомендовали себя, как опытные центры инноваций. С момента производства первого <a href="/oborudovanie/multiklapany/" target="_blank">мультиклапана для ГБО</a>, «Ловато» сосредоточилась на производственной деятельности, постоянно и очень гибко отвечая на запросы рынка и технологические вызовы.</p>
<p>В 2007 году мастерские Lovato стали называться «Ловато Газ», а уже в 2008 году <a href="/" target="_blank">«Ловато Газ»</a> вошла в состав Группы компаний «Landi Renzo Group», мирового лидера в области альтернативных автомобильных топливных систем для рынков Сжатого Природного газа (Метан) и Сжиженного Нефтяного Газа (Пропан). «Landi Renzo Group» представлена на фондовой бирже «Borsa Italia» и имеет несколько филиалов по всему миру.</p>
<p>На сегодняшний день Компания в состоянии предложить полный спектр систем и компонентов для использования пропана и метана, как альтернативу бензину и дизелю.  Все компоненты разрабатываются самостоятельно, путем использования собственного центра исследований, систем качества и развития. Продукты компании поставляются по всему миру, в виде готовых <a href="/oborudovanie/komplekty/" target="_blank">комплектов ГБО</a> под все существующие виды автомобилей, а также устанавливаются автопроизводителями с завода в виде оригинальной OEM продукции. Хочется отметить, что всё оборудование проходит европейскую проверку и отвечает жестким стандартам качества ISO/TS 16949, ISO 9001:2008, OHSAS 18001.</p>
<p>Постоянное присутствие компании «Ловато Газ» на всех рынках дало возможность получать 90% общего оборота за пределами страны. Более чем 8 миллионов автомобилей по всему миру, оборудованных системами «Ловато газ», являются живым доказательством успеха продукта и характеризуются надежностью, простотой <a href="/gbo/ustanovka/" target="_blank">установки</a> и отличной ремонтопригодностью.</p>
</div>';
			?>
		</div>
		<?php include "pages/layouts/footer.php"; ?>		
	</div>
</div>
<input type="hidden" id="link_url" value="-" />
<input type="hidden" value="0" id="all_check_changed" />
<input type="hidden" id="delete_text1" value="<?=$lang116?>"/>
<input type="hidden" id="delete_text2" value="<?=$lang117?>"/>
<input type="hidden" id="tab_lang100" onclick="tab_select(this.id)" class="left_switch" value="test" style="width:50px">
</body>
</html>
