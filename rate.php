<?php
	include('dbEMarketplace.php');

	$rateNum = $_GET['rateNum'];
	$pID = $_GET['pID'];
	$flagPresent = $_GET['flagPresent'];
	$accID = $_GET['accID'];
	$cat = $_GET['cat'];

	if($flagPresent == "false")
	{
		$insertRate = 'INSERT INTO tblrating (productID, accountID, rateNumber) VALUES("'.$pID.'", "'.$accID.'", '.$rateNum.')';
		$checkInsertRate = mysql_query($insertRate, $dbLink);
		if($checkInsertRate)
		{
			echo "<script>location='index.php';</script>";
			/*if($cat == "")
				echo "<script>location='index.php';</script>";
			else
				echo "<script>location='index.php?cat=".$cat."';</script>";*/
		}
	}
	else
	{
		$updateRate = 'UPDATE tblrating SET rateNumber = '.$rateNum.' WHERE productID = "'.$pID.'" AND accountID = "'.$accID.'"';
		$checkUpdateRate = mysql_query($updateRate, $dbLink);
		if($checkUpdateRate)
		{
			echo "<script>location='index.php';</script>";
			/*if($cat == "")
				echo "<script>location='index.php';</script>";
			else
				echo "<script>location='index.php?cat=".$cat."';</script>";*/
		} 
	}
?>