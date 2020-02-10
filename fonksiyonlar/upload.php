<?php
include '../connection/baglanti.php';
include '../fonksiyonlar/metinselislemler.php';

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["FATURA_ADI"]["name"]);
$uploadOk = 1;

$dosyaFormati = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    echo "Hata. Dosya Zaten Mevcut. </br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["FATURA_ADI"]["size"] > 500000) {
    echo "Hata. Dosyanızın Boyutu çok Büyük. </br>";
    $uploadOk = 0;
}
// Allow certain file formats



if($dosyaFormati != "xml" ) {
    echo "Hata. Sadece XML dosya formatı yükleyebilirsiniz.";
    $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Hata. Dosyanız Yüklenemedi.</br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["FATURA_ADI"]["tmp_name"], $target_file)) {
        echo "Sisteme yüklenen dosya ". basename( $_FILES["FATURA_ADI"]["name"]). " ";

	$FATURA_ADI	=CiftBoslukSil(basename( $_FILES["FATURA_ADI"]["name"]));
	$OLUSTURAN=CiftBoslukSil($_REQUEST['OLUSTURAN']);
	$FATURA_FIRMA=CiftBoslukSil($_REQUEST['FATURA_FIRMA']);
	$OLUSTURAN	=CiftBoslukSil($_REQUEST['OLUSTURAN']);
	$TARIH=$_REQUEST['TARIH'];
	$date = date('Y-m-d', strtotime($TARIH));
	
	$doc = new DOMDocument();
	$doc->load( $target_file ,LIBXML_NOWARNING);
  
$LineExtensionAmount="";$InvoicedQuantity="";$Item="";$Note="";$Percent="";$TaxAmount="";
$doc = new DOMDocument();
$doc->load( $target_file ,LIBXML_NOWARNING);
if ($doc != null)
{
	echo "<table class=\"table table-striped table-inverse\" border=1px>";
	echo "<thead  >";
	
	echo  "<tr bgcolor=\"#449d44\" >";
		echo "<th align=\"left\">Sıra No</th>";
		echo "<th align=\"left\">İtem</th>";
		echo "<th align=\"left\">İnvoiced Quantity</th>";
		echo "<th align=\"left\">PriceAmount</th>";
		echo "<th align=\"left\">Percent</th>";
		echo "<th align=\"left\" >TaxAmount</th>";
		echo "<th align=\"left\">LineExtensionAmount </th>";
		echo "<th align=\"left\">Note </th>";
		echo "</tr>";
	echo "</thead>";
 echo "<tbody >";
$datalar2 = $doc->getElementsByTagName( "InvoiceLine" );
$i=0;
$data = array();
	foreach( $datalar2 as $data2 )
	{
		$data_temp = array();
		$i++;
		if ($i%2==0)
		echo " <tr bgcolor=\"#99CCCC\" >"; 
		else
		echo " <tr bgcolor=\"#99FFFF\" >"; 	
		//
		$LineExtensionAmount = $data2->getElementsByTagName( "LineExtensionAmount" );
		if ($LineExtensionAmount->length==0)
		{$LineExtensionAmount="";}
		else
		$LineExtensionAmount = $LineExtensionAmount->item(0)->nodeValue;
		//
		$InvoicedQuantity = $data2->getElementsByTagName( "InvoicedQuantity" );
		if ($InvoicedQuantity->length==0)
			{$InvoicedQuantity="";}
		else
		$InvoicedQuantity = $InvoicedQuantity->item(0)->nodeValue;
		//
		$Item = $data2->getElementsByTagName( "Item" );
		if ($Item->length==0)
			{$Item="";}
		else
		$Item = $Item->item(0)->nodeValue;
		//
		$Note = $data2->getElementsByTagName( "Note" );
		if ($Note->length==0)
			{$Note="";}
		else
		$Note = $Note->item(0)->nodeValue;
		//
		$Percent = $data2->getElementsByTagName( "Percent" );
		if($Percent->length == 0)
			{
			  $Percent="";
			}
			else{
		$Percent = $Percent->item(0)->nodeValue;
			}
		$PriceAmount = $data2->getElementsByTagName( "PriceAmount" );
		if ($PriceAmount->length==0)
		{
			$PriceAmount="";
		}
		else{
		$PriceAmount = $PriceAmount->item(0)->nodeValue;
		}
		//
		$TaxAmount = $data2->getElementsByTagName( "TaxAmount" );
		if($TaxAmount->length==0)
		{
			$TaxAmount="";
		}
		else{
		$TaxAmount = $TaxAmount->item(0)->nodeValue;
		}
		$data[]= array("item"=>CiftBoslukSil($Item),"InvoicedQuantity"=>CiftBoslukSil($InvoicedQuantity),"PriceAmount"=>CiftBoslukSil($PriceAmount),"Percent"=>CiftBoslukSil($Percent),"TaxAmount"=>CiftBoslukSil($TaxAmount),"LineExtensionAmount"=>CiftBoslukSil($LineExtensionAmount),"Note"=>CiftBoslukSil($Note));
		echo "	 <th > $i ) </th>
				 <td> ".CiftBoslukSil($Item)."</td>
				 <td> ".CiftBoslukSil($InvoicedQuantity)."</td>
				 <td> ".CiftBoslukSil($PriceAmount)."</td>
				 <td> ".CiftBoslukSil($Percent)."</td>
				 <td> ".CiftBoslukSil($TaxAmount)."</td>
				 <td> ".CiftBoslukSil($LineExtensionAmount)."</td>
				 <td> ".CiftBoslukSil($Note)."</td>
			";
	}
	echo "</tr>";
}
echo "</table>";

//var_dump($doc);
$xml = json_encode($data);
$sql = "INSERT INTO faturalar (FATURA_ADI,FATURA_FIRMA,TARIH,OLUSTURAN,FATURA_ONAY,XML) VALUES ('$FATURA_ADI','$FATURA_FIRMA','$date','$OLUSTURAN','0','$xml')";
if ($pdo->query($sql) == true) {
    echo "</br>Yeni Kayıt Eklendi";
} else {
    echo "</br>Error: " . $sql . "<br>" ;
}

$pdo = null;
    } else {
        echo "Hata. Dosya Yüklenirken Hata Oluştu.</br>";
    }
}


?>