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
    $sql = "SELECT (@row_number:=@row_number + 1) AS row_num, ID, FIRMAUNVAN, FIRMAADRES, FIRMASEHIR, FIRMAILCE, FIRMATELEFON1, FIRMATELEFON2, FIRMAFAKS, FIRMATICARETSICILNO, FIRMAVERGIDAIRESI, FIRMAEPOSTA, FIRMAWEBADRESI, FIRMATEMSILCISI, FIRMAACIKLAMA FROM firmalar, (SELECT @row_number:=0) AS t ORDER BY ID desc";
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
				"FIRMAUNVAN"			=> $company['FIRMAUNVAN'],
				"FIRMAADRES"			=> $company['FIRMAADRES'],
				"FIRMASEHIR"			=> $company['FIRMASEHIR'],
				"FIRMAILCE"				=> $company['FIRMAILCE'],
				"FIRMATELEFON1"			=> $company['FIRMATELEFON1'],
				"FIRMATELEFON2"			=> $company['FIRMATELEFON2'],
				"FIRMAFAKS"				=> $company['FIRMAFAKS'],
				"FIRMATICARETSICILNO"	=> $company['FIRMATICARETSICILNO'],
				"FIRMAVERGIDAIRESI"		=> $company['FIRMAVERGIDAIRESI'],
				"FIRMAEPOSTA"			=> $company['FIRMAEPOSTA'],
				"FIRMAWEBADRESI"		=> $company['FIRMAWEBADRESI'],
				"FIRMATEMSILCISI"		=> $company['FIRMATEMSILCISI'],
				"FIRMAACIKLAMA"			=> $company['FIRMAACIKLAMA'],			
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
