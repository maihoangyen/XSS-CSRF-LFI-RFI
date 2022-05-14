<?php
    session_start();
    if (!(isset($_SESSION['username']) && $_SESSION['username'])) {
        echo ("<script LANGUAGE='JavaScript'>window.alert('Vui lòng đăng nhập');window.location.href='login.html';</script>");
    }


$conn = new mysqli('localhost','root', '','demo');


//error_reporting(0); 

if (isset($_GET['submit'])) { 
	$name = $_GET['name']; 
	$email = $_GET['email']; 
	$comment = $_GET['comment']; 

	$sql = "INSERT INTO comment (name, email, comment)
			VALUES ('$name', '$email', '$comment')";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		echo "<script>alert('Bình luận thành công.')</script>";
	} else {
		echo "<script>alert('Bình luận thất bại')</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="cm.css">

	<title>Bình luận</title>
</head>
<body>
	<div class="wrapper">
		<form action="" method="GET" class="form">
			<div class="row">
				<div class="input-group">
					<label for="name">Tên</label>
					<input type="text" name="name" id="name" placeholder="Nhập tên" required>
				</div>
				<div class="input-group">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" placeholder="Nhập email" required>
				</div>
			</div>
			<div class="input-group textarea">
				<label for="comment">Bình luận</label>
				<textarea id="comment" name="comment" placeholder="Click để bình luận" required></textarea>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Bình luận</button>
			</div>
		</form>
		<div class="prev-comments">
			<?php 
			
			$sql = "SELECT * FROM comment";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {

			?>
			<div class="single-item">
				<h4><?php echo $row['name']; ?></h4>
				<a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
				<p><?php echo $row['comment']; ?></p>
			</div>
			<?php

				}
			}
			
			?>
		</div>
	</div>
</body>
</html>