<?php
session_start();
require_once('../../global/libs/gfconfig.php');
require_once('../../global/libs/gfinit.php');
require_once('../../global/libs/gffunc.php');
require_once('../../includes/gfconfig.php');
require_once('../../libs/cls.mysql.php');
require_once('../../libs/cls.users.php');
require_once('../../libs/cls.he.php');
require_once('../../libs/cls.khoa.php');
require_once('../../libs/cls.nganh.php');

$objuser=new CLS_USER;
if(!$objuser->isLogin()) die("E01");
$action = isset($_POST['action'])?addslashes(htmlentities(strip_tags($_POST['action']))):'';
$value = isset($_POST['value'])?addslashes(htmlentities(strip_tags($_POST['value']))):'';
$objng = new CLS_NGANH;
$objng->getListKhoaNganh(" AND id='$value'");
$r=$objng->Fetch_Assoc();
?>
<div class="row form-group">
	<div class="col-md-6 col-xs-4 text">Tên hiển thị</div>
	<div class="col-md-6 col-xs-8">
		<input type="text" name="txtname" id="txtname" class="form-control" value="<?php echo $r['name'];?>" required>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-6 col-xs-4 text">Mã ngành/nhóm ngành</div>
	<div class="col-md-6 col-xs-8">
		<select name="ma_nganh" id="ma_nganh" class="form-control" required>
		<option value=""></option>
		<?php $objng = new CLS_NGANH;
		$objng->getList(); 
		while($item=$objng->Fetch_Assoc()) { ?>
		<option value="<?php echo $item['id'];?>" <?php if($r['id_nganh']==$item['id']) echo "selected";?>>
		<?php echo $item['id']." - ".$item['name'];?></option>
		<?php } ?>
		</select>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-6 col-xs-4 text">Bậc đào tạo</div>
	<div class="col-md-6 col-xs-8">
		<select name="cbobac" id="cbobac" class="form-control" required>
		<option value=""></option>
		<?php $objhe = new CLS_HE;
		$objhe->getList(); 
		while($item=$objhe->Fetch_Assoc()) { ?>
		<option value="<?php echo $item['id'];?>" <?php if($r['id_he']==$item['id']) echo "selected";?>>
		<?php echo $item['name'];?></option>
		<?php } ?>
		</select>
	</div>
</div>
<div class="row form-group">
	<div class="col-md-6 col-xs-4 text">Khóa</div>
	<div class="col-md-6 col-xs-8">
		<select name="cbokhoa" id="cbokhoa" class="form-control" required>
		<?php 
		$objkhoa = new CLS_KHOA;
		//$type = substr($r['id_khoa'],0,2); $type=str_replace("Y","",$type); 
		$objkhoa->getList(" ");
		while($item=$objkhoa->Fetch_Assoc()) { ?>
		<option value="<?php echo $item['id'];?>" <?php if($item['id']==$r['id_khoa']) echo 'selected';?>>
		<?php echo $r['name'];?></option>
		<?php } ?>
		</select>
	</div>
</div>
<div class="row form-group text-center">
	<button type="button" name="btnsave" id="btnsave" class="btn btn-primary">Lưu</button>
	<button type="button" name="btncancel" id="btncancel" class="btn btn-default" data-dismiss="modal">Thoát</button>
</div>
<div class="clearfix"></div>
<script>
$(document).ready(function(){
	$("#cboyear").change(function(){
		var year = $("#cboyear option:selected").val();
		$("#txtname").val('Khóa '+year);
	})
	$("#btnsave").click(function(){
		
		if(checkinput()==true) {
			var ma_nganh = $("#ma_nganh").val();
			var name = $("#txtname").val();
			var bac = $("#cbobac").val();
			var khoa = $("#cbokhoa").val();
			var url = "<?php echo ROOTHOST;?>ajaxs/nganh/process_edit.php";
			showLoading();
			$.post(url,{'id':'<?php echo $value;?>','ma_nganh':ma_nganh,'name':name,'bac':bac,'khoa':khoa},function(req){
				console.log(req);
				hideLoading();
				if(req=="E01") showMess("Vui lòng đăng nhập hệ thống","error");
				else if(req=="success"){
					showMess("Cập nhật ngành mới thành công");
					window.location.reload();
				}
			})
		} return false;
	})
	$("#btncancel").click(function(){
		
	})
})
function checkinput(){
	var ma_nganh = $("#ma_nganh").val();
	var name = $("#txtname").val();
	var bac = $("#cbobac").val();
	var khoa = $("#cbokhoa").val();
	if(ma_nganh=="") {
		$("#ma_nganh").focus();
		return false;
	}if(name=="") {
		$("#txtname").focus();
		return false;
	}if(bac=="") {
		$("#cbobac").focus();
		return false;
	}if(khoa=="") {
		$("#cbokhoa").focus();
		return false;
	}
	return true;
}
</script>