<?php
function mesajHata($str){
  echo "<div class=\"alert alert-danger alert-dismissable\">
  <i class=\"fa fa-ban\"></i>
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
  <b>Hata!</b> $str.
 </div>";
}
function mesajBilgi($str){
echo "<div class=\"alert alert-info alert-dismissable\">
        <i class=\"fa fa-info\"></i>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
          <b>Bilgi!</b> $str .</div>";
}
function mesajUyari($str) {
	echo "<div class=\"alert alert-warning alert-dismissable\">
           <i class=\"fa fa-warning\"></i>
           <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
            <b>Uyarý!</b> $str. </div>";
}
function mesajBasari($str) {
	echo "<div class=\"alert alert-success alert-dismissable\">
         <i class=\"fa fa-check\"></i>
         <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
         <b>Baþarý!</b> $str.  </div>";
}
function gridBaslikOlustur($baslik){	
	$dizi = $baslik;
	foreach ($dizi as $deger)
	{
		echo "<th>".$deger."</th>";
	}
}
 ?>