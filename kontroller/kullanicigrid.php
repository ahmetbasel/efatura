<?php
// Database details
include '../connection/baglanti.php';
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
// Diziyi tanýmla
$mysql_data = array();

// Ýþ Geçerli mi, Kontrol et
if ($job != ''){
    // Ýþi Çalýþtýr
  if ($job == 'get_companies'){
    // Get companies
    $sql = "SELECT (@row_number:=@row_number + 1) AS row_num, ID, USER_ADI, USER_SOYADI, USER_EPOSTA, USER_SIFRE, 
	USER_CINSIYET, USER_DOGUMTARIHI, USER_YETKI, USER_SABITTEL, USER_CEPTEL, USER_USERNAME FROM kullanicilar, (SELECT @row_number:=0) AS t ORDER BY ID desc";
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
				"row_num"				=> $company['row_num'],
				"ID"					=> $company['ID'],
				"USER_ADI"				=> $company['USER_ADI'],
				"USER_SOYADI"			=> $company['USER_SOYADI'],
				"USER_EPOSTA"			=> $company['USER_EPOSTA'],
				"USER_SIFRE"			=> $company['USER_SIFRE'],
				"USER_CINSIYET"			=> $company['USER_CINSIYET'],
				"USER_DOGUMTARIHI"		=> $company['USER_DOGUMTARIHI'],
				"USER_YETKI"			=> $company['USER_YETKI'],
				"USER_SABITTEL"			=> $company['USER_SABITTEL'],
				"USER_CEPTEL"			=> $company['USER_CEPTEL'],
				"USER_USERNAME"			=> $company['USER_USERNAME'],
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
  "data"    => $mysql_data
);
// Convert PHP array to JSON array
$json_data = json_encode($data);
print $json_data;
////////////

?>
