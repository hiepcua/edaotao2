<?php session_start();
require_once('../../global/libs/gfconfig.php');
require_once('../../global/libs/gfinit.php');
require_once('../../global/libs/gffunc.php');
require_once('../../includes/gfconfig.php');
require_once('../../libs/cls.mysql.php');
require_once('../../libs/cls.users.php');

$objuser=new CLS_USER;
if(!$objuser->isLogin()) die("E01");

$ma=isset($_GET['ma'])?htmlentities(strip_tags($_GET['ma'])):'';
if(!isset($_SESSION["SV$ma"]['TAB_KYLUAT'])) $_SESSION["SV$ma"]['TAB_KYLUAT']=array();
$n = count($_SESSION["SV$ma"]['TAB_KYLUAT']);
?>
<table class="table table-striped">
	<thead><tr><th></th>
		<th>STT</th>
		<th>Học kỳ</th>
		<th>Hình thức</th>
		<th>Lý do</th>
		<th>Quyết định</th>
		<th>Từ ngày</th>
		<th>Đến ngày</th>
		<th></th>
	</tr></thead>
	<tbody>
	<?php $stt=0; foreach($_SESSION["SV$ma"]['TAB_KYLUAT'] as $item) {?>
	<tr dataid="<?php echo $stt;?>">
		<td><button type="button" class="btn btn-default del_kyluat red" dataid="<?php echo $stt;?>">
		<i class="fa fa-times"></i></button></td>
		<td><?php echo $stt+1;?></td>
		<td><?php echo $item['hocky'];?></td>
		<td><?php echo $item['hinhthuc'];?></td>
		<td><?php echo $item['lydo'];?></td>
		<td><?php echo $item['quyetdinh'];?></td>
		<td><?php echo $item['tungay'];?></td>
		<td><?php echo $item['denngay'];?></td>
		<td><button type="button" class="btn btn-default edit_kyluat" dataid="<?php echo $stt;?>">
		<i class="fa fa-edit"></i></button></td>
	</tr>
	<?php  $stt++;} ?>
	<tr class="new"><td></td><td><?php echo $stt+1;?></td>
		<td><input type="number" name="row2_hocky" class="form-control" placeholder="Học kỳ"></td>
		<td><input type="text" name="row2_hthuc" class="form-control" placeholder="Hình thức"></td>
		<td><input type="text" name="row2_lydo" class="form-control" placeholder="Lý do"></td>
		<td><input type="text" name="row2_qdinh" class="form-control" placeholder="Quyết định"></td>
		<td><input type="date" name="row_tungay" class="form-control" placeholder="Từ ngày"></td>
		<td><input type="date" name="row_denngay" class="form-control" placeholder="Đến ngày"></td>
		<td><button type="button" class="btn btn-success" id="save_kyluat"><i class="fa fa-save"></i></button></td>
	</tr>
	</tbody>
</table>
<script>
$("#save_kyluat").click(function(){
	var ma = "<?php echo $ma;?>";
	var row_hocky = $("input[name='row2_hocky']").val();
	var row_hthuc = $("input[name='row2_hthuc']").val();
	var row_lydo = $("input[name='row2_lydo']").val();
	var row_qdinh = $("input[name='row2_qdinh']").val();
	var row_tungay = $("input[name='row_tungay']").val();
	var row_denngay = $("input[name='row_denngay']").val();
	var url = "<?php echo ROOTHOST;?>ajaxs/student/save_kyluat.php";
	$.post(url,{'ma':ma,'row_hocky':row_hocky,'row_hthuc':row_hthuc,'row_lydo':row_lydo,
	'row_qdinh':row_qdinh,'row_tungay':row_tungay,'row_denngay':row_denngay},function(req){
		//console.log(req);
		$("#tab5").html(req);
	})
})
$(".edit_kyluat").click(function(){
	var ma = "<?php echo $ma;?>";
	var row_id = $(this).attr('dataid');
	var url = "<?php echo ROOTHOST;?>ajaxs/student/edit_kyluat.php";
	$.post(url,{'ma':ma,'row_id':row_id},function(req){
		//console.log(req);
		$("#tab5").html(req);
	})
})
</script>