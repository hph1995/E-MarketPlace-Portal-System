<?php 
	$dbLink = mysql_connect("localhost", "username", "password") or die(mysql_error());
	$dbName = "dbemarketplace";
	$Table = array(
	"CREATE TABLE tblaccount(accountID BIGINT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100), password VARCHAR(100), accType VARCHAR(30), status CHAR(30))",	
	"CREATE TABLE tblpersonnel(personnelID BIGINT AUTO_INCREMENT PRIMARY KEY, accountID BIGINT, name VARCHAR(50), NRIC VARCHAR(13), email VARCHAR(30), addr VARCHAR(100), city VARCHAR(100), state VARCHAR(100), country VARCHAR(100), contactNum VARCHAR(12))",
	"CREATE TABLE tblseller(sellerID BIGINT AUTO_INCREMENT PRIMARY KEY, personnelID BIGINT, bankAccount VARCHAR(50), status VARCHAR(9))",
	"CREATE TABLE tblproduct(productID INT(5) PRIMARY KEY AUTO_INCREMENT,image_name VARCHAR(10), productName VARCHAR(80), category VARCHAR(50), description VARCHAR(100), placeManufacture VARCHAR(100), sellerID VARCHAR(80), status CHAR(30))",
	"CREATE TABLE tblcategory(catID INT(5) PRIMARY KEY AUTO_INCREMENT, catName VARCHAR(80), status VARCHAR(50))",
	"CREATE TABLE tblsubscribe(subID INT(5) PRIMARY KEY AUTO_INCREMENT, sellerID VARCHAR(80), customerID VARCHAR(50))",
	"CREATE TABLE tblsellingprice(priceID INT(15) PRIMARY KEY AUTO_INCREMENT, productID VARCHAR(15), sellerID VARCHAR(15), sellingPrice DOUBLE, status CHAR(30))",
	"CREATE TABLE tblrating(ratingID INT(15) PRIMARY KEY AUTO_INCREMENT, productID VARCHAR(15), accountID VARCHAR(15), rateNumber DOUBLE)",
	"CREATE TABLE tblcart(cartID INT(15) PRIMARY KEY AUTO_INCREMENT, productID VARCHAR(15), accountID VARCHAR(15), quantity int, total_price FLOAT, status VARCHAR(9))",
	"CREATE TABLE tblstockcontrol(stockControlID INT(15) PRIMARY KEY AUTO_INCREMENT, productID VARCHAR(15), sellerID VARCHAR(15), quantity INT(15), status CHAR(30),paymentID CHAR(15))",
	"CREATE TABLE tblfavourite(favID INT(15) PRIMARY KEY AUTO_INCREMENT, productID VARCHAR(15), accountID VARCHAR(15), status CHAR(30))",
	"CREATE TABLE tblpayment(ID INT(5) PRIMARY KEY AUTO_INCREMENT, itemName VARCHAR(100), qty VARCHAR(50), price VARCHAR(50), totalAmt DOUBLE, dateCr DATE, pic VARCHAR(50), status VARCHAR(20))");
	
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
			$Adduser = "SELECT count(accountID) AS intNum FROM tblaccount WHERE accountID = '1'";
			$AddResult = mysql_query($Adduser, $dbLink);
			$Row = mysql_fetch_array($AddResult);
			if($Row['intNum'] > 0)
			{
				
			}
			else
			{
				//adding default account
				$Add = "INSERT INTO tblaccount (username, password, accType, status) VALUES('".strtoupper('admin')."', '".strtoupper(md5('admin'))."', 'ADMINISTRATOR', 'ACTIVE')";
				$AddNew = mysql_query($Add, $dbLink);
				/*$AddPersonnel = "INSERT INTO tblpersonnel (accountID, name, NRIC, email, addr, city, state, country, contactNum) VALUES(1, 'ADMIN', '999999-13-999999', 'admin@gmail.com', '-', '-', '-', '-', '-')";
				$AddNewResult = mysql_query($AddPersonnel, $dbLink);*/
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