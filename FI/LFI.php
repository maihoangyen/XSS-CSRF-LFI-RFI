<?php require_once "config.php"; ?>
<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>
            My Web
        </title>
    </head>
    <body>
     <h1>Welcom to myweb</h1>
	<div>
		<a href="LFI.php">Home</a>
        <a href="LFI.php?page=lfi1.php">lfi1.php</a>
	</div>
<?php


if(isset($_GET['page'])){

   $page = $_GET['page'];
   
    //include $_GET['page'];
    //$page = str_replace(array("http://", "https://"),"",$page);
    //$page = str_replace(array("../"),"", $page);

    include($page);

}else{
    echo "<p>Đây là trang web của tôi!!!</p>";
}

?>
    </body>

</html>

