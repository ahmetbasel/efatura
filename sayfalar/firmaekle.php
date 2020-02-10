<?php 
 error_reporting(0);
  session_start(); 
header('Content-type: text/html; charset=utf-8');
include '../connection/baglanti.php';
include '../fonksiyonlar/arayuzfonksiyonlar.php';
include "sessionkontrol.php";



$output = array( "op" => "", "success"=> true, "error_code" => 0, "message" => "","data" => array() );
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	error_reporting(0);
  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getData") ){
     $id = $_REQUEST["id"];
     $sql = "SELECT * FROM FIRMALAR WHERE ID='".$id."' ORDER BY ID asc";
  
    if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
      $result  = 'success';
      $message = 'query success';
    $st = $pdo->prepare($sql);
    $st->execute();
    $mysql_data = $st->fetch(PDO::FETCH_ASSOC);
    }

  $pdo=null;
  //////geni if üstteki { iiaretiyle bitiyor
  // Prepare data
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
  );
  // Convert PHP array to JSON array
  $json_data = json_encode($data);
  //var_dump($mysql_data);
  print $json_data;
  exit;  
  }
  
  
  
  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getILCE") ){
     $ilce_plaka = $_REQUEST["ilce_plaka"];
     $sql = "SELECT * FROM ilce WHERE ilce_plaka='".$ilce_plaka."' order by ilce_adi";
  
    if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
		  $result  = 'success';
		  $message = 'query success';
		$st = $pdo->prepare($sql);
		$st->execute();
		$mysql_data = $st->fetchAll(PDO::FETCH_ASSOC);
    }	
  $pdo=null;
  //////geni if üstteki { iþaretiyle bitiyor
  // Prepare data
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
  );
  //echo $data;
  // Convert PHP array to JSON array
  $json_data = json_encode($data);
  //var_dump($mysql_data);
  print $json_data;
  exit;  
  }
  
  
  
  
  
  
else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Sil") ){
	 $id = $_REQUEST["ID"];
     $sql = "DELETE FROM FIRMALAR WHERE ID=".$id;
	     if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
      $result  = 'success';
      $message = 'query success';
    $st = $pdo->prepare($sql);
    $st->execute();
    }	
  $pdo=null;
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => null
  );
  $json_data = json_encode($data);
  echo $json_data;
}
else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Kaydet") ){
	$id 					= $_REQUEST["ID"];
	$FIRMAUNVAN 			= $_REQUEST["FIRMAUNVAN"];
	$FIRMAADRES 			= $_REQUEST["FIRMAADRES"];
	$FIRMASEHIR 			= $_REQUEST["FIRMASEHIR"];
	$FIRMAILCE 				= $_REQUEST["FIRMAILCE"];
	$FIRMATELEFON1 			= $_REQUEST["FIRMATELEFON1"];
	$FIRMATELEFON2 			= $_REQUEST["FIRMATELEFON2"];
	$FIRMAFAKS 				= $_REQUEST["FIRMAFAKS"];
	$FIRMATICARETSICILNO 	= $_REQUEST["FIRMATICARETSICILNO"];
	$FIRMAVERGIDAIRESI 		= $_REQUEST["FIRMAVERGIDAIRESI"];
	$FIRMAEPOSTA 			= $_REQUEST["FIRMAEPOSTA"];
	$FIRMAWEBADRESI 		= $_REQUEST["FIRMAWEBADRESI"];
	$FIRMATEMSILCISI 		= $_REQUEST["FIRMATEMSILCISI"];
	$FIRMAACIKLAMA 			= $_REQUEST["FIRMAACIKLAMA"];
	 
	 $OLUSTURAN = $_SESSION['username'];
	 
	 if ($id!=null){
     $sql = "UPDATE FIRMALAR set FIRMAUNVAN='$FIRMAUNVAN',FIRMAADRES='$FIRMAADRES',FIRMASEHIR='$FIRMASEHIR',FIRMAILCE='$FIRMAILCE',FIRMATELEFON1='$FIRMATELEFON1',
	 FIRMATELEFON2='$FIRMATELEFON2',FIRMAFAKS='$FIRMAFAKS',FIRMATICARETSICILNO='$FIRMATICARETSICILNO',
	 FIRMAVERGIDAIRESI='$FIRMAVERGIDAIRESI',FIRMAEPOSTA='$FIRMAEPOSTA',FIRMAWEBADRESI='$FIRMAWEBADRESI',FIRMATEMSILCISI='$FIRMATEMSILCISI',FIRMAACIKLAMA='$FIRMAACIKLAMA' WHERE ID=".$id;
	 } else 
	 {	  
		$sql = "INSERT INTO FIRMALAR (FIRMAUNVAN,FIRMAADRES,FIRMASEHIR,FIRMAILCE,FIRMATELEFON1,FIRMATELEFON2,FIRMAFAKS,FIRMATICARETSICILNO,FIRMAVERGIDAIRESI,FIRMAEPOSTA,FIRMAWEBADRESI,FIRMATEMSILCISI,FIRMAACIKLAMA,OLUSTURAN) 
		VALUES 
		('$FIRMAUNVAN', '$FIRMAADRES', '$FIRMASEHIR', '$FIRMAILCE', '$FIRMATELEFON1', '$FIRMATELEFON2', '$FIRMAFAKS', '$FIRMATICARETSICILNO', '$FIRMAVERGIDAIRESI', '$FIRMAEPOSTA', '$FIRMAWEBADRESI', '$FIRMATEMSILCISI', '$FIRMAACIKLAMA', '$OLUSTURAN') ";		
	 } 	 
		 
				 $firmavarmi = $pdo->query("SELECT ID FROM efatura.FIRMALAR WHERE FIRMAUNVAN = '".$FIRMAUNVAN ."'")->fetch();
				 $varmi = $firmavarmi[0];	
				 if ($varmi && $id<>$varmi)
				 {	 	
							$result  = 'Hata';
							$message = 'Bu firma zaten kayıtlı';
				 }
				 else
				 {
						if ($pdo->query($sql) == false) {
						  $result  = 'Hata';
						  $message = 'Hata';
						} else {
						  $result  = 'success';
						  $message = 'Kaydedildi';
						}
				 }
	
  $pdo=null;

  
