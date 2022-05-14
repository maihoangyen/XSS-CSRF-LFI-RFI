<?php
    session_start();
    if (!(isset($_SESSION['username']) && $_SESSION['username'])) {
        echo ("<script LANGUAGE='JavaScript'>window.alert('Vui lòng đăng nhập');window.location.href='login.html';</script>");
    }
?>
<html>
    <head>
        <title>Chức năng tìm kiếm</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="search.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body >
        <?php
        // Nếu người dùng submit form thì thực hiện
        if (isset($_REQUEST['ok'])) 
        {
            // Gán hàm addslashes để chống sql injection
            $search = $_GET['search'];
 
            // Nếu $search rỗng thì báo lỗi, tức là người dùng chưa nhập liệu mà đã nhấn submit.
            if (empty($search)) {
                echo "Yeu cau nhap du lieu vao o trong";
            } 
            else
            {
                // Dùng câu lênh like trong sql và sứ dụng toán tử % của php để tìm kiếm dữ liệu chính xác hơn.
                $query = "SELECT * FROM posts WHERE status = '1' AND title LIKE '%$search%' OR keywords LIKE '%$search%' OR descr LIKE '%$search%' ORDER BY title";

 
                // Kết nối sql
                $con = mysqli_connect('localhost', 'root', '', 'demo');
 
                // Thực thi câu truy vấn
                $sql = mysqli_query($con, $query);
 
                // Đếm số đong trả về trong sql.
                $num = mysqli_num_rows($sql);
 
                // Nếu có kết quả thì hiển thị, ngược lại thì thông báo không tìm thấy kết quả
                if ($num > 0 && $search != "") 
                {
                    // Dùng $num để đếm số dòng trả về.
                    echo '<div class="form-kq">';
                    echo "<b>$num</b> ket qua tra ve voi tu khoa <b>$search</b>";
                    echo '</div>';
                    // Vòng lặp while & mysql_fetch_assoc dùng để lấy toàn bộ dữ liệu có trong table và trả về dữ liệu ở dạng array.
                    echo '<article>';
                    while ($row = mysqli_fetch_assoc($sql)) {
                    echo '<div class="box-search">';
                        echo'<div class="box-item">';
                            echo '<div class="img">';
                                echo '<img height="180" width="300" src='.$row['url_thumb'].' />';
                            echo '</div>';
                            echo '<div class="title">';
                                echo "<a href=".$row['slug'].">{$row['title']}</a>";
                            echo '</div>';
                            echo '<div class="descr">';
                                echo "<div>{$row['descr']}</div>";
                            echo '</div>';
                        echo'</div>';
                    echo '</div>';
                    }
                    echo '</article>';
                    echo '<div style="margin-left: 42%;">';
                        echo 'Click vào đây để trở lại <a href="index.html">Trang chủ</a><br/>';
                     echo '</div>';   

                } 
                else {
                    echo "Khong tim thay ket qua!";
                }
            }
        }
        ?>  
    </body>
</html>