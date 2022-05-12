<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $database = "demo";
  
   $conn = mysqli_connect($servername, $username, $password, $database);
   if (!$conn) {
     die("kết nối thất bại " . mysqli_connect_error());
   }
     echo "kết nối thành công";
   mysqli_close($conn);
?>