/*     $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => null
  ); */
  
  	 $data['result']=$result;
	 $data['message'] = $message;
	 $data['data'] = null;
  
  $json_data = json_encode($data);
  echo $json_data;
}
	
exit;
}

include '../tasarim/menu.php';
include '../tasarim/ustalan.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Trust Me (TM) | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->

  
    <style type="text/css">
  /* altta gecici oluşan frame i gizliyor. */
  #upload_frame{
	display:none;
	height:0;
	width:0;
  }
  #msg{
	background-color:#FFE07E;
	border-radius:5px;
	padding:5px;
	display:none;
	width:200px;
	font:italic 13px/18px arial,sans-serif;
  }
  
  </style>
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

				  

				  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hoş Geldiniz
        <small>Her şey burada başlıyor!</small>
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Firma Oluşturma Ekranı</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <!--Start creating your amazing application!-->
		  
					<div class="col-lg-12">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-xs-12">
									<form id="form1" >	
										<div class="box-header">
											<button type="reset" id="btnYeni" name="Yeni" onclick = "" class="btn btn-primary"><span class="fa fa-file-text-o fa-2x"></span> Yeni</button>
											<button type="button" id="btnKaydet" name="Kaydet"  class="btn btn-warning"><span class="fa fa-save fa-2x"></span> Kaydet</button>
											<button type="button" id="btnSil" name="Sil" onclick = "" class="btn btn-danger"><span class="fa fa-trash-o fa-2x"></span> Sil</button>
										</div>
										<input type="text" name="ID" id="ID" class="form-control hidden"  placeholder="ID"  >
										
										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-4"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Firma Ünvan</span></h4>		
													<textarea rows = "5" cols = "60" class="form-control" name="FIRMAUNVAN" id="FIRMAUNVAN"></textarea>
												</div>
											</div>
											<div class="col-sm-4"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary ">Firma Adres</span></h4>	
														<textarea rows = "5" cols = "60" class="form-control" name="FIRMAADRES" id="FIRMAADRES"></textarea>
												</div>
											</div>
											<div class="col-sm-4"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Firma Açıklama</span></h4>	
														<textarea rows = "5" cols = "60" class="form-control" name="FIRMAACIKLAMA" id="FIRMAACIKLAMA"></textarea>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Firma Şehir</span></h4>
													<!--<input type="text" class="form-control" name="FIRMASEHIR" id="FIRMASEHIR"/>-->
														<?php
															$smt = $pdo->prepare('SELECT * FROM iller order by il_adi');
															$smt->execute();
															$data = $smt->fetchAll();
														?>
														<select name="FIRMASEHIR" id="FIRMASEHIR" class="form-control">
															<option value="0">- Select -</option>
															<?php foreach ($data as $row): ?>
																<option value="<?=$row["il_plaka"]?>" ><?=$row["il_adi"]?></option>
															<?php endforeach ?>
														</select>
												</div>
											</div>
											
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Firma İlçe</span></h4>	
													<div class="col-lg-8">
														
														<select id="FIRMAILCE" class="form-control">
															<option value="0">- Select -</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#FIRMASEHIR").change(function(){
													var ilce_plaka = $(this).val();
													$("#FIRMAILCE").html("<option value=''>Yükleniyor...</option>");
													$.ajax({
															url: '?op=getILCE&ilce_plaka='+ilce_plaka, type:'GET', 
															contentType: false,
															processData:false,
															cache: false,
															dataType: "json",   
														}).done(function(response){ //
															$("#FIRMAILCE").empty();
															$.each(response.data,function(i,e){
																$("#FIRMAILCE").append("<option value='"+e.ilce_id+"'>"+e.ilce_adi+"</option>");
															});
														});
												});
											});
										</script>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Firma Telefon1</span></h4>	
													<input type="text" class="form-control" name="FIRMATELEFON1" id="FIRMATELEFON1"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Firma Telefon2</span></h4>	
														<input type="text" class="form-control" name="FIRMATELEFON2" id="FIRMATELEFON2"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Firma Faks</span></h4>
														<input type="text" class="form-control" name="FIRMAFAKS" id="FIRMAFAKS"/>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Firma Ticaret Sicil No</span></h4>	
													<input type="text" class="form-control" name="FIRMATICARETSICILNO" id="FIRMATICARETSICILNO" required />
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Firma Vergi Dairesi</span></h4>	
														<input type="text" class="form-control" name="FIRMAVERGIDAIRESI" id="FIRMAVERGIDAIRESI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Firma Eposta</span></h4>	
														<input type="text" class="form-control" name="FIRMAEPOSTA" id="FIRMAEPOSTA" onblur="kontrolet()" />
												</div>
											</div>
											<script>
												function kontrolet()
													{
														var mail = document.getElementById("FIRMAEPOSTA").value;
														var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+.)+([.])+[a-zA-Z0-9.-]{2,4}$/;
														if (regex.test(mail)==true)
														{alert("Mail adresi geçerli");}
														else
														{alert("Hata geçersiz mail adresi girdiniz!");}
													}
											</script>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Firma Web Adresi</span></h4>	
														<input type="text" class="form-control" name="FIRMAWEBADRESI" id="FIRMAWEBADRESI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Firma Temsilcisi</span></h4>	
														<input type="text" class="form-control" name="FIRMATEMSILCISI" id="FIRMATEMSILCISI"/>
												</div>
											</div>
											
										</div>
									</form>
								</div>
							</div>
						<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
								<script>
								jQuery(function($){
								$("#FIRMATELEFON1").mask("(999) 999-9999", { autoclear: false });
								$("#FIRMATELEFON2").mask("(999) 999-9999", { autoclear: false });
								$("#FIRMAFAKS").mask("(999) 999-9999", { autoclear: false });
								});
								</script>
					</div>					
						<div class="col-xs-12">
								<script type="text/javascript">
									$(document).ready(function(){
										$('#table_firmalar tbody').on('click', 'tr', function () {
											 $.blockUI(); 
											var table = $('#table_firmalar').DataTable();
											var datalar= table.row(this).data();
											var id = datalar['ID'];
											$.ajax({
												url: '?op=getData&id='+id, type:'GET',  
												contentType: false,
												processData:false,
												cache: false,
												dataType: "json",   
											}).done(function(response){ //
											//console.log(response);
											$FIRMAID			= response.data.ID;
											$FIRMAUNVAN			= response.data.FIRMAUNVAN;
											$FIRMAADRES			= response.data.FIRMAADRES;
											$FIRMASEHIR			= response.data.FIRMASEHIR;
											$FIRMAILCE			= response.data.FIRMAILCE;
											$FIRMATELEFON1		= response.data.FIRMATELEFON1;
											$FIRMATELEFON2		= response.data.FIRMATELEFON2;
											$FIRMAFAKS			= response.data.FIRMAFAKS;
											$FIRMATICARETSICILNO= response.data.FIRMATICARETSICILNO;
											$FIRMAVERGIDAIRESI	= response.data.FIRMAVERGIDAIRESI;
											$FIRMAEPOSTA		= response.data.FIRMAEPOSTA;
											$FIRMAWEBADRESI		= response.data.FIRMAWEBADRESI;
											$FIRMATEMSILCISI	= response.data.FIRMATEMSILCISI;
											$FIRMAACIKLAMA		= response.data.FIRMAACIKLAMA;
											document.getElementById("ID").value 					= $FIRMAID;
											document.getElementById("FIRMAUNVAN").value 			= $FIRMAUNVAN;
											document.getElementById("FIRMAADRES").value 			= $FIRMAADRES;
											document.getElementById("FIRMASEHIR").value 			= $FIRMASEHIR;
											$('#FIRMASEHIR').trigger('change');
											document.getElementById("FIRMAILCE").value				= $FIRMAILCE;
											document.getElementById("FIRMATELEFON1").value 			= $FIRMATELEFON1;
											document.getElementById("FIRMATELEFON2").value 			= $FIRMATELEFON2;
											document.getElementById("FIRMAFAKS").value				= $FIRMAFAKS;
											document.getElementById("FIRMATICARETSICILNO").value 	= $FIRMATICARETSICILNO;
											document.getElementById("FIRMAVERGIDAIRESI").value		= $FIRMAVERGIDAIRESI;
											document.getElementById("FIRMAEPOSTA").value 			= $FIRMAEPOSTA;
											document.getElementById("FIRMAWEBADRESI").value 		= $FIRMAWEBADRESI;
											document.getElementById("FIRMATEMSILCISI").value 		= $FIRMATEMSILCISI;
											document.getElementById("FIRMAACIKLAMA").value 			= $FIRMAACIKLAMA;
											});
										});
									});	
								</script>
								
								
								<div id="page_container" class="col-lg-12">
									<h3>Firma Listesi</h3>
									<!--<button type="button" class="button" id="add_company">Add company</button>-->
									<table class="datatable" id="table_firmalar">
										<thead>
											<tr>
												<?php 
													//gridBaslikOlustur(array('S.No','Firma Ünvanı','Temsilcisi','Telefonu'));
													gridBaslikOlustur(array('S.No','Firma Ünvanı','Temsilcisi','Telefonu'));
												?>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<script type="text/javascript">
										//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
										var tabloadi= "table_firmalar";
										var sayfaadi="../kontroller/firmagrid.php";
										var parameter =  [
											   { "data": "row_num"},
											   { "data": "FIRMAUNVAN" },
											   { "data": "FIRMATEMSILCISI" },
   											   { "data": "FIRMATELEFON1" },
										   ];
										gridbas(tabloadi,sayfaadi,parameter);
									</script>
								</div>
							</div>
						
						<div class="lightbox_bg"></div>
						<div class="lightbox_container">
							<div class="lightbox_close"></div>
							<noscript id="noscript_container">
									<div id="noscript" class="error">
										<p>Bu sayfa için Javascript desteğine ihtiyaç var.</p>
									</div>
							</noscript>
							<div id="loading_container">
								<div id="loading_container2">
									<div id="loading_container3">
										<div id="loading_container4">
											Yükleniyor, lütfen bekleyiniz...
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
								</div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- fatura detay popup -->
