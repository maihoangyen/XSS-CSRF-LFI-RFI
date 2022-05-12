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

<br> 1.5 Mô phỏng code XSS <a name="tc"></a></br>
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

<br> 1.6 khắc phục code XSS <a name="tc"></a></br>
 - Đây là code khắc phục lỗi XSS:

   ![image](https://user-images.githubusercontent.com/101852647/167768472-d622c437-0863-497b-b52a-c5c2984a9f3b.png)

 - Đây là màn hình của web fix lỗi:

   ![image](https://user-images.githubusercontent.com/101852647/167768565-b27f20fa-a9ba-41ec-b60c-2cd1ff96b81c.png)

 - Thử chèn lại đoạn mã đã thực thi phía trên `<script>alert(document.cookie)</script>` và `<script>alert('hacker')</script>`.

   ![image](https://user-images.githubusercontent.com/101852647/167768683-02e5354e-27f4-4358-aabb-8cbe7be7520a.png)

   ![image](https://user-images.githubusercontent.com/101852647/167768738-0cef7b51-ecf2-4c8b-9235-752af6ddd39a.png)

   ![image](https://user-images.githubusercontent.com/101852647/167768787-ef7015ca-4070-403b-ae8d-075977648cee.png)

#### 2. CSRF <a name="gioithieu"></a>
<br> 2.1 Khái niệm CSRF <a name="tc"></a></br>
 - CSRF là viết tắt của Cross-site Request Forgery là kỹ thuật tấn công giả mạo chính chủ thể của nó. CSRF nói đến việc tấn công vào chứng thực request trên web thông qua việc sử dụng Cookies.
 
<br> 2.2 Cách thức tấn công CSRF <a name="tc"></a></br>
 - CSRF là một kiểu tấn công gây sự nhầm lẫn tăng tính xác thực và cấp quyền của nạn nhân khi gửi một request giả mạo đến máy chủ. Vì thế một lỗ hổng CSRF ảnh hưởng đến các quyền của người dùng ví dụ như quản trị viên, kết quả là chúng truy cập được đầy đủ quyền.
 - Khi gửi một request HTTP, trình duyệt của nạn nhân sẽ nhận về Cookie. Các cookie thường được dùng để lưu trữ một session để định danh người dùng không phải xác thực lại cho mỗi yêu cầu gửi lên.
 - Nếu phiên làm việc đã xác thực của nạn nhân được lưu trữ trong một Cookie vẫn còn hiệu lực và nếu ứng dụng không bảo mật dễ bị tấn công CSRF. Kẻ tấn công có thể sử dụng CSRF để chạy bất cứ requets nào với ứng dụng web mà ngay cả trang web không thể phân biệt được request nào là thực hay giả mạo.
 
<br> 2.3 Mô phỏng code CSRF <a name="tc"></a></br>
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

<br> 2.3 Khắc phụ code CSRF <a name="tc"></a></br>
 - Đây là code CSRF đã được fix:

   ![image](https://user-images.githubusercontent.com/101852647/168137750-5d4a6d87-93ba-4c60-a56f-6e121e02254e.png)

 - Sau khi fix xong chúng ta sẽ thử thay đổi password lại xem thử chúng ta có thay đổi được hay không. Nhập mật khẩu mới là `123345` và như chúng ta thấy thì đã thay đổi thành công.

  ![image](https://user-images.githubusercontent.com/101852647/168138079-f8f9d87d-52b2-456e-99bd-538a4512344a.png)

  ![image](https://user-images.githubusercontent.com/101852647/168138205-b2f141ee-a75b-49d3-897c-5497ba9c066a.png)

 - Tiếp theo chúng ta làm tương tự như ở phía trên mô phỏng code lỗi CSRF chúng ta sẽ copy form và sửa chúng trên notepad. 

  ![image](https://user-images.githubusercontent.com/101852647/168138615-a32112bd-995d-4a8f-acae-88ebafbcb1b5.png)

 - Mở trang web lên là click vào `change` nhưng rất tiếc là lần này chúng ta không thể thay đổi được password.

  ![image](https://user-images.githubusercontent.com/101852647/168139000-5a2ab595-b343-45e9-b7df-cd184191b005.png)

  ![image](https://user-images.githubusercontent.com/101852647/168138900-1d80ebf3-dc27-413b-a404-4b0621e97ca8.png)

#### 3. LFI <a name="gioithieu"></a>
<br> 3.1 Khái niệm LFI <a name="tc"></a></br>
 - Local file inclustion (LFI) là kĩ thuật đọc file trong hệ thống , lỗi này xảy ra thường sẽ khiến website bị lộ các thông tin nhảy cảm như là passwd, php.ini, access_log,config.php…
 
<br> 3.2 Cách thức hoạt động LFI <a name="tc"></a></br>
 - Tấn công Local file inclusion Lỗ hổng Local file inclusion nằm trong quá trình include file cục bộ có sẵn trên server. Lỗ hổng xảy ra khi đầu vào người dùng chứa đường dẫn đến file bắt buộc phải include. Khi đầu vào này không được kiểm tra, tin tặc có thể sử dụng những tên file mặc định và truy cập trái phép đến chúng, tin tặc cũng có thể lợi dụng các thông tin trả về trên để đọc được những tệp tin nhạy cảm trên các thư mục khác nhau bằng cách chèn các ký tự đặc biệt như “/”, “../”, “-“.

<br> 3.3 Mô phỏng code LFI <a name="tc"></a></br>
- Đây là code lỗi LFI:

  ![image](https://user-images.githubusercontent.com/101852647/168015234-3ff28878-8afa-4f35-9116-da7362f35dce.png)
  
- Đây là giao diện trang web có lỗi LFI:

  ![image](https://user-images.githubusercontent.com/101852647/167999472-495509d4-60b0-4848-ac9c-831dafe2775d.png)

- Để có thể thực hiện tấn công LFI thì chúng ta có thể thay đổi URL trông giống như sau:

  ![image](https://user-images.githubusercontent.com/101852647/168001508-e3f75bd3-8084-4f68-bd94-937761a1c639.png)
  
- Nếu trong trường hợp không lọc thích hợp, máy chủ sẽ hiển thị nội dung nhạy cảm của tệp /etc/passwd:

  ![image](https://user-images.githubusercontent.com/101852647/167999155-bced5b89-08d2-468b-8731-e806dbc20191.png)
  
<br> 3.4 Khắc phục lỗi LFI <a name="tc"></a></br>
 - Đây là code khắc phục lỗi LFI. Chúng ta sẽ sử dụng hàm ` str_replace` để thay đổi một số ký tự `http://, https://, ../` trên url để các hacker không thể khai thác được:

   ![image](https://user-images.githubusercontent.com/101852647/168015562-1f783fb4-5d7f-4e70-82bc-e9d00f954095.png)

 - Trang web vẫn bình thường cho đến khi chúng ta chèn thêm `../../../../etc/paswd` thì nó sẽ không hiển thị nội dung của tệp /etc/passwd:

   ![image](https://user-images.githubusercontent.com/101852647/168018052-5df140bf-6e0f-4e00-a5da-6c44417fa015.png) 

#### 4. RFI <a name="gioithieu"></a>
<br> 4.1 Khái niệm RFI <a name="tc"></a></br>
 - Remote File Inclusion còn được viết tắt là RFI cho phép kẻ tấn công nhúng một mã độc hại được tuỳ chỉnh trên trang web hoặc máy chủ bằng cách sử dụng các tập lệnh . RFI còn cho phép tải lên một tệp nằm trên máy chủ khác được chuyển đến dưới dạng hàm PHP ( include, include_once, require, or require_once)

<br> 4.2 Cách thức hoạt động RFI <a name="tc"></a></br>
 - Lỗ hổng Remote file inclusion RFI cho phép tin tặc include và thực thi trên máy chủ mục tiêu một tệp tin được lưu trữ từ xa. Tin tặc có thể sử dụng RFI để chạy một mã độc trên cả máy của người dùng và phía máy chủ. Ảnh hưởng của kiểu tấn công này thay đổi từ đánh cắp tạm thời session token hoặc các dữ liệu của người dùng cho đến việc tải lên các webshell, mã độc nhằm đến xâm hại hoàn toàn hệ thống máy chủ. 
 - Khai thác lỗ hổng Remote file inclusion trong PHP PHP có nguy cơ cao bị tấn công RFI do việc sử dụng lệnh include rất nhiều và thiết đặt mặc định của server cũng ảnh hưởng một phần nào đó. Để bắt đầu chúng ta cần tìm nơi chứa file include trong ứng dụng phụ thuộc vào dữ liệu đầu vào người dùng. 
<br> 4.3 Mô phỏng code RFI <a name="tc"></a></br>
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
  
<br> 4.4 Khắc phục lỗi RFI <a name="tc"></a></br>
 - Đây là code khắc phục lỗi RFI. Chúng ta sẽ sử dụng hàm ` str_replace` để thay đổi một số ký tự `http://, https://, ../` trên url để các hacker không thể khai thác được:

   ![image](https://user-images.githubusercontent.com/101852647/168013767-b5f6ae69-c584-4b23-968b-b49a771423c4.png)

 - Trang web vẫn bình thường cho đến khi chúng ta chèn thêm `http://www.google.com` thì nó sẽ thông báo lỗi:

   ![image](https://user-images.githubusercontent.com/101852647/168014384-a891fa29-9e61-4c90-a730-9d9994acbd07.png)
