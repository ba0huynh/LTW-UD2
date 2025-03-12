<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<style>
    ul,li{
        list-style-type: none;
        margin: 10px 0 !important;
    }
    body{
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 18px;
    }
    .left-footer h1{
        color: red;
    }
    h4{
        width: 100%;
    }
    .footer{
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 20px 10%;
    }
    .icon{
        font-size: 45px;
    }
    .left-footer{
        width: 26%;
        border-right: 2px solid;
        margin: 2px 0;
    }
    .left-footer p {
        margin: 5px;
    }
    .infor {
        width: 33%;
    }
    .infor li{
        text-align: left;
    }
    .right-footer {
        width: 70%;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin: 20px 0;
        padding: 10px;
    }
    #contact {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between; 
        align-items: flex-start
    }
    .footer-li li {
        position: relative;
        font-size: 16px;
        font-weight: bold;
        color: black;
        padding-left: 15px;
        transition: transform 0.3s ease-in-out, color 0.3s;
        cursor: pointer;
    }
    .footer-li li::before {
        content: "—"; 
        position: absolute;
        left: -20px;
        color: pink;
        opacity: 0;
        transition: left 0.3s ease-in-out, opacity 0.3s;
    }
    
    .footer-li li:hover {
        transform: translateX(10px); 
        color: pink; 
    }
    
    .footer-li li:hover::before {
        left: -10px; 
        opacity: 1;
    }
    #contact span {
        width: 30%;
    }
    .images {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    .images div{
        width: 30%;
        float: left;
        margin: 10px 0;
        
    }
    .images img{
        width: 40%;
        max-width: 100%;
        height: auto;
        margin: 5px;
    }
</style>
<body>
    <div class="footer">
        <div class="left-footer">
            <img src="./images/image1.jpg" alt="100%" width="30%"><br>
            <p>Lầu 5,367-369 Hai Bà Trưng Quận 3 TP.HCM</p>
            <p>Công Ty Cổ Phần Phát Hành Sách TP.HCM-FAHASA</p>  
            <p>60-62 Lê Lợi, Quận 1 TP.HCM, Việt Nam</p>
            <p>Fahasa.com nhận đặt hàng trực tuyến và giao hàng tận nơi KHÔNG hỗ trợ đặt mua và nhận hàng trực tiếp tại văn phòng cũng như tất cả hệ thống Fahasa trên toàn quốc.</p>
            <div><img src="./images/logo-bo-cong-thuong-da-thong-bao1.webp" width="30%"></div>
            <div class="icon">
                <span><i class='bx bxl-facebook-circle' ></i></span>
                <span><i class='bx bxl-instagram-alt' ></i></span>
                <span><i class='bx bxl-youtube' ></i></span>
                <span><i class='bx bxl-twitter' ></i></span>
                <span><i class='bx bxl-pinterest' ></i></span>
                <span><i class='bx bxl-tumblr' ></i></span>
            </div>
            <div class="device">
                <img src="./images/android1.webp" width="30%">
                <img src="./images/appstore1.webp" width="30%">
            </div>
        </div>
        <div class="right-footer">
            <div class="infor">
                <h4>DỊCH VỤ</h4>
                <ul class="footer-li">
                    <li>Điều khoản sử dụng</li>
                    <li>Chính sách bảo mật thông tin cá nhân</li>
                    <li>Chính sách bảo mật thanh toán</li>
                    <li>Giới thiệu Fahasa</li>
                    <li>Hệ thống trung tâm-nhà sách</li>
                </ul>
            </div>
            <div class="infor">
                <h4>HỖ TRỢ</h4>
                <ul class="footer-li">
                    <li>Chính sách đổi-trả-hoàn tiền</li>
                    <li>Chính sách bảo hành-bồi hoàn</li>
                    <li>Chính sách vận chuyển</li>
                    <li>Chính sách khách sĩ</li>
                </ul>
            </div>
            <div class="infor">
                <h4>TÀI KHOẢN CỦA TÔI</h4>
                <ul class="footer-li">
                    <li>Đằng nhập/Tạo tài khoản mới</li>
                    <li>Thay đổi địa chỉ khách hàng</li>
                    <li>Chi tiết tài khoản</li>
                    <li>Lịch sử mua hàng</li>
                </ul>
            </div>
            <div id="contact">
                <h4>LIÊN HỆ</h4>
                <span><i class='bx bxs-map' ></i>60-62 Lê Lợi, Q1, TP.HCM</span>
                <span><i class='bx bxs-envelope' ></i>cskh@fahasa.com.vn</span>
                <span><i class='bx bxs-phone' ></i>1900636467</span>
            </div>
            <div class="images">
                <div><img src="./images/logo_lex.webp" ></div>
                <div><img src="./images/Logo_ninjavan.webp"></div>
                <div><img src="./images/vnpost1.webp" ></div>
                <div><img src="./images/vnpay_logo.webp" ></div>
                <div><img src="./images/shopeepay_logo.webp" ></div>
                <div><img src="./images/momopay.webp" style="width: 30%"></div>
            </div>
        </div>
    </div>
</body>
</html>