<style type="text/css">
.modal-dialog {
  width: 80%;
  height: 80%;
  margin: center;
  padding: 0;
}

.modal-content {
  height: auto;
  min-height: 80%;
  border-radius: 0;
}

</style>
<!--
<div class="modal fade" id="mdl-ayrinti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      <form role="form" name="formSonuc" id="formSonuc" method="post" enctype="multipart/form-data" action="" onSubmit="">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-fw fa-check-square-o"></i> Fatura Ayrıntısı</h4>
        </div>
        
		
        <div class="modal-body">
			<div class="table-responsive">
			
				<?php
				/*
					echo "<table class=\"ayrinti-table table table-striped table-inverse\" border=1px>";
					echo "<thead  >";  
					echo  "<tr bgcolor=\"#449d44\" >";
					echo "<th align=\"left\">Sıra No</th>";
					echo "<th align=\"left\">Firma Adı</th>";
					echo "<th align=\"left\">İletişim</th>";
					echo "</tr>";
					echo "</thead>";           
					*/
				?>          
				<tbody class="ayrinti-table-body"></tbody>
				</table>
			</div>
		</div>
		-->

        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->  


									<script>
									  $(document).ready(function () {
									   // $('.sidebar-menu').tree()
									   $(document).ajaxStop($.unblockUI); 
									  });
									  

									 
									  $("#btnSil").click(function (event) {
										  $.blockUI(); 
												var mesaj = "";
												var tablex = $('#table_firmalar').DataTable();
												if($("#ID").val()=="" )
												{
													mesaj +=('Silinecek Kaydı Seçiniz');
												}
												if(mesaj.trim()==""){
											

												var r = confirm("Bu kaydı silmek istediğinize eminmisiniz?");
												if (r == true) {
																event.preventDefault();
																var form = $('#form1')[0];
																var data = new FormData(form);
																data.append("op", "Sil");
																		$.ajax({
																					type: "POST",
																					url: "",
																					data: data,
																					processData: false,
																					contentType: false,
																					cache: false,
																								   beforeSend: function() {
																								$.blockUI;
																								   },
																					success: function (sonuc) {
																						
																								 $.unblockUI;
																									alert(JSON.parse(sonuc).message);
																									$(form1.reset());
																									
																					},
																					error: function (e) {
																									
																									alert(JSON.parse(sonuc).message+' HATA:'+e);
																					},
																					complete: function(data) {
																						tablex.ajax.reload();
																						
																				}
																				});//ajax
																}
																else 
																{
																alert('iptal edildi');
																}
								
																	
								}	
									//alert(""+mesaj+"");

    });   
 
															  $("#btnKaydet").click(function (event) {
																  event.preventDefault();
																  $.blockUI(); 
																  var mesaj = "";
																	if($("#FIRMAUNVAN").val()=="" )		{mesaj +=('Firma Ünvanı <br>');}
																	if($("#FIRMATELEFON1").val()=="" )	{mesaj +=('Firma Telefonu <br>');}
																	if($("#FIRMATEMSILCISI").val()=="" ){mesaj +=('Firma Temsilcisi');}
																  
																if(!mesaj.trim()=="")
																{
																$.blockUI({
																	fadeIn: 500,
																	message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">Lütfen Gerekli Alanları Doldurunuz. </h1><p><font color=red><h3>'+mesaj+'</h3></font></p>',
																	 onOverlayClick: $.unblockUI ,
																	timeout:   3000 
																});		
																
																}
																	else																
																	{
																	var tablex = $('#table_firmalar').DataTable();
																
																var form = $('#form1')[0];
																var data = new FormData(form);
																data.append("op", "Kaydet");
																		$.ajax({
																					type: "POST",
																					url: "",
																					data: data,
																					processData: false,
																					contentType: false,
																					cache: false,
																								beforeSend: function() {
																								$.blockUI;
																								   },
																					success: function (sonuc) {
																$.blockUI({
																	fadeIn: 500,
																	message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">İşlem. </h1><p><font color=red><h3>'+JSON.parse(sonuc).message+'</h3></font></p>',
																	 onOverlayClick: $.unblockUI ,
																	timeout:   3000 
																});		

																									$(form1.reset());
																									
																					},
																					error: function (e) {
																									
																									alert(JSON.parse(sonuc).message+' HATA:'+e);
																					},
																					complete: function(data) {
																						tablex.ajax.reload();
																						
																				}
																		});//ajax
																		
																	}		
																		
																});   
																  

</script>
</body>
</html>
