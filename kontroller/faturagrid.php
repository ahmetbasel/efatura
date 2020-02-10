<?php

 error_reporting(0);
// Database details
include '../connection/baglanti.php';
 
 session_start(); 
 
 function json_encode_tr($string)
{
    return json_encode($string, JSON_UNESCAPED_UNICODE);
}

function gridBaslikOlustur($baslik){	
	$dizi = $baslik;
	foreach ($dizi as $deger)
	{
		echo "<th>".$deger."</th>";
	}
}
	// Get job (and id)
$job = '';
$id  = '';
	
	
	if (isset($_GET['job'])){
  $job = $_GET['job'];
  if ($job == 'get_companies'){
    if (isset($_GET['id'])){
      $id = $_GET['id'];
      if (!is_numeric($id)){
        $id = '';
      }
    }
  } else {
    $job = '';
  }
}
// Diziyi tanımla
$mysql_data = array();

// Ýþ Geçerli mi, Kontrol et
if ($job != ''){
    // Ýþi Çalýþtýr
  if ($job == 'get_companies'){
    // Get companies
	$XWHERE="";
	if ($_SESSION['YETKI']!="TAM"){$XWHERE=" AND F.OLUSTURAN='".$_SESSION['username']."'";}
		$sql = "SELECT F.ID,F.FATURA_ADI,F.FATURA_FIRMA,U.FIRMAUNVAN AS FIRMAUNVAN,F.TARIH,F.OLUSTURAN,F.FATURA_ONAY FROM FATURALAR F 
		Left OUTER JOIN 
		FIRMALAR U
		ON F.FATURA_FIRMA = U.ID  where 1 ".$XWHERE." ORDER BY F.ID desc  ";
	
		if ($pdo->query($sql) == false) {
		$result  = 'error';
		$message = 'query error';
		} else {
		$result  = 'success';
		$message = 'query success';
		$st = $pdo->prepare($sql);
		$st->execute();
		

	
	
		while ($company = $st->fetch(PDO::FETCH_ASSOC)){
			$mysql_data[] = array(
			"ID"			=> $company['ID'],
			"FATURA_ADI"  => $company['FATURA_ADI'],
			"FIRMAUNVAN"=> $company['FIRMAUNVAN'],
			"OLUSTURAN"=> $company['OLUSTURAN'],
			//"XML"=> json_decode($company['XML']),
			);
		}
		}
  } 
  $pdo=null;
}
//////geniþ if üstteki { iþaretiyle bitiyor
// Prepare data
$data = array(
  "result"  => $result,
  "message" => $message,
  "data"    => $mysql_data,
  "xx"    => $_SESSION['YETKI']
  
);
// Convert PHP array to JSON array
$json_data = json_encode($data);

print $json_data;
////////////

?>
