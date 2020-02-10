<?php 
header('Content-type: text/html; charset=utf-8');
include '../connection/baglanti.php';
include '../fonksiyonlar/arayuzfonksiyonlar.php';
include "sessionkontrol.php";

//include '../tasarim/mainheader.php';
 error_reporting(0);
 session_start(); 

$output = array( "op" => "", "success"=> true, "error_code" => 0, "message" => "","data" => array() );
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getData") ){
     $id = $_REQUEST["id"];
     $sql = "SELECT * FROM KULLANICILAR WHERE ID='".$id."' ORDER BY ID asc";
  
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
  //////geni if üstteki { iþaretiyle bitiyor
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
else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Sil") ){
	 $id = $_REQUEST["ID"];
     $sql = "DELETE FROM KULLANICILAR WHERE ID=".$id;
	     if ($pdo->query($sql) == false) {
      $result  = 'Hata';
      $message = 'Hata Oluştu';
    } else {
      $result  = 'Başarılı';
      $message = 'Kayıt Silindi';
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
	$USER_ADI 				= $_REQUEST["USER_ADI"];
	$USER_SOYADI 			= $_REQUEST["USER_SOYADI"];
	$USER_EPOSTA 			= $_REQUEST["USER_EPOSTA"];
	$USER_SIFRE 			= $_REQUEST["USER_SIFRE"];
	$USER_CINSIYET 			= $_REQUEST["USER_CINSIYET"];
	$USER_DOGUMTARIHI 		= $_REQUEST["USER_DOGUMTARIHI"];
	$USER_YETKI 			= $_REQUEST["USER_YETKI"];
	$USER_SABITTEL 			= $_REQUEST["USER_SABITTEL"];
	$USER_CEPTEL 			= $_REQUEST["USER_CEPTEL"];
	$USER_USERNAME 			= $_REQUEST["USER_USERNAME"];
	
	//şifre değiştirmek istiyorsak bu alanı kontrol ediyoruz. 
	$checkdeger 			= $_REQUEST["checkdeger"];

	
	 
	 
	 
	$md5li= md5(sha1($USER_SIFRE)); 
	 
	 if ($id!=null)
		{
			
			if ($checkdeger == '1')
				{
					
					$sql = "UPDATE KULLANICILAR set USER_ADI='$USER_ADI', USER_SOYADI='$USER_SOYADI',USER_EPOSTA='$USER_EPOSTA',USER_CINSIYET='$USER_CINSIYET', USER_SIFRE = '$md5li',
			 USER_DOGUMTARIHI='$USER_DOGUMTARIHI',USER_YETKI='$USER_YETKI',USER_SABITTEL='$USER_SABITTEL',
			 USER_CEPTEL='$USER_CEPTEL',USER_USERNAME='$USER_USERNAME' WHERE ID=".$id;
			
				}
			else
				{
					$sql = "UPDATE KULLANICILAR set USER_ADI='$USER_ADI',USER_SOYADI='$USER_SOYADI',USER_EPOSTA='$USER_EPOSTA',USER_CINSIYET='$USER_CINSIYET',
			 USER_DOGUMTARIHI='$USER_DOGUMTARIHI',USER_YETKI='$USER_YETKI',USER_SABITTEL='$USER_SABITTEL',
			 USER_CEPTEL='$USER_CEPTEL',USER_USERNAME='$USER_USERNAME' WHERE ID=".$id;
				}
			
		}
	else 
	 {	  
		$OLUSTURAN = $_SESSION['username'];
		$sql = "INSERT INTO KULLANICILAR (USER_ADI,USER_SOYADI,USER_EPOSTA,USER_SIFRE,USER_CINSIYET,USER_DOGUMTARIHI,USER_YETKI,USER_SABITTEL,USER_CEPTEL,USER_USERNAME,OLUSTURAN) 
		VALUES 
		('$USER_ADI', '$USER_SOYADI', '$USER_EPOSTA','$md5li', '$USER_CINSIYET', '$USER_DOGUMTARIHI', '$USER_YETKI', '$USER_SABITTEL', '$USER_CEPTEL', '$USER_USERNAME', '$OLUSTURAN') ";		
	 } 	 
		 
		 		$kullanicivarmi = $pdo->query("SELECT ID FROM efatura.KULLANICILAR WHERE USER_USERNAME = '".$USER_USERNAME ."'")->fetch();
				 $varmi = $kullanicivarmi[0];	
				 if ($varmi && $id<>$varmi)
				 {	 	
							$result  = 'Hata';
							$message = 'Bu kullanıcı ismi zaten kayıtlı';
				 }
				 else
				 {
							if ($pdo->query($sql) == false) {
							  $result  = 'error';
							  $message = 'query error';
							} else {
								$basari= " Kullanıcısı başarı ile eklendii."; 
								$result  = 'İşlem Tamam';
								$message = 'Kayıt işlemi başarılı';
							}
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
  
  <script type="text/javascript">
  
function hideCheckDiv() {
$("#divChck").hide();
};
function showCheckDiv() {
$("#divChck").show();
};
function hideSifre() {
	$("#divSifre").hide();
}
function showSifre() {
	$("#divSifre").show();
}
</script>
  <script>
$(document).ready(function() {
	hideCheckDiv();
	showSifre();
});
  </script>  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hoşgeldiniz
        <small>Her şey burada başlıyor</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Kullanıcı Yönetim Ekranı</h3>

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
									<form id="form1">	
										<div class="box-header">
											<button type="reset" id="btnYeni" name="Yeni" onclick = "hideCheckDiv(),showSifre()" class="btn btn-primary"><span class="fa fa-file-text-o fa-2x"></span> Yeni</button>
											<button type="button" id="btnKaydet" name="Kaydet"  class="btn btn-warning"  ><span class="fa fa-save fa-2x"></span> Kaydet</button>
											<button type="button" id="btnSil" name="Sil" onclick = "" class="btn btn-danger"><span class="fa fa-trash-o fa-2x"></span> Sil</button>
										</div>
										<input type="text" name="ID" id="ID" class="form-control hidden"  placeholder="ID"  >
										
										
										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">KULLANICI ADI</span></h4>
													
														<input type="text" class="form-control" name="USER_USERNAME" id="USER_USERNAME" required="required" />
												</div>
											</div>
											<div class="col-sm-3">
												<div class="col-sm-6"	>
													<div class="form-group has-success" class="col-sm-6" >
														<h4> <span class="label label-primary" size="6">YETKİ</span></h4>	
														<select id="USER_YETKI" name="USER_YETKI" class="btn btn-warning dropdown">
															<option value="0" selected>SEÇİNİZ</option>
															<option value="KISITLI">KISITLI</option>
															<option value="TAM">TAM</option>
														</select>
													</div>
													<div class="form-group has-success" class="col-sm-6" id ="divChck">
														<input type="checkbox" id="chckSifre" />
														<h5><span class="label label-primary" size="6">Şifre Güncelle</span></h5>
														<input type="text" class="form-control" name="checkdeger" id="checkdeger" style="display:none;"  />
													</div>
												</div>
											</div>												
												
												
												<div id="divSifre" class="col-sm-6" style="display: none">
													<div class="col-sm-6"	>
														<div class="form-group has-success">
															<h4> <span class="label label-primary">ŞİFRE</span></h4>
															<input type="password" class="form-control" name="USER_SIFRE" id="USER_SIFRE"  />
														</div>
													</div>
												<div class="col-sm-6"	>
													<div class="form-group has-success">
															<h4> <span class="label label-primary">ŞİFRE TAKRAR</span></h4>	
															<input type="password" class="form-control" name="USER_SIFRETEKRAR" id="USER_SIFRETEKRAR"/>
													</div>
												</div>
													
												
												<script>
													$(function () {
														$("#chckSifre").click(function () {
															if ($(this).is(":checked")) {
																$("#divSifre").show();
																document.getElementById("checkdeger").value = '1';
																
															} else {
																$("#divSifre").hide();
																document.getElementById("checkdeger").value = '0';
																
															}
														});
													});				
																								
																								
												</script>										
												</div>
												
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span for="USER_ADI" class="label label-primary">ADI</span></h4>	
													
														<input type="text" class="form-control" name="USER_ADI" id="USER_ADI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">SOYADI</span></h4>	
														<input type="text" class="form-control" name="USER_SOYADI" id="USER_SOYADI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">E-POSTA</span></h4>	
														<input type="text" class="form-control" name="USER_EPOSTA" id="USER_EPOSTA" onblur=""/>
												</div>
											</div>
											<script>

											</script>
										</div>		
											<script type="text/javascript">
											
												$( function() {
													$("#USER_DOGUMTARIHI").datepicker({
														dateFormat: "yy-mm-dd"
													});
												} );
											
											</script>										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">CİNSİYET</span></h4>		
													<label class="radio-inline"><input type="radio" name="USER_CINSIYET" id="ERKEK" Value="ERKEK" checked>Erkek</label>
													<label class="radio-inline"><input type="radio" name="USER_CINSIYET" id = "KADIN" Value="KADIN">Kadın</label>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">DOĞUM TARİHİ</span></h4>
														<input type="text" class="form-control" name="USER_DOGUMTARIHI" id="USER_DOGUMTARIHI"/>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">SABİT TELEFON</span></h4>		
														<input type="text" class="form-control" name="USER_SABITTEL" id="USER_SABITTEL"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">CEP TELEFON</span></h4>	
														<input type="text" class="form-control" name="USER_CEPTEL" id="USER_CEPTEL"/>
												</div>
											</div>											
										</div>	
										
										
								<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
								<script>
								jQuery(function($){
								$("#USER_SABITTEL").mask("(999) 999-9999", { autoclear: false });
								$("#USER_CEPTEL").mask("(999) 999-9999", { autoclear: false });
								
								//$("#FIRMATELEFON2").mask("(999) 999-9999");
								//$("#nic").mask("99999-9999999-9");
								//$("#date").mask("99/99/9999");
								//$("#phone").mask("(999) 999-9999");
								//$("#ext").mask("(999) 999-9999? Ext.99999");
								//$("#mobile").mask("+99 999 999 999");
								//$("#percent").mask("99%");
								//$("#productkey").mask("a*-999-a999");
								//$("#orderno").mask("PO: aaa-999-***");
								//$("#date2").mask("99/99/9999", { autoclear: false });
								//$("#date3").mask("99/99/9999", { autoclear: false, completed:function(){alert("Completed!");} });
								//$("#mobile2").mask("+1 999 999 999");
								});
								</script>
										
										
										
									</form>
								</div>
								
							</div>
							</div>
							<div class="col-xs-12">
									<script type="text/javascript">
									$(document).ready(function(){
										
										
										$('#table_KULLANICILAR tbody').on('click', 'tr', function () {
											$.blockUI(); 
											var table = $('#table_KULLANICILAR').DataTable();
											var datalar= table.row(this).data();
											var id = datalar['ID'];
											$.ajax({
												url: '?op=getData&id='+id, type:'GET',  
												contentType: false,
												processData:false,
												cache: false,
												dataType: "json",   
											}).done(function(response){ 
												$("#divChck").show();
												$("#divSifre").hide();
											console.log(response);
											
											document.getElementById("ID").value 				= response.data.ID;
											document.getElementById("USER_ADI").value 			= response.data.USER_ADI;
											document.getElementById("USER_SOYADI").value 		= response.data.USER_SOYADI;
											document.getElementById("USER_EPOSTA").value 		= response.data.USER_EPOSTA;
											var cinsiyet = response.data.USER_CINSIYET;
											if (cinsiyet =="ERKEK")
											{
												document.getElementById("ERKEK").checked = true ;
											}
											else 
											{
												document.getElementById("KADIN").checked = true ;
											}
											document.getElementById("USER_DOGUMTARIHI").value 	= response.data.USER_DOGUMTARIHI;
											document.getElementById("USER_YETKI").value			= response.data.USER_YETKI;
											document.getElementById("USER_SABITTEL").value 		= response.data.USER_SABITTEL;
											document.getElementById("USER_CEPTEL").value		= response.data.USER_CEPTEL;
											document.getElementById("USER_USERNAME").value 		= response.data.USER_USERNAME;
											
											});
										
										});
									});	
								</script>
									<div id="page_container" class="col-lg-12">
									<h3>Kullanıcı Listesi</h3>
									<!--<button type="button" class="button" id="add_company">Add company</button>-->
									<table class="datatable" id="table_KULLANICILAR">
										<thead>
											<tr>
												<?php 
													//gridBaslikOlustur(array('S.No','Firma Ünvanı','Temsilcisi','Telefonu'));
													gridBaslikOlustur(array('S.No','KULLANICI ADI','EPOSTA','YETKİ'));
												?>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<script type="text/javascript">
										//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
										var tabloadi= "table_KULLANICILAR";
										var sayfaadi="../kontroller/kullanicigrid.php";
										var parameter =  [
											   { "data": "row_num"},
											   { "data": "USER_USERNAME" },
											   { "data": "USER_EPOSTA" },
   											   { "data": "USER_YETKI" },
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
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->  

							<script>
							var form = document.getElementById('form');
							//var btnKaydet = document.getElementById('btnKaydet');
							var btnKaydet = document.getElementById('btnKaydet');

							//btnKaydet.addEventListener('click', send);

							function send(e) {
								btnKaydet.click();
							}
							</script>
							<script>
								$(document).ready(function () {
									$(document).ajaxStop($.unblockUI); 
									$(document).ajaxStart($.blockUI); 
									$(form1.reset());
								// $('.sidebar-menu').tree()
								});
								  $("#btnSil").click(function (event) {
									  $.blockUI(); 
									var mesaj = "";
									var tablex = $('#table_KULLANICILAR').DataTable();
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
																				
																				   },
																	success: function (sonuc) {
																		
																$.blockUI({
																	fadeIn: 500,
																	message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">'+JSON.parse(sonuc).result+'</h1><p><font color=red><h3>'+JSON.parse(sonuc).message+'</h3></font></p>',
																	 onOverlayClick: $.unblockUI ,
																	timeout:   3000 
																});	
																		$("#divChck").hide();
																		$("#divSifre").show();
																		$(form1.reset());
																					
																	},
																	error: function (e) {
																				//	alert(result.message+' HATA:'+e);
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
									});   
								$("#btnKaydet").click(function (event) {
									
								var mail = document.getElementById("USER_EPOSTA").value;
								var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+.)+([.])+[a-zA-Z0-9.-]{2,4}$/;
									

									 if ($('#USER_USERNAME').val()=='')
									{
										$.blockUI({
										fadeIn: 500,
										message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">Hata. </h1><p><font color=red><h3>Kullanıcı Adı Giriniz</h3></font></p>',
										 onOverlayClick: $.unblockUI ,
										timeout:   3000 
									});	return;										
									} 
									else if ($('#USER_SIFRE').val().length<3 && $('#chckSifre').prop('checked'))
									{
										$.blockUI({
										fadeIn: 500,
										message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">Hata. </h1><p><font color=red><h3>En az 3 karakterli şifre giriniz</h3></font></p>',
										 onOverlayClick: $.unblockUI ,
										timeout:   3000 
									});	return;										
									}
									else if ($('#USER_SIFRE').val()!=$('#USER_SIFRETEKRAR').val() && $('#chckSifre').prop('checked') )
									{
										$.blockUI({
										fadeIn: 500,
										message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">Hata. </h1><p><font color=red><h3>Şifreler aynı değil</h3></font></p>',
										 onOverlayClick: $.unblockUI ,
										timeout:   3000 
									});	return;										
									}									

									else if ($('#USER_YETKI').val()=='0')
									{
										$.blockUI({
										fadeIn: 500,
										message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">Hata. </h1><p><font color=red><h3>Yetki seçiniz</h3></font></p>',
										 onOverlayClick: $.unblockUI ,
										timeout:   3000 
									});	return;										
									}

										else if (regex.test(mail)==false)
										{
										$.blockUI({
										fadeIn: 500,
										message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">Hata. </h1><p><font color=red><h3>Geçersiz mail adresi girdiniz!</h3></font></p>',
										 onOverlayClick: $.unblockUI ,
										timeout:   3000 
									});	return;		
										}	
									else
									{
									
									var mesaj = "";
									var tablex = $('#table_KULLANICILAR').DataTable();
									event.preventDefault();
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
												},
											success: function (sonuc) {

																$.blockUI({
																	fadeIn: 500,
																	message: '<h1 style="padding:0px 20px 5px 20px; color:#003366; font-size:18px;">'+JSON.parse(sonuc).result+'</h1><p><font color=red><h3>'+JSON.parse(sonuc).message+'</h3></font></p>',
																	 onOverlayClick: $.unblockUI ,
																	timeout:   3000 
																});		
												hideSifre();
												hideCheckDiv();
												$(form1.reset());
											},
											error: function (e) {
												alert(sonuc.message+' HATA:'+e);
											},
											complete: function(data) {
												tablex.ajax.reload();
											}
										});//ajax
									}//else
								});   
							</script>
</body>
</html>
