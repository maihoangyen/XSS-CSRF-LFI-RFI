<?php

	//Khai báo sử dụng session
	session_start();
 
	//Khai báo utf-8 để hiển thị được tiếng việt
	header('Content-Type: text/html; charset=UTF-8');

	$username = $_POST['username'];
	$password = $_POST['password'];

	$conn = new mysqli('localhost','root', '','demo');

	$sql = "SELECT * FROM member WHERE username = '$username'";
	$result = $conn->query($sql)->fetch_assoc();

	//$password = md5($password);
	if($result['password'] == $password){
		$_SESSION['username'] = $username;
		header('Location: index.html');
		die();	
	}else{
		echo 'Sai thông tin';
		echo '<script language="javascript">alert("Sai thông tin!"); window.location="login.html";</script>';
	}

	$conn->close();
?>