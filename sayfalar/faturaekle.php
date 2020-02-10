<?php 
header('Content-type: text/html; charset=utf-8');
include '../connection/baglanti.php';
include '../fonksiyonlar/arayuzfonksiyonlar.php';
include "sessionkontrol.php";

 error_reporting(0);
  session_start(); 

$output = array( "op" => "", "success"=> true, "error_code" => 0, "message" => "","data" => array() );
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getData") ){
     $id = $_REQUEST["id"];
     $sql = "SELECT * from Faturalar
		 where ID='".$id."' ORDER BY ID desc";
  
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
  //////geniş if üstteki { işaretiyle bitiyor
  // Prepare data
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
  );
  // Convert PHP array to JSON array
  
  
      $a1 = array("u00fc","u011f","u0131","u015f","u00e7","u00f6","u00dc","u011e","u0130","u015e","u00c7","u00d6");
	$a2 = array("ü","ğ","ı","ş","ç","ö","Ü","Ğ","İ","Ş","Ç","Ö");
	$sonuc = str_replace($a1, $a2, json_encode($data));
  
  //$json_data = json_encode($data);
  //var_dump($mysql_data);
  print $sonuc;
  exit;  
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
	  jQuery(document).ready(

		  function(){
				jQuery('#file_upload_form').submit(function(){
						// show loader [optional line]
						//$('#msg').html('Yükleniyor....').fadeIn();
						var tablex = $('#table_companies').DataTable();
					if(document.getElementById('upload_frame') == null) {
						// create iframe
						$('body').append('<iframe id="upload_frame" name="upload_frame"></iframe>');
						$('#upload_frame').on('load',function(){
							if($(this).contents()[0].location.href.match($(this).parent('form').attr('action'))){
							// display server response [optional line]
							$('#server_response').html($(this).contents().find('html').html());
							// hide loader [optional line]
							$('#msg').hide();
							//KAYIT GİRİLDİKTEN SONRA FORMDAKİ KONTROLLERİ RESETLİYOR
							$("#file_upload_form")[0].reset();
							tablex.ajax.reload();
							}
						})
						$(this).attr('method','post');	
						$(this).attr('enctype','multipart/form-data');	
						$(this).attr('target','upload_frame').submit();						
						
					}
				});
		  }
	  );
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
        
        <small>Her Şey Burada Başlıyor</small>
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Fatura Yükleme Ekranı</h3>

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
								<div class="col-xs-4">
									<form id="file_upload_form" action="../fonksiyonlar/upload.php"  >	
										<div class="row" style="margin-top:20px">	
											<div class="col-lg-12"	>
												<div class="form-group has-primary">
													<div class="col-lg-4 .label label-primary">	
														<h4> <span class="label label-primary" size="6">FİRMA</span></h4>	
													</div>
													<div class="col-lg-8">
														<?php
														$smt = $pdo->prepare('SELECT ID,FIRMAUNVAN FROM FIRMALAR');
														$smt->execute();
														$data = $smt->fetchAll();
														?>
														<select name='FATURA_FIRMA' id='FATURA_FIRMA' class="btn btn-warning dropdown">
															<option value="0">Seçiniz</option>
															<?php foreach ($data as $row): ?>
															<option value="<?=$row["ID"]?>"><?=$row["FIRMAUNVAN"]?></option>
															<?php endforeach ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:20px">	
											<div class="col-lg-12"	>
												<div class="form-group has-success">
													<div class="col-lg-4 .label label-primary">	
													
														<h4> <span class="label label-primary" size="6">OLUŞTURAN</span></h4>
														
													</div>
													<div class="col-lg-8">
													
													<?php
													$kontrol = $_SESSION['username'];
													echo "<input type=\"text\" class=\"form-control\" name=\"OLUSTURAN\" id=\"OLUSTURAN\" value=\"".$kontrol."\" readonly/>";
													?>
													
													
													
														
													</div>
												</div>
											</div>
										</div>	
										<script type="text/javascript">
											$( function() {
												$( "#TARIH" ).datepicker({
													dateFormat: "dd-mm-yy"
												});
											} );
										</script>				
										<div class="row" style="margin-top:20px">	
											<div class="col-lg-12"	>
												<div class="form-group has-success">
													<div class="col-lg-4 .label label-primary">	
														<h4> <span class="label label-primary" size="6">TARİH</span></h4>	
													</div>
													<div class="col-lg-8">
														<input type="text" class="form-control" name="TARIH" id="TARIH" readonly/>
													</div>
												</div>
											</div>
										</div>	
										<div class="row" style="margin-top:20px">	
											<div class="col-lg-12"	>
												<div class="form-group has-success">
													<div class="col-lg-12">				
														<input type="file" id="FATURA_ADI" name="FATURA_ADI" class="fileUpload btn btn-success" />
													</div>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:20px">	
											<div class="col-lg-12"	>
												<div class="form-group has-success">
													<input type="submit" value="Upload" class="btn btn-primary btn-block"/>
												</div>
											</div>
										</div>	
									</form>
								</div>
								<div class="col-xs-8">
									<div id="msg"></div>
									<pre id="server_response" ></pre>
								</div>
							</div>
						</div>

						<script type="text/javascript">
							$(document).ready(function(){
							  // On page load: datatable
							   $('#table_companies tbody').on('click', 'tr', function () {
									var table = $('#table_companies').DataTable();
									var datalar= table.row(this).data();
									var id = datalar['ID'];
									$.ajax({
									url: '?op=getData&id='+id, type:'GET',  
									//data: {islem:'getData', id:id},        
									contentType: false,
									processData:false,
									cache: false,
									dataType: "json",   
								  }).done(function(response){ //
									console.log(response);
									$fatura_str = response.data.XML.replace(/\r\n|\n|\r/g, ' ');
									$fatura = JSON.parse($fatura_str);
									//console.log($fatura);
									$tr = "";
									$.each($fatura,function($index,$row){
									  $tr +="<tr>";                      
									  $tr +="<td align=\"left\">"+($index+1)+"</td>";
									  $tr +="<td align=\"left\">"+$row.item+"</td>";
									  $tr +="<td align=\"left\">"+$row.InvoicedQuantity+"</td>";
									  $tr +="<td align=\"left\">"+$row.PriceAmount+"</td>";
									  $tr +="<td align=\"left\">"+$row.Percent+"</td>";
									  $tr +="<td align=\"left\">"+$row.TaxAmount+"</td>";
									  $tr +="<td align=\"left\">"+$row.LineExtensionAmount+" </td>";
									  $tr +="<td align=\"left\">"+$row.Note+" </td>";
									  $tr +="</tr>";                      
									});
									$(".ayrinti-table-body").html($tr);
									$("#mdl-ayrinti").modal("show");
								  });
								});
							});	
						</script>
						
						
						
						
						
						
						<div id="page_container" class="col-lg-12">
							<h3>E-fatura Listesi</h3>
							<!--<button type="button" class="button" id="add_company">Add company</button>-->
							<table class="datatable" id="table_companies">
								<thead>
									<tr>
										<?php 
											gridBaslikOlustur(array('ID','FATURA_ADI','FATURA_FIRMA','OLUSTURAN'));
										?>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<script type="text/javascript">
								//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
								var tabloadi= "table_companies";
								var sayfaadi="../kontroller/faturagrid.php";
								var parameter =  [
									   { "data": "ID"},
									   { "data": "FATURA_ADI" },
									   { "data": "FIRMAUNVAN" },
									   { "data": "OLUSTURAN" },
								   ];
								gridbas(tabloadi,sayfaadi,parameter);
							</script>
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

			<table class="ayrinti-table table table-striped table-inverse" border=1px>
            <thead>
            <tr bgcolor="#449d44" >
              <th align="left">S.No</th>
              <th align="left">İtem</th>
              <th align="left">İnvoiced Quantity</th>
              <th align="left">PriceAmount</th>
              <th align="left">Percent</th>
              <th align="left" >TaxAmount</th>
              <th align="left">LineExtensionAmount </th>
              <th align="left">Note </th>
              </tr>
            </thead>
       
         <tbody class="ayrinti-table-body"></tbody>
       </table>
     </div>
     </div>
          <div class="modal-footer clearfix">

          <button type="button" name="btnIptal" value="İptal" class="btn btn-danger pull-left" data-dismiss="modal" onclick=""><i class="fa fa-times"></i> Kapat</button>
            
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->  


<script>
  $(document).ready(function () {
   // $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
