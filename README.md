# <div align="center"><p> XSS, CSRF, LFI, RFI </p></div>
 ## Họ và tên: Mai Thị Hoàng Yến
 ## Ngày báo cáo: Ngày 11/5/2022
 ### MỤC LỤC
 1. [XSS](#gioithieu)
 
     1.1 [Phương pháp manual](#tc)
      
     1.2 [Phương pháp sử dụng sqlmap](#pp)
 
     1.3 [Phương pháp sử dụng công cụ BurpSuite](#p3)
     
 2. [CSRF](#mp) 
       
 3. [LFI](#lv)

     3.1 [Code sửa lỗi sqli cho level2](#code1)
      
     3.2 [Code sửa lỗi sqli cho level1](#code2)
     
     3.3 [Các hàm sử dụng](#chsd)

  3. [RFI](#lv)
 
### Nội dung báo cáo 
#### 1. XSS <a name="gioithieu"></a>
<br> 1.1 Khái niệm XSS <a name="tc"></a></br>
 - XSS là một lỗi bảo mật cho phép các hecker chèn các đoạn script nguy hiểm vào trong source code ứng dụng web. Nhằm thực thi các đoạn mã độc Javascript để chiếm phiên đăng nhập của người dùng.
 
<br> 1.2 Các kiểu khai thác XSS <a name="tc"></a></br>
 - `Reflected XSS`: Reflected XSS là hình thức tấn công XSS được sử dụng nhiều nhất trong chiếm phiên làm việc của người dùng mạng. Qua đó, hacker đánh cắp các dữ liệu người dùng, chiếm quyền truy cập và hoạt động của họ trên website thông qua việc chia sẻ địa chỉ URL chứa mã độc và chờ nạn nhân cắn câu. Hình thức tấn công này thường nhắm vào một số ít nạn nhân.
 - `Stored XSS`: Không giống như Reflected XSS, Stored XSS nhắm đến khá nhiều nạn nhân cùng lúc. Với hình thức tấn công này, hacker chèn các mã độc vào database thông qua những dữ liệu đầu vào như form, input, textarea…Khi người dùng mạng truy cập website và tiến hành những thao tác liên quan đến các dữ liệu đã lưu, mã độc lập tức hoạt động trên trình duyệt của người dùng. 
 - `DOM Based XSS`: Dạng tấn công XSS thường gặp cuối cùng đó là DOM Based XSS. Đây là một dạng kỹ thuật dùng để khai thác XSS dựa vào cơ sở thay đổi HTML của tài liệu, nói cách khác là thay đổi các cấu trúc DOM. 
 
<br> 1.3 Khi nào thì XSS sẽ xảy ra <a name="tc"></a></br>
 - Để một lỗi XSS xảy ra thì phải đáp ứng 2 điều kiện:
   -  Kẻ tấn công chèn các đoạn mã độc vào hệ thống web
   -  Người dùng truy cập vào trang web
   
<br> 1.4 Cách khắc phục XSS <a name="tc"></a></br>
 - Chúng ta sẽ sử dụng các hàm sau đây để ngăn chặn xss:
   - Mã hóa HTML:
     - `htmlspecialchars`: sẽ chuyển đổi bất kỳ "ký tự đặc biệt HTML" nào thành các mã hóa HTML của chúng, có nghĩa là sau đó chúng sẽ không được xử lý dưới dạng HTML tiêu chuẩn. 
        - Ví dụ:
               
               `<?php echo '<div>' . htmlspecialchars($_GET['input']) . '</div>';`
     - `filter_input`: Hàm này được sử dụng để xác thực các biến từ các nguồn không an toàn, chẳng hạn như đầu vào của người dùng.
        - Ví dụ: 
               
               `echo '<div>' . filter_input(INPUT_GET, 'input', FILTER_SANITIZE_SPECIAL_CHARS) . '</div>';`
     - `htmlentities`: Cũng thực hiện tác vụ tương tự như htmlspecialchars () nhưng hàm này bao gồm nhiều thực thể ký tự hơn. Nó sẽ chuyển các kí tự thích hợp thành các kí tự HTML entiies(kí tự dùng để hiển thị các biểu tượng).
        - Ví dụ:
               
               `htmlentities($var, ENT_QUOTES | ENT_HTML5, $charset)`
   - Mã hóa URL:
     - `urlencode`: Chức năng để xuất các URL hợp lệ một cách an toàn. Mọi thông tin đầu vào độc hại sẽ được chuyển đổi thành tham số URL được mã hóa.
        - Ví dụ:
                
                `<?php $input = urlencode($_GET['input']);`
     - Chúng ta cũng có thể sử dụng bộ lọc `FILTER_SANITIZE_URL` trong hàm `filter_input` để mã hóa url.
        - Ví dụ: `$input = filter_input(INPUT_GET, 'input', FILTER_SANITIZE_URL);`
   - `strip_tags`: Hàm này có tác dụng loại bỏ đi các ký tự html trong một string. Mặc dù strip_tags có thể loại bỏ các ký tự html cho data của chúng ta tuy nhiên nó chỉ xóa một số thẻ nhất định ngay cả khi thẻ đó là hợp lệ.
     - Ví dụ: 
              
              `<?php 
               $text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>'; 
               echo strip_tags($text, '<p><a>');`
   
   - `Addlashes `: Thêm một ký tự gạch chéo nhằm ngăn kẻ tấn công chấm dứt việc gán biến và thêm mã thực thi vào cuối.
   - `str_replace`: Trả về một chuỗi mới với tất cả các lần xuất hiện của một chuỗi con được thay thế bằng một chuỗi khác.
     - Ví dụ:
            
            ` $name = str_replace( '<script>', '', $_GET[ 'name' ] );`
   - `preg_replace`: Dùng để replace một chuỗi nào đó khớp với đoạn Regular Expression truyền vào. Hàm này có chức năng tương tự như str_replace nhưng có sự khác biệt là một bên dùng regex một bên không dùng.
     - Ví dụ:
            
            ` $name = preg_replace( '/<(.*)s(.*)c(.*)r(.*)i(.*)p(.*)t/i', '', $_GET[ 'name' ] );`
   - `stripos`: Sẽ chỉ ra vị trí xuất hiện đầu tiên của chuỗi con nào đó trong chuỗi mà không phân biệt chữ hoa chữ thường. Hàm trả về số nguyên là vị trí xuất hiện đầu tiên của chuỗi con.
     - Ví dụ: 
           
           `if (stripos ($default, "<script") !== false)`

<br> 1.5 Mô phỏng code XSS <a name="tc"></a></br>
