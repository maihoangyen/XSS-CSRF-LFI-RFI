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
<br> 1.1 Các kiểu khai thác XSS <a name="tc"></a></br>
