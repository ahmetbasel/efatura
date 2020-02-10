  
  <?php 
 error_reporting(0);
  session_start(); 
$pth="/basel/";
 ?>



<link href="<?php echo $pth;?>/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo $pth;?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?php echo $pth;?>/css/jquery-ui.css" rel="stylesheet" media="screen">
<script src="<?php echo $pth;?>/js/jquery.js"></script>
<script src="<?php echo $pth;?>/js/jquery.min.js"></script>
<script src="<?php echo $pth;?>/js/jquery-ui.js"></script>
<script src="<?php echo $pth;?>/js/bootstrap.js"></script>
<script src="<?php echo $pth;?>/js/bootstrap.min.js"></script>


  <link rel="stylesheet" href="<?php echo $pth;?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo $pth;?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oxygen:400,700">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $pth;?>/css/scrud_layout.css">
    <script charset="utf-8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <script charset="utf-8" src="//cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.min.js"></script>
	<script charset="utf-8" src="<?php echo $pth;?>/js/gridOlustur.js"></script>
	<script charset="utf-8" src="<?php echo $pth;?>/js/jquery.blockUI.js"></script>






<header class="main-header">
    <a href="<?php echo $pth;?>index.php" class="logo">
      <span class="logo-mini"><b>T</b>M</span>
      <span class="logo-lg"><b>Trust</b>Me<b>&nbsp;&nbsp;(TM)</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
				<span class="icon-bar">Dashboard</span>
				<span class="icon-bar">Fatura Ekle</span>
				<span class="icon-bar">Firma Ekle</span>
				<span class="icon-bar">Kullanıcı Ekle</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $pth;?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
							<?php 
							$kullaniciadi = $_SESSION['username'];
							$sessionprofiladi = $pdo->prepare("SELECT user_username,user_adi,user_soyadi,user_yetki FROM efatura.kullanicilar where user_username = '$kullaniciadi'");
							$sessionprofiladi->execute();
							$sessionprofildata = $sessionprofiladi->fetchAll();
								foreach ($sessionprofildata as $satir)
								{
									echo "<span>".$satir["user_adi"] ." " . $satir["user_soyadi"]." - " . $satir["user_yetki"]."</span>";
								}
								?>

								
            </a>
            
          </li>

        </ul>
      </div>
    </nav>
  </header>
  

 
 
 
 