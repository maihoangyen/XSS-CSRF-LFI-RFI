<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="login.css">
	<title>Form Forgot</title>
</head>
<body>
	<div class="container">
		<div><?php if(isset($message)) { echo $message; } ?></div>
		<form action="#" method="GET"class="form-login">
			<h1>Thay đổi mật khẩu</h1>
			<div class="form-text">
				<label for="username"> Mật khẩu mới</label>
				<input type="text" name="new_pass">
<br>
			</div>
			<div class="form-text">
				<label for="password"> Nhập lại Mật khẩu mới</label>
				<input type="text" name="conf_pass">
<br>
			</div>
			<input type="submit" name="Change" value="Change">
			<br>
			<span>Bạn muốn đăng nhập lại click <a href="login.html">Tại đây</a></span>
<?php
	session_start();
	if(isset($_REQUEST['Change'])){
		
		if( stripos( $_SERVER[ 'HTTP_REFERER' ] ,$_SERVER[ 'SERVER_NAME' ]) !== false ) {
		$username = $_SESSION['username'];
		$conn = new mysqli('localhost','root', '','demo');

		$new_pass = $_REQUEST['new_pass'];
		$conf_pass = $_REQUEST['conf_pass'];


		if($new_pass == $conf_pass){
			//$new_pass = md5($new_pass);
		
			$query = "UPDATE `member` SET password = '$new_pass' WHERE username ='$username'; ";
			$result = mysqli_query($conn, $query) or die('<pre>'.mysqli_error($conn). '</pre>');
			if($result){

				echo" Đã thay đổi mật khẩu!!!".$new_pass."";

			}else{
				echo"Không thể thay đổi mật khẩu!!!";
			}
		}else{
			echo" Mật khẩu không trùng khớp!!!!";
		}
	}
	else {
        
        echo "Yêu cầu không chính xác!!!";
    }
		mysqli_close($conn);
}
?>
		</form>
	</div>
</body>
</html>
