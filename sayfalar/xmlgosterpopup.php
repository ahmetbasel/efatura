<?php
include '../connection/baglanti.php';
include '../fonksiyonlar/metinselislemler.php';

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["FATURA_ADI"]["name"]);
 
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
	foreach( $datalar2 as $data2 )
	{
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
?>
