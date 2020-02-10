<?php 
 session_start();  
 error_reporting(0);
$pth="/basel/";

$m_firma	="";
$m_fatura	= "";
$m_kullanici="";

$m_fatura= "
		<li>
          <a href=\"".$pth."sayfalar/faturaekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Fatura İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if($_SESSION['YETKI']=="TAM")				
$m_firma="
		<li>
          <a href=\"".$pth."sayfalar/firmaekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Firma İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if($_SESSION['YETKI']=="TAM")			
$m_kullanici="
		<li>
          <a href=\"".$pth."sayfalar/kullaniciekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Kullanıcı İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";


echo "
<aside class=\"main-sidebar\">
    <section class=\"sidebar\">
      <div class=\"user-panel\">
        <div class=\"pull-left \">
          <img src=\"".$pth."logo.png\"  alt=\"User Image\">
        </div>
      </div>
      <form action=\"#\" method=\"get\" class=\"sidebar-form\">
        
      </form>
      <ul class=\"sidebar-menu\" data-widget=\"tree\">
        <li class=\"navbar\">
          <a href=\"".$pth."index.php\" class=\"btn btn-primary btn\">
            <i class=\"fa fa-th\"></i> <span>Dashboard</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
       
".
$m_firma.	
$m_fatura.	
$m_kullanici.
"
     <div class=\"dropdown-divider\"></div>
		<li class=\"navbar\">
          <a href=\"".$pth."sayfalar/profil.php\" class=\"btn btn-info btn\">
            <i class=\"fa fa-th\"></i> <span>Profil</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
		<li class=\"navbar\">
          <a href=\"".$pth."logout.php\" class=\"btn btn-primary btn\">
            <i class=\"fa fa-th\"></i> <span>Çıkış Yap</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>

      </ul>
    </section>
  </aside>";
?>