<?php 
	$dbLink = mysql_connect("localhost", "username", "password") or die(mysql_error());
	$dbName = "dbemarketplace";
	$Table = array(
	"CREATE TABLE tbluser(NRIC VARCHAR(15) PRIMARY KEY, username VARCHAR(100), password VARCHAR(32), accType VARCHAR(30), status CHAR(30))",	
	"CREATE TABLE tblpersonnelaccount(userID VARCHAR(15) PRIMARY KEY, name VARCHAR(80), dob DATE, gender CHAR(1), addr VARCHAR(100), postcode VARCHAR(100), city VARCHAR(100), state VARCHAR(100), country VARCHAR(100), contactNum VARCHAR(15), email VARCHAR(100))",
	"CREATE TABLE tblproduct(productID INT(5) PRIMARY KEY AUTO_INCREMENT, productName VARCHAR(80), description VARCHAR(100), placeManufacturer VARCHAR(100))",
	"CREATE TABLE tblsellingprice(priceID INT(15) PRIMARY KEY AUTO_INCREMENT, productID VARCHAR(15), sellingPrice DOUBLE)",
	"CREATE TABLE tblpayment(ID INT(5) PRIMARY KEY AUTO_INCREMENT, itemName VARCHAR(100), qty INT(10), price DOUBLE, totalAmt DOUBLE, dateCr DATE, receiptNo VARCHAR(15), paymentType VARCHAR(100))");
	
	if($dbLink)
	{
		if(mysql_select_db($dbName))
		{
			for($i = 0; $i < count($Table); $i++)
			{
				$Result = mysql_query($Table[$i], $dbLink);
			}
			
			if($Result)
			{
				echo "<script> alert('Table successfully added'); </script>";	
			}
			
			//Check default user
			$Adduser = "SELECT count(NRIC) AS intNum FROM tbluser WHERE NRIC = '999999999999'";
			$AddResult = mysql_query($Adduser, $dbLink);
			$Row = mysql_fetch_array($AddResult);
			if($Row['intNum'] > 0)
			{
				
			}
			else
			{
				//adding default account
				$Add = "INSERT INTO tbluser (NRIC, username, password, accType, status) VALUES('999999999999', 'admin', '".md5('admin')."', 'ADMINISTRATOR', 'ACTIVE')";
				$AddNewResult = mysql_query($Add, $dbLink);
			}
		}
		else
		{
			//Create New Database
			$SQL = "CREATE DATABASE ".$dbName;
			mysql_query($SQL, $dbLink);
			echo "<script> alert('Database added successfully'); </script>";
		}
	}
	else
	{
		echo "Failure connect to MYSQL Server";
	}
?>